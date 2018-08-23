<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Panel_model extends CI_Model {
	
	# WORK WITH ADMIN THEME
	
	protected $_tpl_table = 'theme_admin';
	
	public function getItemsTheme($limit = false, $offset = false, $order = false, $params = array())
	{
		$items = $this->query->items($this->_tpl_table, $limit, $offset, $order, $params);
		return $items;
	}
	
	public function getItemTheme($id, $alias = false, $params = array())
	{
		if($alias) $params['alias'] = $id;
		else $params['idItem'] = $id;
		
		$item = $this->query->item($this->_tpl_table, $params);
		return $item;
	}
	
	public function getCurrentTheme()
	{
		$item = $this->query->item($this->_tpl_table, array('current' => 1));
		return $item;
	}
	
	public function getCountTheme($params = array())
	{
		return $this->query->items_count($this->_tpl_table, $params);
	}
	
	public function updateTheme()
	{
		$post = $this->post();
		$current = $post['theme'];
		$this->query->update($this->_tpl_table, array('current' => 0));
		$error = $this->query->update($this->_tpl_table, array('current' => 1), array('alias' => $current));
		if(!$error)
		{
			set_flash('result', action_result('success', fa('check mr5').' Внешний вид успешно изменен!', true));
			return false;
		} else {
			set_flash('result', $error);
			return true;
		}
	}
	
	# HELPERS
	
	public function post()
	{
		$return = $this->input->post();
		if(array_key_exists('csrf_test_name', $return)) unset($return['csrf_test_name']);
		
		return $return;
	}
	
	# VALIDATE
	
	public function validate($key = 'default')
	{
		$rules = array(
			'default' => array(
			
			),
			'theme' => array(
				array(
					'field' => 'theme',
					'label' => 'Тема',
					'rules'   => 'required'
				),
			),
		);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		$this->form_validation->set_rules($rules[$key]);
		return $this->form_validation->run();
	}
}
