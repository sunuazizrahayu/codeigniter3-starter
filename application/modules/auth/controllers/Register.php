<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth/Authlib');
		$this->authlib->mustLogout();
	}

	public function index()
	{
		$data['url_terms'] = 'javascript:void(0)';
		// ------------------------------------------------------------------------
		$data['url_form'] = site_url('auth/register/process_ajax');
		$data['page_title'] = 'Register';
		view('auth/register', $data);
	}

	public function process_ajax()
	{
		$input_raw = $this->input->raw_input_stream;
		parse_str($input_raw, $input);

		$this->form_validation->set_data($input);
		$this->form_validation->set_rules('email', 'email', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'required|min_length[8]');
		$this->form_validation->set_rules('password_retype', 'retype password', 'required|matches[password]');
		$this->form_validation->set_rules('terms', 'terms', 'trim|required', [
			'required' => 'You must agree with our terms.'
		]);
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
		$password = $input['password'];


		$this->db->trans_start();
		//get user
		$user = $this->Users_model->get_by_email($email)->row_array();
		if ($user) {
			http_response_code(403);
			echo json(['message' => 'An Account with This Email Already Exists']);
			die;
		}

		//create user
		$user_id = $this->Users_model->create_user($email, $password);

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
			echo json(['message' => "We've Sent You an Email to Activate Your Account"]);
			die;
		}

		http_response_code(500);
		echo json(['message' => 'Internal Server Error [422]']);
	}

}

/* End of file Register.php */
/* Location: ./application/modules/auth/controllers/Register.php */