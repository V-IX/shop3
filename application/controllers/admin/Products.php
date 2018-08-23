<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends ADMIN_Controller {
	
	protected $model = '';
	protected $page = 'products';
	
	public function __construct ()
	{
		parent::__construct();
		$this->load->model('products_model');
		$this->model = $this->products_model;
		$this->load->model('catalog_model');
	}
	
	public function index()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$count = $this->model->getCount();
		$pagination = admin_pagination(uri(2).'/index', $count, $data['siteinfo']['count_admin']);
		if (count($_GET) > 0) $pagination['suffix'] = '?' . http_build_query($_GET, '', "&");
		
		$sort = isset($_GET['sort']) ? $_GET['sort'] : 'title|ASC';
		
		$data['items'] = $this->model->getItems($pagination['per_page'], $pagination['offset'], $sort, array());
		$this->load->library('pagination');
		$this->pagination->initialize($pagination);
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		
		$data['count'] = $count;
		
		$items = $this->catalog_model->getItemsTree(false, false, 'num|DESC//title|ASC', array());
		$data['parents'] = $items['tree'];
		
		$data['view'] = uri(2).'/index';
		$this->load->view('admin/common/template', $data);
	}
	
	public function create()
	{
		$this->load->library('upload', $this->model->configPhoto());
		
		$this->init_admin($this->page);
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->model->validate('product_insert'))
		{
			$error = $this->model->insert();
			if(!$error) redirect('/admin/'.uri(2));
		}
		
		$parents = $this->catalog_model->getItemsTree(false, false, 'num|DESC//title|ASC', array());
		$data['parents'] = $parents['tree'];
		
		if(empty($data['parents']))
		{
			set_flash('result', action_result('warning', fa('ban mr5').' У вас не создано ни одной категории!', true));
			redirect('admin/catalog');
		}
		
		$data['size'] = $this->model->thumbSize();
		
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		$this->breadcrumbs->add('Добавить', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/product_create';
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
		
		$data['modificationsArr'] = $this->model->getModifications(array('idParent' => uri(4)));
		
		$this->load->model('mfrs_model');
		$data['mfrs'] = $this->mfrs_model->getList();
		
		//$data['catalog'] = $this->catalog_model->getList();
		$items = $this->catalog_model->getItemsTree(false, false, 'num|DESC//title|ASC', array());
		$data['catalogs'] = $items['tree'];
		$data['catalog'] = $this->catalog_model->getList();
		$data['catalogArr'] = $this->model->getCatalogProductsList(array('idProduct' => uri(4)));
		
		$this->load->model('units_model');
		$data['units_length'] = $this->units_model->listLength();
		$data['units_weight'] = $this->units_model->listWeight();
		$data['units_currency'] = $this->units_model->listCurrency();
		
		$data['articles'] = $this->model->getArticles(uri(4));
		$data['similars'] = $this->model->getSimilars(uri(4));
		$data['fields'] = $this->model->getProductFields(uri(4));
		$data['descrs'] = $this->model->getDescriptions(array('idParent' => uri(4)));
		
		$data['size'] = $this->model->thumbSize();
		
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		$this->breadcrumbs->add('Редактирование', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/product_edit';
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
		
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		$this->breadcrumbs->add('Просмотр', '');
		
		$data['view'] = uri(2).'/view';
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
	
	public function import()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->input->post('hidden') == 'import')
		{
			if (array_key_exists('file', $_FILES) && ($_FILES['file']['error'] == 0))
			{
				$error = $this->model->import($_FILES['file']['tmp_name']);
				if(!$error) redirect('/admin/'.uri(2));
			}
			else
			{
				$error = 'Файл не выбран';
			}
		}
		
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		$this->breadcrumbs->add('Импорт CSV', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/import';
		$this->load->view('admin/common/template', $data);
	}
	
	public function import_mod()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->input->post('hidden') == 'import')
		{
			if (array_key_exists('file', $_FILES) && ($_FILES['file']['error'] == 0))
			{
				$error = $this->model->import_assort($_FILES['file']['tmp_name']);
				if(!$error) redirect('/admin/'.uri(2));
			}
			else
			{
				$error = 'Файл не выбран';
			}
		}
		
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		$this->breadcrumbs->add('Импорт CSV модификаций', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/import_mod';
		$this->load->view('admin/common/template', $data);
	}
	
	/* AJAX MODIFICTIONS */
	
	public function ajaxInsertMod()
	{
		$this->output->set_content_type('application/json');
		
		$data = array('error' => true, 'text' => 'Ошибка данных POST');
		
		if($this->input->post()) {
			$data = $this->model->ajaxInsertMod(uri(4));
		}
		
		$this->output->set_output(json_encode($data));
	}
	
	public function ajaxModDelete()
	{
		$this->output->set_content_type('application/json');
		
		if($this->input->post()) {
			$data = $this->model->ajaxModDelete(uri(4));
		}
		
		$this->output->set_output(json_encode($data));
	}
	
	/* AJAX DESCRIPTIONS */
	
	public function ajaxInsertDescr()
	{
		$this->output->set_content_type('application/json');
		
		$data = array(
			'error' => true,
			'text' => 'Ошибка данных POST',
			'html' => '',
		);
		
		if($this->input->post()) {
			$data = $this->model->ajaxInsertDescr(uri(4));
			$data['html'] = $this->load->view('admin/products/ajax_descr', array('id' => $data['id']), true);
		}
		
		$this->output->set_output(json_encode($data));
	}
	
	public function ajaxDescrDelete()
	{
		$this->output->set_content_type('application/json');
		
		$data = array(
			'error' => true,
			'text' => 'Ошибка данных POST',
		);
		
		if($this->input->post()) {
			$data = $this->model->ajaxDescrDelete(uri(4));
		}
		
		$this->output->set_output(json_encode($data));
	}
	
	public function ajaxCatalogDelete()
	{
		$this->output->set_content_type('application/json');
		
		if($this->input->post()) {
			$data = $this->model->ajaxCatalogDelete(uri(4));
		}
		
		$this->output->set_output(json_encode($data));
	}
	
	/* AJAX ARTICLES */
	
	public function ajaxGetArticles()
	{
		$this->output->set_content_type('application/json');
		
		$data = array('html' => '');
		
		if($this->input->post()) {
			$items = $this->model->ajaxGetArticles(uri(4));
			$data['html'] = $this->load->view('admin/products/ajax_articles', array('items' => $items), true);
		}
		
		$this->output->set_output(json_encode($data));
	}
	
	public function ajaxUpdateArticles()
	{
		$this->output->set_content_type('application/json');
		
		$data = array(
			'error' => true,
			'text' => 'Ошибка данных POST',
			'toggle' => false,
		);
		
		if($this->input->post()) {
			$data = $this->model->ajaxUpdateArticles(uri(4));
		}
		
		$this->output->set_output(json_encode($data));
	}
	
	/* AJAX SIMILARS */
	
	public function ajaxGetSimilarsFull()
	{
		$this->output->set_content_type('application/json');
		
		$data = array('html' => '');
		
		$this->load->model('catalog_model');
		$catalogs = $this->catalog_model->getItemsTree(false, false, 'num|DESC//title|ASC', array());
		
		//var_dump($catalogs); die;
		
		$data['html'] = $this->load->view('admin/products/ajax_similars_window', array('catalogs' => $catalogs['tree']), true);
		
		$this->output->set_output(json_encode($data));
	}
	
	public function ajaxSimilarsProduct()
	{
		$this->output->set_content_type('application/json');
		
		$data = array('html' => '');
		
		$idprod = $this->input->post('product');
		
		$items = $this->model->getItemsByCatalogAdmin(uri(4), $idprod);
		
		$data['html'] = $this->load->view('admin/products/ajax_similars_products', array('items' => $items), true);
		
		$this->output->set_output(json_encode($data));
	}
	
	public function ajaxUpdateSimilars()
	{
		$this->output->set_content_type('application/json');
		
		$data = array(
			'error' => true,
			'text' => 'Ошибка данных POST',
			'toggle' => false,
		);
		
		if($this->input->post()) {
			$data = $this->model->ajaxUpdateSimilars(uri(4));
		}
		
		$this->output->set_output(json_encode($data));
	}
	
	/* AJAX FIELDS */
	
	public function ajaxGetFields()
	{
		$this->output->set_content_type('application/json');
		
		$data = array('html' => '');
		
		$this->load->model('fields_model');
		$fields = $this->fields_model->getTree();
		$type = $this->fields_model->getTypes();
		
		$rel = $this->model->getFields(uri(4));
		
		$data['html'] = $this->load->view('admin/products/ajax_fields_window', array('items' => $fields, 'type' => $type, 'rel' => $rel), true);
		
		$this->output->set_output(json_encode($data));
	}
	
	public function ajaxRefreshField()
	{
		$this->output->set_content_type('application/json');
		
		$data = array('html' => '');
		
		$this->load->model('fields_model');
		$fields = $this->model->getProductFields(uri(4));
		
		$data['html'] = $this->load->view('admin/products/ajax_fields_refresh', array('fields' => $fields), true);
		
		$this->output->set_output(json_encode($data));
	}
	
	public function ajaxUpdateField()
	{
		$this->output->set_content_type('application/json');
		
		$data = array(
			'error' => true,
			'text' => 'Ошибка данных POST',
			'toggle' => false,
		);
		
		if($this->input->post()) {
			$data = $this->model->ajaxUpdateField(uri(4));
		}
		
		$this->output->set_output(json_encode($data));
	}
	
	/* WORK WITH COPY */
	
	public function pcopy()
	{
		$this->init_admin($this->page);
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->model->validate('product_copy'))
		{
			$error = $this->model->pcopy(uri(4));
			if(!$error) redirect('admin/'.uri(2));
		}
		
		$data['item'] = $this->model->getItem(uri(4));
		if(empty($data['item']))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			redirect('admin/'.uri(2));
		}
		
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		$this->breadcrumbs->add($data['item']['title'], uri(2).'/view/'.uri(4));
		$this->breadcrumbs->add('Копировать', '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/product_copy';
		$this->load->view('admin/common/template', $data);
	}
	
	/* WORK WITH IMGS */
	
	public function imgs()
	{
		$this->load->library('upload', $this->model->configPhoto());
		
		$this->init_admin($this->page);
		$data = $this->data;
		
		$error = false;
		if($this->input->post() and $this->model->validate())
		{
			$error = $this->model->update(uri(4));
			if(!$error) redirect('/admin/'.uri(2));
		}
		
		$data['item'] = $this->model->getItem(uri(4));
		if(empty($data['item']))
		{
			set_flash('result', action_result('error', fa('warning mr5').' Запись не найдена!', true));
			redirect('admin/'.uri(2));
		}
		
		$data['imgs'] = $this->model->getImgs(false, false, false, array('idParent' => uri(4)));
		$data['count'] = $this->model->getImgsCount(uri(4));
		
		$this->breadcrumbs->add($data['pageinfo']['name'], uri(2));
		$this->breadcrumbs->add('Дополнительные изображения '.$data['item']['title'], '');
		
		$data['_error'] = $error;
		$data['view'] = uri(2).'/imgs';
		$this->load->view('admin/common/template', $data);
	}
	
	protected $_folder = 'products';
	
	public function upload()
	{	
	
		$size = $this->model->thumbSize();		
		$parent = $this->input->post('idParent');
		if(!$parent)
		{
			$this->session->set_flashdata('result', action_result('error', '<i class="fa fa-fw fa-times"></i> Родительская категория не указана!', true));
			redirect('admin/products');
		}
		
		$config['upload_path'] = './assets/uploads/products/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = 2048;
		$config['encrypt_name'] = true;
		$config['remove_spaces'] = false;
		$congig['overwrite'] = true;
		
		
		$this->load->library('upload');
		
		$errors_status = false;
		$error = '<h4 class="medium">'.fa('warning mr5').' Ошибка загрузки!</h4>';
		
		$this->load->library('SimpleImage');
		
		$files = $_FILES;
		$cpt = count($_FILES['userfile']['name']);
		for($i=0; $i<$cpt; $i++)
		{           
			$_FILES['img']['name'] 		= $files['userfile']['name'][$i];
			$_FILES['img']['type'] 		= $files['userfile']['type'][$i];
			$_FILES['img']['tmp_name']	= $files['userfile']['tmp_name'][$i];
			$_FILES['img']['error']		= $files['userfile']['error'][$i];
			$_FILES['img']['size']		= $files['userfile']['size'][$i];
			
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('img'))
			{
				$errors_status = true;
				$error .= '<div class="mt10"><span class="medium">Ошибка загрузки изображения '.$_FILES['img']['name'].'</span><br/>'.$this->upload->display_errors().'</div>';
			}    
			else
			{
				$img = $this->upload->data();
				$db_err = $this->model->addImg($img, $parent);
				if($db_err) $error .= '<div class="mt10"><span class="medium">Ошибка загрузки изображения '.$_FILES['img']['name'].'</span><br/>'.$db_err.'</div>';
				
				$this->simpleimage->load('assets/uploads/'.$this->_folder.'/'.$img['file_name'])->thumbnail($size['x'], $size['y'])->save('assets/uploads/'.$this->_folder.'/thumb/'.$img['file_name']);
			}
		}
		
		if($errors_status) $this->session->set_flashdata('result', action_result('error', $error, true));
		else $this->session->set_flashdata('result', action_result('success', '<i class="fa fa-fw fa-check"></i> Все фотографии успешно добавлены!', true));
		redirect('admin/'.uri(2).'/imgs/'.$parent);
	}
	
	public function ajaxEdit()
	{
		$this->output->set_content_type('application/json');
		
		$post = $this->input->post();
		
		$data['error'] = false;
		$data['success'] = false;
		
		$error = $this->model->edit_img($post);
		if($error) $data['error'] = $error;
		else $data['success'] = true;
		
		$this->output->set_output(json_encode($data));
		return;
	}
	
	public function ajaxDelete()
	{
		$this->output->set_content_type('application/json');
		
		$post = $this->input->post();
		
		$data['error'] = false;
		$data['success'] = false;
		
		$error = $this->model->delete_img($post);
		if($error) $data['error'] = $error;
		else $data['success'] = true;
		
		$this->output->set_output(json_encode($data));
		return;
	}
	
	
}
