<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->input->is_cli_request()) {
			show_error("You don't have permission for this action.");
			return;
		}
		
		$this->load->database();
	}

	public function send($message_id=null)
	{
		$current_time = time();

		// get messages
		// ------------------------------------------------------------------------
		if (!empty($message_id)) {
			$this->db->where('id', $message_id);
		}
		$this->db->where('delivery_status', 'pending');
		$this->db->where('time_delivery <=', $current_time);
		$this->db->where('time_deleted', NULL);
		$messages = $this->db->get('ci_messages')->result_array();

		// send message
		// ------------------------------------------------------------------------
		foreach ($messages as $key => $data) {
			$message_method = $data['method'] ?? '';
			switch ($message_method) {
				case 'email':
					$message = (object) $data;
					$this->_send_email($message);
					break;
				
				default:
					// code...
					break;
			}
		}
	}

	private function _send_email($message)
	{
		$message_id = $message->id;
		$sender_name = $message->sender_name ?? '';
		$subject = $message->subject;
		$to = $message->recipient;
		$message = $message->message;
		$message_status = ['delivery_status' => 'failed'];

		// ------------------------------------------------------------------------
		$CI = get_instance();
		try {
			$CI->load->library('email');
			$CI->email->from(getenv('MAIL_USER'), $sender_name);
			$CI->email->to($to);
			$CI->email->subject($subject);
			$CI->email->message($message);
			$result = $CI->email->send();
			if ($result === TRUE) {
				$message_status = [
					'delivery_status' => 'sent',
					'time_sent' => time(),
				];
			}else{
				$response = $this->email->print_debugger(array('headers'));
				$CI->db->update('ci_messages', ['response'=>$response], ['id'=>$message_id]);
			}
		} catch (Exception $e) {
			// $CI->db->update('ci_messages', ['delivery_status'=>'failed'], ['id'=>$message_id]);
			$CI->db->update('ci_messages', ['response'=>$e], ['id'=>$message_id]);
		}
		$CI->db->update('ci_messages', $message_status, ['id'=>$message_id]);
	}

}

/* End of file Message.php */
/* Location: ./application/modules/cmd/controllers/Message.php */