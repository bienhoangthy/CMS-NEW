<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Media extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('media',$this->_data['language']);
    }
    public function index()
    {
        $this->mpermission->checkPermission("media","index",$this->_data['user_active']['active_user_group']);
    	$this->_data['title'] = lang('title');
    	$this->my_layout->view("admin/media/index", $this->_data);
    }
}
