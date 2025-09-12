<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthLogoutApi implements Luthier\MiddlewareInterface {

	public function run($args)
	{
		$CI =& get_instance();
		$CI->load->library('auth/Authlib');

		if ($CI->authlib->isLoggedIn()) {
			http_response_code(403);
			echo json(['message' => "You're already logged in!"]);
			die;
		}
	}

}

/* End of file AuthLogoutApi.php */
/* Location: ./application/middleware/AuthLogoutApi.php */