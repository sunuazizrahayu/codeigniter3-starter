<?php
if (!function_exists('themes')) {
	function themes($path='')
	{
		return base_url('themes/'.$path);
	}
}

if (!function_exists('assets')) {
	function assets($path='')
	{
		return base_url('assets/'.$path);
	}
}

