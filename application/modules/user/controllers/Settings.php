<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {

	protected $user_id;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('auth/Authlib');
		$this->authlib->mustLogin();
		$this->load->language('user/user');

		$this->user_id = $this->session->userdata('user_id');
	}

	public function index()
	{
		$user_id = $this->user_id;
		$user = $this->Users_model->get_by_id($user_id)->row_array();
		$email = $user['email'] ?? '';

		$data['url_form'] = site_url('user/settings/');
		$data['form_email'] = $email;
		// ------------------------------------------------------------------------
		$data['page_title'] = lang('Settings');
		view('settings', $data);
	}

	public function ajax_change_email()
	{
		$input_raw = $this->input->raw_input_stream;
		parse_str($input_raw, $input);

		$user_id = $this->user_id;

		$this->form_validation->set_data($input);
		$this->form_validation->set_rules('email_current', lang('current email'), 'trim|required|max_length[255]|valid_email|callback_validate_email_current['.$user_id.']');
		$this->form_validation->set_rules('email_new', lang('new email'), 'trim|required|max_length[255]|valid_email|callback_validate_email_new['.$user_id.']');
		if ($this->form_validation->run() == FALSE) {
			http_response_code(400);
			echo json([
				'message' => lang('Invalid Input'),
				'errors' => $this->form_validation->error_array()
			]);
			die;
		}

		//input
		$email_new = trim($input['email_new']);

		//update email
		$status = $this->Users_model->update_email($user_id, $email_new);
		if ($status) {
			//response
			echo json(['message' => lang('Email Changed Successfully')]);
			die;
		}

		http_response_code(500);
		echo json(['message' => 'Internal Server Error [422]']);
	}

	public function ajax_change_password()
	{
		$input_raw = $this->input->raw_input_stream;
		parse_str($input_raw, $input);

		$user_id = $this->user_id;

		$this->form_validation->set_data($input);
		$this->form_validation->set_rules('password_current', lang('current password'), 'required|callback_validate_password_current['.$user_id.']');
		$this->form_validation->set_rules('password_new', lang('new password'), 'required|min_length[8]');
		$this->form_validation->set_rules('password_new_repeat', lang('repeat new password'), 'required|matches[password_new]');
		if ($this->form_validation->run() == FALSE) {
			http_response_code(400);
			echo json([
				'message' => lang('Invalid Input'),
				'errors' => $this->form_validation->error_array()
			]);
			die;
		}

		//input
		$password_new = $input['password_new'];

		//update password
		$status = $this->Users_model->update_password($user_id, $password_new);
		if ($status) {
			//response
			echo json(['message' => lang('Password Changed Successfully')]);
			die;
		}

		http_response_code(500);
		echo json(['message' => 'Internal Server Error [422]']);
	}



	// CUSTOM FORM VALIDATION
	// ------------------------------------------------------------------------
	public function validate_email_current($value, $user_id)
	{
		if (empty($value)) {
			return TRUE;
		}

		$user = $this->Users_model->get_by_id($user_id)->row_array();
		$user_email = $user['email'] ?? '';
		if ($user_email != $value) {
			$this->form_validation->set_message('validate_email_current', lang('Incorrect current email').'.');
			return FALSE;
		}

		return TRUE;
	}

	public function validate_email_new($value, $user_id)
	{
		if (empty($value)) {
			return TRUE;
		}

		$other = $this->Users_model->get_by_email($value)->row_array();
		$other_id = $other['id'] ?? '';

		//check current email user
		if ($other_id == $user_id) {
			$this->form_validation->set_message('validate_email_new', lang('This is already your current email').'.');
			return FALSE;
		}

		//check other user email
		if ($other) {
			$this->form_validation->set_message('validate_email_new', lang('This email has already been used').'.');
			return FALSE;
		}

		return TRUE;
	}

	public function validate_password_current($value, $user_id)
	{
		if (empty($value)) {
			return TRUE;
		}

		$user = $this->Users_model->get_by_id($user_id)->row_array();
		$password_hash = $user['password'] ?? '';
		if (!password_verify($value, $password_hash)) {
			$this->form_validation->set_message('validate_password_current', lang('Invalid current password').'.');
			return FALSE;
		}

		return TRUE;
	}

}

/* End of file Settings.php */
/* Location: ./application/modules/user/controllers/Settings.php */