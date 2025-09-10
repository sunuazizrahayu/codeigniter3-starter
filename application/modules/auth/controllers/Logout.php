<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth/Authlib');
	}

	public function index()
	{
		//destory session
		$this->session->sess_destroy();

		//remove remember me
		$this->authlib->remove_remember();

		echo 'Logout Success';
		redirect('/','refresh');
	}

}

/* End of file Logout.php */
/* Location: ./application/modules/auth/controllers/Logout.php */