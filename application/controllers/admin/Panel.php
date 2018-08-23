<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends ADMIN_Controller {
	
	protected $model = '';
	protected $page = 'panel';
	
	public function __construct ()
	{
		parent::__construct();
		$this->load->model('panel_model');
		$this->model = $this->panel_model;
	}
	
	public function index()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$data['theme'] = $this->model->getCurrentTheme();
		
		$data['view'] = uri(2).'/index';
		$this->load->view('admin/common/template', $data);
	}
	
	public function edit_theme()
	{
		$error = false;
		if($this->input->post() and $this->model->validate('theme'))
		{
			$error = $this->model->updateTheme();
			if(!$error) redirect('/admin/'.uri(2));
		}
		
		$this->init_admin($this->page);
		$data = $this->data;
		
		$data['themes'] = $this->model->getItemsTheme();
		
		$this->breadcrumbs->add('Изменить внешний вид', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/edit_theme';
		$this->load->view('admin/common/template', $data);
	}
	
	public function edit()
	{
		$this->load->library('upload', $this->settings_model->configPhoto());
		
		$error = false;
		if($this->input->post() and $this->model->validate())
		{
			$error = $this->model->update();
			if(!$error) redirect('/admin/'.uri(2));
		}
		
		$this->init_admin($this->page);
		$data = $this->data;
		
		$this->breadcrumbs->add($data['pageinfo']['name'], 'settings');
		$this->breadcrumbs->add('Редактирование', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/edit';
		$this->load->view('admin/common/template', $data);
	}
}
