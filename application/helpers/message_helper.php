<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('send_email')) {
	function send_email($to, $subject, $message)
	{
		$current_time = time();

		$sender_name = getenv('MAIL_SENDER_NAME');
		if ($sender_name === FALSE) {
			$sender_name = NULL;
		}

		$CI = get_instance();
		$CI->load->database();
		$CI->db->trans_start();
		$CI->db->insert('ci_messages', [
			'message_method' => 'email',
			'sender_name' => $sender_name,
			'subject' => $subject,
			'message' => $message,
			'recipient' => $to,
			'time_created' => $current_time
		]);
		$message_id = $CI->db->insert_id();
		
		if (function_exists('shell_exec')) {
			$command = "php ".FCPATH."index.php cmd/message/send/".$message_id;
			shell_exec($command . " > /dev/null 2>/dev/null &");
		}else{
			// ------------------------------------------------------------------------
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
		$CI->db->trans_complete();
		
		return $message_id;
	}
}

/* End of file message_helper.php */
/* Location: ./application/helpers/message_helper.php */