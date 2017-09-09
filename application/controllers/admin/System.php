<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class System extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->lang->load('system',$this->_data['language']);
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
    }
    public function index()
    {
        $this->_data['title'] = lang('title');
        $this->my_layout->view("admin/system/index", $this->_data);
    }
}
