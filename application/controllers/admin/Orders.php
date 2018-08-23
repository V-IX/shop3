<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends ADMIN_Controller {
	
	protected $model = '';
	protected $page = 'orders';
	
	public function __construct ()
	{
		parent::__construct();
		$this->load->model('orders_model');
		$this->model = $this->orders_model;
	}
	
	public function index()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$count = $this->model->getCount();
		$pagination = admin_pagination(uri(2).'/index', $count);
		
		$data['items'] = $this->model->getItems($pagination['per_page'], $pagination['offset'], 'isRead|ASC//addDate|DESC', array());
		$this->load->library('pagination');
		$this->pagination->initialize($pagination);
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		
		$data['view'] = uri(2).'/index';
		$this->load->view('admin/common/template', $data);
	}
	
	public function view()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$data['item'] = $this->model->getItem(array('idItem' => uri(4)));
		if(empty($data['item']))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			redirect('admin/'.uri(2));
		}
		
		if($data['item']['isRead'] == 0) $this->model->isRead(uri(4));
		
		$data['pageinfo']['title'] = $data['pageinfo']['title'].' #'.$data['item']['alias'];
		
		$this->breadcrumbs->add($data['pageinfo']['name'].' #'.$data['item']['alias'], uri(2));
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
