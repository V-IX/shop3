<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*if ( ! function_exists(''))
{
	function action_result()
	{
		return $return;
	}
}*/



/*
|--------------------------------------------------------------------------
| SESSION HELPERS
|--------------------------------------------------------------------------
*/
if ( ! function_exists('check_session'))
{
	function check_session()
	{
		
	}
}

if ( ! function_exists('set_flash'))
{
	function set_flash($key, $value = '')
	{
		$CI =& get_instance();		
		return $CI->session->set_flashdata($key, $value);
	}
}

/*
|--------------------------------------------------------------------------
| URL HELPERS
|--------------------------------------------------------------------------
*/
if ( ! function_exists('uri'))
{
	function uri($num)
	{
		$CI =& get_instance();		
		return $CI->uri->segment($num);
	}
}

/*
|--------------------------------------------------------------------------
| LIBRARIES HELPERS
|--------------------------------------------------------------------------
*/
if ( ! function_exists('admin_pagination'))
{
	function admin_pagination($base_url, $total, $per_page = 10, $uri_segment = 4)
	{
		$return = array(
			'base_url'		=> '/admin/'.trim($base_url, '/').'/',
			'total_rows'	=> $total,
			'uri_segment'	=> $uri_segment,
			'per_page'		=> $per_page,
		);
		
		$return['offset'] = (uri(4) * $return['per_page']) - $return['per_page'];
		if($return['offset'] < 0) $return['offset'] = 0;
		
		return $return;
	}
}

if ( ! function_exists('site_pagination'))
{
	function site_pagination($base_url, $total, $per_page = 10, $uri_segment = 3)
	{
		$return = array(
			'base_url'		=> '/'.trim($base_url, '/').'/',
			'total_rows'	=> $total,
			'uri_segment'	=> $uri_segment,
			'per_page'		=> $per_page,
			
			'full_tag_open' => ' <ul class="pagination">',
			'full_tag_close' => '</ul>',
			'num_tag_open'	=> '<li class="pagination-num">',
			'num_tag_close'	=> '</li>',
			'cur_tag_open'	=> '<li class="pagination-num pagination-active"><a href="javascript:void(0)">',
			'cur_tag_close'	=> '</a></li>',
			
			'first_tag_open'	=> '<li class="pagination-nav pagination-left pagination-first">',
			'first_tag_close'	=> '</li>',
			'last_tag_open'		=> '<li class="pagination-nav pagination-right pagination-last">',
			'last_tag_close'	=> '</li>',
			'next_tag_open'		=> '<li class="pagination-nav pagination-right pagination-next">',
			'next_tag_close'	=> '</li>',
			'prev_tag_open'		=> '<li class="pagination-nav pagination-left pagination-prev">',
			'prev_tag_close'	=> '</li>',
			
			'first_link'	=> fa('angle-double-left') . ' <span>В начало</span>',
			'last_link'		=> '<span>В конец</span> ' . fa('angle-double-right'),
			'prev_link'		=> fa('angle-left') . ' <span>Предыдущая</span>',
			'next_link'		=> '<span>Следующая</span> ' . fa('angle-right'),
		);
		
		$uri = uri($uri_segment);
		$uri_segment = !is_null($uri) ? trim($uri, 'page-') : 0;
		
		$return['offset'] = ($uri_segment * $return['per_page']) - $return['per_page'];
		if($return['offset'] < 0) $return['offset'] = 0;
		
		if (count($_GET) > 0) $return['suffix'] = '?' . http_build_query($_GET, '', "&");
		
		return $return;
	}
}