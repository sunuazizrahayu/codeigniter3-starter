<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sample extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Storage');
	}

	public function index()
	{
		echo '
		<form action="" method="post" enctype="multipart/form-data">
			Select image to upload:
			<input type="file" name="upload" id="fileToUpload">
			<input type="submit" value="Upload Image" name="submit">
		</form>';

		if(isset($_POST["submit"])) {
			$file = file_get_contents($_FILES['upload']['tmp_name']);

			echo '<pre>';
			print_r($_FILES['upload']);
			echo '</pre>';

			echo "<hr>";
			
			echo '<pre>';
			$x  = $this->storage->upload('upload','/storage');
			print_r($x);
			echo '</pre>';
		}
	}

}

/* End of file Sample.php */
/* Location: ./application/third_party/storage/controllers/Sample.php */