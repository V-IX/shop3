<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Files extends ADMIN_Controller {
	
	function __construct ()
	{	
		parent::__construct();
	}
	
	public function index()
	{
		$this->init_admin('files');
		$data = $this->data;
		
		$data['view'] = 'common/files';
		$this->load->view('admin/common/template', $data);
	}
	
	public function elfinder_init()
	{
		$this->load->helper('path');
	  
		$opts = array(
			// 'debug' => true, 
			'roots' => array(
				array( 
					'driver' => 'LocalFileSystem', 
					'path'   => set_realpath(FCPATH . '/assets/uploads/files/'), 
					'URL'    => site_url('/assets/uploads/files/'),
					'acceptedName' => '/^[A-Za-z0-9_][A-Za-z0-9_\s\.\%\-]*$/u',//without cyrillic
					'accessControl' => 'access',
					'attributes' => array(
						array(
							'pattern' => '/\.tmb$/',
							'hidden' => true,
						)
					),
					#'uploadAllow' => array('image/png','image/jpeg','image/gif','image/bmp','application/pdf'),
					#'uploadDeny'  => array('all'),
					#'uploadOrder'=> 'deny, allow',
					'uploadAllow' => array('all'),
					#'uploadDeny'  => array('all'),
					'uploadOrder'=> 'deny, allow',
				)
			),
			
		);
		$this->load->library('ElfinderLib', $opts);
	}
}
