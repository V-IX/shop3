<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Catalog extends ADMIN_Controller {
	
	protected $model = '';
	protected $page = 'catalog';
	
	public function __construct ()
	{
		parent::__construct();
		$this->load->model('catalog_model');
		$this->model = $this->catalog_model;
	}
	
	public function index()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$count = $this->model->getCount();
		
		$items = $this->model->getItemsTree(false, false, 'num|DESC//title|ASC', array());
		
		//var_dump($items); die;
		
		$data['items'] = $items['tree'];
		
		
		$data['view'] = uri(2).'/index';
		$this->load->view('admin/common/template', $data);
	}
	
	public function create()
	{
		$this->load->library('upload', $this->model->configPhoto());
		
		$this->init_admin($this->page);
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->model->validate())
		{
			$error = $this->model->insert();
			if(!$error) redirect('/admin/'.uri(2));
		}
		
		$items = $this->model->getItemsTree(false, false, 'num|DESC//title|ASC', array());
		$data['parents'] = $items['tree'];
		
		$data['size'] = $this->model->thumbSize();
		
		$this->breadcrumbs->add('Добавить', '');
		
		//$this->load->helper('text');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/create';
		$this->load->view('admin/common/template', $data);
	}
	
	public function edit()
	{
		$this->load->library('upload', $this->model->configPhoto());
		
		$this->init_admin($this->page);
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->model->validate())
		{
			$error = $this->model->update(uri(4));
			if(!$error)
			{
				$redirect = uri(5) == 'close' ? '/admin/'.uri(2) : current_url();
				redirect($redirect);
			}
		}
		
		$data['item'] = $this->model->getItem(uri(4));
		if(empty($data['item']))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			redirect('admin/'.uri(2));
		}
		
		$items = $this->model->getItemsTree(false, false, 'num|DESC//title|ASC', array());
		$data['parents'] = $items['tree'];
		
		$data['size'] = $this->model->thumbSize();
		
		$this->breadcrumbs->add('Редактирование', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/edit';
		$this->load->view('admin/common/template', $data);
	}
	
	public function view()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$data['item'] = $this->model->getItem(uri(4));
		if(empty($data['item']))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			redirect('admin/'.uri(2));
		}
		
		$this->breadcrumbs->add('Просмотр', '');
		
		$data['view'] = uri(2).'/view';
		$this->load->view('admin/common/template', $data);
	}
	
	public function fields()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$data['item'] = $this->model->getItem(uri(4));
		if(empty($data['item']))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			redirect('admin/'.uri(2));
		}
		
		$error = false;
		if($this->input->post())
		{
			$error = $this->model->fields(uri(4));
			if(!$error) redirect(current_url());
		}
		
		$this->load->model('fields_model');
		$data['fields'] = $this->fields_model->getTree();
		
		$this->breadcrumbs->add('Поля для фильтрации', '');
		
		$data['view'] = uri(2).'/fields';
		$this->load->view('admin/common/template', $data);
	}
	
	public function delete()
	{
		if($this->input->post()) $this->model->delete(uri(4));
		redirect('admin/'.uri(2));
	}
	
	public function ajaxDeleteImg()
	{
		$this->output->set_content_type('application/json');
		
		if($this->input->post()) {
			$data = $this->model->ajaxDeleteImg(uri(4));
		}
		
		$this->output->set_output(json_encode($data));
	}
	
	
	/* export */
	
	
	protected $_export_array = array();
	
	public function export()
	{
		$items = array(
			array('num'	=> 100,	'title' => 'Тренажеры',
				'childs'=> array(
					array('num'	=> 10,	'title' => 'Беговые дорожки'),
					array('num'	=> 9,	'title' => 'Эллиптические тренажеры'),
					array('num'	=> 8,	'title' => 'Велотренажеры, эргометры'),
				),
			),
			array('num' => 99,	'title' => 'Тяжелая атлетика',
				'childs'=> array(
					array('num' => 10,	'title' => 'Железо'),
					array('num' => 9,	'title' => 'Инвентарь'),
					array('num' => 8,	'title' => 'Экипировка'),
				)
			),
			array('num' => 98,	'title' => 'Легкая атлетика',
				'childs'=> array(
					array('num' => 10,	'title' => 'Инвентарь', 'pre' => 'lite'),
					array('num' => 9,	'title' => 'Экипировка', 'pre' => 'lite'),
				)
			),
			array('num' => 97,	'title' => 'Летний инвентарь',
				'childs'=> array(
					array('num' => 10,	'title' => 'Коньки роликовые'),
					array('num' => 9,	'title' => 'Велосипеды'),
					array('num' => 8,	'title' => 'Скейты'),
					array('num' => 7,	'title' => 'Самокаты'),
				)
			),
			array('num' => 96,	'title' => 'Зимний инвентарь',
				'childs'=> array(
					array('num' => 10,	'title' => 'Хоккей'),
					array('num' => 9,	'title' => 'Фигурное катание'),
					array('num' => 8,	'title' => 'Лыжи беговые, ботинки, инвентарь'),
					array('num' => 7,	'title' => 'Лыжи горные, ботинки'),
					array('num' => 6,	'title' => 'Санки, ледянки, тюбинги'),
				)
			),
			array('num' => 95,	'title' => 'Спортивный инвентарь',
				'childs'=> array(
					array('num' => 10,	'title' => 'Весы, секундомеры, шагометры, динамометры'),
					array('num' => 9,	'title' => 'Обручи, скакалки, палки гимнастические'),
					array('num' => 8,	'title' => 'Мячи'),
				)
			),
		);
		
		$this->_export_insert($items, 0);
		
		var_dump($this->_export_array); die;
		
		die;
	}
	
	protected function _export_insert($items, $parent)
	{
		foreach($items as $item)
		{
			$alias = translit($item['title']);
			if(isset($item['pre']) and $item['pre'] != '') $alias .= '-'.$item['pre'];
				
			$insert = array(
				'idParent' => $parent,
				'title' => $item['title'],
				'alias' => $alias,
				'num' => $item['num'],
				'mTitle' => $item['title'],
			);
			
			$this->_export_array[] = $insert;
			
			$this->query->insert('shop_catalog', $insert);
			$id = $this->query->insert_id();
			
			if(isset($item['childs']) and !empty($item['childs']))
			{
				$this->_export_insert($item['childs'], $id);
			}
		}
	}
}
