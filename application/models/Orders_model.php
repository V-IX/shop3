<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders_model extends CI_Model 
{
	protected $_table = 'shop_orders';
	protected $_items  = 'shop_orders_products';

    public function __construct()
    {
        parent::__construct();
    }
	
	public function getItems($limit = false, $offset = false, $order = false, $params = array())
	{
		$items = $this->query->items($this->_table, $limit, $offset, $order, $params);
		return $items;
	}
	
	public function getItem($params = array())
	{
		$return = $this->query->item($this->_table, $params);
		if(empty($return)) return array();
		$return['child'] = $this->query->items($this->_items, false, false, false, array('idParent' => $return['idItem']));
		return $return;
	}
	
	public function getCount($params = array())
	{
		return $this->query->items_count($this->_table, $params);
	}
	
	public function isRead($id)
	{
		$this->query->update($this->_table, array('isRead' => 1), array('idItem' => $id));
	}
	
	public function preOrder()
	{
		$order = array();
		$post = $this->input->post();
		
		$pay = 'не указано';
		$delivery = 'не указано';
		$delivery_price = 0;
		
		if(isset($post['pay']))
		{
			$_pay = $this->query->item('shop_pay', array('idItem' => $post['pay']));
			if(!empty($_pay)) $pay = $_pay['title'];
			unset($post['pay']);
		}
		
		if(isset($post['delivery']))
		{
			$_del = $this->query->item('shop_delivery', array('idItem' => $post['delivery']));
			if(!empty($_del))
			{
				$delivery = $_del['title'];
				$delivery_price = $_del['price'];
			}
			unset($post['delivery']);
		}
		
		$price = $this->cart->total();
		$count = $this->cart->total_items();
		$total = $price + $delivery_price;
		
		$order = $post;
		$order['delivery'] = $delivery;
		$order['delivery_price'] = $delivery_price;
		$order['pay'] = $pay;
		$order['price'] = $price;
		$order['count'] = $count;
		$order['total'] = $total;
		
		$error = $this->query->insert($this->_table, array('preorder' => 1));
		if($error)
		{
			return array('error' => 'Ошибка сервера');
		} else {
			$id = $this->query->insert_id();
			$alias = $id + 100000;
			$this->query->update($this->_table, array('alias' => $alias), array('idItem' => $id));
			$order['alias'] = $alias;
			$this->session->set_userdata('order', $order);
			return array('error' => false, 'alias' => $alias);
		}
		
		var_dump($order); die;
	}
	
	public function createOrder()
	{
		$order = $this->session->userdata('order');
		$carts = $this->cart->contents();
		$products = array();
		
		if(!isset($order['name'])) $order['name'] = null;
		if(!isset($order['email'])) $order['email'] = null;
		$order['preorder'] = 0;
		$order['isRead'] = 0;
		
		if(isset($order['qty'])) unset($order['qty']);
		
		$error = $this->query->update($this->_table, $order, array('alias' => $order['alias']));
		if($error) return 'Ошибка сервера';
		
		$where_in = array();
		$substr = array();
		foreach($carts as $item) $where_in[] = $item['idProduct'];
		if(!empty($where_in))
		{
			$this->db->where_in('idItem', $where_in);
			$this->db->select('idItem, count_subtraction');
			$query = $this->query->items('shop_products', false, false, false, array('count_subtraction' => 1));
			foreach($query as $q)
			{
				$substr[$q['idItem']] = $q['idItem'];
			}
		}
		
		foreach($carts as $item)
		{
			$insert = array(
				'idParent' 		=> intval($order['alias']) - 100000,
				'articul' 		=> $item['id'],
				'title' 		=> $item['name'],
				'brief' 		=> $item['brief'],
				'img' 			=> $item['img'],
				'modification' 	=> $item['mod'],
				'price'			=> $item['price'],
				'count'			=> $item['qty'],
				'total'			=> $item['subtotal'],
			);
			
			$this->query->insert($this->_items, $insert);
			
			if(array_key_exists($item['idProduct'], $substr))
			{
				if($item['mod'] == 1) $this->db->query('UPDATE shop_products_modifications SET count = (count - '.$item['qty'].') WHERE articul = "'.$item['id'].'"');
				else $this->db->query('UPDATE shop_products SET count = (count - '.$item['qty'].') WHERE articul = "'.$item['id'].'"');
			}
		
			$products[] = $insert;
		}
		
		$order['products'] = $products;
		$order['date'] = date('d.m.Y H:i:s');
		$this->sendMail($order);
		
		set_flash('site', action_result('info', fa('check mr5') . ' Ваш заказ <strong>№'.$order['alias'].'</strong> принят в обработку. Наши менеджеры свяжутся с Вами в ближайшее рабочее время!'));
		
		return false;
		
		var_dump($products); die;
	}
	
	public function sendMail($data)
	{
		$site = $this->settings_model->getItem();
		$data['site'] = $site;
		$data['currency'] = $this->query->item('shop_unit_currency', array('idItem' => $site['currency']));
		$this->load->library('email');
		
		$config = array (
			'mailtype' => 'html',
			'charset'  => 'utf-8',
			'priority' => '1'
		);
		
		if($data['email'] != '') 
		{
			$this->email->initialize($config);
			$this->email->from($site['email_sender'], $site['title']);
			$this->email->to($data['email']);
			$this->email->subject('Заказ товара на сайте ' . $site['title']);
			$message = $this->load->view('site/emails/shop_user', $data, TRUE);
			$this->email->message($message);
			$this->email->send();
		}
		
		$this->email->clear();
		$this->email->from($site['email_sender'], $site['title']);
		$this->email->to($site['email']);
		$this->email->subject('Новый заказ #'. $data['alias'] . ' - ' . $site['title']);
		$message = $this->load->view('site/emails/shop_admin', $data, TRUE);
		$this->email->message($message);
		$this->email->send();
	}
	
	public function delete($id)
	{
		$insert = $this->post();
		if($insert['delete'] != 'delete')
		{
			set_flash('result', action_result('error', fa('warning mr5').' Ошибка данных POST!', true));
			return true;
		}
		
		$item = $this->getItem($id);
		if(empty($item))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			return true;
		}
		
		$error = $this->query->delete($this->_table, array('idItem' => $id));
		if(!$error)
		{
			$this->query->delete($this->_items, array('idParent' => $id));
			set_flash('result', action_result('success', fa('trash mr5').' Запись <span class="medium">"'.$item['alias'].'"</span> успешно удалена!', true));
			return false;
		} else {
			set_flash('result', $error);
			return true;
		}
	}
	
	public function validate()
	{
		$rules = array(
			array(
				'field' => 'name',
				'label' => 'Имя',
				'rules'   => 'trim|max_length[255]'
			),
			array(
				'field' => 'email',
				'label' => 'E-mail',
				'rules'   => 'trim|valid_email|max_length[255]'
			),
			array(
				'field' => 'phone',
				'label' => 'Телефон',
				'rules'   => 'trim|required|max_length[255]'
			),
			array(
				'field' => 'text',
				'label' => 'Комментарий',
				'rules'   => 'trim|max_length[255]'
			),
			array(
				'field' => 'adres',
				'label' => 'Адрес',
				'rules'   => 'trim'
			),
		);
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		$this->form_validation->set_rules($rules);
		return $this->form_validation->run();
	}
}