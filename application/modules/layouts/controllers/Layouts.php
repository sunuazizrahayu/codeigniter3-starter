<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layouts extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth/Authlib');

		//load session with remember
		if (!$this->authlib->isLoggedIn()) {
			$this->authlib->create_session_by_remember(TRUE);
		}
	}

	public function page404()
	{
		$data['page_title'] = '404 Page Not Found';
		view('layouts/404', $data);
	}

}

/* End of file Layouts.php */
/* Location: ./application/modules/layouts/controllers/Layouts.php */