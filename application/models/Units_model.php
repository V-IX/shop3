<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Units_model extends CI_Model {
	
	protected $_table_length = 'shop_unit_length';
	protected $_table_weight = 'shop_unit_weight';
	protected $_table_currency = 'shop_unit_currency';
	
	/* LENGTH CONTROL */
	
	public function itemsLength($limit = false, $offset = false, $order = false, $params = array())
	{
		return $this->_items($this->_table_length, $limit, $offset, $order, $params);
	}
	
	public function listLength($limit = false, $offset = false, $order = false, $params = array())
	{
		$items = $this->itemsLength($limit, $offset, $order, $params);
		return $this->query->items_list($items, 'idItem', 'title');
	}
	
	public function itemLength($id, $alias = false, $params = array())
	{
		return $this->_item($this->_table_length, $id, $alias, $params);
	}
	
	public function countLength($params = array())
	{
		return $this->_count($this->_table_length, $params);
	}
	
	public function insertLength()
	{
		return $this->_insert($this->_table_length);
	}
	
	public function updateLength($id)
	{
		return $this->_update($this->_table_length, $id);
	}
	
	public function deleteLength($id)
	{
		$check = $this->query->items_count('shop_products', array('unit_length' => $id));
		if($check != 0)
		{
			set_flash('result', action_result('error', fa('times mr5').' Запись не может быть удалена, так как используется в товарах!', true));
			return false;
		}
		
		return $this->_delete($this->_table_length, $id);
	}
	
	/* Weight CONTROL */
	
	public function itemsWeight($limit = false, $offset = false, $order = false, $params = array())
	{
		return $this->_items($this->_table_weight, $limit, $offset, $order, $params);
	}
	
	public function listWeight($limit = false, $offset = false, $order = false, $params = array())
	{
		$items = $this->itemsWeight($limit, $offset, $order, $params);
		return $this->query->items_list($items, 'idItem', 'title');
	}
	
	public function itemWeight($id, $alias = false, $params = array())
	{
		return $this->_item($this->_table_weight, $id, $alias, $params);
	}
	
	public function countWeight($params = array())
	{
		return $this->_count($this->_table_weight, $params);
	}
	
	public function insertWeight()
	{
		return $this->_insert($this->_table_weight);
	}
	
	public function updateWeight($id)
	{
		return $this->_update($this->_table_weight, $id);
	}
	
	public function deleteWeight($id)
	{
		$check = $this->query->items_count('shop_products', array('unit_weight' => $id));
		if($check != 0)
		{
			set_flash('result', action_result('error', fa('times mr5').' Запись не может быть удалена, так как используется в товарах!', true));
			return false;
		}
		
		return $this->_delete($this->_table_weight, $id);
	}
	
	/* Currency CONTROL */
	
	public function itemsCurrency($limit = false, $offset = false, $order = false, $params = array())
	{
		return $this->_items($this->_table_currency, $limit, $offset, $order, $params);
	}
	
	public function listCurrency($limit = false, $offset = false, $order = false, $params = array())
	{
		$items = $this->itemsCurrency($limit, $offset, $order, $params);
		return $this->query->items_list($items, 'idItem', 'title');
	}
	
	public function itemCurrency($id, $alias = false, $params = array())
	{
		return $this->_item($this->_table_currency, $id, $alias, $params);
	}
	
	public function countCurrency($params = array())
	{
		return $this->_count($this->_table_currency, $params);
	}
	
	public function insertCurrency()
	{
		return $this->_insert($this->_table_currency);
	}
	
	public function updateCurrency($id)
	{
		return $this->_update($this->_table_currency, $id);
	}
	
	public function deleteCurrency($id)
	{
		$check = $this->query->items_count('shop_products', array('currency' => $id));
		if($check != 0)
		{
			set_flash('result', action_result('error', fa('times mr5').' Запись не может быть удалена, так как используется в товарах!', true));
			return false;
		}
		
		return $this->_delete($this->_table_currency, $id);
	}
	
	/* HELPERS */
	
	protected function _items($table, $limit = false, $offset = false, $order = false, $params = array())
	{
		$items = $this->query->items($table, $limit, $offset, $order, $params);
		return $items;
	}
	
	protected function _item($table, $id, $alias = false, $params = array())
	{
		if($alias) $params['alias'] = $id;
		else $params['idItem'] = $id;
		
		$item = $this->query->item($table, $params);
		return $item;
	}
	
	protected function _count($table, $params = array())
	{
		return $this->query->items_count($table, $params);
	}
	
	protected function _insert($table)
	{
		$insert = $this->post();
		
		$error = $this->query->insert($table, $insert);
		if($error)
		{
			return $error;
		} else {
			set_flash('result', action_result('success', fa('check mr5').' Запись <span class="medium">"'.$insert['title'].'"</span> успешно создана!', true));
			return false;
		}
	}
	
	protected function _update($table, $id)
	{
		$insert = $this->post();
		
		$error = $this->query->update($table, $insert, array('idItem' => $id));
		if($error)
		{
			return $error;
		} else {
			set_flash('result', action_result('success', fa('check mr5').' Запись <span class="medium">"'.$insert['title'].'"</span> успешно обновлена!', true));
			return false;
		}
	}
	
	protected function _delete($table, $id)
	{
		$insert = $this->post();
		if($insert['delete'] != 'delete')
		{
			set_flash('result', action_result('error', fa('warning mr5').' Ошибка данных POST!', true));
			return true;
		}
		
		$item = $this->_item($table, $id);
		if(empty($item))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			return true;
		}
		
		$error = $this->query->delete($table, array('idItem' => $id));
		if(!$error)
		{
			set_flash('result', action_result('success', fa('trash mr5').' Запись <span class="medium">"'.$item['title'].'"</span> успешно удалена!', true));
			return false;
		} else {
			set_flash('result', $error);
			return true;
		}
	}
	
	public function post()
	{
		$return = $this->input->post();
		if(array_key_exists('csrf_test_name', $return)) unset($return['csrf_test_name']);
		
		return $return;
	}
	
	# VALIDATE
	
	public function validate($key)
	{
		$rules = array(
			'length' => array(
				array(
					'field' => 'title',
					'label' => 'Заголовок',
					'rules'   => 'trim|required|max_length[255]',
				),
				array(
					'field' => 'alias',
					'label' => 'Единица измерения',
					'rules'   => 'trim|required|max_length[255]',
				),
				array(
					'field' => 'value',
					'label' => 'Значение',
					'rules'   => 'trim|required|numeric',
				),
			),
			'weight' => array(
				array(
					'field' => 'title',
					'label' => 'Заголовок',
					'rules'   => 'trim|required|max_length[255]',
				),
				array(
					'field' => 'alias',
					'label' => 'Единица измерения',
					'rules'   => 'trim|required|max_length[255]',
				),
				array(
					'field' => 'value',
					'label' => 'Значение',
					'rules'   => 'trim|required|numeric',
				),
			),
			'currency' => array(
				array(
					'field' => 'title',
					'label' => 'Заголовок',
					'rules'   => 'trim|required|max_length[255]',
				),
				array(
					'field' => 'alias',
					'label' => 'Код валюты',
					'rules'   => 'trim|required|max_length[255]',
				),
				array(
					'field' => 'unit',
					'label' => 'Сокращение',
					'rules'   => 'trim|required|max_length[5]',
				),
				array(
					'field' => 'value',
					'label' => 'Значение',
					'rules'   => 'trim|required|numeric',
				),
			),
		);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		$this->form_validation->set_rules($rules[$key]);
		return $this->form_validation->run();
	}
	
}
