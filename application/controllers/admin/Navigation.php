<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Navigation extends ADMIN_Controller {
	
	protected $model = '';
	protected $page = 'navigation';
	
	public function __construct ()
	{
		parent::__construct();
		$this->load->model('navigation_model');
		$this->model = $this->navigation_model;
		$this->data['position'] = 'top';
	}
	
	public function index()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$data['items'] = $this->model->getTree(array('position' => $this->data['position']));
		
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		
		$data['view'] = 'navigation/index';
		$this->load->view('admin/common/template', $data);
	}
	
	public function create()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->model->validate())
		{
			$error = $this->model->insert();
			if(!$error) redirect('/admin/'.uri(2));
		}
		
		$data['parents'] = $this->model->getList(array('idParent' => 0, 'position' => $this->data['position']));
		
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		$this->breadcrumbs->add('Добавить', '');
		
		$data['_error'] = $error;
		$data['view'] = 'navigation/create';
		$this->load->view('admin/common/template', $data);
	}
	
	public function edit()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->model->validate())
		{
			$error = $this->model->update(uri(4));
			if(!$error)
			{
				$redirect = uri(5) == 'close' ? '/admin/'.uri(2) : current_url();
				redirect($redirect);
			}
		}
		
		$data['item'] = $this->model->getItem(uri(4));
		if(empty($data['item']))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			redirect('admin/'.uri(2));
		}
		
		$data['parents'] = $this->model->getList(array('idParent' => 0, 'position' => $this->data['position']));
		
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		$this->breadcrumbs->add('Редактирование', '');
		
		$data['_error'] = $error;
		$data['view'] = 'navigation/edit';
		$this->load->view('admin/common/template', $data);
	}
	
	public function view()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$data['item'] = $this->model->getItem(uri(4), array('position' => $this->data['position']));
		if(empty($data['item']))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			redirect('admin/'.uri(2));
		}
		
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		$this->breadcrumbs->add('Просмотр', '');
		
		$data['view'] = 'navigation/view';
		$this->load->view('admin/common/template', $data);
	}
	
	public function delete()
	{
		if($this->input->post()) $this->model->delete(uri(4));
		redirect('admin/'.uri(2));
	}
}
