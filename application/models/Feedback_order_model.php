<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback_order_model extends CI_Model {
	
	protected $_table = 'feedback_orders';
		
	public function getItems($limit = false, $offset = false, $order = false, $params = array())
	{
		$items = $this->query->items($this->_table, $limit, $offset, $order, $params);
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
	
	# ACTIONS
	
	public function insert()
	{
		$insert = $this->post();
		
		$error = $this->query->insert($this->_table, $insert);
		if($error)
		{
			return $error;
		} else {
			$insert['idItem'] = $this->query->insert_id();
			$this->sendMail($insert);
			return false;
		}
	}
	
	public function sendMail($data)
	{
		$site = $this->settings_model->getItem();
		$data['site'] = $site;
		$this->load->library('email');
		
		$config = array (
			'mailtype' => 'html',
			'charset'  => 'utf-8',
			'priority' => '1'
		);
		
		$this->email->initialize($config);
		$this->email->from($site['email_sender'], $site['title']);
		$this->email->to($site['email']);
		$this->email->subject('Обратная связь - '.$data['title']);
		$message = $this->load->view('site/emails/feedback', $data, TRUE);
		$this->email->message($message);
		$this->email->send();
	}
	
	public function isRead($id)
	{
		$insert = array('isRead' => 1);
		$this->query->update($this->_table, $insert, array('idItem' => $id));
	}
	
	public function post()
	{
		$return = $this->input->post();
		if(array_key_exists('csrf_test_name', $return)) unset($return['csrf_test_name']);
		return $return;
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
}
