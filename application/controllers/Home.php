<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends SITE_Controller {
	
	protected $model = '';
	protected $page = 'home';
	
	public function __construct ()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->init_site($this->page);
		
		$this->load->model('slider_model');
		$this->data['slider'] = $this->slider_model->getItems(false, false, 'num|DESC', array('visibility' => 1));
		
		$this->load->model('catalog_model');
		
		$tree = $this->catalog_model->getItemsTree(false, false, 'num|DESC', array('visibility' => 1));
		$this->data['paths'] = $tree['paths'];
		
		$this->load->model('products_model');
		$this->data['hits'] = $this->products_model->getItems(10, false, 'num|DESC//title|ASC', array('visibility' => 1, 'sticker_hit' => 1));
		
		$this->load->model('news_model');
		$this->data['news'] = $this->news_model->getItems(9, false, 'addDate|DESC', array('visibility' => 1));
		
		$this->load->model('mfrs_model');
		$this->data['mfrs'] = $this->mfrs_model->getItems(false, false, 'home_num|DESC//num|DESC', array('visibility' => 1, 'home' => 1));
		
		$this->site_seo();
		$this->data['view'] = 'common/index';
		$this->load->view('site/common/template', $this->data);
	}
}
