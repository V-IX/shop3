<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends SITE_Controller {

	protected $model = '';
	protected $page = 'errors';
	
	public function __construct ()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->init_site($this->page);
		
		$this->breadcrumbs->add($this->data['pageinfo']['name'], uri(1));
		
		header("HTTP/1.1 404 Not Found");
		
		$this->site_seo();
		$this->data['view'] = 'common/errors';
		$this->load->view('site/common/template', $this->data);
	}
}
