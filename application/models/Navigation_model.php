<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Navigation_model extends CI_Model {
	
	protected $_table = 'navigation';
	
	public function getItems($limit = false, $offset = false, $order = false, $params = array())
	{
		$items = $this->query->items($this->_table, $limit, $offset, $order, $params);
		return $items;
	}
	
	public function getList($params = array())
	{
		$items = $this->query->items($this->_table, false, false, 'num|DESC', $params);
		$items = $this->query->items_list($items, 'idItem', 'title');
		return $items;
	}
	
	public function getTree($params = array())
	{
		$params['idParent'] = 0;
		$parents = $this->getItems(false, false, 'num|DESC', $params);
		if(empty($parents)) return array();
		foreach($parents as $parent)
		{
			$current = false;
			
			$check = trim($parent['link'], '/');
			$check_arr = explode('/', $check);
			if($check_arr[0] != 'pages' and $check_arr[0] == uri(1)) $current = true;
			if($check_arr[0] == 'pages' and $check_arr[1] == uri(2)) $current = true;
			
			$parent['current'] = $current;
			
			$items[$parent['idItem']] = $parent;
			$items[$parent['idItem']]['child'] = array();
		}
		
		unset($params['idParent']);
		$params['idParent !='] = 0;
		$childs = $this->getItems(false, false, 'num|DESC', $params);
		
		foreach($childs as $child) $items[$child['idParent']]['child'][] = $child;
		
		return $items;
	}
	
	public function getItem($id, $alias = false, $params = array())
	{
		if($alias) $params['alias'] = $id;
		else $params['idItem'] = $id;
		
		$item = $this->query->item($this->_table, $params);
		return $item;
	}
	
	public function getCount($params = array())
	{
		return $this->query->items_count($this->_table, $params);
	}
	
	public function insert()
	{
		$insert = $this->post();
		
		$error = $this->query->insert($this->_table, $insert);
		if($error)
		{
			return $error;
		} else {
			set_flash('result', action_result('success', fa('check mr5').' Запись <span class="medium">"'.$insert['title'].'"</span> успешно создана!', true));
			return false;
		}
	}
	
	public function update($id)
	{
		$insert = $this->post();
		
		$error = $this->query->update($this->_table, $insert, array('idItem' => $id));
		if($error)
		{
			return $error;
		} else {
			set_flash('result', action_result('success', fa('check mr5').' Запись <span class="medium">"'.$insert['title'].'"</span> успешно обновлена!', true));
			return false;
		}
	}
	
	public function delete($id)
	{
		$insert = $this->post();
		if($insert['delete'] != 'delete')
		{
			set_flash('result', action_result('error', fa('warning mr5').' Ошибка данных POST!', true));
			return true;
		}
		
		$item = $this->getItem($id);
		if(empty($item))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			return true;
		}
		
		if($item['idParent'] == 0)
		{
			$check = $this->getCount(array('idParent' => $id));
			if($check != 0)
			{
				set_flash('result', action_result('error', fa('warning mr5').' В категории есть записи!', true));
				return true;
			}
		}
		
		$error = $this->query->delete($this->_table, array('idItem' => $id));
		if(!$error)
		{
			set_flash('result', action_result('success', fa('trash mr5').' Запись <span class="medium">"'.$item['title'].'"</span> успешно удалена!', true));
			return false;
		} else {
			set_flash('result', $error);
			return true;
		}
	}
	
	# HELPER
	
	public function post()
	{
		$return = $this->input->post();
		if(array_key_exists('csrf_test_name', $return)) unset($return['csrf_test_name']);
		
		if(array_key_exists('visibility', $return)) $return['visibility'] = $return['visibility'] ? 1 : 0;
		else $return['visibility'] = 0;
		
		return $return;
	}
	
	# VALIDATE
	
	public function validate()
	{
		$rules = array(
			array(
				'field' => 'title',
				'label' => 'Заголовок',
				'rules'   => 'trim|required|max_length[255]',
			),
			array(
				'field' => 'link',
				'label' => 'Ссылка',
				'rules'   => 'trim|max_length[255]',
			),
			array(
				'field' => 'idParent',
				'label' => 'Категория',
				'rules'   => 'trim|required|integer',
			),
			array(
				'field' => 'num',
				'label' => 'Номер по порядку',
				'rules'   => 'trim|integer',
			),
		);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		$this->form_validation->set_rules($rules);
		return $this->form_validation->run();
	}
	
}
