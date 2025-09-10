<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

	protected $table = 'users';

	public function get_by_id($user_id, $active=FALSE)
	{
		$this->db->where('id', $user_id);
		if ($active) {
			$this->db->where('time_deleted', NULL);
		}
		return $this->db->get($this->table);
	}

	public function get_by_email($user_email, $active=FALSE)
	{
		$this->db->where('email', $user_email);
		if ($active) {
			$this->db->where('time_deleted', NULL);
		}
		return $this->db->get($this->table);
	}


	// ------------------------------------------------------------------------
	public function create_user($email, $password=NULL)
	{
		$current_time = time();
		$password_hash = NULL;
		if (!empty($password)) {
			$password_hash = $this->generate_password_hash($password);
		}

		$object = [
			'email' => $email,
			'password' => $password_hash,
			'time_created' => $current_time,
			'time_updated' => $current_time,
		];
		$this->db->insert($this->table, $object);
		$user_id = $this->db->insert_id();
		return $user_id;
	}

	public function update_password($user_id, $password)
	{
		$current_time = time();
		$password_hash = $this->generate_password_hash($password);

		$object = [
			'password' => $password_hash,
			'password_forgot_code' => NULL,
			'time_updated' => $current_time,
		];
		return $this->db->update($this->table, $object, ['id' => $user_id]);
	}

	public function save_user_activation_code($user_id, $code_hash)
	{
		$object = [
			'activation_code' => $code_hash,
		];
		$this->db->where('id', $user_id);
		return $this->db->update($this->table, $object);
	}


	// ------------------------------------------------------------------------
	public function generate_reset_password($user_id, $expire_in_second=1800)
	{
		$current_time = time();
		$time_expired = $current_time + $expire_in_second;
		$payload = array(
			'time_generated' => $current_time,
			'time_expired' => $time_expired,
			'user_id' => $user_id,
			'code' => $this->generate_password_hash($current_time . $user_id),
		);
		$code = md5(json_encode($payload));
		$code_hash = $this->generate_password_hash($code . $time_expired);
		$code_hash = $time_expired.'_'.$code_hash;

		//save data
		$object = [
			'password_forgot_code' => $code_hash,
		];
		$this->db->update($this->table, $object, ['id'=>$user_id]);

		return $code;
	}

	private function generate_password_hash($password)
	{
		$options = [
			'cost' => 12,
		];
		$password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
		return $password_hash;
	}

}

/* End of file Users_model.php */
/* Location: ./application/modules/auth/models/Users_model.php */