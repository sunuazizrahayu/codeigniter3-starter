<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Storage
{
	protected $ci;
	protected $driver;
	protected $path;

	public function __construct()
	{
        $this->ci =& get_instance();
        $this->ci->load->helper('url');
        
        //validate storage driver
        switch (getenv('CI_STORAGE')) {
        	case 'google':
        		$this->path = getenv('CI_STORAGE_PATH');
        		$this->driver = getenv('CI_STORAGE');
        		break;
        	
        	default:
        		$this->path = $_SERVER['CI_STORAGE_PATH'] ?? 'storage';
        		$this->driver = 'local';
        		break;
        }
	}

	/**
	 * Upload Validation based on CodeIgniter Upload Library
	 */
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
	}


	/**
	 * Upload file to storage based on defined driver / service
	 */
	public function upload($file, $destination_path='', $filename_custom='')
	{
		switch ($this->driver) {
			case 'local':
				$default_destination_path = $this->path; // storage
				if (empty($destination_path) || strtolower(substr($destination_path, 0, strlen($destination_path))) == $default_destination_path || strtolower(substr($destination_path, 0, 8)) == $default_destination_path.'/') {

					//remove prefix `storage`
					$suffix = $destination_path;
					$prefix = substr($destination_path, 0, 7);
					if (substr($destination_path, 0, strlen($prefix)) == $prefix) {
						$suffix = substr($destination_path, strlen($prefix));
					}

					//set path
					$destination_path = './'.$default_destination_path.$suffix;
				}else{
					$first_char = substr($destination_path, 0,1);
					if ($first_char != '/') {
						$destination_path = './'.$default_destination_path.'/'.$destination_path;
					}
				}

				$destination_path = rtrim($destination_path,'/') .'/';
				
				$this->ci->load->library('srv/Local');
				return $this->ci->local->upload($file, $destination_path, $filename_custom);
				break;
			
			case 'google':
				if (!empty($this->path)) {
					$this->path = rtrim($this->path,'/') .'/';
				}
				$destination_path = $this->path . rtrim($destination_path,'/') .'/';

				$this->ci->load->library('srv/Google', null, 'GoogleStorage');
				return $this->ci->GoogleStorage->upload($file, $destination_path, $filename_custom);
				break;

			default:
				return 'Driver not supported.';
				break;
		}
	}
}

/* End of file Storage.php */
/* Location: ./application/third_party/storage/libraries/Storage.php */
