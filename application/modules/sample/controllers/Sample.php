<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sample extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		$this->load->view('sample');
	}

}

/* End of file Sample.php */
/* Location: ./application/modules/sample/controllers/Sample.php */ ?>