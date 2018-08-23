<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Fields extends ADMIN_Controller {
	
	protected $model = '';
	protected $page = 'fields';
	
	public function __construct ()
	{
		parent::__construct();
		$this->load->model('fields_model');
		$this->model = $this->fields_model;
	}
	
	public function index()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$count = $this->model->getGroupCount();
		$pagination = admin_pagination(uri(2).'/index', $count);
		
		$data['items'] = $this->model->getGroups($pagination['per_page'], $pagination['offset'], 'num|DESC');
		$this->load->library('pagination');
		$this->pagination->initialize($pagination);
		
		$data['view'] = uri(2).'/group_index';
		$this->load->view('admin/common/template', $data);
	}
	
	public function tree()
	{
		$items = $this->model->getTree();
		var_dump($items);
	}
	
	public function create()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->model->validate('group'))
		{
			$error = $this->model->insertGroup();
			if(!$error) redirect('/admin/'.uri(2));
		}
		
		$this->breadcrumbs->add('Добавить группу', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/group_create';
		$this->load->view('admin/common/template', $data);
	}
	
	public function edit()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->model->validate('group'))
		{
			$error = $this->model->updateGroup(uri(4));
			if(!$error) redirect('/admin/'.uri(2));
		}
		
		$data['item'] = $this->model->getGroup(uri(4));
		if(empty($data['item']))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			redirect('admin/'.uri(2));
		}
		
		$this->breadcrumbs->add('Редактирование', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/group_edit';
		$this->load->view('admin/common/template', $data);
	}
	
	public function view()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$data['item'] = $this->model->getGroup(uri(4));
		if(empty($data['item']))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			redirect('admin/'.uri(2));
		}
		
		$data['items'] = $this->model->getItems(false, false, 'num|DESC//title|ASC', array('idParent' => uri(4)));
		$data['types'] = $this->model->getTypes();
		
		$this->breadcrumbs->add($data['item']['title'], '');
		
		$data['view'] = uri(2).'/group_view';
		$this->load->view('admin/common/template', $data);
	}
	
	public function delete()
	{
		if($this->input->post()) $this->model->deleteGroup(uri(4));
		redirect('admin/'.uri(2));
	}
	
	/* items */
	
	public function item_create()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->model->validate())
		{
			$error = $this->model->insertItem();
			if(!$error) redirect('/admin/'.uri(2).'/view/'.uri(4));
		}
		
		$data['item'] = $this->model->getGroup(uri(4));
		if(empty($data['item']))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			redirect('admin/'.uri(2));
		}
		
		$data['types'] = $this->model->getTypes();
		
		$this->breadcrumbs->add($data['item']['title'], 'fields/view/'.$data['item']['idItem']);
		$this->breadcrumbs->add('Добавить поле', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/item_create';
		$this->load->view('admin/common/template', $data);
	}
	
	public function item_edit()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$data['item'] = $this->model->getItem(uri(4));
		if(empty($data['item']))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			redirect('admin/'.uri(2));
		}
		
		$error = false;
		if($this->input->post() and $this->model->validate())
		{
			$error = $this->model->updateItem(uri(4));
			if(!$error) redirect('/admin/'.uri(2).'/view/'.$data['item']['idParent']);
		}
		
		$parent = $this->model->getGroup($data['item']['idParent']);
		if(empty($parent))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Родительская группа не найдена!', true));
			redirect('admin/'.uri(2));
		}
		$data['parent'] = $parent;
		$data['types'] = $this->model->getTypes();
		
		$data['values'] = $this->model->getValues(uri(4));
		
		$this->breadcrumbs->add($parent['title'], 'fields/view/'.$parent['idItem']);
		$this->breadcrumbs->add('Редактирование', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/item_edit';
		$this->load->view('admin/common/template', $data);
	}
	
	public function item_delete()
	{
		if($this->input->post()) $this->model->deleteItem(uri(4));
		redirect('admin/'.uri(2));
	}
	
	
}
