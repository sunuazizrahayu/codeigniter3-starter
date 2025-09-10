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

}

/* End of file Users_model.php */
/* Location: ./application/modules/auth/models/Users_model.php */