<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends SITE_Controller {
	
	protected $model = '';
	protected $page = 'contacts';
	
	public function __construct ()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->init_site($this->page);
		
		$this->breadcrumbs->add($this->data['pageinfo']['name'], uri(1));
		
		$this->site_seo();
		$this->data['view'] = 'pages/contacts';
		$this->load->view('site/common/template', $this->data);
	}
	
	public function ajaxSend()
	{
		$this->output->set_content_type('application/json');
		$this->load->model('feedback_model');
		$this->feedback_model->insert();
		$this->output->set_output(json_encode(array('error'=> false)));
	}
	
	public function ajaxOrder()
	{
		$this->output->set_content_type('application/json');
		$this->load->model('feedback_order_model');
		$this->feedback_order_model->insert();
		$this->output->set_output(json_encode(array('error'=> false)));
	}
	
	public function ajaxComment()
	{
		$this->output->set_content_type('application/json');
		$this->load->model('comments_model');
		$this->comments_model->insert_user();
		$this->output->set_output(json_encode(array('error'=> false)));
	}
}
