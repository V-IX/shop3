<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends ADMIN_Controller {
	
	protected $model = '';
	
	public function __construct ()
	{
		parent::__construct();
		$this->model = $this->users_model;
	}
	
	public function index()
	{
		$this->init_admin('users');
		$data = $this->data;
		
		$count = $this->model->getCount();
		$pagination = admin_pagination(uri(2).'/index', $count);
		
		$data['items'] = $this->model->getItems($pagination['per_page'], $pagination['offset'], 'login|ASC');
		$this->load->library('pagination');
		$this->pagination->initialize($pagination);
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		
		$data['view'] = uri(2).'/index';
		$this->load->view('admin/common/template', $data);
	}
	
	public function create()
	{
		$this->init_admin('users');
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->model->validate('insert'))
		{
			$error = $this->model->insert();
			if(!$error) redirect('/admin/'.uri(2));
		}
		
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		$this->breadcrumbs->add('Добавить', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/create';
		$this->load->view('admin/common/template', $data);
	}
	
	public function edit()
	{
		$this->init_admin('users');
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->model->validate('update'))
		{
			$error = $this->model->update(uri(4));
			if(!$error) redirect('/admin/'.uri(2));
		}
		
		$data['item'] = $this->model->getItem(uri(4));
		if(empty($data['item']))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Пользователь не найден!', true));
			redirect('admin/'.uri(2));
		}
		
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		$this->breadcrumbs->add('Редактирование', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/edit';
		$this->load->view('admin/common/template', $data);
	}
	
	public function password()
	{
		$this->init_admin('users');
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->model->validate('password'))
		{
			$error = $this->model->password();
			if(!$error) redirect('/admin/'.uri(2));
		}
		
		$data['item'] = $this->model->getItem($this->session->userdata('id'));
		if(empty($data['item']))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Пользователь не найден!', true));
			redirect('admin/'.uri(2));
		}
		
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		$this->breadcrumbs->add('Изменения пароля', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/password';
		$this->load->view('admin/common/template', $data);
	}
	
	public function view()
	{
		$this->init_admin('users');
		$data = $this->data;
		
		$data['item'] = $this->model->getItem(uri(4));
		if(empty($data['item']))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Пользователь не найден!', true));
			redirect('admin/'.uri(2));
		}
		
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		$this->breadcrumbs->add('Просмотр', '');
		
		$data['view'] = uri(2).'/view';
		$this->load->view('admin/common/template', $data);
	}
	
	public function delete()
	{
		if($this->input->post()) $this->model->delete(uri(4));
		redirect('admin/'.uri(2));
	}
}
