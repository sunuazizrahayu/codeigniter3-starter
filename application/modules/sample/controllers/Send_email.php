<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Send_email extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('message');
	}

	public function index()
	{
		echo '
		<form action="" method="post">
		to: <input type="email" name="to" required>
		<div style="margin-top: 5px"></div>
		subject: <input type="text" name="subject" required>
		<div style="margin-top: 5px"></div>
		message: <br>
		<textarea name="message" required></textarea>
		<div style="margin-top: 5px"></div>
		<input type="submit" value="Send" name="submit">
		</form>';

		if (isset($_POST['submit'])) {
			send_email($_POST['to'], $_POST['subject'], $_POST['message']);
		}
	}

}

/* End of file Send_email.php */
/* Location: ./application/modules/sample/controllers/Send_email.php */ ?>