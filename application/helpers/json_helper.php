<?php
if (!function_exists('json')) {
	function json($array=[], $status_code='')
	{
		if ($status_code != '') {
			http_response_code($status_code);
		}

		header('Content-Type: application/json');
		return json_encode($array, JSON_PRETTY_PRINT);
	}
}

if (!function_exists('is_json')) {
	function is_json($json_data)
	{
		json_decode($json_data);
		return (json_last_error() == JSON_ERROR_NONE);
	}
}
