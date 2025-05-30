<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		if (function_exists('session_write_close')) {
			session_write_close();
		}
	}

	public function index()
	{
		$migration_text = 'Migration not executed.';

		$this->load->config('migration');
		$ci_migration = $this->config->item('migration_enabled');
		$ci_migration_auto = $this->config->item('migration_auto_latest');
		$ci_migration_version = $this->config->item('migration_version');

		if ($ci_migration === true) {
			// LOAD MIGRATION
			$this->load->library('migration');

			// MIGRATE TO THE LATEST VERSION
			if ($ci_migration_auto === true) {
				$version = $this->migration->get_version();
				$migration_text = 'Migrated to version: '.$version.' (latest)';
				echo $migration_text;
				die;
			}

			// MIGRATE TO THE SPECIFIC VERSION
			if ($ci_migration_version > 0) {
				$version = $this->migration->current();
				if ($version === true) {
					$version = $this->migration->get_version();
					$migration_text = 'Migration is version: '.$version;
				}else{
					if (!empty($version)) {
						$migration_text = 'Migrated to version: '.$version;
					}else{
						$version = $ci_migration_version;
						$migration_text = 'Migration for version '.$version.' not found';
					}
				}
				echo $migration_text;
				die;
			}

			// MIGRATE TO VERSION 0
			if ($ci_migration_version === '0') {
				$version = $this->migration->current();
				if ($version === true) {
					$version = $this->migration->get_version();
					$migration_text = 'Migration is version: '.$version;
				}else{
					if (!empty($version)) {
						$migration_text = 'Migrated to version: '.$version;
					}else{
						$version = $ci_migration_version;
						$migration_text = 'Migration for version '.$version.' not found';
					}
				}
				echo $migration_text;
				die;
			}
		}


		echo $migration_text;
	}

}

/* End of file Migrate.php */
/* Location: ./application/modules/webhook/controllers/Migrate.php */