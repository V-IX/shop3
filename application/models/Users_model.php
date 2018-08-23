<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {
	
	protected $_table = 'users';
		
	public function login()
	{
		$params = array(
			'login' => $this->input->post('login'),
			'password' => md5($this->input->post('password')),
		);
		
		$item = $this->query->item($this->_table, $params);
		
		if(!empty($item))
		{
			$this->session->set_userdata(array(
				'id' 		=> $item['idItem'],
				'login' 	=> $item['login'],
				'access'	=> $item['access'],
			));
			
			$time = $this->_time();
			set_flash('result', action_result('success', fa('check mr5').' Добро пожаловать, <span class="medium">'.$item['name'].' '.$item['sname'].'</span>! Компания '.anchor('http://narisuemvse.by', 'Narisuemvse.by', array('target' => 'blank')).' желает Вам '.$time.'!'));
			return false;
		} else {
			return fa('warning mr5') . ' Неправильные логин или пароль!';
		}
	}
		
	public function password()
	{
		$insert = $this->post();
		if($insert['password'] != $insert['confirm_password']) return action_result('error', fa('times mr5').' Новые пароли не совпадают!');
		
		$params = array(
			'idItem' => $this->session->userdata('id'),
			'password' => $insert['old_password'],
		);
		
		$check = $this->getCount($params);
		if($check == 0) return action_result('error', fa('times mr5').' Старый пароль не совпадает!');
		
		$error = $this->query->update($this->_table, array('password' => $insert['password']), array('idItem' => $this->session->userdata('id')));
		if($error)
		{
			return $error;
		} else {
			set_flash('result', action_result('success', fa('check mr5').' Ваш пароль успешно изменен!', true));
			return false;
		}
	}
	
	public function restorePass()
	{
		$insert = $this->post();
		$item = $this->query->item($this->_table, array('login' => $insert['login']));
		if(empty($item)) return fa('warning mr5').' Такого логина не существует';
		
		$newpass = $this->generate_password();
		$error = $this->query->update($this->_table, array('password' => md5($newpass)), array('login' => $insert['login']));
		if(!$error)
		{
			$this->load->model('settings_model');
			$sett = $this->settings_model->getItem();
			$config = array (
				'mailtype' => 'html',
				'charset'  => 'utf-8',
				'priority' => '1'
			);
			
			$this->load->library('email');
			
			$this->email->initialize($config);
			
			$url = base_url();
			$message = '<div style="padding: 15px 20px; background: url('.$url.'/assets/admin/img/bg-header.jpg) no-repeat center center; color: #fff; font-size: 18px;">Восстановление пароля для пользователя '.$item['login'].'</div><div style="padding: 30px 20px; color: #333; font-size: 14px;">Новый пароль: <span style="text-decoration: underline; color: #50abad;">'.$newpass.'</span></div>';
			
			$this->email->from($sett['email'], $sett['title']);
			$this->email->to($item['email']);
			$this->email->subject('Восстановление пароля '.$sett['title']);
			$this->email->message($message);
			$this->email->send();
			
			set_flash('result', action_result('success', fa('check mr5').' Новый пароль был выслан вам на почту!', true));
			
			return false;
			
		} else {
			return $this->query->_server_error();
		}
		
	}
	
	# ADMIN ACTIONS
	
	public function getItems($limit = false, $offset = false, $order = false, $params = array())
	{
		return $this->query->items($this->_table, $limit, $offset, $order, $params);
	}
	
	public function getItem($id, $params = array())
	{
		$params['idItem'] = $id;
		$item = $this->query->item($this->_table, $params);
		$item['title'] = $item['name'].' '.$item['sname'].' ('.$item['login'].')';
		return $item;
	}
	
	public function getCount($params = array())
	{
		return $this->query->items_count($this->_table, $params);
	}
	
	public function insert()
	{
		$insert = $this->post();
		
		$check = $this->getCount(array('login' => $insert['login']));
		if($check != 0) return action_result('error', fa('warning mr5').' Пользователь <span class="medium">'.$insert['login'].'</span> уже есть в базе!', true);
		
		$error = $this->query->insert($this->_table, $insert);
		if($error)
		{
			return $error;
		} else {
			set_flash('result', action_result('success', fa('check mr5').' Пользователь <span class="medium">'.$insert['login'].'</span> успешно создан!', true));
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
			set_flash('result', action_result('success', fa('check mr5').' Пользователь <span class="medium">'.$insert['name'].' '.$insert['sname'].'</span> успешно изменен!', true));
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
			set_flash('result', action_result('error', fa('warning mr5').' Пользователь не найден!', true));
			return true;
		}
		
		$error = $this->query->delete($this->_table, array('idItem' => $id));
		if(!$error)
		{
			set_flash('result', action_result('success', fa('warning mr5').' Пользователь <span class="medium">'.$item['login'].'</span> успешно удален!', true));
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
		if(array_key_exists('password', $return)) $return['password'] = md5($return['password']);		
		if(array_key_exists('old_password', $return)) $return['old_password'] = md5($return['old_password']);		
		if(array_key_exists('confirm_password', $return)) $return['confirm_password'] = md5($return['confirm_password']);		
		return $return;
	}
	
	public function _time()
	{
		$time = array(
			1 => 'доброй ночи',
			2 => 'доброго утра',
			3 => 'хорошего дня',
			4 => 'приятного вечера',
		);
		$h = date('H');
		$h = ltrim($h, '0');
		$id = 2;
		if($h >= 23 or $h < 5) $id = 1;
		elseif($h >= 5 and $h < 11) $id = 2;
		elseif($h >= 11 and $h < 20) $id = 3;
		elseif($h >= 20) $id = 4;
		return $time[$id];
	}
	
	public function generate_password($number = 8)
	{
		$arr = array('a','b','c','d','e','f', 'g','h','i','j','k','l', 'm','n','o','p','r','s', 't','u','v','x','y','z',
					 'A','B','C','D','E','F', 'G','H','I','J','K','L', 'M','N','O','P','R','S', 'T','U','V','X','Y','Z',
					 '1','2','3','4','5','6', '7','8','9','0',
					);
		$pass = "";
		for($i = 0; $i < $number; $i++)
		{
			$index = rand(0, count($arr) - 1);
			$pass .= $arr[$index];
		}
		return $pass;
	}
	
	# VALIDATE
	
	public function validate($key)
	{
		$rules = array(
			'login' => array(
				array(
					'field' => 'login',
					'label' => 'Логин',
					'rules'   => 'trim|required|min_length[3]|max_length[255]',
				),
				array(
					'field' => 'password',
					'label' => 'Пароль',
					'rules'   => 'trim|required|min_length[6]|max_length[255]',
				),
			),
			'insert' => array(
				array(
					'field' => 'login',
					'label' => 'Логин',
					'rules'   => 'trim|required|min_length[3]|max_length[255]',
				),
				array(
					'field' => 'password',
					'label' => 'Пароль',
					'rules'   => 'trim|required|min_length[6]|max_length[255]',
				),
				array(
					'field' => 'email',
					'label' => 'E-mail',
					'rules'   => 'trim|required|valid_email',
				),
				array(
					'field' => 'name',
					'label' => 'Имя',
					'rules'   => 'trim|required|max_length[255]',
				),
				array(
					'field' => 'name',
					'label' => 'Имя',
					'rules'   => 'trim|required|max_length[255]',
				),
				array(
					'field' => 'sname',
					'label' => 'Фамилия',
					'rules'   => 'trim|max_length[255]',
				),
			),
			'update' => array(
				array(
					'field' => 'email',
					'label' => 'E-mail',
					'rules'   => 'trim|required|valid_email',
				),
				array(
					'field' => 'name',
					'label' => 'Имя',
					'rules'   => 'trim|required|max_length[255]',
				),
				array(
					'field' => 'name',
					'label' => 'Имя',
					'rules'   => 'trim|required|max_length[255]',
				),
				array(
					'field' => 'sname',
					'label' => 'Фамилия',
					'rules'   => 'trim|max_length[255]',
				),
			),
			'password' => array(
				array(
					'field' => 'old_password',
					'label' => 'Старый пароль',
					'rules'   => 'trim|required|max_length[255]',
				),
				array(
					'field' => 'password',
					'label' => 'Новый пароль',
					'rules'   => 'trim|required|max_length[255]',
				),
				array(
					'field' => 'confirm_password',
					'label' => 'Подтверждение пароля',
					'rules'   => 'trim|required|max_length[255]',
				),
			),
			'restorePass' => array(
				array(
					'field' => 'login',
					'label' => 'Логин',
					'rules'   => 'trim|required|max_length[255]',
				),
			),
		);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		$this->form_validation->set_rules($rules[$key]);
		return $this->form_validation->run();
	}
}
