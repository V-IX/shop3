<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_settings extends ADMIN_Controller {
	
	protected $page = 'shop_settings';
	protected $model = '';
	
	public function __construct ()
	{
		parent::__construct();
		$this->model = $this->settings_model;
		$this->load->model('units_model');
	}
	
	public function index()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$data['currency'] = $this->units_model->itemCurrency($this->data['siteinfo']['currency']);
		$data['length'] = $this->units_model->itemLength($this->data['siteinfo']['length']);
		$data['weight'] = $this->units_model->itemWeight($this->data['siteinfo']['weight']);
		
		//var_dump($data); die;
		
		$data['view'] = uri(2).'/index';
		$this->load->view('admin/common/template', $data);
	}
	
	public function edit()
	{
		$this->load->library('upload', $this->settings_model->configPhoto());
		
		$error = false;
		if($this->input->post() and $this->model->validate('shop'))
		{
			$error = $this->model->update_shop();
			if(!$error)
			{
				$redirect = uri(4) == 'close' ? '/admin/'.uri(2) : current_url();
				redirect($redirect);
			}
		}
		
		$this->init_admin($this->page);
		$data = $this->data;
		
		$data['currency'] = $this->units_model->listCurrency();
		$data['length'] = $this->units_model->listLength();
		$data['weight'] = $this->units_model->listWeight();
		
		$this->breadcrumbs->add('Редактирование', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/edit';
		$this->load->view('admin/common/template', $data);
	}
}
