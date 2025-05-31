<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * to use this library, you must execute: `composer require "cloudinary/cloudinary_php" ^3.1`
 * or you can add `"cloudinary/cloudinary_php": "^3.1"` on your composer.json, then execute `composer install`
 */

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

class Cloudinary
{

	public function __construct()
	{
		Configuration::instance([
			'cloud' => [
				'cloud_name' 	=> getenv('CLOUDINARY_CLOUD_NAME'),
				'api_key' 		=> getenv('CLOUDINARY_API_KEY'),
				'api_secret' 	=> getenv('CLOUDINARY_API_SECRET'),
			],
			'url' => ['secure' => true]
		]);
	}

	# The `options` parameters list: https://cloudinary.com/documentation/upload_parameters#required_file_parameter
	public function upload($file_path, $options=[])
	{
		$response = (new UploadApi())->upload($file_path, $options);
		return $response;
	}

	public function delete($file_url, $options=[])
	{
		//get file path by file url
		$pattern = "/^https:\/\/([a-z0-9\\.]+\/){5}/i";
		$file = preg_replace($pattern, "", $file_url);
		$file = substr($file, 0, strrpos($file, '.'));
		$file = urldecode($file);

		//delete
		$options['invalidate'] = true; //bypass caching
		$response = (new UploadApi())->destroy($file, $options);
		return $response;
	}

}

/* End of file Cloudinary.php */