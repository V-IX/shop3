<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends SITE_Controller {
	
	protected $model = '';
	protected $page = 'cart';

	function __construct ()
	{	
		parent::__construct();
		$this->load->model('orders_model');
		$this->model = $this->orders_model;
		
		$this->load->model('products_model');
	}

	public function index()
	{
		//var_dump($this->cart->contents()); die;
		$this->init_site($this->page);
		
		$cart = $this->cart->contents();
		
		if($this->input->post())
		{
			if($this->model->validate())
			{
				$result = $this->model->preOrder();
				if($result['error']) {
					$this->data['error'] = $result['error'];
				} else {
					redirect('cart/confirm/'.$result['alias']);
				}
			} else {
				$this->data['error'] = 'Проверьте правильность заполненных полей!';
			}
		}
		
		$this->data['items'] = $cart;
		
		$this->load->model('delivery_model');
		$this->data['delivery'] = $this->delivery_model->getItems(false, false, 'num|DESC//title|ASC', array('visibility' => 1));
		
		$this->load->model('pay_model');
		$this->data['pay'] = $this->pay_model->getItems(false, false, 'num|DESC//title|ASC', array('visibility' => 1));
		
		$this->load->model('catalog_model');
		$tree = $this->catalog_model->getItemsTree(false, false, 'num|DESC', array('visibility' => 1));
        $this->data['paths'] = $tree['paths'];
		
		$this->breadcrumbs->add($this->data['pageinfo']['name'], uri(1));
		
		$this->site_seo();
		$this->data['view'] = 'shop/cart';
		$this->load->view('site/common/template', $this->data);
	}
	
	public function confirm()
	{
		$this->init_site('confirm');
		
		$error = false;
		
		if($this->input->post())
		{
			if($this->input->post('confirm') == 'confirm')
			{
				$error = $this->model->createOrder();
				if(!$error)
				{
					$this->cart->destroy();
					$order = $this->session->userdata('order');
					$this->session->unset_userdata('order');
					redirect('order/'.$order['alias']);
				}
			} else {
				$error = 'Ошибка данных POST!';
			}
		}
		
		$this->data['error'] = $error;
		
		$order = $this->session->userdata('order');
		if(empty($order)) redirect('cart');
		
		$this->data['order'] = $order;
		$this->data['items'] = $this->cart->contents();
		
		$this->breadcrumbs->add($this->data['pageinfo']['name'], uri(1));
		
		$this->site_seo();
		$this->data['view'] = 'shop/confirm';
		$this->load->view('site/common/template', $this->data);
	}
	
	public function destroy()
	{
		$this->cart->destroy();
		redirect('cart');
	}
	
	public function ajaxAddToCart()
	{
		$this->output->set_content_type('application/json');
		
		$post = $this->input->post();

		if (array_key_exists('idProduct', $post) && !empty($post['idProduct']))
		{
			$_mod = isset($post['mod']) ? $post['mod'] : 0;
			
			if($_mod)
			{
				$item = $this->products_model->getModification(array('articul' => $post['idProduct']));
				
				$this->query->select('currency');
				$_def_curr = $this->query->item('settings');
				
				if($item['currency'] != $_def_curr['currency'])
				{
					$this->db->where_in('idItem', array($item['currency'], $_def_curr['currency']));
					$_curr_arr = $this->query->items('shop_unit_currency');
					$_curr_arr = $this->query->items_list($_curr_arr, 'idItem', 'value');
					$item['price'] = price_calc($item['price'], $_curr_arr[$_def_curr['currency']], $_curr_arr[$item['currency']]);
				}
				
				$product = $this->products_model->getItem($item['idProduct']);
				
			} else {
				$product = $this->products_model->getItemByArticul($post['idProduct']);
			}
			
			$data = array(
				'id'		=> $post['idProduct'],
				'qty'		=> $post['quantity'],
				'price'		=> $_mod ? $item['price'] : $product['price'],
				'name'		=> $_mod ? $item['title'] : $product['title'],
				'idProduct'	=> $_mod ? $item['idProduct'] : $product['idItem'],
				'idParent'	=> $product['idParent'],
				'mod'		=> $_mod,
				'alias'		=> $_mod ? $item['alias'] : $product['alias'],
				'img'  		=> $_mod ? $item['img'] : $product['img'],
				'brief'		=> $_mod ? $item['brief'] : $product['brief'],
			);
			
			$rowid = $this->cart->insert($data); 
			
			$inTotalQuantity = $this->cart->total_items();
			$inTotalPrice = $this->cart->total();
			
			$this->output->set_output(json_encode(array(
				'inTotalQuantity' 	=> $inTotalQuantity,
				'inTotalPrice' 		=> price($inTotalPrice, false),
				'title' 			=> $data['name'],
				'url' 				=> base_url('product/'.$data['alias']),
				'img' 				=> check_img('assets/uploads/products/thumb/'.$data['img'], false, 'product.png', true),
				'qty'				=> $data['qty'],
				'price'   			=> $data['price'],
				'item_total'   		=> price($data['qty'] * $data['price']),
				'rowid'				=> $rowid,
			)));
			return;
		}
		
		$this->output->set_output(json_encode(array('error'=> TRUE)));
	}
	
	public function ajaxUpdateCart()
	{
		$this->output->set_content_type('application/json');
		
		$this->init_site('cart');
		
		$params = $this->input->post();
		
		if (array_key_exists('rowid', $params) && !empty($params['rowid']))
		{
			$data = array(
			   'rowid' => $params['rowid'],
			   'qty'   => $params['quantity']
			);
			$this->cart->update($data); 
			
			$delivery_price = 0;
			$delivery = isset($params['delivery']) ? $params['delivery'] : false;
			if($delivery)
			{
				$this->load->model('delivery_model');
				$delivery = $this->delivery_model->getItem($delivery);
				if(!empty($delivery)) $delivery_price = $delivery['price'];
			}

			$data = array(
				'inTotalQuantity' 	=> $this->cart->total_items(),
				'inTotalPrice'    	=> price($this->cart->total()),
				'inTotalDelivery'	=> price($delivery_price),
				'inTotal'			=> price($this->cart->total() + $delivery_price),
			);

			if(array_key_exists($params['rowid'], $this->cart->contents()))
			{
				$product = $this->cart->contents();
				$product = $product[$params['rowid']];
				
				$this->load->model('catalog_model');
				$tree = $this->catalog_model->getItemsTree(false, false, 'num|DESC', array('visibility' => 1));
				
				$data['content'] = $this->load->view('site/shop/ajax_cart', array('item'=> $product, 'currency' => $this->data['currency'], 'paths' => $tree['paths']), TRUE);
				$this->output->set_output(json_encode($data));
				return;
			}
			
			$data['deleted'] = TRUE;
			$this->output->set_output(json_encode($data));
			return;
		}
		
		$this->output->set_output(json_encode(array('error'=> TRUE)));
	}
	
	public function ajaxUpdateDelivery()
	{
		$this->output->set_content_type('application/json');
		
		$params = $this->input->post();
		
		$delivery_price = 0;
		$delivery = isset($params['delivery']) ? $params['delivery'] : false;
		if($delivery)
		{
			$this->load->model('delivery_model');
			$delivery = $this->delivery_model->getItem($delivery);
			if(!empty($delivery)) $delivery_price = $delivery['price'];
		}

		$data = array(
			'inTotalDelivery'	=> price($delivery_price),
			'inTotal'			=> price($this->cart->total() + $delivery_price),
		);
		
		$this->output->set_output(json_encode($data));
		return;
	}
}