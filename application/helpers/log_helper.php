<?php
if (!function_exists('print_log')) {
	function print_log($message, $type='log')
	{
		$datetime = date('Y-m-d H:i:s');
		file_put_contents("php://stderr", $datetime . ' ' .strtoupper($type) .': '. $message . PHP_EOL);
	}
}