<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth/Authlib');
		$this->authlib->mustLogout();
	}

	// FORGOT PASSWORD
	// ------------------------------------------------------------------------
	public function index()
	{
		$data['url_form'] = site_url('auth/forgot/forgot_process_ajax');
		$data['page_title'] = 'Forgot Password';
		view('auth/forgot_password', $data);
	}

	public function forgot_process_ajax()
	{
		$input_raw = $this->input->raw_input_stream;
		parse_str($input_raw, $input);

		$this->form_validation->set_data($input);
		$this->form_validation->set_rules('email', 'email', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			http_response_code(400);
			echo json([
				'message' => 'Invalid Input',
				'errors' => $this->form_validation->error_array(),
			]);
			die;
		}

		//input
		$email = trim($input['email']);


		$this->db->trans_start();
		//get user
		$user = $this->Users_model->get_by_email($email, TRUE)->row_array();
		if (!$user) {
			http_response_code(404);
			echo json(['message' => 'Account Not Found']);
			die;
		}

		//user data
		$user_id = $user['id'];
		$user_password_hash = $user['password'];
		$user_is_active = ($user['time_activation'] === NULL) ? FALSE : TRUE;

		//check user is activated
		if (!$user_is_active) {
			http_response_code(403);
			echo json(['message' => 'Account Not Activated']);
			die;
		}

		//generate forgot code
		$forgot_code = $this->Users_model->generate_reset_password($user_id);

		$complete = $this->db->trans_complete();
		if ($complete) {
			//send recovery link
			$this->authlib->send_reset_password_link($email, $user_id, $forgot_code);

			//response
			echo json(['message' => "We've sent you a link to reset your password"]);
			die;
		}

		http_response_code(500);
		echo json(['message' => 'Internal Server Error [422]']);
	}


	// PASSWORD RECOVERY
	// ------------------------------------------------------------------------
	public function recovery($user_id=null, $code_key=null)
	{
		//get user
		$user = $this->Users_model->get_by_id($user_id, TRUE)->row_array();
		if (!$user) {
			print_log('Recovery Password :: user_id='.$user_id.' | code_key='.$code_key.' -> user not found');
			show_404();
		}

		//user data
		$user_id = $user['id'];
		$user_is_active = ($user['time_activation'] === NULL) ? FALSE : TRUE;

		//check user is activated
		if (!$user_is_active) {
			print_log('Recovery Password :: user_id='.$user_id.' | code_key='.$code_key.' -> user not activated');
			show_404();
		}


		//validate forgot code
		// ------------------------------------------------------------------------
		$user_forgot = $user['password_forgot_code'] ?? '';
		$user_forgot_hash = preg_replace('/^[0-9]*_/i', '', $user_forgot);
		$user_forgot_time_expired = preg_replace('/\_.*/','',$user_forgot);

		//check expire
		$current_time = time();
		if ($current_time > $user_forgot_time_expired) {
			print_log('Recovery Password :: user_id='.$user_id.' | code_key='.$code_key.' -> reset password expired ['.$user_forgot.']');
			show_404();
		}

		//check token
		$token = $code_key.$user_forgot_time_expired;
		$valid = password_verify($token, $user_forgot_hash);
		if (!$valid) {
			$log_codekey_verify = json_encode(['token'=>$token, 'hash'=>$user_forgot_hash]);
			print_log('Recovery Password :: user_id='.$user_id.' | code_key='.$code_key.' -> code key invalid ['.$log_codekey_verify.']');
			show_404();
		}
		// ------------------------------------------------------------------------
		$data['user_id'] = $user_id;
		$data['code_key'] = $code_key;
		$data['url_login'] = site_url('login');
		// ------------------------------------------------------------------------
		$data['url_form'] = site_url('auth/forgot/recovery_process_ajax');
		$data['page_title'] = 'Password Recovery';
		view('auth/forgot_password_recovery', $data);
	}

	public function recovery_process_ajax()
	{
		$input_raw = $this->input->raw_input_stream;
		parse_str($input_raw, $input);

		$this->form_validation->set_data($input);
		$this->form_validation->set_rules('user_id', 'user id', 'trim|required');
		$this->form_validation->set_rules('code', 'reset password code', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'required|min_length[8]');
		$this->form_validation->set_rules('password_retype', 'retype password', 'required|matches[password]');
		if ($this->form_validation->run() == FALSE) {
			http_response_code(400);
			echo json([
				'message' => 'Invalid Input',
				'errors' => $this->form_validation->error_array(),
			]);
			die;
		}

		//input
		$user_id = trim($input['user_id']);
		$code_key = trim($input['code']);
		$password = $input['password'];


		$this->db->trans_start();
		//get user
		$user = $this->Users_model->get_by_id($user_id, TRUE)->row_array();
		if (!$user) {
			http_response_code(404);
			echo json(['message' => 'Account Not Found']);
			die;
		}

		//user data
		$user_id = $user['id'];
		$user_email = $user['email'];
		$user_is_active = ($user['time_activation'] === NULL) ? FALSE : TRUE;

		//check user is activated
		if (!$user_is_active) {
			http_response_code(403);
			echo json(['message' => 'Account Not Activated']);
			die;
		}


		//validate forgot code
		// ------------------------------------------------------------------------
		$user_forgot = $user['password_forgot_code'] ?? '';
		$user_forgot_hash = preg_replace('/^[0-9]*_/i', '', $user_forgot);
		$user_forgot_time_expired = preg_replace('/\_.*/','',$user_forgot);

		//check expire
		$current_time = time();
		if ($current_time > $user_forgot_time_expired) {
			http_response_code(410);
			echo json(['message' => 'Reset Password Expired']);
			die;
		}

		//check token
		$token = $code_key.$user_forgot_time_expired;
		$valid = password_verify($token, $user_forgot_hash);
		if (!$valid) {
			http_response_code(401);
			echo json(['message' => 'Invalid Reset Password Token']);
			die;
		}
		// ------------------------------------------------------------------------

		//update password
		$this->Users_model->update_password($user_id, $password);

		$complete = $this->db->trans_complete();
		if ($complete) {
			//send notif reset password success
			$this->authlib->send_reset_password_success($user_email);

			//response
			echo json(['message' => 'Password Reset Successful']);
			die;
		}

		http_response_code(500);
		echo json(['message' => 'Internal Server Error [422]']);
	}

}

/* End of file Forgot.php */
/* Location: ./application/modules/auth/controllers/Forgot.php */