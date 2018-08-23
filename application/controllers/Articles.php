<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends SITE_Controller {
	
	protected $model = '';
	protected $page = 'articles';
	
	public function __construct ()
	{
		parent::__construct();
		$this->load->model('articles_model');
		$this->model = $this->articles_model;
	}
	
	public function index()
	{
		$this->init_site($this->page);
		
		$params = array('visibility' => 1);
		$count = $this->model->getCount($params);
		$pagination = site_pagination(uri(1).'/index', $count, 12);
		$this->data['items'] = $this->model->getItems($pagination['per_page'], $pagination['offset'], 'addDate|DESC', $params, true);
		
		$this->load->library('pagination');
		$this->pagination->initialize($pagination);
		
		$this->breadcrumbs->add($this->data['pageinfo']['name'], uri(1));
		
		$this->site_seo();
		$this->data['view'] = 'pages/articles';
		$this->load->view('site/common/template', $this->data);
	}
	
	public function view()
	{
		$this->init_site($this->page);
		$data = $this->data;
		
		$item = $this->model->getItem(uri(2), true, array('visibility' => 1));
		if(empty($item)) redirect(uri(1));
		
		$this->data['item'] = $item;
		
		$this->data['news'] = $this->model->getItems(6, false, 'addDate|RANDOM', array('idItem !=' => $item['idItem']));
		
		$this->breadcrumbs->add($this->data['pageinfo']['name'], uri(1));
		$this->breadcrumbs->add($item['title'], uri(1).'/'.$item['alias']);
		
		$this->site_seo();
		$this->data['view'] = 'pages/article';
		$this->load->view('site/common/template', $this->data);
	}
}
