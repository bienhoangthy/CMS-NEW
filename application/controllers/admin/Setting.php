<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->lang->load('setting',$this->_data['language']);
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
    }
    public function index()
    {
        $this->mpermission->checkPermission("setting","index",$this->_data['user_active']['active_user_group']);
        $this->_data['title'] = lang('title');
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
    	$this->my_layout->view("admin/setting/index", $this->_data);
    } 
}
