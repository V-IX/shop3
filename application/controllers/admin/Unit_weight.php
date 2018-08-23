<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_weight extends ADMIN_Controller {
	
	protected $model = '';
	protected $page = 'unit_weight';
	
	public function __construct ()
	{
		parent::__construct();
		$this->load->model('units_model');
		$this->model = $this->units_model;
	}
	
	public function index()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$count = $this->model->countWeight();
		$pagination = admin_pagination(uri(2).'/index', $count);
		
		$data['items'] = $this->model->itemsWeight($pagination['per_page'], $pagination['offset'], 'value|DESC');
		$this->load->library('pagination');
		$this->pagination->initialize($pagination);
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		
		$data['view'] = uri(2).'/index';
		$this->load->view('admin/common/template', $data);
	}
	
	public function create()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->model->validate('weight'))
		{
			$error = $this->model->insertWeight();
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
		$this->init_admin($this->page);
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->model->validate('weight'))
		{
			$error = $this->model->updateWeight(uri(4));
			if(!$error)
			{
				$redirect = uri(5) == 'close' ? '/admin/'.uri(2) : current_url();
				redirect($redirect);
			}
		}
		
		$data['item'] = $this->model->itemWeight(uri(4));
		if(empty($data['item']))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			redirect('admin/'.uri(2));
		}
		
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		$this->breadcrumbs->add('Редактирование', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/edit';
		$this->load->view('admin/common/template', $data);
	}
	
	public function delete()
	{
		if($this->input->post()) $this->model->deleteWeight(uri(4));
		redirect('admin/'.uri(2));
	}
}
