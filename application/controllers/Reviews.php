<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reviews extends SITE_Controller {
	
	protected $model = '';
	protected $page = 'reviews';
	
	public function __construct ()
	{
		parent::__construct();
		$this->load->model('reviews_model');
		$this->model = $this->reviews_model;
	}
	
	public function index()
	{
		$this->init_site($this->page);
		
		$params = array('visibility' => 1);
		$count = $this->model->getCount($params);
		$pagination = site_pagination(uri(1).'/index', $count);
		$this->data['items'] = $this->model->getItems($pagination['per_page'], $pagination['offset'], 'addDate|DESC', $params, true);
		
		$this->load->library('pagination');
		$this->pagination->initialize($pagination);
		
		$this->breadcrumbs->add($this->data['pageinfo']['name'], uri(1));
		
		$this->site_seo();
		$this->data['view'] = 'pages/reviews';
		$this->load->view('site/common/template', $this->data);
	}
	
	public function ajaxSend()
	{
		$this->output->set_content_type('application/json');
		$this->model->insert_user();
		$this->output->set_output(json_encode(array('error'=> false)));
	}
}
