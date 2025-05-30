<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('message');
	}

	public function index()
	{
		echo '
		Send Email:
		<form action="" method="post">
		to: <input type="email" name="to" required>

		<div style="margin-top: 5px">
			subject: <input type="text" name="subject" required>
		</div>
		<div style="margin-top: 5px">
			message: <br>
		</div>
		<div style="margin-top: 5px">
			<textarea name="message" required></textarea>
		</div>
		<div style="margin-top: 5px">
			<input type="submit" value="Send" name="submit">
		</div>
		</form>';

		if (isset($_POST['submit'])) {
			send_email($_POST['to'], $_POST['subject'], $_POST['message']);
		}
	}

}

/* End of file Message.php */
/* Location: ./application/modules/sample/controllers/Message.php */