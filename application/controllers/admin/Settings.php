<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends ADMIN_Controller {
	
	protected $model = '';
	
	public function __construct ()
	{
		parent::__construct();
		$this->load->model('settings_model');
		$this->model = $this->settings_model;
	}
	
	public function index()
	{
		$this->init_admin('settings');
		$data = $this->data;
		
		$this->breadcrumbs->add($data['pageinfo']['name'], 'settings');
		
		$data['view'] = uri(2).'/index';
		$this->load->view('admin/common/template', $data);
	}
	
	public function edit()
	{
		$this->load->library('upload', $this->settings_model->configPhoto());
		
		$error = false;
		if($this->input->post() and $this->model->validate())
		{
			$error = $this->model->update();
			if(!$error)
			{
				$redirect = uri(4) == 'close' ? '/admin/'.uri(2) : current_url();
				redirect($redirect);
			}
		}
		
		$this->init_admin('settings');
		$data = $this->data;
		
		$this->breadcrumbs->add($data['pageinfo']['name'], 'settings');
		$this->breadcrumbs->add('Редактирование', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/edit';
		$this->load->view('admin/common/template', $data);
	}
}
