<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends SITE_Controller {
	
	protected $model = '';
	protected $page = 'search';
	
	public function __construct ()
	{
		parent::__construct();
		$this->load->model('catalog_model');
		$this->load->model('products_model');
	}
	
	public function index()
	{
		$this->init_site($this->page);
		
		$params = array('visibility' => 1);
		$count = $this->products_model->getCount($params);
		$pagination = site_pagination(uri(1).'/index', $count, 10);
		$this->data['products'] = $this->products_model->getItems($pagination['per_page'], $pagination['offset'], 'addDate|DESC', $params);
		$this->data['count'] = $count;
		$this->data['search'] = $this->input->get('search');
		
		$this->load->library('pagination');
		$this->pagination->initialize($pagination);
		
		$tree = $this->catalog_model->getItemsTree(false, false, 'num|DESC', array('visibility' => 1));
		
        $this->data['paths'] = $tree['paths'];
		
		$this->breadcrumbs->add($this->data['pageinfo']['name'], 'pages/'.uri(1));
		
		$this->site_seo();
		$this->data['view'] = 'shop/search';
		$this->load->view('site/common/template', $this->data);
	}
}
