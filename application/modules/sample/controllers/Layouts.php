<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layouts extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/Slice-Library/')->library('slice');
	}

	public function index()
	{
		$data['page_title'] = 'My Page Sample';
		view('layouts/raw/content', $data);
	}

}

/* End of file Layouts.php */
/* Location: ./application/modules/sample/controllers/Layouts.php */