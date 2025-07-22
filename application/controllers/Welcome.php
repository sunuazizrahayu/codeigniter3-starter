<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$lang_code = $this->config->item('language_abbr');
		if (file_exists(APPPATH.'views/welcome_message.'.$lang_code.'.php')) {
			$lang_code = '.'.$lang_code.'.php';
		}else{
			$lang_code = '';
		}
		$this->load->view('welcome_message'.$lang_code);
	}
}
