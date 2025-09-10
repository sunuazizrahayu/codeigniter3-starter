<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_table_users extends CI_Migration {

	protected $table = 'users';

	public function __construct()
	{
		$this->load->dbforge();
		$this->load->database();
	}

	public function up()
	{
		$fields = [
			'id' => [
				'type' => 'BIGINT',
				'constraint' => 20,
				'unsigned' => TRUE,
				'auto_increment' => TRUE,
				'comment' => 'user_id'
			],
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'unique' => TRUE,
				'null' => FALSE
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => 60,
				'default' => NULL,
				'comment' => 'password hash'
			],
			'password_forgot_code' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
				'default' => NULL
			],
			'activation_code' => [
				'type' => 'VARCHAR',
				'constraint' => 60,
				'default' => NULL,
				'comment' => 'make null when activated'
			],
			'time_activation' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'default' => NULL,
				'comment' => 'not null is activated'
			],
			'time_created' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'null' => FALSE,
				'default' => 0,
			],
			'time_updated' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'null' => FALSE,
				'default' => 0,
			],
			'time_deleted' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'default' => NULL,
			]
		];
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($this->table, true);


		// create dummy users (for development)
		// ------------------------------------------------------------------------
		if (ENVIRONMENT == 'development') {
			$current_time = time();
			$password_hash = '$2y$08$200Z6ZZbp3RAEXoaWcMA6uJOFicwNZaqk4oDhqTUiFXFe63MG.Daa'; //password
			$list_users = [
				'admin@local.host',
				'user@local.host',
			];

			//check exist user
			$insert_users = [];
			foreach ($list_users as $key => $user) {
				if (!$this->db->get_where($this->table, ['email'=>$user])->row()) {
					$insert_users[] = [
						'email' => $user,
						'password' => $password_hash,
						'time_activation' => $current_time,
						'time_created' => $current_time,
						'time_updated' => $current_time,
					];
				}
			}

			//insert all dummy users
			if (!empty($insert_users)) {
				$this->db->insert_batch($this->table, $insert_users);
			}
		}
	}

	public function down()
	{
		$this->dbforge->drop_table($this->table, TRUE);
	}

}

/* End of file 003_create_table_users.php */
/* Location: ./application/migrations/003_create_table_users.php */