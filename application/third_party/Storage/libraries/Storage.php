<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Storage
{
	protected $ci;
	protected $server;
	protected $server_path;

	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->helper('url');

		//validate storage driver
		switch (getenv('CI_STORAGE')) {
			case 'cloudinary':
			case 'google':
				$this->server = getenv('CI_STORAGE');
				break;
			
			default:
				$this->server = 'local';
				break;
		}

		//set storage path
		$storage_path = getenv('CI_STORAGE_PATH') ?? '';
		$this->server_path = rtrim($storage_path,'/') . '/';
	}

	public function validate($input_name, $config=[])
	{
		if (empty($config['upload_path'])) {
			$config['upload_path'] = sys_get_temp_dir();
		}

		$this->ci->load->library('upload', $config);
		$this->ci->upload->initialize($config);

		if ( ! $this->ci->upload->do_upload($input_name)){
			return $this->ci->upload->display_errors('','');
		}

		return TRUE;
	}

	public function upload($input_name, $destination_path='', $filename_custom='')
	{
		$destination_path = rtrim($destination_path,'/') .'/';

		switch ($this->server) {
			case 'cloudinary':
				$destination_path = strtolower($this->server_path).$destination_path;
				return $this->upload_cloudinary($input_name, $destination_path, $filename_custom);
				break;
			case 'google':
				return $this->upload_google($input_name, $destination_path, $filename_custom);
				break;
			default:
				if (strtolower($this->server_path) != 'storage/') {
					$destination_path = './storage/'.$this->server_path.$destination_path;
				} else {
					$destination_path = './storage/'.$destination_path;
				}
				return $this->upload_local($input_name, $destination_path, $filename_custom);
				break;
		}
	}



	// ------------------------------------------------------------------------
	public function upload_local($input_name, $destination_path, $filename_custom='')
	{
		$this->ci->load->library('srv/Local', NULL, 'StorageLocal');
		return $this->ci->StorageLocal->upload($input_name, $destination_path, $filename_custom);
	}

	public function upload_cloudinary($input_name, $destination_path, $filename_custom='')
	{
		$this->ci->load->library('srv/Cloudinary', NULL, 'Cloudinary');

		$file_path = $_FILES[$input_name]['tmp_name'];
		$options = [
			'folder' => $destination_path,
		];
		if (!empty($filename_custom)) {
			//generate subfix
			$random = bin2hex(random_bytes(8));
			$filename = $filename_custom.'_'.$random;

			//fix file naming
			$filename = preg_replace('/[^a-z0-9]+/', '_', $filename);
			$filename = trim($filename, '_');

			$options['public_id'] = $filename;
			$options['overwrite'] = false;
		}
		$response = $this->ci->Cloudinary->upload($file_path, $options);
		$response['url'] = $response['secure_url'];
		return $response;
	}

}

/* End of file Storage.php */
/* Location: ./libraries/Storage.php */