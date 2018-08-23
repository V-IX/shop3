<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends SITE_Controller {
	
	protected $model = '';
	protected $page = '';
	
	public function __construct ()
	{
		parent::__construct();
		$this->load->model('pages_model');
		$this->model = $this->pages_model;
	}
	
	public function index()
	{
		$this->init_site($this->page);
		
		if(!uri(2)) redirect('/');
		
		$item = $this->model->getItem(uri(2), true, array('visibility' => 1));
		if(empty($item)) redirect(uri(1));
		$this->data['item'] = $item;
		
		$this->breadcrumbs->add($item['title'], 'pages/'.uri(1));
		
		$this->site_seo();
		$this->data['view'] = 'pages/page';
		$this->load->view('site/common/template', $this->data);
	}
}
