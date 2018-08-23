<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model {
	
	protected $_folder = 'products';
	protected $_table = 'shop_products';
	protected $_page = 'products';
	protected $_filter_arr = array('where_in' => array(), 'enable' => true);
	
	public function getItems($limit = false, $offset = false, $order = false, $params = array(), $select = false)
	{
		$this->_filter_get();
		if($select) $this->query->select($select);
		$items = $this->query->items($this->_table, $limit, $offset, $order, $params);
		return $items;
	}
	
	public function getItemsList($limit = false, $offset = false, $order = false, $params = array())
	{
		$items = $this->getItems(false, false, 'title|ASC', array(), 'idItem, title');
		$return = $this->query->items_list($items, 'idItem', 'title');
		return $return;
	}
	
	public function getItemsByCatalog($id, $limit = false, $offset = false, $order = false, $params = array())
	{
		$this->_filter();
		$this->query->select('shop_catalog_products.*, shop_products.idParent as mainCatId, shop_products.title, shop_products.alias, shop_products.articul, shop_products.img, shop_products.brief, shop_products.price, shop_products.oldPrice, shop_products.mTitle, shop_products.sticker_hit, shop_products.sticker_new, shop_products.sticker_best, shop_products.num, shop_products.count');
		
		$this->db->join('shop_products', 'shop_catalog_products.idProduct = shop_products.idItem', 'left');
		$this->db->group_by('shop_catalog_products.idItem');
		
		$params['shop_catalog_products.idParent'] = $id;
		$params['shop_products.visibility'] = 1;
		
		$items = $this->query->items($this->_table_catalogs, $limit, $offset, $order, $params);
		
		return $items;
	}
	
	public function getItem($id, $alias = false, $params = array())
	{
		if($alias) $params['alias'] = $id;
		else $params['idItem'] = $id;
		
		$item = $this->query->item($this->_table, $params);
		return $item;
	}
	
	public function getItemByArticul($id, $params = array())
	{
		$params['articul'] = $id;
		$item = $this->query->item($this->_table, $params);
		return $item;
	}
	
	public function getCount($params = array())
	{
		$this->_filter_get();
		return $this->query->items_count($this->_table, $params);
	}
	
	public function getCountByCatalog($id)
	{
		$this->_filter();
		$this->query->select('shop_catalog_products.idProduct, shop_products.title');
		$this->db->join('shop_products', 'shop_catalog_products.idProduct = shop_products.idItem', 'left');
		$this->db->group_by('shop_catalog_products.idItem');
		
		$params = array(
			'shop_catalog_products.idParent' => $id,
			'shop_products.visibility' => 1,
		);
		
		$return = $this->query->items($this->_table_catalogs, false, false, false, $params);
		return count($return);
	}
	
	protected function _filter_get()
	{
		if(uri(1) == 'search')
		{
			$like = $this->input->get('search');
			
			$this->db->group_start()
				->like('title', $like)
				->or_like('articul', $like)
				->or_like('text', $like)
				->group_end();
			
		} else {
			if(isset($_GET['idParent']) and $_GET['idParent'] != 'all')
			{
				$products = $this->query->items($this->_table_catalogs, false, false, false, array('idParent' => $_GET['idParent']));
				if(!empty($products))
				{
					foreach($products as $product)
					{
						$where_in[] = $product['idProduct'];
					}
					$this->db->where_in('idItem', $where_in);
				}
				//$this->db->where('idParent', $_GET['idParent']);
			}
			
			if(isset($_GET['title']) and $_GET['title'] != '')
			{
				$this->db->like('LOWER(title)', strtolower($_GET['title']));
			}
		}
	}
	
	public function getPrices($parent = false)
	{
		$return = array(
			'min' => 0, 'get_min' => 0,
			'max' => 0, 'get_max' => 0,
		);
		
		if($parent !== false)
		{
			$prod = $this->query->items($this->_table_catalogs, false, false, false, array('idParent' => $parent));
			if(!empty($prod))
			{
				$where_in = array();
				foreach($prod as $p) $where_in[] = $p['idProduct'];
				$this->db->where_in('idItem', $where_in);
				//var_dump($where_in); die;
			}	
		}
		
		$this->db->select('MIN(price) as min, MAX(price) as max');
		$mm = $this->query->item($this->_table);
		
		$return['min'] = floor($mm['min']);
		$return['max'] = ceil($mm['max']);
		$return['get_min'] = isset($_GET['price']['from']) ? floor($_GET['price']['from']) : $return['min'];
		$return['get_max'] = isset($_GET['price']['to']) ? ceil($_GET['price']['to']) : $return['max'];
		
		return $return;
		var_dump($return); die;
	}
	
	// ACTIONS
	
	public function insert()
	{
		$insert = $this->post();
		
		if(array_key_exists('visibility', $insert)) $insert['visibility'] = $insert['visibility'] ? 1 : 0;
		else $insert['visibility'] = 0;
		
		$config = $this->settings_model->getItem();
		$insert['currency'] = $config['currency'];
		$insert['unit_length'] = $config['length'];
		$insert['unit_weight'] = $config['weight'];
		
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
			$id = $this->query->insert_id();
			if(isset($insert['idParent']) and $insert['idParent'] != '') $this->query->insert($this->_table_catalogs, array('idParent' => $insert['idParent'], 'idProduct' => $id));
			
			set_flash('result', action_result('success', fa('check mr5').' Запись <span class="medium">"'.$insert['title'].'"</span> успешно создана!', true));
			redirect('/admin/'.uri(2).'/edit/'.$id);
			return false;
		}
	}
	
	public function update($id)
	{
		$insert = $this->post();
		
		/* check alias */
		$check = $this->getCount(array('alias' => $insert['alias'], 'idItem !=' => $id));
		if($check != 0) return action_result('error', fa('warning mr5').' Запись с ссылкой <span class="medium">'.$insert['alias'].'</span> уже есть в базе!', true);
		
		/* check checkbox */
		if(array_key_exists('visibility', $insert)) $insert['visibility'] = $insert['visibility'] ? 1 : 0;
		else $insert['visibility'] = 0;
		
		if(array_key_exists('count_subtraction', $insert)) $insert['count_subtraction'] = $insert['count_subtraction'] ? 1 : 0;
		else $insert['count_subtraction'] = 0;
		
		if(array_key_exists('sticker_new', $insert)) $insert['sticker_new'] = $insert['sticker_new'] ? 1 : 0;
		else $insert['sticker_new'] = 0;
		
		if(array_key_exists('sticker_hit', $insert)) $insert['sticker_hit'] = $insert['sticker_hit'] ? 1 : 0;
		else $insert['sticker_hit'] = 0;
		
		if(array_key_exists('sticker_best', $insert)) $insert['sticker_best'] = $insert['sticker_best'] ? 1 : 0;
		else $insert['sticker_best'] = 0;
		
		/* check extra params */
		$myMod = array();
		if(isset($insert['modifications']))
		{
			$myMod = $insert['modifications'];
			unset($insert['modifications']);
		}
		
		$myParent = array();
		if(isset($insert['parents']))
		{
			$myParent = $insert['parents'];
			unset($insert['parents']);
		}
		
		$myFields = array();
		if(isset($insert['field']))
		{
			$myFields = $insert['field'];
			unset($insert['field']);
		}
		
		$myDescrs = array();
		if(isset($insert['descr']))
		{
			$myDescrs = $insert['descr'];
			unset($insert['descr']);
		}
		
		/* check chars */
		
		if(isset($insert['chars']))
		{
			$insert['charArr'] = json_encode($insert['chars']);
			unset($insert['chars']);
		}
		
		//var_dump($insert); die;
		
		/* check img */
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
		
		/* check currency */
		
		$this->db->select('currency');
		$siteinfo = $this->query->item('settings');
		
		if($siteinfo['currency'] == $insert['currency'])
		{
			$insert['price'] = $insert['price_curr'];
			$insert['oldPrice'] = $insert['oldPrice_curr'];
		} else {		
			$this->db->select('idItem, value');
			$this->db->where('idItem', $insert['currency']);
			$this->db->or_where('idItem', $siteinfo['currency']);
			$curr_query = $this->query->items('shop_unit_currency');
			$curr = $this->query->items_list($curr_query, 'idItem', 'value');
			
			$insert['price'] = $insert['price_curr'] * $curr[$insert['currency']] / $curr[$siteinfo['currency']];
			$insert['oldPrice'] = $insert['oldPrice_curr'] * $curr[$insert['currency']] / $curr[$siteinfo['currency']];
		}
		
		/* upload, bitch */
		$error = $this->query->update($this->_table, $insert, array('idItem' => $id));
		if($error)
		{
			if(isset($insert['img'])) $this->deletephoto($insert['img']);
			return $error;
		} else {
			if(isset($insert['img']) and isset($oldImg)) $this->deletephoto($oldImg);
			
			if(!empty($myParent)) $this->_updateParents(uri(4), $myParent);
			if(!empty($myMod)) $this->_updateModification(uri(4), $myMod);
			if(!empty($myFields)) $this->_updateFields(uri(4), $myFields);
			if(!empty($myDescrs)) $this->_updateDescription(uri(4), $myDescrs);
			
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
			
			$this->query->delete('shop_products_articles', array('idParent' => $id));
			$this->query->delete('shop_products_comments', array('idParent' => $id));
			$this->query->delete('shop_products_descr', array('idParent' => $id));
			$this->query->delete('shop_products_modifications', array('idParent' => $id));
			$this->query->delete('shop_products_modifications', array('idParent' => $id));
			$this->query->delete('shop_products_similars', array('idParent' => $id));
			
			$imgs = $this->query->items($this->_table_imgs, false, false, false, array('idParent' => $id));
			foreach($imgs as $img) $this->deletephoto($img['img']);
			
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
	
	protected function _filter()
	{
		if(empty($_GET)) return false;
		
		if($this->_filter_arr['enable'])
		{
			$_get_types = array('text', 'num', 'select', 'checkbox');
			$where_fields = array();
			foreach($_GET as $key => $array)
			{
				if(in_array($key, $_get_types))
				{
					if(is_array($array))
					{
						foreach($array as $arr_key => $arr_value) $where_fields[] = $arr_key;
					}
				}
			}
			
			$items = array();
			if(!empty($where_fields))
			{
				$this->db->where_in('idField', $where_fields);
				$items_query = $this->query->items('shop_fields_products');
				if(!empty($items_query))
				{
					foreach($items_query as $item)
					{
						$items[$item['idParent']][$item['idField']] = $item['value'];
					}
				}
			}
			
			$fields_type = array();
			if(!empty($items))
			{
				$this->db->where_in('idItem', $where_fields);
				$fields_type_query = $this->query->items('shop_fields');
				foreach($fields_type_query as $_ft)
				{
					$fields_type[$_ft['idItem']] = $_ft['type'];
				}
			}
			
			foreach($items as $id => $item)
			{
				$delete = false;
				foreach($fields_type as $field => $type)
				{
					$type = $type == 'number' ? 'num' : $type;	// сраный костыль
					
					if(!array_key_exists($field, $item)) $delete = true;
					
					if(!$delete and isset($_GET[$type][$field]))
					{
						// FOR TEXT FIELDS
						if($type == 'text' and $_GET['text'][$field] != '')
						{
							$_search_get = $_GET['text'][$field];
							$_field_value = mb_strtolower($item[$field]);
							
							$check = strpos($_field_value, $_search_get);
							if($check === false) $delete = true;
						}
						
						// FOR NUM FIELDS
						if($type == 'num')
						{
							$_field_value = $item[$field];
							
							if(isset($_GET['num'][$field]['from']) and $_GET['num'][$field]['from'] != '')
							{
								if($_GET['num'][$field]['from'] > $_field_value) $delete = true;
							}
							
							if(isset($_GET['num'][$field]['to']) and $_GET['num'][$field]['from'] != '')
							{
								if($_GET['num'][$field]['to'] < $_field_value) $delete = true;
							}
						}
						
						// FOR SELECT FIELDS
						if($type == 'select' and $_GET['select'][$field] != 'all')
						{
							$_search_get = $_GET['select'][$field];
							$_field_value = $item[$field];
							
							if($_search_get != $_field_value) $delete = true;
						}
						
						// FOR CHECKBOX FIELDS
						if($type == 'checkbox')
						{
							$_coin_counter = 0;
							$_field_json = json_decode($item[$field], true);
							$_search_get = $_GET['checkbox'][$field];
							
							foreach($_field_json as $_fj)
							{
								if(array_key_exists($_fj, $_search_get)) $_coin_counter++;
							}
							if($_coin_counter == 0) $delete = true;
						}
					}
				}
					
				if($delete) unset($items[$id]);
			}
			
			
			if(!empty($items))
			{
				foreach($items as $key => $item) $this->_filter_arr['where_in'][] = $key;
			}
			$this->_filter_arr['enable'] = false;
		}
		
		if(!empty($this->_filter_arr['where_in']))
		{
			$this->db->where_in('shop_products.idItem', $this->_filter_arr['where_in']);
		}
		
	}
	
	# RELATIONS
	
	protected $_table_catalogs = 'shop_catalog_products';
	
	public function getCatalogProducts($params = array())
	{
		return $this->query->items($this->_table_catalogs, false, false, false, $params);
	}
	
	public function getCatalogProductsList($params = array())
	{
		$items = $this->query->items($this->_table_catalogs, false, false, false, $params);
		return $this->query->items_list($items, 'idParent', 'idParent');
	}
	
	public function ajaxCatalogDelete($id)
	{
		$insert = $this->post();
		if($insert['delete_mod'] != 'delete')
		{
			return array('error' => true, 'text' => 'Ошибка данных POST');
		}
		
		$error = $this->query->delete($this->_table_catalogs, array('idParent' => $insert['parent'], 'idProduct' => $id));
		if(!$error)
		{
			return array('error' => false, 'text' => 'Запись успешно удалена');
		} else {
			return array('error' => true, 'text' => 'Ошибка сервера');
		}
	}
	
	public function getItemsByCatalogAdmin($id, $current = false)
	{
		$return = array();
		$this->db->select('shop_catalog_products.*, shop_products.idItem, shop_products.title, shop_products.brief, shop_products.img');
		$this->db->join('shop_products', 'shop_catalog_products.idProduct = shop_products.idItem', 'left');
		$this->db->group_by('shop_catalog_products.idItem');
		$items = $this->query->items($this->_table_catalogs, false, false, false, array('shop_catalog_products.idParent' => $id));
		
		$rel = array();
		if($current)
		{
			$rel_query = $this->query->items($this->_table_similars, false, false, false, array('idParent' => $current));
			$rel = $this->query->items_list($rel_query, 'idProduct', 'idProduct');
		}
		
		foreach($items as $item)
		{
			$item['current'] = false;
			if($current and isset($rel[$item['idItem']])) $item['current'] = true;
			$return[] = $item;
		}
		
		return $return;
	}
	
	protected function _updateParents($id, $parents = array())
	{
		$rel = $this->getCatalogProductsList(array('idProduct' => $id));
		foreach($parents as $parent)
		{
			if(!isset($rel[$parent]))
			{
				$this->query->insert($this->_table_catalogs, array('idParent' => $parent, 'idProduct' => $id));
			}
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
	
	public function validate($key = 'product_edit')
	{
		$rules = array(
			'product_insert' => array(
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
					'field' => 'articul',
					'label' => 'Артикул',
					'rules'   => 'trim|required|max_length[255]',
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
			),
			'product_edit' => array(
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
					'field' => 'articul',
					'label' => 'Артикул',
					'rules'   => 'trim|required|max_length[255]',
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
			),
			'product_copy' => array(
				array(
					'field' => 'title',
					'label' => 'Заголовок',
					'rules'   => 'trim|required|max_length[255]',
				),
				array(
					'field' => 'alias',
					'label' => 'Ссылка (ЧПУ)',
					'rules'   => 'trim|required|max_length[255]',
				),
				array(
					'field' => 'articul',
					'label' => 'Артикул',
					'rules'   => 'trim|required|max_length[255]',
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
			),
		);
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="form-error">', '</div>');
		$this->form_validation->set_rules($rules[$key]);
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
	
	public function copyimg($file, $name)
	{
		if(!$file or !$name) return null;
		
		$ext = explode('.', $file);
		$ext = $ext[count($ext) - 1];
		$paths = array(
			'./assets/uploads/'.$this->_folder.'/',
			'./assets/uploads/'.$this->_folder.'/thumb/',
		);
		
		foreach($paths as $p)
		{
			$nfile = $p.$file;
			if(file_exists($nfile) and !is_dir($nfile))
			{
				copy($nfile, $p.$name.'.'.$ext);
			}
		}
		return $name.'.'.$ext;
	}
	
	# WORK WITH MODIFICATIONS
	
	protected $_table_modification = 'shop_products_modifications';
	
	public function getModifications($params = array())
	{
		return $this->query->items($this->_table_modification, false, false, 'idItem|ASC', $params);
	}
	
	public function getModification($params = array())
	{
		$item = $this->query->item($this->_table_modification, $params);
		if(empty($item)) return array();
		
		$parent = $this->getItem($item['idParent']);
		if(empty($parent)) return array();
		
		$return = array(
			'articul' => $item['articul'],
			'idProduct' => $item['idParent'],
			'title' => $item['title'],
			'brief' => $parent['brief'],
			'alias' => $parent['alias'],
			'img' => $parent['img'],
			'price' => $item['price'],
			'currency' => $parent['currency'],
		);
		
		return $return;
	}
	
	public function ajaxInsertMod($id)
	{
		$post = $this->post();
		
		$insert = array(
			'idParent' => $id,
			'articul' => $post['add_mod']['articul'],
			'title' => $post['add_mod']['title'],
			'price' => $post['add_mod']['price'],
			'oldPrice' => $post['add_mod']['oldPrice'],
		);
		
		$error = $this->query->insert($this->_table_modification, $insert);
		if(!$error)
		{
			return array('error' => false, 'text' => 'Запись успешно удалена', 'id' => $this->query->insert_id());
		} else {
			return array('error' => true, 'text' => 'Ошибка сервера');
		}
	}
	
	public function ajaxModDelete($id)
	{
		$insert = $this->post();
		if($insert['delete_mod'] != 'delete')
		{
			return array('error' => true, 'text' => 'Ошибка данных POST');
		}
		
		$error = $this->query->delete($this->_table_modification, array('idItem' => $id));
		if(!$error)
		{
			return array('error' => false, 'text' => 'Запись успешно удалена');
		} else {
			return array('error' => true, 'text' => 'Ошибка сервера');
		}
	}
	
	protected function _updateModification($id, $mods = array())
	{
		foreach($mods as $mod)
		{
			$id = $mod['idItem'];
			unset($mod['idItem']);
			$this->query->update($this->_table_modification, $mod, array('idItem' => $id));
		}
	}
	
	# WORK WITH DESCRIPTIONS
	
	protected $_table_descr = 'shop_products_descr';
	
	public function getDescriptions($params = array())
	{
		return $this->query->items($this->_table_descr, false, false, 'num|DESC//title|ASC', $params);
	}
	
	public function ajaxInsertDescr($id)
	{
		$post = $this->post();
		
		$insert = array(
			'idParent' => $id,
			'title' => $post['title'],
			'num' => 1,
			'visibility' => 1,
		);
		
		$error = $this->query->insert($this->_table_descr, $insert);
		if(!$error)
		{
			return array('error' => false, 'text' => 'Запись успешно удалена', 'id' => $this->query->insert_id());
		} else {
			return array('error' => true, 'text' => 'Ошибка сервера');
		}
	}
	
	public function ajaxDescrDelete($id)
	{
		$insert = $this->post();
		if($insert['delete_descr'] != 'delete')
		{
			return array('error' => true, 'text' => 'Ошибка данных POST');
		}
		
		$error = $this->query->delete($this->_table_descr, array('idItem' => $id));
		if(!$error)
		{
			return array('error' => false, 'text' => 'Запись успешно удалена');
		} else {
			return array('error' => true, 'text' => 'Ошибка сервера');
		}
	}
	
	protected function _updateDescription($id, $descrs = array())
	{
		foreach($descrs as $id => $descr)
		{
			if(array_key_exists('visibility', $descr)) $descr['visibility'] = $descr['visibility'] ? 1 : 0;
			else $descr['visibility'] = 0;
			
			$this->query->update($this->_table_descr, $descr, array('idItem' => $id));
		}
	}
	
	# WORK WITH ARTICLES
	
	protected $_table_articles = 'articles';
	protected $_table_articles_rel = 'shop_products_articles';
	
	public function getArticles($id, $params = array())
	{
		$this->db->select('shop_products_articles.*, articles.img, articles.title, articles.brief, articles.alias');
		$this->db->join('articles', 'shop_products_articles.idArticle = articles.idItem', 'left');
		$this->db->group_by('shop_products_articles.idItem');
		
		$params['shop_products_articles.idParent'] = $id;
		
		$items = $this->query->items($this->_table_articles_rel, false, false, false, $params);
		
		return $items;
	}
	
	public function ajaxGetArticles($id = false)
	{
		$return = array();
		
		$this->query->select('idItem, title, img, brief, addDate');
		$items = $this->query->items($this->_table_articles, false, false, 'addDate|DESC');
		
		foreach($items as $item)
		{
			if($id !== false) $item['current'] = false;
			$return[$item['idItem']] = $item;
		}
		
		if($id !== false)
		{
			$rel = $this->query->items($this->_table_articles_rel, false, false, false, array('idParent' => $id));
			
			foreach($rel as $_rel)
			{
				if(isset($return[$_rel['idArticle']])) $return[$_rel['idArticle']]['current'] = true;
			}
		}
		
		return $return;
	}
	
	public function ajaxUpdateArticles($id)
	{
		$return = array(
			'error' => true,
			'text' => 'Ошибка данных POST',
			'toggle' => false,
		);
		
		$post = $this->input->post();
		if(!isset($post['id'])) return $return;
		
		$check = $this->query->items_count($this->_table_articles_rel, array('idParent' => $id, 'idArticle' => $post['id']));
		
		if($check)
		{
			$error = $this->query->delete($this->_table_articles_rel, array('idParent' => $id, 'idArticle' => $post['id']));
			if($error)
			{
				$return['error'] = 'Ошибка сервера';
			} else {
				$return['error'] = false;
				$return['toggle'] = 'delete';
			}
		} else {
			$insert = array(
				'idParent' => $id,
				'idArticle' => $post['id'],
			);
			$error = $this->query->insert($this->_table_articles_rel, $insert);
			if($error)
			{
				$return['error'] = 'Ошибка сервера';
			} else {
				$return['error'] = false;
				$return['toggle'] = 'insert';
			} 
		}
		
		return $return;
	}
	
	/* SIMILARS */
	
	protected $_table_similars = 'shop_products_similars';
	
	public function getSimilars($id, $params = array())
	{
		$this->db->select('shop_products_similars.*, shop_products.idParent as mainCatId, shop_products.title, shop_products.alias, shop_products.articul, shop_products.img, shop_products.brief, shop_products.price, shop_products.oldPrice, shop_products.mTitle, shop_products.sticker_hit, shop_products.sticker_new, shop_products.sticker_best, shop_products.num');
		$this->db->join('shop_products', 'shop_products_similars.idProduct = shop_products.idItem', 'left');
		$this->db->group_by('shop_products_similars.idItem');
		
		$params['shop_products_similars.idParent'] = $id;
		$items = $this->query->items($this->_table_similars, false, false, false, $params);
		
		return $items;
	}
	
	public function ajaxUpdateSimilars($id)
	{
		$return = array(
			'error' => true,
			'text' => 'Ошибка данных POST',
			'toggle' => false,
		);
		
		$similar = $this->input->post('id');
		if(!$similar) return $return;
		
		$check = $this->query->items_count($this->_table_similars, array('idParent' => $id, 'idProduct' => $similar));
		if($check)
		{
			$error = $this->query->delete($this->_table_similars, array('idParent' => $id, 'idProduct' => $similar));
			if($error)
			{
				$return['error'] = 'Ошибка сервера';
			} else {
				$return['error'] = false;
				$return['toggle'] = 'delete';
			}
		} else {
			$insert = array(
				'idParent' => $id,
				'idProduct' => $similar,
			);
			$error = $this->query->insert($this->_table_similars, $insert);
			if($error)
			{
				$return['error'] = 'Ошибка сервера';
			} else {
				$return['error'] = false;
				$return['toggle'] = 'insert';
			}
		}
		
		return $return;
	}
	
	/* FIELDS */
	
	protected $_table_fields = 'shop_fields';
	protected $_table_fields_values = 'shop_fields_values';
	protected $_table_fields_groups = 'shop_fields_groups';
	protected $_table_fields_products = 'shop_fields_products';
	
	public function getFields($id)
	{
		$items = $this->query->items($this->_table_fields_products, false, false, false, array('idParent' => $id));
		$items = $this->query->items_list($items, 'idField', 'value');
		return $items;
	}
	
	public function getProductFields($id)
	{
		$this->load->model('fields_model');
		$return = array();
		
		$items = $this->fields_model->getGroups(false, false, 'num|DESC');
		if(empty($items)) return array();
		
		foreach($items as $item)
		{
			$item['child'] = array();
			$return[$item['idItem']] = $item;
		}
		
		$childs = $this->fields_model->getItems(false, false, 'num|DESC');
		
		$products = $this->query->items($this->_table_fields_products, false, false, false, array('idParent' => $id));
		$products = $this->query->items_list($products, 'idField', 'value');
		
		foreach($products as $id => $value)
		{
			if(isset($childs[$id])) $childs[$id]['value'] = $value;
		}
		
		$values = $this->fields_model->getValues();
		foreach($values as $value)
		{
			$_vp = $value['idParent'];
			if(isset($childs[$_vp]))
			{
				$childs[$_vp]['values'][$value['idItem']] = $value['title'];
			}
		}
		
		foreach($childs as $child)
		{
			if(isset($return[$child['idParent']]))
			{
				if(!array_key_exists($child['idItem'], $products)) 
				{
					unset($childs[$child['idItem']]);
				} else {
					if(($child['type'] == 'select' or $child['type'] == 'checkbox') and !isset($child['values'])) $child['values'] = array();
					
					$return[$child['idParent']]['child'][$child['idItem']] = $child;
				}
			}
		}
		
		//var_dump($return); die;
		return $return;
	}
	
	public function ajaxUpdateField($id)
	{
		$return = array(
			'error' => true,
			'text' => 'Ошибка данных POST',
			'toggle' => false,
		);
		
		$field = $this->input->post('id');
		if(!$field) return $return;
		
		$check = $this->query->items_count($this->_table_fields_products, array('idParent' => $id, 'idField' => $field));
		if($check)
		{
			$error = $this->query->delete($this->_table_fields_products, array('idParent' => $id, 'idField' => $field));
			if($error)
			{
				$return['error'] = 'Ошибка сервера';
			} else {
				$return['error'] = false;
				$return['toggle'] = 'delete';
			}
		} else {
			$insert = array(
				'idParent' => $id,
				'idField' => $field,
			);
			$error = $this->query->insert($this->_table_fields_products, $insert);
			if($error)
			{
				$return['error'] = 'Ошибка сервера';
			} else {
				$return['error'] = false;
				$return['toggle'] = 'insert';
			}
		}
		
		return $return;
	}
	
	protected function _updateFields($id, $fields)
	{
		foreach($fields as $type => $arr)
		{
			foreach($arr as $key => $value)
			{
				if($type == 'checkbox')
				{
					$value = json_encode($value);
					//var_dump($value); die;
				}
				$this->query->update($this->_table_fields_products, array('value' => $value), array('idParent' => $id, 'idField' => $key));
			}
		}
	}
	
	# WORK WITH COPY
	
	protected $_img_counter = 0;
	
	public function pcopy($id)
	{
		$insert = $this->post();
		
		/* check alias */
		$check = $this->getCount(array('alias' => $insert['alias']));
		if($check != 0) return action_result('error', fa('warning mr5').' Запись с ссылкой <span class="medium">'.$insert['alias'].'</span> уже есть в базе!', true);
		
		$check = $this->getCount(array('articul' => $insert['articul']));
		if($check != 0) return action_result('error', fa('warning mr5').' Запись с артикулом <span class="medium">'.$insert['articul'].'</span> уже есть в базе!', true);
		
		/* check checkbox */
		if(array_key_exists('visibility', $insert)) $insert['visibility'] = $insert['visibility'] ? 1 : 0;
		else $insert['visibility'] = 0;
		
		$item = $this->getItem($id);
		
		$this->_img_counter = 0;
		$img = $item['img'];
		$insert['img'] = $this->copyimg($img, $insert['alias'].'_'.$this->_img_counter);
		$this->_img_counter++;
		
		unset($item['idItem'], $item['img'], $item['addDate']);
		
		foreach($item as $k => $v)
		{
			if(!isset($insert[$k])) $insert[$k] = $v;
		}
		
		$this->query->insert($this->_table, $insert);
		$nId = $this->query->insert_id();
		
		
		// Parents
		$this->db->select('idParent');
		$parents = $this->getCatalogProducts(array('idProduct' => $id));
		foreach($parents as $parent)
		{
			$this->query->insert($this->_table_catalogs, array('idParent' => $parent['idParent'], 'idProduct' => $nId));
		}
		
		// Imgs
		$this->db->select('img');
		$imgs = $this->getImgs(false, false, false, array('idParent' => $id));
		foreach($imgs as $img)
		{
			$img_ins = $this->copyimg($img['img'], $insert['alias'].'_'.$this->_img_counter);
			if($img_ins)
			{
				$this->query->insert($this->_table_imgs, array('idParent' => $nId, 'img' => $img_ins));
				$this->_img_counter++;
			}
		}
		
		// Description
		$this->db->select('title, text, num, visibility');
		$descrs = $this->getDescriptions(false, false, false, array('idParent' => $id));
		foreach($descrs as $descr)
		{
			$descr['idParent'] = $nId;
			$this->query->insert($this->_table_descr, $descr);
		}
		
		// Fields
		$this->db->select('idField, value');
		$fields = $this->query->items($this->_table_fields_products, false, false, false, array('idParent' => $id));
		foreach($fields as $field)
		{
			$field['idParent'] = $nId;
			$this->query->insert($this->_table_fields_products, $field);
		}
		
		// Articles
		$articles = array();
		$articles_query = $this->getArticles($id);
		foreach($articles_query as $article)
		{
			$this->query->insert($this->_table_articles_rel, array('idParent' => $nId, 'idArticle' => $article['idArticle']));
		}
		
		// Similars
		$similars = $this->query->items($this->_table_similars, false, false, false, array('idParent' => $id));
		foreach($similars as $similar)
		{
			$this->query->insert($this->_table_similars, array('idParent' => $nId, 'idProduct' => $similar['idProduct']));
		}
		
		set_flash('result', action_result('success', fa('check mr5').' Запись <span class="medium">"'.$insert['title'].'"</span> успешно скопирована!', true));
		
		redirect('admin/'.uri(2).'/edit/'.$nId);
		
		return false;
		
		
		
		var_dump($item); die;
		
		die;
	}
	
	# WORK WITH IMGS
	
	protected $_table_imgs = 'shop_products_imgs';
	
	public function addImg($img, $parent)
	{
		//var_dump($img); die;
		$insert = array(
			'idParent' => $parent,
			'img' => $img['file_name'],
		);
		if(!$this->query->insert($this->_table_imgs, $insert))
		{
			return 'Ошибка сервера'; 
		} else {
			return false;
		}
	}
	
	public function getImgs($limit = false, $offset = false, $order = false, $params = false)
	{
		$items = $this->query->items($this->_table_imgs, $limit, $offset, $order, $params);
		return $items;
	}
	
	public function getImgsCount($parent = false)
	{
		if($parent) $this->db->where('idParent', $parent);		
		return $this->db->count_all_results($this->_table_imgs);
	}
	
	public function edit_img($post)
	{
		$insert = array(
			'ru' => $post['ru'],
			'en' => $post['en'],
		);
		
		$this->db->where('idItem', $post['idItem']);
		if(!$this->db->update($this->_table_imgs, $insert))
		{
			return 'Ошибка сервера'; 
		} else {
			return false;
		}
	}
	
	public function delete_img($post)
	{
		$this->db->where('idItem', $post['idItem']);
		$file = $this->db->get($this->_table_imgs);
		$file = $file->row_array();
		
		$this->db->where('idItem', $post['idItem']);
		if(!$this->db->delete($this->_table_imgs))
		{
			return 'Ошибка сервера'; 
		} else {
			$paths = array(
				'/assets/uploads/'.$this->_folder.'/'.$file['img'],
				'/assets/uploads/'.$this->_folder.'/thumb/'.$file['img'],
			);
			
			foreach($paths as $path)
			{
				if(file_exists('.'.$path) and !is_dir('.'.$path)) unlink('.'.$path);
			}
			return false;
		}
	}
	
	
	/* IMPORT */

	public function import($path)
    {
		$error = '';
		
		$this->db->select('currency');
		$siteinfo = $this->query->item('settings');
		
		$counter = array('insert' => 0, 'update' => 0, 'missing' => 0);
		
		$csv = file_get_contents($path);
		$csv = iconv("WINDOWS-1251", "UTF-8", $csv);//меняем кодировку на человеческую
		file_put_contents($path, $csv);
		
		$csv = fopen($path, "r");//открыли на чтение
		
		$csvArr = array();
		$fields = array('articul','idParent','idMfrs','title','brief','text','country','text_delivery','text_garanty','price','oldPrice','num','count','count_subtraction','sticker_new','sticker_hit','sticker_best','visibility','alias','mTitle','mKeywords','mDescription','img');
		
		$this->db->select('articul, idItem, img');
		$_get_articul = $this->query->items($this->_table);
		foreach($_get_articul as $_ga) $_arr_articul[$_ga['articul']] = array('id' => $_ga['idItem'], 'img' => $_ga['img']);
		
		$this->db->select('idItem, title');
		$_get_catalog = $this->query->items('shop_catalog');
		foreach($_get_catalog as $_gc) $_arr_catalog[$_gc['title']] = $_gc['idItem'];
		
		//var_dump($_arr_catalog); die;
		
		$this->db->select('idItem, title');
		$_get_mfrs = $this->query->items('shop_mfrs');
		foreach($_get_mfrs as $_gm) $_arr_mfrs[$_gm['title']] = $_gm['idItem'];
		
		$this->load->library('SimpleImage');
		$_line_str = 1;
        while (($line = fgetcsv($csv, 0, ";")) !== FALSE)//построчно считываем 
		{
			$i = 0;
			$_line_err = false;
			foreach ($line as $key => $value) 
			{
				$data[$fields[$i]] = $value;
				$i++;
			}
			
			if($data['idParent'] != '')
			{
				$parents = $data['idParent'];
				$data['parents'] = array();
				$data['idParent'] = null;
				//$parents = str_replace(' ', '', $parents);
				$parents = explode(',', $parents);
				foreach($parents as $k => $v) $parents[$k] = trim($v);
				
				//var_dump($parents);
				
				foreach($parents as $parent)
				{
					if(array_key_exists($parent, $_arr_catalog))
					{
						$data['parents'][] = $_arr_catalog[$parent];
						if($data['idParent'] == null) $data['idParent'] = $_arr_catalog[$parent];
					}
				}
			}
			
			if($data['idMfrs'] == '')
			{
				$data['idMfrs'] = null;
			} elseif(array_key_exists($data['idMfrs'], $_arr_mfrs))
			{
				$data['idMfrs'] = $_arr_mfrs[$data['idMfrs']];
			} else {
				if($_line_str != 1) $error .= '<div class="mb5"><strong>Ошибка добавления записи. Строка '.$_line_str.'.</strong> Производитель указан не верно.</div>';
				$_line_err = true;
			}
			
			if($data['articul'] == '')
			{
				if($_line_str != 1) $error .= '<div class="mb5"><strong>Ошибка добавления записи. Строка '.$_line_str.'.</strong> Артикул обязателен для заполнения.</div>';
				$_line_err = true;
			}
			
			if(!$_line_err)
			{
				$img = $data['img'];
				unset($data['img']);
				if($img != '')
				{
					$_img_return = $this->uploadImageFromUrl($img);
					if(array_key_exists('error', $_img_return))
					{
						$error .= '<div class="mb5"><strong>Ошибка загрузки изображения. Строка '.$_line_str.'.</strong> '.$_img_return['error'].'.</div>';
					} else {
						$data['img'] = $_img_return['file_name'];
					}
				}
			}
			
			$data['currency'] = $siteinfo['currency'];
			$data['price'] = str_replace(',', '.', $data['price']);
			$data['oldPrice'] = str_replace(',', '.', $data['oldPrice']);
			$data['price_curr'] = $data['price'];
			$data['oldPrice_curr'] = $data['oldPrice'];
			
			if(!$_line_err) $csvArr[] = $data;
			elseif($_line_str != 1) $counter['missing']++;
			$_line_str++;
		}
		
		fclose($csv);
		
		//die;
		
		foreach($csvArr as $insert)
		{
			$_ins_error = false;
			$parents = $insert['parents'];
			unset($insert['parents']);
			if(array_key_exists($insert['articul'], $_arr_articul))
			{
				$_ins_error = $this->query->update($this->_table, $insert, array('articul' => $insert['articul']));
				if($_ins_error)
				{
					$error .= '<div class="mb5"><strong>Ошибка сервера!</strong> Запись с артикулом '.$insert['articul'].' не была обновлена.</div>';
					$counter['missing']++;
				} else {
					if(array_key_exists('img', $insert)) $this->deletephoto($_arr_articul[$insert['articul']]['img']);
					$this->query->delete($this->_table_catalogs, array('idProduct' => $_arr_articul[$insert['articul']]['id']));
					$idItem = $_arr_articul[$insert['articul']]['id'];
					$counter['update']++;
				}
			} else {
				$_ins_error = $this->query->insert($this->_table, $insert);
				if($_ins_error)
				{
					$error .= '<div class="mb5"><strong>Ошибка сервера!</strong> Запись с артикулом '.$insert['articul'].' не была добавлена.</div>';
					$counter['missing']++;
				} else {
					$idItem = $this->query->insert_id();
					$counter['insert']++;
				}
			}
			if(!$_ins_error)
			{
				foreach($parents as $parent)
				{
					$ins = array(
						'idParent' => $parent,
						'idProduct' => $idItem,
					);
					$this->query->insert($this->_table_catalogs, $ins);
				}
			}
		}
		
		if($error == '')
		{
			set_flash('result', action_result('success', fa('check mr5').' <strong>Запрос выполнен успешно.</strong> Добавлено записей: '.$counter['insert'].'. Обновлено записей: '.$counter['update'], true));
			return false;
		} else {
			$error .= '<div class="mt15"><strong>Запрос выполнен с ошибками.</strong> Добавлено записей: '.$counter['insert'].'. Обновлено записей: '.$counter['update'].'. Попущено записей: '.$counter['missing'].'.</div>';
			return action_result('error', $error);
		}
	}
	
	
	/**
     * @var object Экземпляр класса SimpleImage для работы с изображениями 
     */
    public $simpleImage;
    /**
     * @var string название атрибута, хранящего в себе имя файла и файл
     */
    public $attributeName = 'image';
    /**
     * @var string алиас директории, куда будем сохранять файлы
     */
    //public $savePathAlias = 'webroot.assets.uploads.products';
    public $savePathAlias = './assets/uploads/products';
    /**
     * @var string алиас поддиректории, куда будем сохранять превью
     */
    //public $thumbnailPathAlias = 'webroot.assets.uploads.products.thumbs';
    public $thumbnailPathAlias = './assets/uploads/products/thumb';
    /**
     * @var string расширения файлов, которые можно загружать (нужно для валидации)
     */
    public $fileTypes = 'jpg,jpeg,png,gif,bmp';
    /**
     * @var string mime-типы файлов, которые можно загружать (нужно для валидации)
     */
    public $mimeTypes = 'image/jpg,image/jpeg,image/png,image/gif,image/bmp';
    /**
     * @var int максимальный размер файла (нужно для валидации)
     */
    public $maxSize =  2097152;
	
	/**
     * Загрузка изображения с удаленного сервера.
     * Валидация проходит в соответствии с настройками поведения
     * Метод сохраняет файл и сгенерированное превью в указанные при подключении поведения директории
     * Возвращает массив данных о загруженном изображении
     */
    public function uploadImageFromUrl($url)
    {
        $curl = curl_init($url);
        
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        curl_close($curl);
        //var_dump($response);//die;
        if(!$response)
        {
            return array('error'=>"Не удается получить указанный файл.");
        }
        $headers = $this->getHeadersFromCurlResponse($response);
        //var_dump($headers);die;
        if (strpos($this->mimeTypes, $headers['Content-Type'])===FALSE)
        {
            return array('error' => "Файл типа ".$headers['Content-Type']." не может быть загружен. Допустимые типы: ".$this->mimeTypes);
        }
        if ($headers['Content-Length'] > $this->maxSize)
        {
            return array('error' => "Размер файла слишком велик, он не должен превышать 2Mb");
        }
        
        $fileOriginalName = basename($url);
        $fileExtension = pathinfo($url, PATHINFO_EXTENSION);
        $fileSaveName = md5(uniqid('',true)) . '.' . $fileExtension;
        
        //$this->createStorageIfNotExists();
        
        file_put_contents($this->savePathAlias . '/' . $fileSaveName, file_get_contents($url));
        
        $this->createThumbnailForImage($fileSaveName);
        
        return array(
            'file_name' => $fileSaveName,
            'orig_name' => $fileOriginalName,
            'file_size' => $headers['Content-Length'],
            'mime_type' => $headers['Content-Type'],
            'is_remote_file' => (int)TRUE,
        );
    }
    /**
     * Возвращает заголовки curl-ответа в виде ассоциативного массива
     */
    public function getHeadersFromCurlResponse($response)
    {
        $headers = array();
        $string = substr($response, 0, strpos($response, "\r\n\r\n"));
        foreach (explode("\r\n", $string) as $i => $line)
        {
            if ($i === 0)
            {
                $headers['http_code'] = $line;
            }
            else
            {
                list ($key, $value) = explode(': ', $line);
                $headers[$key] = $value;
            }
        }
        return $headers;
    }
    
    /**
     * Генерация превью для файла
     */
    public function createThumbnailForImage($fileSaveName)
    {
		$size = $this->thumbSize();
        $this->simpleimage
            ->load($this->savePathAlias . '/' . $fileSaveName)
            ->thumbnail($size['x'], $size['y'])->save($this->thumbnailPathAlias . '/' . $fileSaveName);
    } 

	public function import_assort($path)
    {
		$error = '';
		
		$counter = array('insert' => 0, 'update' => 0, 'missing' => 0);
		
		$csv = file_get_contents($path);
		$csv = iconv("WINDOWS-1251", "UTF-8", $csv);//меняем кодировку на человеческую
		file_put_contents($path, $csv);
		
		$csv = fopen($path, "r");//открыли на чтение
		
		$csvArr = array();
		$fields = array('articul','idParent','title','price','oldPrice','count');		
		
		$_arr_articul = array();
		$this->db->select('articul');
		$_get_articul = $this->query->items($this->_table_modification);
		foreach($_get_articul as $_ga) $_arr_articul[$_ga['articul']] = $_ga['articul'];
		
		$_arr_catalog = array();
		$this->db->select('idItem, articul');
		$_get_catalog = $this->query->items('shop_products');
		foreach($_get_catalog as $_gc) $_arr_catalog[$_gc['articul']] = $_gc['idItem'];
		
		$_line_str = 1;
        while (($line = fgetcsv($csv, 0, ";")) !== FALSE)//построчно считываем 
		{
			$i = 0;
			$_line_err = false;
			foreach ($line as $key => $value) 
			{
				$data[$fields[$i]] = $value;
				$i++;
			}
			
			if(array_key_exists($data['idParent'], $_arr_catalog))
			{
				$data['idParent'] = $_arr_catalog[$data['idParent']];
			} else {
				if($_line_str != 1) $error .= '<div class="mb5"><strong>Ошибка добавления записи. Строка '.$_line_str.'.</strong> Товар указан не верно.</div>';
				$_line_err = true;
			}
			
			if($data['articul'] == '')
			{
				if($_line_str != 1) $error .= '<div class="mb5"><strong>Ошибка добавления записи. Строка '.$_line_str.'.</strong> Артикул обязателен для заполнения.</div>';
				$_line_err = true;
			}
			
			if(!$_line_err) $csvArr[] = $data;
			elseif($_line_str != 1) $counter['missing']++;
			$_line_str++;
		}
		
		fclose($csv);
		
		//var_dump($csvArr); die;
		
		foreach($csvArr as $insert)
		{
			$_ins_error = false;
			if(array_key_exists($insert['articul'], $_arr_articul))
			{
				$_ins_error = $this->query->update($this->_table_modification, $insert, array('articul' => $insert['articul']));
				if($_ins_error)
				{
					$error .= '<div class="mb5"><strong>Ошибка сервера!</strong> Запись с артикулом '.$insert['articul'].' не была обновлена.</div>';
					$counter['missing']++;
				} else {
					$counter['update']++;
				}
			} else {
				$_ins_error = $this->query->insert($this->_table_modification, $insert);
				if($_ins_error)
				{
					$error .= '<div class="mb5"><strong>Ошибка сервера!</strong> Запись с артикулом '.$insert['articul'].' не была добавлена.</div>';
					$counter['missing']++;
				} else { 
					$counter['insert']++;
				}
			}
		}
		
		if($error == '')
		{
			set_flash('result', action_result('success', fa('check mr5').' <strong>Запрос выполнен успешно.</strong> Добавлено записей: '.$counter['insert'].'. Обновлено записей: '.$counter['update'], true));
			return false;
		} else {
			$error .= '<div class="mt15"><strong>Запрос выполнен с ошибками.</strong> Добавлено записей: '.$counter['insert'].'. Обновлено записей: '.$counter['update'].'. Попущено записей: '.$counter['missing'].'.</div>';
			return action_result('error', $error);
		}
	}
}
