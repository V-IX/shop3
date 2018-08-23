<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cap extends SITE_Controller {

	public function index()
	{
		$this->init_site('home');
		
		$this->site_seo();
		$this->load->view('site/common/cap', $this->data);
	}
}
