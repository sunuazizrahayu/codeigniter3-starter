<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authlib
{
	protected $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->add_package_path(APPPATH.'third_party/Slice-Library/')->helper('language')->library('slice'); //blade engine
		$this->ci->load->database();
		$this->ci->load->library(['session','form_validation']);
		$this->ci->load->helper(['url','cookie','json','message','log']);
		$this->ci->load->model('auth/Users_model');
		$this->ci->load->language('auth/auth');
	}

	// SESSION
	// ------------------------------------------------------------------------
	public function isLoggedIn()
	{
		if ($this->ci->session->userdata('logged_in')) {
			return TRUE;
		}

		return FALSE;
	}

	public function create_session($user_id)
	{
		$CI = $this->ci;
		$user = $CI->Users_model->get_by_id($user_id)->row();
		if ($user) {
			$object = array(
				'logged_in' => TRUE,
				'user_id' => $user->id,
			);
			$CI->session->set_userdata( $object );
		}
	}

	public function create_session_by_remember($force=FALSE)
	{
		$CI = $this->ci;
		$logged_in = $this->isLoggedIn();
		if (!$logged_in || $force == TRUE) {
			$current_time = time();
			$session_key = $CI->config->item('sess_cookie_name');
			$cookie_name = $session_key.'_remember';
			$remember_id = $CI->input->cookie($cookie_name);
			if ($remember_id) {
				//check remember me data exist
				$CI->db->where('id', $remember_id.'.remember');
				$CI->db->where('timestamp >=', $current_time);
				$remember = $CI->db->get('ci_sessions')->row_array();
				if (!$remember) {
					return;
				}

				//get remember data
				$remember_data = json_decode($remember['data'], TRUE);
				$hash = $remember_data['hash'] ?? '';
				$data = $remember_data['data'] ?? '';
				$data = base64_decode($data);
				$payload = json_decode($data, TRUE) ?? [];
				$data = $payload['data'] ?? [];


				//validate remember id and remember hash
				if (!password_verify($remember_id, $hash)) {
					return;
				}

				//create session
				$user_id = $data['user_id'] ?? '';
				$this->create_session($user_id);

				//remove old remember me data
				$this->remove_remember();

				//create new remember
				$this->create_remember($user_id);
			}
		}
	}


	// REMEMBER
	// ------------------------------------------------------------------------
	/* create remember me: default value is 24 hours */
	public function create_remember($user_id, $expire_in_minutes=(60*24))
	{
		$CI = $this->ci;
		$current_time = time();
		$expire_in_second = 60 * $expire_in_minutes;
		$time_expired = $current_time + $expire_in_second;

		$session_key = $CI->config->item('sess_cookie_name');
		$cookie_name = $session_key.'_remember';

		$token_data = [
			'data' => [
				'user_id' => $user_id,
			],
			'session_id' => $session_key,
			'iat' => $current_time,
			'nbf' => $current_time,
			'exp' => $time_expired,
		];
		$token_data_json = json_encode($token_data);
		$remember_id = md5($token_data_json);
		$remember_hash = password_hash($remember_id, PASSWORD_DEFAULT);

		//save to db
		$object = [
			'id' => $remember_id.'.remember',
			'ip_address' => $CI->input->ip_address(),
			'timestamp' => $time_expired,
			'data' => json_encode([
				'data' => base64_encode($token_data_json),
				'hash' => $remember_hash,
			]),
		];
		$CI->db->insert('ci_sessions', $object);

		//set cookie
		$CI->input->set_cookie($cookie_name, $remember_id, $expire_in_second, null, '/', NULL, is_https(), TRUE);
	}

	public function remove_remember($remember_id=NULL)
	{
		$CI = $this->ci;

		$session_key = $CI->config->item('sess_cookie_name');
		$cookie_name = $session_key.'_remember';
		if ($remember_id === NULL) {
			$remember_id = $CI->input->cookie($cookie_name);
		}

		//delete remember on database
		if ($remember_id) {
			$CI->db->delete('ci_sessions', ['id'=>$remember_id.'.remember']);
		}

		//delete remember cookie
		delete_cookie($cookie_name);
	}


	// MIDDLEWARE
	// ------------------------------------------------------------------------
	public function mustLogin()
	{
		$CI = $this->ci;

		//create session by remember
		$this->create_session_by_remember();

		//check logged in
		if (!$this->isLoggedIn()) {
			if ($CI->input->is_ajax_request()) {
				http_response_code(403);
				echo json(['message' => lang("You're not logged in")]);
			}else{
				redirect('/');
			}
			die;
		}
	}

	public function mustLogout()
	{
		$CI = $this->ci;

		//create session by remember
		$this->create_session_by_remember();

		//check logged in
		if ($this->isLoggedIn()) {
			if ($CI->input->is_ajax_request()) {
				http_response_code(403);
				echo json(['message' => lang("You're logged in")]);
			}else{
				redirect('/');
			}
			die;
		}
	}


	// FUNCTION
	// ------------------------------------------------------------------------
	# register
	public function generate_activation_code($user_id)
	{
		$payload = [
			'uid' => $user_id,
			'time' => time(),
			'random' => base64_encode(openssl_random_pseudo_bytes(30)),
		];
		$data = json_encode($payload);
		$code = password_hash($data, PASSWORD_BCRYPT);
		$code = md5($code);
		$code_hash = password_hash($code, PASSWORD_BCRYPT);
		$result = [
			'code' => $code,
			'hash' => $code_hash,
		];
		return $result;
	}

	public function send_activation_link($email, $user_id, $code)
	{
		$CI = $this->ci;
		$lang_code = $CI->config->item('language_abbr');

		$link = site_url('auth/activation/activate/'.$user_id.'/'.$code);

		$message = $CI->load->view('auth/email/'.$lang_code.'/activation', [], TRUE);
		$message = str_replace('[url_activation]', $link, $message);
		return send_email($email, lang('Account Activation'), $message);
	}


	# activation
	public function send_activation_success($email)
	{
		$CI = $this->ci;
		$lang_code = $CI->config->item('language_abbr');

		$message = $CI->load->view('auth/email/'.$lang_code.'/activation_success', [], TRUE);
		return send_email($email, lang('Account Activation Successful'), $message);
	}


	# forgot password
	public function send_reset_password_link($email, $user_id, $code)
	{
		$CI = $this->ci;
		$lang_code = $CI->config->item('language_abbr');

		$link = site_url('auth/forgot/recovery/'.$user_id.'/'.$code);

		$message = $CI->load->view('auth/email/'.$lang_code.'/forgot_password', [], TRUE);
		$message = str_replace('[link_reset]', $link, $message);
		return send_email($email, lang('Reset Password'), $message);
	}

	public function send_reset_password_success($email)
	{
		$CI = $this->ci;
		$lang_code = $CI->config->item('language_abbr');

		$message = $CI->load->view('auth/email/'.$lang_code.'/forgot_password_success', [], TRUE);
		return send_email($email, lang('Password Reset Successful'), $message);
	}

}

/* End of file Authlib.php */
/* Location: ./application/modules/auth/libraries/Authlib.php */
