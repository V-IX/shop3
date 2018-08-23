<?php defined('BASEPATH') OR exit('No direct script access allowed');

class News_model extends CI_Model {
	
	protected $_folder = 'news';
	protected $_table = 'news';
	protected $_page = 'news';
	
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
		
		$check = $this->getCount(array('alias' => $insert['alias'], 'idItem !=' => $id));
		if($check != 0) return action_result('error', fa('warning mr5').' Запись с ссылкой <span class="medium">'.$insert['alias'].'</span> уже есть в базе!', true);
		
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
		
		$error = $this->query->update($this->_table, $insert, array('idItem' => $id));
		if($error)
		{
			if(isset($insert['img'])) $this->deletephoto($insert['img']);
			return $error;
		} else {
			if(isset($insert['img']) and isset($oldImg)) $this->deletephoto($oldImg);
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
			if(isset($item['img'])) $this->deletephoto($item['img']);
			
			set_flash('result', action_result('success', fa('trash mr5').' Запись <span class="medium">"'.$item['title'].'"</span> успешно удалена!', true));
			return false;
		} else {
			set_flash('result', $error);
			return true;
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
				'field' => 'title',
				'label' => 'Заголовок',
				'rules'   => 'trim|required|max_length[255]',
			),
			array(
				'field' => 'brief',
				'label' => 'Краткое описание',
				'rules'   => 'trim|required|max_length[255]',
			),
			array(
				'field' => 'alias',
				'label' => 'Ссылка (ЧПУ)',
				'rules'   => 'trim|required|max_length[255]',
			),
			array(
				'field' => 'text',
				'label' => 'Текст',
				'rules'   => 'trim',
			),
			array(
				'field' => 'mTitle',
				'label' => 'Meta Title',
				'rules'   => 'trim|required|max_length[255]',
			),
			array(
				'field' => 'mKeywords',
				'label' => 'Meta Keywords',
				'rules'   => 'trim|max_length[255]',
			),
			array(
				'field' => 'mDescription',
				'label' => 'Meta Description',
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
		$this->load->library('SimpleImage');
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
			$file = $img['file_name'];
			
			$size = $this->thumbSize();
			$this->simpleimage->load('assets/uploads/'.$this->_folder.'/'.$img['file_name'])->thumbnail($size['x'], $size['y'])->save('assets/uploads/'.$this->_folder.'/thumb/'.$img['file_name']);
			
			return $file;
		} else {
			return false;
		}		
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
