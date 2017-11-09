<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include ( APPPATH . 'core/MY_Controllerfront.php' );
class Home extends MY_Controllerfront {
	public function __construct()
    {
        parent::__construct();
    }
	public function index()
	{
		// echo json_encode($this->_data);
		var_dump($this->_data);die();
		// phpinfo();
	}
}
