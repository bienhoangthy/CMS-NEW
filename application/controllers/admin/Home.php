<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('home',$this->_data['language']);
    }
    public function index()
    {
    	$this->_data['title'] = lang('dashboard');
        $this->mpermission->checkPermission("home","index",$this->_data['user_active']['active_user_group']);
    	$this->my_layout->view("admin/home/index", $this->_data);
    }
}
