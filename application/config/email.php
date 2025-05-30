<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol']	 = 'smtp';
$config['smtp_host'] = getenv('MAIL_HOST');
$config['smtp_port'] = getenv('MAIL_PORT');
$config['smtp_user'] = getenv('MAIL_USER');
$config['smtp_pass'] = getenv('MAIL_PASS');

$config['wordwrap']  = TRUE;
$config['mailtype']  = 'html';
$config['charset'] 	 = 'utf-8';
$config['crlf']	     = "\r\n";
$config['newline']   = "\r\n";

/* End of file email.php */
/* Location: ./application/config/email.php */