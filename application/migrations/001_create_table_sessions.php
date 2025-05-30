<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_table_sessions extends CI_Migration {

	protected string $table = 'ci_sessions';
	protected string $db_driver;

	public function __construct()
	{
		$this->load->dbforge();
		$this->load->database();

		$this->db_driver = $this->db->dbdriver;
	}

	public function up()
	{
		$fields = [
			'id' => [
				'type' => 'VARCHAR',
				'constraint' => 128,
			],
			'ip_address' => [
				'type' => 'VARCHAR',
				'constraint' => 45,
			],
			'timestamp' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned' => TRUE,
				'default' => 0
			],
			'data' => [
				'type' => 'BLOB',
			]
		];

		//override for postgre
		if ($this->db_driver == 'postgre') {
			$fields['data'] = [
				'type' => 'text',
				'default' => '',
			];
		}

		//add key
		if ($this->config->item('sess_match_ip') === TRUE) {
			$this->dbforge->add_key(['id','ip_address'], true);
		}
		else {
			$this->dbforge->add_key('timestamp');
			$this->dbforge->add_key('id', true);
		}

		//execute for create table
		$this->dbforge->add_field($fields);
		$this->dbforge->create_table($this->table, true);
	}

	public function down()
	{
		$this->dbforge->drop_table($this->table, TRUE);
	}

}

/* End of file 001_create_table_sessions.php */
/* Location: ./application/migrations/001_create_table_sessions.php */