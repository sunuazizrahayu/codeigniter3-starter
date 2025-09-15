<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth/Authlib');

		//load session with remember
		if (!$this->authlib->isLoggedIn()) {
			$this->authlib->create_session_by_remember(TRUE);
		}
	}

	public function index()
	{
		$data['page_title'] = 'CodeIgniter 3 Application Starter';
		view('auth/home', $data);
	}

}

/* End of file Home.php */
/* Location: ./application/modules/auth/controllers/Home.php */