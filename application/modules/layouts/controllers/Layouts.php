<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layouts extends MY_Controller {

	public function theme($theme='')
	{
		$data['page_title'] = 'Sample with AdminLTE v3';
		view('layouts/themes/'.$theme.'/sample/sample', $data);
	}

}

/* End of file Layouts.php */
/* Location: ./application/modules/layouts/controllers/Layouts.php */