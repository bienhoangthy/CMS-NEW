<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->lang->load('setting',$this->_data['language']);
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->load->Model("admin/mcomponent");
        $this->load->Model("admin/msetting");
    }
    public function index()
    {
        $this->mpermission->checkPermission("setting","index",$this->_data['user_active']['active_user_group']);
        $this->_data['title'] = lang('title');
        $mySetting = $this->msetting->getData("",array('id' => 1));
        $this->_data['formData'] = array(
            'write_log' => $mySetting['write_log'], 
            'component_log' => $mySetting['component_log'], 
            'limit_title' => $mySetting['limit_title'], 
            'ratio_news' => $mySetting['ratio_news'], 
            'ratio_album' => $mySetting['ratio_album'], 
            'ratio_video' => $mySetting['ratio_video'], 
            'ratio_product' => $mySetting['ratio_product'] 
        );
        if (isset($_POST['limit_title'])) {
            var_dump($_POST);die();
        }
        $this->_data['listComponent'] = $this->mcomponent->whereIn("id,component_name,component","2,3,4,6,10,11,13,16,19,20,25");
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','switchery.min.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js','switchery.min.js'];
    	$this->my_layout->view("admin/setting/index", $this->_data);
    } 
}
