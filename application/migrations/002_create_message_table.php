<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_message_table extends CI_Migration {

	protected $table = 'ci_messages';

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
				'comment' => 'message_id'
			],
			'message_method' => [
				'type' => "ENUM('email')"
			],
			'sender_name' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
				'default' => NULL,
			],
			'subject' => [
				'type' => 'VARCHAR',
				'constraint' => 255,
			],
			'message' => [
				'type' => 'TEXT'
			],
			'recipient' => [
				'type' => 'TEXT'
			],
			'delivery_status' => [
				'type' => "ENUM('pending','sent','failed')",
				'null' => FALSE,
				'default' => 'pending'
			],
			'time_delivery' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'null' => FALSE,
				'default' => '0',
				'comment' => 'when the message will deliver (scheduled)'
			],
			'time_sent' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'default' => NULL,
				'comment' => 'when the message sent'
			],
			'time_created' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'null' => FALSE,
				'default' => '0',
			],
			'time_updated' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'null' => TRUE,
				'default' => NULL,
				'comment' => 'null is not updated'
			],
			'time_deleted' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'default' => NULL,
				'comment' => 'null value is active'
			]
		];

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table($this->table, true);
	}

	public function down()
	{
		$this->dbforge->drop_table($this->table, true);
	}

}

/* End of file 002_create_message_table.php */
/* Location: ./application/migrations/002_create_message_table.php */ ?>