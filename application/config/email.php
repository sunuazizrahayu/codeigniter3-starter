<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol']	 = 'smtp';
$config['smtp_host'] = getenv('MAIL_HOST'); //ssl://smtp.googlemail.com, ssl://smtp.zoho.com, ssl://smtp.gmail.com
$config['smtp_port'] = getenv('MAIL_PORT'); //465
$config['smtp_user'] = getenv('MAIL_USER'); //youremail@domain.com
$config['smtp_pass'] = getenv('MAIL_PASS'); //youremailpassword

$config['wordwrap']  = TRUE;
$config['mailtype']  = 'html';
$config['charset'] 	 = 'utf-8';
$config['crlf']	     = "\r\n";
$config['newline']   = "\r\n";

/* End of file email.php */
/* Location: ./application/config/email.php */