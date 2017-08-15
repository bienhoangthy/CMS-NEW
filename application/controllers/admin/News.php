<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class News extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->Model("admin/mgroup");
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
    }
    public function index()
    {
    	echo "This is News";
    }   
}
