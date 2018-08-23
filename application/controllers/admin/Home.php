<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends ADMIN_Controller {
	
	public function index()
	{
		redirect('admin/settings');
		$this->init_admin('home');
		$data = $this->data;
		
		$this->load->model('feedback_model');
		$data['counter']['feedback'] = $this->feedback_model->getCount(array('isRead' => 0));
		$data['feedbacks'] = $this->feedback_model->getItems(false, false, 'addDate|DESC', array('isRead' => 0));
		
		$this->load->model('news_model');
		$data['counter']['publications'] = $this->news_model->getCount();
		
		$this->load->model('pages_model');
		$data['counter']['pages'] = $this->pages_model->getCount();
		
		//$this->load->model('price_model');
		//$data['counter']['price'] = $this->price_model->getPriceCount();
		
		$data['view'] = 'common/index';
		$this->load->view('admin/common/template', $data);
	}
}
