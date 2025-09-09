<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/Slice-Library/')->library('slice');
	}

	public function index()
	{
		$data['page_title'] = 'CodeIgniter 3 Application Starter';
		view('home', $data);
	}

}

/* End of file Home.php */
/* Location: ./application/modules/auth/controllers/Home.php */