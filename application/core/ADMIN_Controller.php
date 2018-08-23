<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ADMIN_Controller extends CI_Controller {

	protected $data = array();
	
	public function __construct ()
	{
		parent::__construct();
		$this->load->model('settings_model');
		$this->load->model('adminpage_model');
		$this->load->model('users_model');
		
	}
	
	public function init_admin($id)
	{
		if(!$this->session->userdata('id')) redirect('/admin/login');
		
		$this->data['siteinfo'] = $this->_settings();
		$this->data['cms'] = $this->_cms();
		$this->data['left_nav'] = $this->_left_nav();
		$this->data['userinfo'] = $this->_user();
		$this->data['pageinfo'] = $this->_adminpage($id);
		$this->data['admin_bells'] = $this->_bells();
		$this->data['folder'] = $id;
		$this->data['currency'] = $this->_currency($this->data['siteinfo']['currency']);
		
		$this->breadcrumbs->add($this->data['pageinfo']['name'], $this->data['pageinfo']['link']);
	}
	
	/* admin */
	
	protected function _settings()
	{
		$return = $this->settings_model->getItem();
		if(empty($return)) exit('No current settings');
		return $return;
	}
	
	protected function _theme()
	{
		$item = $this->query->item('theme_admin', array('current' => 1));
		if(empty($item)) exit('No current theme');
		$return = $item['alias'];
		return $return;
	}
	
	protected function _cms()
	{
		return array(
			'title' => $this->config->config['cms_title'],
			'version' => $this->config->config['cms_version'],
			'copyright' => $this->config->config['cms_copyright'],
		);
	}
	
	protected function _left_nav()
	{
		$return = $this->adminpage_model->tree();
		return $return;
	}
	
	protected function _user()
	{
		$return = $this->users_model->getItem($this->session->userdata('id'));
		return $return;
	}
	
	protected function _adminpage($alias)
	{
		$return = $this->adminpage_model->item($alias, true);
		return $return;
	}
	
	protected function _currency($id)
	{
		$curr = $this->query->item('shop_unit_currency', array('idItem' => $id));
		if(empty($curr)) exit('No current currency');
		return $curr;
	}
	
	protected function _bells()
	{
		$return = $this->adminpage_model->bells();
		return $return;
	}
	
	
}
