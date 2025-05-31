<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layouts extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/Slice-Library/')->library('slice');
		$this->load->helper('url');
	}

	public function index()
	{
		$url = current_url();

		$data = [
			'raw' => 'RAW',
			'adminlte2/v1' => 'AdminLTE 2 v1',
			'adminlte2/v1_custom' => 'AdminLTE 2 v1 Custom',
			'adminlte3/v1' => 'AdminLTE 3 v1',
			'adminlte3/v1_custom' => 'AdminLTE 3 v1 Custom',
			'adminlte3/v2' => 'AdminLTE 3 v2',
			'adminlte3/v2_custom' => 'AdminLTE 3 v2 Custom',
		];

		$content = 'Layout Sample:';
		$content .= '<ul>';
		foreach ($data as $key => $item) {
			$content .= '<li><a href="'.$url.'/'.$key.'">'.$item.'</a></li>';
		}
		$content .= '</ul>';

		echo $content;
	}

	public function raw()
	{
		$data['page_title'] = 'My Page Sample';
		view('layouts/raw/content', $data);
	}

	public function adminlte2($version)
	{
		switch ($version) {
			case 'v1':
				$data['version'] = $version;
				$data['page_title'] = 'AdminLTE 2 '.$version;
				view('sample/layouts/adminlte2/content', $data);
				break;
			case 'v1_custom':
				$data['version'] = $version;
				$data['page_title'] = 'AdminLTE 2 '.$version;
				view('sample/layouts/adminlte2/content', $data);
				break;
			
			default:
				show_404();
				break;
		}
	}

	public function adminlte3($version)
	{
		switch ($version) {
			case 'v1':
			case 'v2':
				$data['version'] = $version;
				$data['page_title'] = 'AdminLTE 3 Original '.$version;
				view('sample/layouts/adminlte3/content', $data);
				break;

			case 'v1_custom':
			case 'v2_custom':
				$data['version'] = $version;
				$data['page_title'] = 'AdminLTE 3 Custom '.$version;
				view('sample/layouts/adminlte3/content', $data);
				break;
			
			default:
				show_404();
				break;
		}
	}

}

/* End of file Layouts.php */
/* Location: ./application/modules/sample/controllers/Layouts.php */