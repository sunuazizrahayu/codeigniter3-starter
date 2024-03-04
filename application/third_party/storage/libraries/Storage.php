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
		switch (getenv('CI_STORAGE_SERVER')) {
			case 'cloudinary':
			case 'google':
				$this->server = getenv('CI_STORAGE_SERVER');
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
		$destination_path = $this->server_path . $destination_path;

		switch ($this->server) {
			case 'local':
				$destination_path = trim($destination_path, 'storage');
				$destination_path = './storage/'.trim($destination_path);
				return $this->upload_local($input_name, $destination_path, $filename_custom);
				break;
			
			default:
				// code...
				break;
		}
	}



	// ------------------------------------------------------------------------
	public function upload_local($input_name, $destination_path, $filename_custom='')
	{
		$this->ci->load->library('srv/Local', NULL, 'StorageLocal');
		return $this->ci->StorageLocal->upload($input_name, $destination_path, $filename_custom);
	}

}

/* End of file Storage.php */
/* Location: ./application/libraries/Storage.php */