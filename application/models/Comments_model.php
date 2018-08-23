<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comments_model extends CI_Model {
	
	protected $_folder = 'comments';
	protected $_table = 'shop_products_comments';
	
	public function getItems($limit = false, $offset = false, $order = false, $params = array())
	{
		$items = $this->query->items($this->_table, $limit, $offset, $order, $params);
		return $items;
	}
	
	public function getItemsForAdmin($limit = false, $offset = false, $order = false, $params = array())
	{
		$this->query->select('shop_products_comments.*, shop_products.title as product, shop_products.articul, shop_products.img');
		
		$this->db->join('shop_products', 'shop_products_comments.idParent = shop_products.idItem', 'left');
		$this->db->group_by('shop_products_comments.idItem');
		
		$items = $this->query->items($this->_table, $limit, $offset, $order, $params);
		return $items;
	}
	
	public function getItem($id, $alias = false, $params = array())
	{
		if($alias) $params['alias'] = $id;
		else $params['idItem'] = $id;
		
		$item = $this->query->item($this->_table, $params);
		if($item['isRead'] == 0) $this->isRead($id);
		
		return $item;
	}
	
	public function isRead($id)
	{
		$this->query->update($this->_table, array('isRead' => 1), array('idItem' => $id));
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
		if($error) return $error;
		
		$idParent = $this->input->post('idParent');
		if($idParent != '') $this->updateRaiting($idParent);
		
		set_flash('result', action_result('success', fa('check mr5').' Запись <span class="medium">"'.$insert['title'].'"</span> успешно создана!', true));
		return false;
	}
	
	public function update($id)
	{
		$insert = $this->post();
		
		$error = $this->query->update($this->_table, $insert, array('idItem' => $id));
		if($error) return $error;
		
		$idParent = $this->input->post('idParent');
		if($idParent != '') $this->updateRaiting($idParent);
		
		set_flash('result', action_result('success', fa('check mr5').' Запись <span class="medium">"'.$insert['title'].'"</span> успешно обновлена!', true));
		return false;
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
			if(isset($item['img'])) $this->deletephoto($item['img']);
			
			set_flash('result', action_result('success', fa('trash mr5').' Запись <span class="medium">"'.$item['title'].'"</span> успешно удалена!', true));
			return false;
		} else {
			set_flash('result', $error);
			return true;
		}
	}
	
	# DATA FROM FRONT
	
	public function insert_user()
	{
		$insert = $this->post();
		
		$error = $this->query->insert($this->_table, $insert);
		if($error) return $error;
		
		$insert['idItem'] = $this->query->insert_id();
		$this->load->model('products_model');
		$item = $this->products_model->getItem($insert['idParent']);
		$insert['product'] = $item['title'];
		$insert['product_alias'] = $item['alias'];
		$this->sendMail($insert);
		return false;
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
		$this->email->subject('Отзыв к товару - '.$data['product']);
		$message = $this->load->view('site/emails/comments', $data, TRUE);
		$this->email->message($message);
		$this->email->send();
	}
	
	# UPDATE RAITING
	
	protected function updateRaiting($id)
	{
		$this->db->select('raiting');
		$items = $this->query->items($this->_table, false, false, false, array('visibility' => 1));
		
		$count = count($items);
		$raiting = 0;
		$total = 0;
		
		if($count != 0)
		{
			foreach($items as $item) $raiting += $item['raiting'];
			$total = round($raiting / $count, 2);
		}
		
		$this->query->update('shop_products', array('raiting' => $total), array('idItem' => $id));
		
		return;
		
		var_dump($total); die;
	}
	
	# HELPER
	
	public function post()
	{
		$return = $this->input->post();
		if(array_key_exists('csrf_test_name', $return)) unset($return['csrf_test_name']);
		
		if(array_key_exists('stars', $return))
		{
			$return['raiting'] = $return['stars'];
			unset($return['stars']);
		}
		
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
				'label' => 'Имя',
				'rules'   => 'trim|required|max_length[255]',
			),
			array(
				'field' => 'link',
				'label' => 'Ссылка',
				'rules'   => 'trim|max_length[255]',
			),
			array(
				'field' => 'raiting',
				'label' => 'Оценка',
				'rules'   => 'trim|integer',
			),
			array(
				'field' => 'text',
				'label' => 'Текст',
				'rules'   => 'trim',
			),
		);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		$this->form_validation->set_rules($rules);
		return $this->form_validation->run();
	}
	
}
