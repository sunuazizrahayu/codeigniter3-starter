<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/Storage/')->library('Storage');
		$this->load->library('form_validation');
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
			//validation
			$file_upload = $_FILES['upload']['tmp_name'];
			if (empty($file_upload)) {
				echo 'File required.';
				die;
			}

			//get file info
			echo '<hr>';
			$file = file_get_contents($file_upload);
			echo '<pre>';
			echo "file upload info: \n";
			print_r($_FILES['upload']);
			echo '</pre>';


			//upload validation
			echo "<hr>";
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']  = '300';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
			$errors = $this->storage->validate('upload', $config);
			echo "<pre>";
			echo "validation errors:\n";
			var_dump($errors);
			echo "</pre>";


			//upload process
			$result = $this->storage->upload('upload','storage');


			//upload result
			echo "<hr>";
			echo 'result url: <a href="'.$result['url'].'" target="_blank">'.$result['url'].'</a>';
			echo "<pre>";
			echo "upload result info:\n";
			print_r($result);
			echo "</pre>";
		}
	}

}

/* End of file Upload.php */
/* Location: ./application/modules/sample/controllers/Upload.php */