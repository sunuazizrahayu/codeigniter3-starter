<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('send_email')) {
	function send_email($to, $subject, $message)
	{
		$CI = get_instance();
		$CI->load->database();

		$current_time = time();
		$sender_name = getenv('MAIL_SENDER_NAME');
		if (empty($sender_name)) {
			$sender_name = NULL;
		}

		// save message on DB
		// ------------------------------------------------------------------------
		$CI->db->insert('ci_messages', [
			'method' => 'email',
			'sender_name' => $sender_name,
			'subject' => $subject,
			'message' => $message,
			'recipient' => $to,
			'time_delivery' => $current_time,
			'time_created' => $current_time
		]);
		$message_id = $CI->db->insert_id();
		

		// send on background
		// ------------------------------------------------------------------------
		if (function_exists('shell_exec')) {
			$command = "php ".FCPATH."index.php cmd/message/send/".$message_id;
			shell_exec($command . " > /dev/null 2>/dev/null &");
			return $message_id;
		}

		// send now
		// ------------------------------------------------------------------------
		$current_time = time();
		try {
			if (empty($sender_name)) {
				$sender_name = '';
			}

			$CI->load->library('email');
			$CI->email->from(getenv('MAIL_USER'), $sender_name);
			$CI->email->to($to);
			$CI->email->subject($subject);
			$CI->email->message($message);
			$result = $CI->email->send();
			if ($result === TRUE) {
				$CI->db->where('id', $message_id);
				$CI->db->update('ci_messages', ['delivery_status'=>'sent','time_sent'=>$current_time]);
			}else{
				$CI->db->update('ci_messages', ['delivery_status'=>'failed'], ['id'=>$message_id]);
			}
		} catch (Exception $e) {
			$CI->db->update('ci_messages', ['delivery_status'=>'failed', 'response'=>$e], ['id'=>$message_id]);
		}

		return $message_id;
	}
}

/* End of file message_helper.php */
/* Location: ./application/helpers/message_helper.php */