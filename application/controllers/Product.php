<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends SITE_Controller {
	
	protected $model = '';
	protected $page = 'catalog';
	
	public function __construct ()
	{
		parent::__construct();
		$this->load->model('products_model');
		$this->model = $this->products_model;
	}
	
	public function index()
	{
		if(!uri(2)) redirect('catalog');
		
		$this->init_site($this->page);
		
		$item = $this->model->getItem(uri(2), true, array('visibility' => 1));
		if(empty($item)) redirect(uri(1));
		$this->data['item'] = $item;
		
		$this->load->model('catalog_model');
		
		$navs_curr = 0;
		$rel = $this->catalog_model->getItemsByProduct($item['idItem'], 1);
		if(!empty($rel)) $navs_curr = $rel[0]['idParent'];
		$tree = $this->catalog_model->getItemsTree(false, false, 'num|DESC', array('visibility' => 1), $navs_curr);
		//$this->data['navs'] = $tree['tree'];
		//$this->data['navs_curr'] = $navs_curr;
		
		/* get extra */
		$this->data['imgs'] = $this->model->getImgs(false, false, false, array('idParent' => $item['idItem']));
		$this->data['mods'] = $this->model->getModifications(array('idParent' => $item['idItem']));
		$this->data['descrs'] = $this->model->getDescriptions(array('idParent' => $item['idItem']));
		$this->data['similars'] = $this->model->getSimilars($item['idItem'], array('shop_products.visibility' => 1));
		$this->data['associated'] = $this->model->getItemsByCatalog($navs_curr, 10, false, 'shop_products.num|RANDOM', array('shop_products.idItem !=' => $item['idItem']));
		$this->data['articles'] = $this->model->getArticles($item['idItem'], array('articles.visibility' => 1));
		
		$this->load->model('mfrs_model');
		$this->data['mfrs'] = $this->mfrs_model->getItem($item['idMfrs']);
		
		$this->load->model('units_model');
		$this->data['p_currency'] = $this->units_model->itemCurrency($item['currency']);
		
		$this->load->model('comments_model');
		$this->data['comments'] = $this->comments_model->getItems(false, false, 'addDate|DESC', array('visibility' => 1, 'idParent' => $item['idItem']));
		
		
		$this->breadcrumbs->add($this->data['pageinfo']['name'], 'catalog');
		foreach($tree['breadcrumbs'] as $br) $this->breadcrumbs->add($br['title'], 'catalog/'.$br['alias']);
		$this->breadcrumbs->add($item['title'], uri(1));
		
		$this->site_seo();
		$this->data['view'] = 'shop/product';
		$this->load->view('site/common/template', $this->data);
	}
}
