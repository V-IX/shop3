<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Faq_model extends CI_Model {
	
	protected $_folder = 'faq';
	protected $_table = 'faq';
	
	public function getItems($limit = false, $offset = false, $order = false, $params = array())
	{
		$items = $this->query->items($this->_table, $limit, $offset, $order, $params);
		return $items;
	}
	
	public function getItem($id, $params = array())
	{
		$params['idItem'] = $id;
		
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
		
		$insert['isRead'] = 1;
		
		$error = $this->query->insert($this->_table, $insert);
		if($error)
		{
			return $error;
		} else {
			set_flash('result', action_result('success', fa('check mr5').' Запись <span class="medium">"'.$insert['title'].'"</span> успешно создана!', true));
			return false;
		}
	}
	
	public function insert_user()
	{
		$insert = $this->post();
		
		$error = $this->query->insert($this->_table, $insert);
		if($error)
		{
			return $error;
		} else {
			$insert['idItem'] = $this->query->insert_id();
			$insert['text'] = $insert['title'];
			$insert['title'] = 'Новый вопрос';
			$this->load->model('feedback_model');
			$this->feedback_model->sendMail($insert);
			return false;
		}
	}
	
	public function isRead($id)
	{
		$insert = array('isRead' => 1);
		$this->query->update($this->_table, $insert, array('idItem' => $id));
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
				'field' => 'text',
				'label' => 'Текст',
				'rules'   => 'trim',
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
