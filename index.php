<?php
if (!file_exists(__DIR__.'/public') || (php_sapi_name() !== 'cli')) {
	return false;
}

require_once __DIR__.'/public/index.php';