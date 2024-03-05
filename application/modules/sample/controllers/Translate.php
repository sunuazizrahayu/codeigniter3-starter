<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Translate extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('language');
	}

	public function index()
	{
		echo '
		<form action="" method="post">
		<div>
			Words: <textarea name="words" placeholder="Words" required></textarea>
		</div>
		<div>
			to: <input type="text" name="to" placeholder="Lang Abbr" minlength="2" maxlength="2" required>
		</div>
		<div>
			from: <input type="text" name="from" placeholder="Lang Abbr" minlength="2" maxlength="2">
		</div>

		<div style="margin-top: 5px">
			<input type="submit" value="Send" name="submit">
		</div>
		</form>
		';

		if (isset($_POST['submit'])) {
			$words = $_POST['words'];
			$to = $_POST['to'];
			$from = (empty($_POST['from'])) ? null : $_POST['from'];
			echo "Result:<br>";
			echo translate($words, $to, $from);
		}
	}

}

/* End of file Translate.php */
/* Location: ./application/modules/sample/controllers/Translate.php */