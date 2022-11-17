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
		$this->db->trans_start();

		//get message
		$this->db->where('id', $message_id);
		$this->db->where('message_method', 'email');
		$this->db->where('delivery_status', 'pending');
		$this->db->where('time_delivery <=', time());
		$message = $this->db->get('ci_messages')->row();

		if (!$message) {
			echo "Message not found";
			return;
		}

		switch ($message->message_method) {
			case 'email':
				$this->_send_email($message);
				break;
			
			default:
				// code...
				break;
		}
		$this->db->trans_complete();
	}

	private function _send_email($message)
	{
		$message_id = $message->id;
		$sender_name = $message->sender_name;
		$subject = $message->subject;
		$to = $message->recipient;
		$message = $message->message;

		// ------------------------------------------------------------------------
		$CI = get_instance();
		try {
			$CI->load->library('email');
			
			if (empty($sender_name)) {
				$CI->email->from(getenv('MAIL_USER'));
			}else{
				$CI->email->from(getenv('MAIL_USER'), $sender_name);
			}
			$CI->email->to($to);

			
			$CI->email->subject($subject);
			$CI->email->message($message);
			
			$result = $CI->email->send();
			if ($result === TRUE) {
				$CI->db->update('ci_messages', ['delivery_status'=>'sent','time_sent'=>time()], ['id'=>$message_id]);
			}else{
				$CI->db->update('ci_messages', ['delivery_status'=>'failed'], ['id'=>$message_id]);
			}
		} catch (Exception $e) {
			$CI->db->update('ci_messages', ['delivery_status'=>'failed'], ['id'=>$message_id]);
		}
		// ------------------------------------------------------------------------
	}

}

/* End of file Message.php */
/* Location: ./application/modules/cmd/controllers/Message.php */