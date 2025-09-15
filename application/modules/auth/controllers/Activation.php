<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activation extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth/Authlib');
		$this->authlib->mustLogout();
	}

	// RESEND ACTIVATION LINK
	// ------------------------------------------------------------------------
	public function resend()
	{
		$data['url_form'] = site_url('auth/activation/resend_process_ajax');
		$data['page_title'] = lang('Resend Activation');
		view('auth/activation_resend', $data);
	}

	public function resend_process_ajax()
	{
		$input_raw = $this->input->raw_input_stream;
		parse_str($input_raw, $input);

		$this->form_validation->set_data($input);
		$this->form_validation->set_rules('email', lang('email'), 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			http_response_code(400);
			echo json([
				'message' => lang('Invalid Input'),
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
			echo json(['message' => lang('Account Not Found')]);
			die;
		}

		//user data
		$user_id = $user['id'];
		$user_is_active = ($user['time_activation'] === NULL) ? FALSE : TRUE;

		//check user is activated
		if ($user_is_active) {
			http_response_code(403);
			echo json(['message' => lang('Account Already Active')]);
			die;
		}

		//generate activation code
		$code_generated = $this->authlib->generate_activation_code($user_id);
		$code_hash = $code_generated['hash'] ?? '';
		$code = $code_generated['code'] ?? '';

		//save activation code
		$this->Users_model->save_user_activation_code($user_id, $code_hash);

		$complete = $this->db->trans_complete();
		if ($complete) {
			//send activation link
			$this->authlib->send_activation_link($email, $user_id, $code);

			//response
			http_response_code(201);
			echo json(['message' => lang('New Activation Link Sent to Your Email')]);
			die;
		}

		http_response_code(500);
		echo json(['message' => 'Internal Server Error [422]']);
	}


	// ACTIVATION
	// ------------------------------------------------------------------------
	public function activate($user_id=null, $code_key=null)
	{
		//get user
		$user = $this->Users_model->get_by_id($user_id, TRUE)->row_array();
		if (!$user) {
			print_log('Account Activation Page :: user_id='.$user_id.' | code_key='.$code_key.' -> user not found');
			show_404();
		}

		//user data
		$user_id = $user['id'];
		$user_is_active = ($user['time_activation'] === NULL) ? FALSE : TRUE;
		$user_activation_code_hash = $user['activation_code'];

		//check user is activated
		if ($user_is_active) {
			print_log('Account Activation Page :: user_id='.$user_id.' | code_key='.$code_key.' -> user activated');
			show_404();
		}

		//validate activation code
		$valid = password_verify($code_key, $user_activation_code_hash);
		if (!$valid) {
			$log_codekey_verify = json_encode(['code'=>$code_key, 'hash'=>$user_activation_code_hash]);
			print_log('Account Activation Page :: user_id='.$user_id.' | code_key='.$code_key.' -> code key invalid ['.$log_codekey_verify.']');
			show_404();
		}
		// ------------------------------------------------------------------------
		$data['user_id'] = $user_id;
		$data['code_key'] = $code_key;
		$data['url_login'] = site_url('login');
		// ------------------------------------------------------------------------
		$data['url_form'] = site_url('auth/activation/activate_process_ajax');
		$data['page_title'] = lang('Account Activation');
		view('auth/activation', $data);
	}

	public function activate_process_ajax()
	{
		$input_raw = $this->input->raw_input_stream;
		parse_str($input_raw, $input);

		$this->form_validation->set_data($input);
		$this->form_validation->set_rules('user_id', 'user_id', 'trim|required');
		$this->form_validation->set_rules('code', 'code', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			http_response_code(400);
			echo json([
				'message' => lang('Invalid Input'),
				'errors' => $this->form_validation->error_array(),
			]);
			die;
		}

		//input
		$user_id = trim($input['user_id']);
		$code_key = trim($input['code']);


		$this->db->trans_start();
		//get user
		$user = $this->Users_model->get_by_id($user_id, TRUE)->row_array();
		if (!$user) {
			print_log('Account Activation Process :: user_id='.$user_id.' | code_key='.$code_key.' -> user not found');

			http_response_code(404);
			echo json(['message' => lang('Account Not Found')]);
			die;
		}

		//user data
		$user_id = $user['id'];
		$user_email = $user['email'];
		$user_is_active = ($user['time_activation'] === NULL) ? FALSE : TRUE;
		$user_activation_code_hash = $user['activation_code'];

		//check user is activated
		if ($user_is_active) {
			print_log('Account Activation Process :: user_id='.$user_id.' | code_key='.$code_key.' -> user activated');

			http_response_code(403);
			echo json(['message' => lang('Account Already Active')]);
			die;
		}

		//validate activation code
		$valid = password_verify($code_key, $user_activation_code_hash);
		if (!$valid) {
			$log_codekey_verify = json_encode(['code'=>$code_key, 'hash'=>$user_activation_code_hash]);
			print_log('Account Activation Process :: user_id='.$user_id.' | code_key='.$code_key.' -> code key invalid ['.$log_codekey_verify.']');

			http_response_code(401);
			echo json(['message' => lang('Invalid Activation Code')]);
			die;
		}

		//activate user
		$activation_status = $this->Users_model->activate_user($user_id);

		$complete = $this->db->trans_complete();
		if ($complete) {
			//send activation notif
			if ($activation_status) {
				$this->authlib->send_activation_success($user_email);
			}

			//response
			echo json(['message' => lang('Activation Successful')]);
			die;
		}

		http_response_code(500);
		echo json(['message' => 'Internal Server Error [422]']);
	}

}

/* End of file Activation.php */
/* Location: ./application/modules/auth/controllers/Activation.php */