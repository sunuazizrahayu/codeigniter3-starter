<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Local
{
	protected $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
	}

	public function upload($input_name='', $destination_path='', $filename_custom='')
	{
		$fileExt = pathinfo($_FILES[$input_name]["name"], PATHINFO_EXTENSION);
		$fileExt = strtolower($fileExt);


		$config['upload_path'] 		= $destination_path;
		$config['allowed_types'] 	= '*';
		$config['file_ext_tolower'] = true;
		if ($filename_custom != "") {
			$config['file_name'] 	= $filename_custom . ".".$fileExt;
		}


		// check path
		if (!is_dir($destination_path)) {
			$old = umask(0);
			mkdir($destination_path, 0755, true);
			umask($old);
		}
		
		
		$this->ci->load->library('upload', $config);
		$this->ci->upload->initialize($config);
		
		if ( ! $this->ci->upload->do_upload($input_name)){
			return $this->ci->upload->display_errors('','');
		}
		
		$data = $this->ci->upload->data();
		$url = $data['full_path'];
		if (substr($url, 0, strlen(FCPATH)) == FCPATH) {
			$url = substr($url, strlen(FCPATH));
			$url = base_url($url);
		}else{
			$url = null;
		}
		$data['url'] = $url;
		return $data;
	}

}

/* End of file Local.php */
/* Location: ./libraries/srv/Local.php */