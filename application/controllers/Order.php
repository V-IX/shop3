<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends SITE_Controller {
	
	protected $model = '';
	protected $page = 'order';

	function __construct ()
	{	
		parent::__construct();
		$this->load->model('orders_model');
		$this->model = $this->orders_model;
	}

	public function index()
	{
		if(!uri(2)) redirect('catalog');
		
		$this->init_site($this->page);
		
		$this->data['item'] = $this->model->getItem(array('alias' => uri(2)));
		
		$this->load->model('products_model');
		$this->data['hits'] = $this->products_model->getItems(10, false, 'num|DESC//title|ASC', array('sticker_hit' => 1));
		
		$this->breadcrumbs->add($this->data['pageinfo']['name'], uri(1));
		
		$this->site_seo();
		$this->data['view'] = 'shop/order';
		$this->load->view('site/common/template', $this->data);
	}
}