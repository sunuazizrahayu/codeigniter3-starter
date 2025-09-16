<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthLogout implements Luthier\MiddlewareInterface {

	public function run($args)
	{
		$CI =& get_instance();
		$CI->load->library('auth/Authlib');

		if ($CI->authlib->isLoggedIn()) {
			redirect('/');
			die;
		}
	}

}

/* End of file AuthLogout.php */
/* Location: ./application/middleware/AuthLogout.php */