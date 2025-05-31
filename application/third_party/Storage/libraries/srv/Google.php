<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * to use this library you must execute: `composer require google/cloud-storage ^1.48`
 */

use Google\Cloud\Storage\StorageClient;

class Google
{
	protected $ci;
	protected $url = 'https://storage.googleapis.com/';

	public function __construct()
	{
		$this->ci =& get_instance();
	}

	private function bucket_auth()
	{
		$envPath = getenv('GOOGLE_STORAGE_CREDENTIAL');
		$json_file_path = ($envPath[0] === '/') ? $envPath : APPPATH . '../' . $envPath;

		if (!file_exists($json_file_path)) {
			throw new Exception("Service account JSON not found at: $json_file_path");
		}
		$json_file = file_get_contents($json_file_path);
		$config = json_decode($json_file, true);

		$projectId = $config['project_id'] ?? '';
		$bucket_name = $projectId;

		$storage = new StorageClient([
			'projectId' => $projectId,
			'keyFilePath' => $json_file_path
		]);

		$bucket = $storage->bucket($bucket_name);
		return $bucket;
	}

	public function upload($file_input_name, $path, $filename_custom='', $is_private=false)
	{
		$result_file_url = '';

		$file_found = false;
		if (!empty($_FILES[$file_input_name]['name'])) {
			$file_found = true;

			//get file
			$file = fopen($_FILES[$file_input_name]['tmp_name'], 'r');
			$file_ext = pathinfo($_FILES[$file_input_name]['name'],PATHINFO_EXTENSION);
		}

		if ($file_found == false) {
			$file_found = true;

			//get file
			$file = fopen($file_input_name, 'r');
			$file_ext = pathinfo($file_input_name, PATHINFO_EXTENSION);
		}

		if ($file_found == true) {
			// //get file
			// $file = fopen($_FILES[$file_input_name]['tmp_name'], 'r');
			// $file_ext = pathinfo($_FILES[$file_input_name]['name'],PATHINFO_EXTENSION);
			
			if ($file_ext == pathinfo($filename_custom, PATHINFO_EXTENSION)) {
				//remove extension on $filename_custom
				$filename_custom = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename_custom);
			}

			//rename file
			$file_name_generated = preg_replace("[^\w.-]", '', md5( date('Y-m-d H:i:s')) ); //remove non alphanumeric
			$file_name = (empty($filename_custom)) ? $file_name_generated : $filename_custom;
			$file_name .= '.'. strtolower($file_ext); //add extention on file name

			//setting path
			$file_fullpath = $path.$file_name;


			// Upload a file to the bucket.
			$bucket = $this->bucket_auth();
			if ($is_private==true) {
				$bucket->upload($file, [
					'name' => $file_fullpath,
				]);
			}else{
				$bucket->upload($file, [
					'name' => $file_fullpath,
					'predefinedAcl' => 'publicRead',
				]);//->update(['acl' => []], ['predefinedAcl' => 'PUBLICREAD']);
			}

			$object = $bucket->object($file_fullpath);
			$object_info = $object->info();
			$file_path = $object_info['name'] ?? '';
			
			//check is is image
			$object_info['is_image'] = false;
			if (strtolower(substr($object_info['contentType'], 0, 5)) == 'image') {
				$object_info['is_image'] = true;
				$object_info['image_type'] = explode('/', $object_info['contentType'])[1];
			}

			//public url
			$result_file_url = "https://storage.googleapis.com/".$bucket->name()."/".$file_path;
			$object_info['url'] = $result_file_url;
		}

		return $object_info;
	}

}

/* End of file Google.php */