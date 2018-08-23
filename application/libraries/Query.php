<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Query {

	protected $CI;
	protected $db;

	public function __construct($config = array())
	{
		$this->CI =& get_instance();
		$this->db = $this->CI->db;
		log_message('info', 'Query Class Initialized');
	}
	
	public function items($table, $limit = false, $offset = false, $order = false, $params = array()) 
	{
		if(!empty($params)) $this->params($params);
		
		if($order) $this->order($order);
		
		$items = $this->db->get($table, $limit, $offset);
		return $items->result_array();
	}
	
	public function item($table, $params = array()) 
	{
		if(!empty($params)) $this->params($params);
		
		$item = $this->db->get($table);
		return $item->row_array();
	}
	
	public function items_count($table, $params = array())
	{
		if(!empty($params)) $this->params($params);
		return $this->db->count_all_results($table);
	}
	
	public function insert($table, $insert = array()) 
	{
		if($this->db->insert($table, $insert)) return false;
		else return $this->_server_error();
	}
	
	public function insert_id() 
	{
		return $this->db->insert_id();
	}
	
	public function update($table, $insert = array(), $params = array()) 
	{
		if(!empty($params)) $this->params($params);
		
		if($this->db->update($table, $insert)) return false;
		else return $this->_server_error();
	}
	
	public function delete($table, $params = array()) 
	{
		if(!empty($params)) $this->params($params);
		
		if($this->db->delete($table)) return false;
		else return $this->_server_error();
	}
	
	/* HELPERS */
	
	public function items_list($array = array(), $key, $value)
	{
		if(!is_array($array) or empty($array)) return array();
		$return = array();
		foreach($array as $item)
		{
			if(array_key_exists($key, $item) and array_key_exists($value, $item)) $return[$item[$key]] = $item[$value];
		}
		return $return;
	}
	
	public function table($table)
	{
		$this->db->from($table);
	}
	
	public function select($select)
	{
		$this->db->select($select);
	}
	
	public function params($params = array())
	{
		foreach($params as $k => $v) $this->db->where($k, $v);
	}
	
	public function order($order)
	{
		$order = explode('//', $order);
		foreach($order as $str) $order_by[] = explode('|', $str);
		
		foreach($order_by as $item)
		{
			if($item[0] != '' and $item[1] != '') $this->db->order_by($item[0], $item[1]);
		}
	}
	
	/* ERRORS */
	
	function _server_error()
	{
		$CI =& get_instance();
		$message = action_result('error', fa('times mr5').' Ошибка сервера! Обратитесь к разработчику <span class="medium underline">'.$CI->config->config['cms_developer_email'].'</span>', true);
		return $message;
	}
	
	
	
	

}
