<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Catalog_model extends CI_Model {
	
	protected $_folder = 'catalog';
	protected $_table = 'shop_catalog';
	protected $_page = 'catalog';
	protected $_table_catalogs = 'shop_catalog_products';
    
    public $_paths = array();
    
	
	public function getItems($limit = false, $offset = false, $order = false, $params = array(), $select = false)
	{
		if($select) $this->db->select($select);
		$items = $this->query->items($this->_table, $limit, $offset, $order, $params);
		return $items;
	}
	
	public function getList($limit = false, $offset = false, $order = false, $params = array())
	{
		$this->db->select('idItem, title');
		$items = $this->query->items($this->_table, $limit, $offset, $order, $params);
		return $this->query->items_list($items, 'idItem', 'title');
	}
	
	public function getItemsTree($limit = false, $offset = false, $order = false, $params = array(), $current = false)
	{
		$return = array(
			'tree' => array(),
			'current' => $current,
			'upline' => array(),
			'breadcrumbs' => array(),
		);
		$tree = array();
		$items = array();
        $paths = array();
		$relations = array();
		$upline = array();
		$breadcrumbs = array();
		
		$query = $this->getItems($limit, $offset, $order, $params, 'idItem, idParent, title, brief, alias, img, visibility');
		if(empty($query)) return $return;
		
		// Делаем индексированный список и отношения
		foreach($query as $item)
		{
		    $item["path"] = $item["alias"];
              
			$items[$item['idItem']] = $item;
			$items[$item['idItem']]['toggle'] = 'static';
			$items[$item['idItem']]['level'] = 1;
			$relations[$item['idItem']] = $item['idParent'];
		}
		
		if($current)
		{
			// Составляем хлебные крошки
			
			$upline[] = $current;
			$_b_parent = $current;
			while($_b_parent != 0)
			{
				$_new_parent = $relations[$_b_parent];
				if($_new_parent != 0) $upline[] = intval($_new_parent);
				$_b_parent = $_new_parent;
			}
			
			asort($upline);
		
		
			foreach($items as $key => $item)
			{
				if($item['idItem'] == $current) $items[$key]['toggle'] = 'current';
				elseif(in_array($item['idItem'], $upline)) $items[$key]['toggle'] = 'open';
			}
				
			$return['upline'] = $upline;
			
		}
		
		foreach ($items as $id => &$node) {    
			//Если нет вложений
			if (!$node['idParent'])
			{
				$tree[$id] = &$node;
			} else { 
				//Если есть потомки то перебираем массив
				$items[$node['idParent']]['childs'][$id] = &$node;
			}
		}
		
		foreach($tree as $key => $_tree)
		{
			
            $tree[$key] = $this->_add_level($_tree, 1);
            $this->_paths[$tree[$key]["idItem"]] = $tree[$key]["path"]; 
		}


		foreach($upline as $_upline)
			{
				$breadcrumbs[$_upline]['title'] = $items[$_upline]['title'];
				$breadcrumbs[$_upline]['alias'] = $this->_paths[$_upline];
			}

        $return['breadcrumbs'] = $breadcrumbs;
//var_dump ($breadcrumbs);		
		$return['tree'] = $tree;
        
        $return['paths'] = $this->_paths;

		return $return;
		
		var_dump($return); die;
	}
	
	protected function _add_level($item, $level)
	{
		$item['level'] = $level++;
		if(isset($item['childs']))
		{
			foreach($item['childs'] as $key => $child)
			{
			    $child["path"] = $item["path"]."/".$child["path"];
                
				$item['childs'][$key] = $this->_add_level($child, $level);
                
                $this->_paths[$child["idItem"]] = $child["path"]; 
			}
		}
		return $item;
	}
	
	public function getItemsByProduct($id, $limit = false, $offset = false, $order = false, $params = array())
	{
		$params['idProduct'] = $id;
		return $this->query->items($this->_table_catalogs, $limit, $offset, $order, $params);
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
	
	public function fields($id)
	{
		$post = $this->input->post('field');
		
		if(!is_array($post)) $post = array();
		
		$insert['fields'] = json_encode($post);
		
		$error = $this->query->update($this->_table, $insert, array('idItem' => $id));
		if($error) return $error;
		
		set_flash('result', action_result('success', fa('check mr5').' Запись успешно обновлена!', true));
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
		
		$check = $this->getCount(array('idParent' => $id));
		if($check != 0)
		{
			set_flash('result', action_result('error', fa('warning mr5').' Категория содержит дочерние элементы!', true));
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
				'field' => 'idParent',
				'label' => 'Родительская категория',
				'rules'   => 'trim|required|integer',
			),
			array(
				'field' => 'brief',
				'label' => 'Краткое описание',
				'rules'   => 'trim|max_length[255]',
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
				'field' => 'num',
				'label' => 'Номер по порядку',
				'rules'   => 'trim|integer',
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
