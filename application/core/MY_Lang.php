<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Lang extends CI_Lang
{
	
	function __construct()
	{
		global $URI, $CFG, $IN;
		$config =& $CFG->config;

		$language_key = $config['language_cookie_name'] ?? 'ci_language';

		//get default language
		$language = $config['language'];
		$language_abbr = $config['language_abbr'];

		//set language with cookie
		$language_cookie = $IN->cookie($language_key);
		if (empty($language_cookie)) {
			$ip = $IN->ip_address();
			$ip = explode(',', $ip)[0] ?? '';

			$ip_details = json_decode(@file_get_contents("http://ipinfo.io/{$ip}/json"), TRUE);
			$language_cookie = strtolower($ip_details['country'] ?? 'en');

			//set site language on cookie
			$IN->set_cookie($language_key, $language_cookie, $config['sess_expiration'], null, '/');
		}


		// country code to country name
		$country_code = $language_cookie;

		//set language by requested language
		if (empty($language_cookie) && !empty($IN->request_headers()['Accept-Language'])) {
			$country_code = $IN->request_headers()['Accept-Language'];
		}

		//set language by requested language
		if (!empty($config['language_abbr_list'][$country_code])) {
			$language = $config['language_abbr_list'][$country_code];
			$language_abbr = $country_code;
		}


		//set to config
		$config['language'] = $language;
		$config['language_abbr'] = $language_abbr;
	}
}

/* End of file MY_Lang.php */
/* Location: ./application/core/MY_Lang.php */