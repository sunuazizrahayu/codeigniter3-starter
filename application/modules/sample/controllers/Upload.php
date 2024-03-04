<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/storage/')->library('Storage');
	}

	public function index()
	{
		echo '
		<form action="" method="post" enctype="multipart/form-data">
			Select image to upload:
			<div>
			<input type="file" name="upload" id="fileToUpload">
			</div>
			<div>
			<input type="submit" value="Upload Image" name="submit">
			</div>
		</form>';

		if(isset($_POST["submit"])) {
			echo '<hr>';
			$file = file_get_contents($_FILES['upload']['tmp_name']);
			echo '<pre>';
			echo "file upload info: \n";
			print_r($_FILES['upload']);
			echo '</pre>';


			echo "<hr>";
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = '300';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
			$errors = $this->storage->validate('upload', $config);
			echo "<pre>";
			echo "validation info:\n";
			print_r($errors);
			echo "</pre>";


			echo "<hr>";
			echo "<pre>";
			echo "upload info:\n";
			print_r($this->storage->upload('upload','storage'));
			echo "</pre>";
		}
	}

}

/* End of file Upload.php */
/* Location: ./application/modules/sample/controllers/Upload.php */