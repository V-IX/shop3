<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pageinfo_model extends CI_Model {
	
	protected $_table = 'pages_site';
	
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
	
	public function update($id)
	{
		$insert = $this->post();
		
		$item = $this->getItem($id);
		if(empty($item)) return action_result('error', fa('warning mr5').' Запись не найдена', true);
		
		$error = $this->query->update($this->_table, $insert, array('idItem' => $id));
		if($error)
		{			
			return $error;
		} else {
			if(isset($insert['thumb_x']) and isset($insert['thumb_y']))
			{
				if($insert['thumb_x'] != $item['thumb_x'] or $insert['thumb_y'] != $item['thumb_y'])
				{
					$this->thumbResize($item['alias'], $insert['thumb_x'], $insert['thumb_y']);
				}
			}
			
			set_flash('result', action_result('success', fa('check mr5').' Запись <span class="medium">"'.$insert['title'].'"</span> успешно обновлена!', true));
			return false;
		}
	}
	
	# HELPER
	
	public function post()
	{
		$return = $this->input->post();
		if(array_key_exists('csrf_test_name', $return)) unset($return['csrf_test_name']);	
		return $return;
	}
	
	# VALIDATE
	
	public function validate()
	{
		$rules = array(
			array(
				'field' => 'name',
				'label' => 'Название',
				'rules'   => 'trim|required|max_length[255]',
			),
			array(
				'field' => 'title',
				'label' => 'Заголовок',
				'rules'   => 'trim|required|max_length[255]',
			),
			array(
				'field' => 'text',
				'label' => 'Описание страницы',
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
			array(
				'field' => 'thumb_x',
				'label' => 'Ширина эскизов (px)',
				'rules'   => 'trim|integer',
			),
			array(
				'field' => 'thumb_y',
				'label' => 'Высота эскизов (px)',
				'rules'   => 'trim|integer',
			),
		);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		$this->form_validation->set_rules($rules);
		return $this->form_validation->run();
	}
	
	public function thumbResize($folder, $size_x, $size_y)
	{
		$folderPath = 'assets/uploads/'.$folder;
		$thumbPath = $folderPath.'/thumb';
		$thumbExt = array('gif', 'jpg', 'png', 'jpeg', 'bmp');
		
		if(is_dir('./'.$folderPath))
		{
			$filesList = glob('./'.$folderPath.'/*.*');
			$files = array();
			
			foreach($filesList as $file)
			{
				$fileDotArr = explode('.', $file);
				$fileExt = $fileDotArr[count($fileDotArr) - 1];
				if(in_array($fileExt, $thumbExt)) $files[] = str_replace('./'.$folderPath.'/', '', $file);
			}
			
			if(!empty($files) and is_dir('./'.$thumbPath))
			{
				$this->load->library('SimpleImage');
				foreach($files as $file)
				{
					$this->simpleimage->load($folderPath.'/'.$file)->thumbnail($size_x, $size_y)->save($thumbPath.'/'.$file);
				}
			}
			
			return true;
		}
		
		return false;
	}
	
}
