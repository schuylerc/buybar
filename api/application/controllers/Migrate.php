<?php

class Migrate extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

	}
	
	public function index(){
		//TODO impliment testing
		
		$this->update_server();
		$this->update_migration();
	}

	public function update_migration(){
		
		$this->load->library('migration');
		
		if ( ! $this->migration->current())
		{
			show_error($this->migration->error_string());
		}
		else
		{
			echo "Migration Completed Successfully";
		}
		
	}
	
	public function update_server(){
		
		exec('/var/www/brotherportal4/deployment/hooks/update_server.sh', $output);
		echo var_dump($output);
	}
	

}