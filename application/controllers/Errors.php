<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include ( APPPATH . 'core/MY_Controllerfront.php' );
class Errors extends MY_Controllerfront {
	public function __construct()
    {
        parent::__construct();
    }
	public function index()
	{
		$this->output->set_status_header('404');
		echo "404 Not Found!";
	}
}
