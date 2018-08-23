<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Fields_model extends CI_Model {
	
	protected $_table = 'shop_fields';
	protected $_table_values = 'shop_fields_values';
	protected $_table_groups = 'shop_fields_groups';
	protected $_table_products = 'shop_fields_products';
	
	public function getTree()
	{
		$return = array();
		
		$items = $this->getGroups(false, false, 'num|DESC');
		if(empty($items)) return array();
		
		foreach($items as $item)
		{
			$item['child'] = array();
			$return[$item['idItem']] = $item;
		}
		
		$childs = $this->getItems(false, false, 'num|DESC');
		
		foreach($childs as $child)
		{
			if(isset($return[$child['idParent']]))
			{
				$return[$child['idParent']]['child'][$child['idItem']] = $child;
			}
		}
		
		return $return;
	}
	
	/* GROUPS */
	
	public function getItemsByArr($where_in)
	{
		$return = array();
		if(empty($where_in)) return $return;
		
		$this->db->where_in('idItem', $where_in);
		$fields = $this->query->items($this->_table, false, false, 'num|DESC');
		
		$where_val = array();
		foreach($fields as $field)
		{
			if($field['type'] == 'select' or $field['type'] == 'checkbox')
			{
				$field['values'] = array();
				$where_val[] = $field['idItem'];
			}
			if($field['type'] == 'number')
			{
				$this->db->where('idField', $field['idItem']);
				$this->db->select_min('CAST(value as decimal(19,0))', 'min_v');
				$this->db->select_max('CAST(value as decimal(19,0))', 'max_v');
				$_m_query = $this->query->item($this->_table_products);
				
				$field['min'] = $_m_query['min_v'] ? $_m_query['min_v'] : 0;
				$field['max'] = $_m_query['max_v'] ? $_m_query['max_v'] : 0;
				$field['get_min'] = (isset($_GET['num'][$field['idItem']]['from']) and $_GET['num'][$field['idItem']]['from'] != '') ? $_GET['num'][$field['idItem']]['from'] : $field['min'];
				$field['get_max'] = (isset($_GET['num'][$field['idItem']]['to']) and $_GET['num'][$field['idItem']]['to'] != '') ? $_GET['num'][$field['idItem']]['to'] : $field['max'];
			}
			
			$return[$field['idItem']] = $field;
		}
		
		if(!empty($where_val))
		{
			$this->db->where_in('idParent', $where_val);
			$values = $this->query->items($this->_table_values);
			foreach($values as $value)
			{
				$return[$value['idParent']]['values'][$value['idItem']] = $value['title'];
			}
		}
		
		return $return;
		var_dump($return); die;
	}
	
	public function getGroups($limit = false, $offset = false, $order = false, $params = array())
	{
		$items = $this->query->items($this->_table_groups, $limit, $offset, $order, $params);
		return $items;
	}
	
	public function getGroup($id, $alias = false, $params = array())
	{
		if($alias) $params['alias'] = $id;
		else $params['idItem'] = $id;
		
		$item = $this->query->item($this->_table_groups, $params);
		return $item;
	}
	
	public function getGroupCount($params = array())
	{
		return $this->query->items_count($this->_table_groups, $params);
	}
	
	public function insertGroup()
	{
		$insert = $this->post();
		$error = $this->query->insert($this->_table_groups, $insert);
		if(!$error)
		{
			set_flash('result', action_result('success', fa('check mr5').' Запись <span class="medium">"'.$insert['title'].'"</span> успешно создана!', true));
			return false;
		}
		return $error;
	}
	
	public function updateGroup($id)
	{
		$insert = $this->post();
		$error = $this->query->update($this->_table_groups, $insert, array('idItem' => $id));
		if(!$error)
		{
			set_flash('result', action_result('success', fa('check mr5').' Запись <span class="medium">"'.$insert['title'].'"</span> успешно обновлена!', true));
			return false;
		}
		return $error;
	}
	
	public function deleteGroup($id)
	{
		$insert = $this->post();
		if($insert['delete'] != 'delete')
		{
			set_flash('result', action_result('error', fa('warning mr5').' Ошибка данных POST!', true));
			return true;
		}
		
		$item = $this->getGroup($id);
		if(empty($item))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			return true;
		}
		
		$check = $this->getCount(array('idParent' => $id));
		if($check != 0)
		{
			set_flash('result', action_result('error', fa('warning mr5').' Группа содержит поля ('.$check.')', true));
			return true;
		}
		
		$error = $this->query->delete($this->_table_groups, array('idItem' => $id));
		if(!$error)
		{
			set_flash('result', action_result('success', fa('trash mr5').' Запись <span class="medium">"'.$item['title'].'"</span> успешно удалена!', true));
			return false;
		} else {
			set_flash('result', $error);
			return true;
		}
	}
	
	/* ITEMS */
	
	public function getItems($limit = false, $offset = false, $order = false, $params = array())
	{
		$return = array();
		$items = $this->query->items($this->_table, $limit, $offset, $order, $params);
		foreach($items as $item) $return[$item['idItem']] = $item;
		return $return;
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
	
	public function insertItem()
	{
		$insert = $this->post();
		if(array_key_exists('filter', $insert)) $insert['filter'] = $insert['filter'] ? 1 : 0;
		else $insert['filter'] = 0;
		
		$values = array();
		
		if($insert['type'] == 'select' or $insert['type'] == 'checkbox')
		{
			if(empty($insert['value']))
			{
				return action_result('error', fa('warning mr5').' Не указано ни одно значение для поля', true);
			}
			$values = $insert['value'];
		}
		
		unset($insert['value']);
		
		$insert['idParent'] = uri(4);
		
		$error = $this->query->insert($this->_table, $insert);
		if(!$error)
		{
			$id = $this->query->insert_id();
			if($insert['type'] == 'checkbox' or $insert['type'] == 'select') $this->insertValues($id, $values);
			
			set_flash('result', action_result('success', fa('check mr5').' Запись <span class="medium">"'.$insert['title'].'"</span> успешно создана!', true));
			return false;
		}
		return $error;
	}
	
	public function updateItem($id)
	{
		$insert = $this->post();
		if(array_key_exists('filter', $insert)) $insert['filter'] = $insert['filter'] ? 1 : 0;
		else $insert['filter'] = 0;
		
		$values = array();
		$values_new = array();
		$values_delete = array();
		
		if(array_key_exists('value', $insert))
		{
			$values = $insert['value'];
			unset($insert['value']);
		}
		
		if(array_key_exists('value_new', $insert))
		{
			$values_new = $insert['value_new'];
			unset($insert['value_new']);
		}
		
		if(array_key_exists('value_delete', $insert))
		{
			$values_delete = $insert['value_delete'];
			unset($insert['value_delete']);
		}
		
		$error = $this->query->update($this->_table, $insert, array('idItem' => $id));
		if($error)
		{
			return $error;
		} else {
			
			$this->updateValues($id, $values, $values_new, $values_delete);
			
			set_flash('result', action_result('success', fa('check mr5').' Запись <span class="medium">"'.$insert['title'].'"</span> успешно обновлена!', true));
			return false;
		}
	}
	
	public function deleteItem($id)
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
		
		$error = $this->query->delete($this->_table, array('idItem' => $id));
		if(!$error)
		{
			set_flash('result', action_result('success', fa('trash mr5').' Запись <span class="medium">"'.$item['title'].'"</span> успешно удалена!', true));
			redirect('admin/fields/view/'.$item['idParent']);
			return false;
		} else {
			set_flash('result', $error);
			return true;
		}
	}
	
	# VALUES
	
	public function getValues($id = false)
	{
		$return = array();
		$params = array();
		if($id) $params['idParent'] = $id;
		$items = $this->query->items($this->_table_values, false, false, false, $params);
		foreach($items as $item)
		{
			$return[$item['idItem']] = $item;
		}
		
		return $return;
	}
	
	public function insertValues($id, $values = array())
	{
		foreach($values as $value)
		{
			$insert = array(
				'idParent' => $id,
				'title' => $value,
			);
			$this->query->insert($this->_table_values, $insert);
		}
	}
	
	public function updateValues($id, $values = array(), $values_new = array(), $values_delete = array())
	{
		foreach($values as $key => $value)
		{
			$this->query->update($this->_table_values, array('title' => $value), array('idItem' => $key));
		}
		
		foreach($values_delete as $key => $value)
		{
			$this->query->delete($this->_table_values, array('idItem' => $key));
		}
		
		foreach($values_new as $value)
		{
			$insert = array(
				'idParent' => $id,
				'title' => $value,
			);
			$this->query->insert($this->_table_values, $insert);
		}
	}
	
	# HELPER
	
	public function post()
	{
		$return = $this->input->post();
		if(array_key_exists('csrf_test_name', $return)) unset($return['csrf_test_name']);
		
		return $return;
	}
	
	public function getTypes($id = false)
	{
		$return = array(
			'text' => array(
				'title' => 'Текст',
				'alias' => 'text',
			),
			'number' => array(
				'title' => 'Число',
				'alias' => 'number',
			),
			'select' => array(
				'title' => 'Выпадающий список',
				'alias' => 'select',
			),
			'checkbox' => array(
				'title' => 'Чекбоксы',
				'alias' => 'checkbox',
			),
		);
		
		if($id !== false)
		{
			if(array_key_exists($id, $return)) return $return;
			else return 'Ошибка вывода';
		}
		return $return;
		
	}
	
	# VALIDATE
	
	public function validate($key = 'item')
	{
		$rules = array(
			'group' => array(
				array(
					'field' => 'title',
					'label' => 'Заголовок',
					'rules'   => 'trim|required|max_length[255]',
				),
				array(
					'field' => 'num',
					'label' => 'Номер по порядку',
					'rules'   => 'trim|integer',
				),
			),
			'item' => array(
				array(
					'field' => 'title',
					'label' => 'Заголовок',
					'rules'   => 'trim|required|max_length[255]',
				),
				array(
					'field' => 'type',
					'label' => 'Тип поля',
					'rules'   => 'trim|required',
				),
				array(
					'field' => 'num',
					'label' => 'Номер по порядку',
					'rules'   => 'trim|integer',
				),
			),
		);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		$this->form_validation->set_rules($rules[$key]);
		return $this->form_validation->run();
	}
	
}
