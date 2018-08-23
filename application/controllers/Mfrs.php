<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mfrs extends SITE_Controller {
	
	protected $model = '';
	protected $page = 'mfrs';
	
	public function __construct ()
	{
		parent::__construct();
		$this->load->model('mfrs_model');
		$this->model = $this->mfrs_model;
	}
	
	public function index()
	{
		$this->init_site($this->page);
		
		$params = array('visibility' => 1);
		$count = $this->model->getCount($params);
		$pagination = site_pagination(uri(1).'/index', $count, 12);
		$this->data['items'] = $this->model->getItems($pagination['per_page'], $pagination['offset'], 'title|ASC', $params, true);
		
		$this->load->library('pagination');
		$this->pagination->initialize($pagination);
		
		$this->breadcrumbs->add($this->data['pageinfo']['name'], uri(1));
		
		$this->site_seo();
		$this->data['view'] = 'pages/mfrs';
		$this->load->view('site/common/template', $this->data);
	}
	
	public function view()
	{
		$this->init_site($this->page);
		$data = $this->data;
		
		$item = $this->model->getItem(uri(2), true, array('visibility' => 1));
		if(empty($item)) redirect(uri(1));
		
		$this->data['item'] = $item;
		
		$this->load->model('catalog_model');
		$tree = $this->catalog_model->getItemsTree(false, false, 'num|DESC', array('visibility' => 1));
        $this->data['paths'] = $tree['paths'];
		
		$this->load->model('products_model');
		$this->db->select('idItem, idParent, title, alias, articul, brief, img, price, oldPrice, sticker_new, sticker_hit, mTitle');
		$this->data['products'] = $this->products_model->getItems(10, false, 'addDate|RANDOM', array('visibility' => 1, 'idMfrs' => $item['idItem']));
		
		$this->breadcrumbs->add($this->data['pageinfo']['name'], uri(1));
		$this->breadcrumbs->add($item['title'], uri(1).'/'.$item['alias']);
		
		$this->site_seo();
		$this->data['view'] = 'pages/mfr';
		$this->load->view('site/common/template', $this->data);
	}
}
