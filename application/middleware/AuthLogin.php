<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthLogin implements Luthier\MiddlewareInterface {

	public function run($args)
	{
		$CI =& get_instance();
		$CI->load->library('auth/Authlib');

		if (!$CI->authlib->isLoggedIn()) {
			redirect('/login');
			die;
		}
	}

}

/* End of file AuthLogin.php */
/* Location: ./application/middleware/AuthLogin.php */