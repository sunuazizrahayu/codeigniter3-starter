<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth/Authlib');
		$this->authlib->mustLogout();
	}

	public function index()
	{
		$data['url_forgot_password'] = site_url('forgot');
		$data['url_register'] = site_url('register');
		// ------------------------------------------------------------------------
		$data['url_form'] = site_url('auth/login/process_ajax');
		$data['page_title'] = 'Login';
		view('auth/login', $data);
	}

	public function process_ajax()
	{
		$input_raw = $this->input->raw_input_stream;
		parse_str($input_raw, $input);

		$this->form_validation->set_data($input);
		$this->form_validation->set_rules('email', 'email', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'required');
		$this->form_validation->set_rules('remember', 'remember', 'trim');
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
		$remember = filter_var(@$input['remember'], FILTER_VALIDATE_BOOLEAN);


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

		//validate user password
		if (!password_verify($password, $user_password_hash)) {
			http_response_code(401);
			echo json(['message' => 'Incorrect Password']);
			die;
		}

		//check user is activated
		if (!$user_is_active) {
			http_response_code(403);
			echo json(['message' => 'Account Not Activated']);
			die;
		}

		//create session
		$this->authlib->create_session($user_id);

		//create remember me
		if ($remember) {
			$this->authlib->create_remember($user_id);
		}

		//response
		echo json(['message' => 'Login Successful']);
	}

}

/* End of file Login.php */
/* Location: ./application/modules/auth/controllers/Login.php */