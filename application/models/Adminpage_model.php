<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Adminpage_model extends CI_Model {
	
	protected $_table = 'pages_admin';
	
	public function items($limit = false, $offset = false, $order = false, $params = array())
	{
		$items = $this->query->items($this->_table, $limit, $offset, $order, $params);
		return $items;
	}
	
	public function item($id, $alias = false, $params = array())
	{
		if($alias) $params['alias'] = $id;
		else $params['idItem'] = $id;
		
		$item = $this->query->item($this->_table, $params);
		return $item;
	}
	
	public function tree()
	{
		$params = array(
			'idParent' => 0,
			'access !=' => 0,
		);
		
		$parents = $this->items(false, false, 'num|ASC', $params);
		if(empty($parents)) return array();
		$tree = array();
		foreach($parents as $item)
		{
			$tree[$item['idItem']] = $item;
			$tree[$item['idItem']]['child'] = array();
		}
		
		unset($params['idParent']);
		$params['idParent !='] = 0;
		$childs = $this->items(false, false, 'num|ASC', $params);
		if(!empty($childs))
		{
			foreach($childs as $child)
			{
				if(array_key_exists($child['idParent'], $tree)) $tree[$child['idParent']]['child'][] = $child;
			}
		}
		
		return $tree;
	}
	
	public function bells()
	{
		$return = array(
			'feedback' => array(
				'count' => $this->query->items_count('feedback', array('isRead' => 0)),
				'color' => 'success',
			),
			'orders' => array(
				'count' => $this->query->items_count('shop_orders', array('isRead' => 0)),
				'color' => 'success',
			),
			'feedback_orders' => array(
				'count' => $this->query->items_count('feedback_orders', array('isRead' => 0)),
				'color' => 'warning',
			),
			'comments' => array(
				'count' => $this->query->items_count('shop_products_comments', array('isRead' => 0)),
				'color' => 'info',
			),
			'reviews' => array(
				'count' => $this->query->items_count('reviews', array('isRead' => 0)),
				'color' => 'warning',
			),
			'faq' => array(
				'count' => $this->query->items_count('faq', array('isRead' => 0)),
				'color' => 'info',
			),
		);
		
		return $return;
	}
	
}
