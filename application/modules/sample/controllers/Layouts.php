<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layouts extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		$path = rtrim(APPPATH.'modules/layouts/views/themes/*');
		$dirs = glob($path);
		foreach (glob($path) as $dir) {
			$dir = basename($dir);
			echo '<a href="'.current_url().'/theme/'.$dir.'">'.$dir.'</a>';
			echo '<br>';
		}
	}

	public function theme($theme='')
	{
		$data['page_title'] = 'Sample Layouts with '.$theme;
		view('layouts/themes/'.$theme.'/sample/sample', $data);
	}

}

/* End of file Layouts.php */
/* Location: ./application/modules/sample/controllers/Layouts.php */ ?>