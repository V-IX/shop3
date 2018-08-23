<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Banners_model extends CI_Model {
	
	protected $_folder = 'banners';
	protected $_table = 'banners';
	protected $_page = 'banners';
	
	public function getItems($limit = false, $offset = false, $order = false, $params = array(), $where_in = false)
	{
		$return = array();
		
		if($where_in and is_array($where_in)) $this->db->where_in('alias', $where_in);
		$items = $this->query->items($this->_table, $limit, $offset, $order, $params);
		
		foreach($items as $item)
		{
			$return[$item['alias']] = $item;
		}
		
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
	
	public function insert()
	{
		$insert = $this->post();
		
		$check = $this->getCount(array('alias' => $insert['alias']));
		if($check != 0) return action_result('error', fa('warning mr5').' Запись с ссылкой <span class="medium">'.$insert['title'].'</span> уже есть в базе!', true);
		
		if($_FILES['img']['name'] != '')
		{
			$img = $this->loadphoto('img');
			if(!$img) return action_result('error', fa('warning mr5').' Ошибка загрузки изображения!', true);
			else $insert['img'] = $img;
		}
		
		$error = $this->query->insert($this->_table, $insert);
		if($error)
		{
			if(isset($insert['img'])) $this->deletephoto($insert['img']);
			return $error;
		} else {
			set_flash('result', action_result('success', fa('check mr5').' Запись <span class="medium">"'.$insert['title'].'"</span> успешно создана!', true));
			return false;
		}
	}
	
	public function update($id)
	{
		$insert = $this->post();
		
		$item = $this->getItem($id);
		
		if(array_key_exists('oldImg', $insert))
		{
			$oldImg = $insert['oldImg'];
			unset($insert['oldImg']);
		}
		
		if($_FILES['img']['name'] != '')
		{
			$img = $this->loadphoto('img');
			if(!$img) return action_result('error', fa('warning mr5').' Ошибка загрузки изображения!', true);
			else $insert['img'] = $img;
		}
		
		if(isset($insert['img']))
		{
			$this->thumb($insert['img'], $insert['size_x'], $insert['size_y']);
		} elseif($item['img'] and ($insert['size_x'] != $item['size_x'] or $insert['size_y'] != $item['size_y'])) {
			$this->thumb($item['img'], $insert['size_x'], $insert['size_y']);
		}
		
		$error = $this->query->update($this->_table, $insert, array('idItem' => $id));
		if($error)
		{
			if(isset($insert['img'])) $this->deletephoto($insert['img']);
			return $error;
		} else {
			if(isset($insert['img']) and isset($oldImg)) $this->deletephoto($oldImg);
			set_flash('result', action_result('success', fa('check mr5').' Запись <span class="medium">"'.$item['title'].'"</span> успешно обновлена!', true));
			return false;
		}
	}
	
	public function ajaxDeleteImg($id)
	{
		$insert = $this->post();
		if($insert['delete_img'] != 'delete')
		{
			return array('error' => true, 'text' => 'Ошибка данных POST');
		}
		
		$item = $this->getItem($id);
		if(empty($item))
		{
			return array('error' => true, 'text' => 'Запись не найдена');
		}
		
		$error = $this->query->update($this->_table, array('img' => null), array('idItem' => $id));
		if(!$error)
		{
			if(isset($item['img'])) $this->deletephoto($item['img']);
			return array('error' => false, 'text' => 'Запись успешно удалена');
		} else {
			return array('error' => true, 'text' => 'Ошибка сервера');
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
				'field' => 'alt',
				'label' => 'Alt для изображения',
				'rules'   => 'trim',
			),
			array(
				'field' => 'size_x',
				'label' => 'Размеры баннера',
				'rules'   => 'trim|required|integer',
			),
			array(
				'field' => 'size_y',
				'label' => 'Размеры баннера',
				'rules'   => 'trim|required|integer',
			),
			array(
				'field' => 'link',
				'label' => 'Ссылка',
				'rules'   => 'trim',
			),
		);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		$this->form_validation->set_rules($rules);
		return $this->form_validation->run();
	}
	
	# LOAD IMAGE
	
	public function configPhoto()
	{
		$config['upload_path'] = './assets/uploads/'.$this->_folder.'/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = 2048;
		$config['encrypt_name'] = true;
		$config['remove_spaces'] = false;
		$congig['overwrite'] = true;
		return $config;
	}
	
	public function thumbSize($axis = false)
	{
		$this->db->select('thumb_x, thumb_y');
		$item = $this->query->item('pages_site', array('alias' => $this->_page));
		
		$return = array(
			'x' => $item['thumb_x'],
			'y' => $item['thumb_y'],
		);
		
		if($axis !== false) return $return[$axis];
		else return $return;
	}
	
	public function loadphoto($img)
	{
		$this->load->helper('file');
		if($this->upload->do_upload($img)) {
			$img = $this->upload->data();
			return $img['file_name'];
		} else {
			return false;
		}		
	}
	
	public function thumb($img, $size_x, $size_y)
	{
		$this->load->library('SimpleImage');
		$this->simpleimage->load('assets/uploads/'.$this->_folder.'/'.$img)->thumbnail($size_x, $size_y)->save('assets/uploads/'.$this->_folder.'/thumb/'.$img);
	}
	
	public function deletephoto($file)
	{
		$paths = array(
			'/assets/uploads/'.$this->_folder.'/'.$file,
			'/assets/uploads/'.$this->_folder.'/thumb/'.$file,
		);
		deletefile($paths);
	}
	
}
