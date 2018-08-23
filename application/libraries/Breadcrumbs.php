<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Breadcrumbs {

	protected $CI;
	
	protected $segments = array();
	
	protected $breadcrumbs = '';

	public function __construct($config = array())
	{
		$this->CI =& get_instance();
		
		log_message('info', 'Breadcrumbs Class Initialized');
	}
	
	public function create_links($wrapper = false)
	{
		$uri = $this->segments;
		
		$sep = '<span class="breadcrumbs-sep">'.fa('angle-double-right').'</span>';		
		$breadcrumbs = '<div class="breadcrumbs">';
		if($wrapper) $breadcrumbs .= '<div class="wrapper">';		
		$breadcrumbs .= '<div class="breadcrumbs-in">';
		$breadcrumbs .= '<a href="'.base_url().'">Главная</a> ';
		
		$count = count($uri);
		$i = 1;
		foreach($uri as $k => $v)
		{
			$breadcrumbs .= $sep;
			if($i != $count) $breadcrumbs .= ' <a href="'.base_url($k).'">'.$v.'</a> ';
			else $breadcrumbs .= ' <span>'.$v.'</span> ';
				
			$i++;
		}
		
		$breadcrumbs .= '</div>';
		if($wrapper) $breadcrumbs .= '</div>';
		$breadcrumbs .= '</div>';
		
		return $breadcrumbs;
	}
	
	public function create_admin_links()
	{
		$uri = $this->segments;
		
		$sep = '<span class="breadcrumbs-sep"></span>';		
		$breadcrumbs = '<div class="breadcrumbs"><a href="/admin">Главная</a> ';
		
		$count = count($uri);
		$i = 1;
		foreach($uri as $k => $v)
		{
			$breadcrumbs .= $sep;
			if($i != $count) $breadcrumbs .= ' <a href="/admin/'.ltrim($k, '/').'">'.$v.'</a> ';
			else $breadcrumbs .= ' <span>'.$v.'</span> ';
				
			$i++;
		}
		
		$breadcrumbs .= '</div>';
		
		return $breadcrumbs;
	}
	
	public function add($title, $link = '')
	{
		$this->segments[$link] = $title;
	}
	
	/* HELPERS */
	
	
	
	
	

}
