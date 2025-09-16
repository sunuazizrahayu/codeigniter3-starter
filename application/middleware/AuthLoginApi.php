<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthLoginApi implements Luthier\MiddlewareInterface {

	public function run($args)
	{
		$CI =& get_instance();
		$CI->load->library('auth/Authlib');

		if (!$CI->authlib->isLoggedIn()) {
			http_response_code(401);
			echo json(['message' => lang("You're not logged in")."!"]);
			die;
		}
	}

}

/* End of file AuthLoginApi.php */
/* Location: ./application/middleware/AuthLoginApi.php */