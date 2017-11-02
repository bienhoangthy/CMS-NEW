<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->lang->load('setting',$this->_data['language']);
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->load->Model("admin/mcomponent");
        // $this->load->Model("admin/msetting");
    }
    public function index()
    {
        $this->mpermission->checkPermission("setting","index",$this->_data['user_active']['active_user_group']);
        $this->_data['title'] = lang('title');
        $mySetting = $this->msetting->getData("",array('id' => 1));
        $this->_data['formData'] = array(
            'write_log' => $mySetting['write_log'], 
            'write_history_login' => $mySetting['write_history_login'], 
            'component_log' => $mySetting['component_log'], 
            'limit_title' => $mySetting['limit_title'], 
            'ratio_news' => $mySetting['ratio_news'], 
            'ratio_album' => $mySetting['ratio_album'], 
            'ratio_video' => $mySetting['ratio_video'], 
            'ratio_product' => $mySetting['ratio_product'],
            'email' => $mySetting['email'],
            'alias' => $mySetting['alias'],
            'smtp_user' => $mySetting['smtp_user'],
            'smtp_server' => $mySetting['smtp_server'],
            'smtp_password' => $mySetting['smtp_password'],
            'smtp_port' => $mySetting['smtp_port'],
            'smtp_use_ssl' => $mySetting['smtp_use_ssl'],
            'use_ga' => $mySetting['use_ga'],
            'ga_id' => $mySetting['ga_id'],
            'ga_profile_id' => $mySetting['ga_profile_id']
        );
        if (isset($_POST['limit_title'])) {
            $write = $this->input->post('write_log') ?? 0;
            $listComponentPost = $this->input->post('component');
            $component = '';
            if ($write == 1) {
                if ($listComponentPost != null && is_array($listComponentPost) && !empty($listComponentPost)) {
                    $component = serialize($listComponentPost);
                }
            }
            $this->_data['formData'] = array(
                'write_log' => $write, 
                'write_history_login' => $this->input->post('write_history_login') ?? 0, 
                'component_log' => $component, 
                'limit_title' => $this->input->post('limit_title'), 
                'ratio_news' => $this->input->post('ratio_news'), 
                'ratio_album' => $this->input->post('ratio_album'), 
                'ratio_video' => $this->input->post('ratio_video'), 
                'ratio_product' => $this->input->post('ratio_product'),
                'email' => $this->input->post('email'),
                'alias' => $this->input->post('alias'),
	            'smtp_user' => $this->input->post('smtp_user'),
	            'smtp_server' => $this->input->post('smtp_server'),
	            'smtp_password' => $this->input->post('smtp_password'),
	            'smtp_port' => $this->input->post('smtp_port'),
                'smtp_use_ssl' => $this->input->post('smtp_use_ssl') ?? 0,
                'use_ga' => $this->input->post('use_ga') ?? 0,
                'ga_id' => $this->input->post('ga_id'),
	            'ga_profile_id' => $this->input->post('ga_profile_id')
            );
            $error = false;
            do {
                if ($this->_data['formData']['limit_title'] < 1) {
                    $text = lang('pleaseinput').lang('limit');$error = true;break;
                }
                if ($this->_data['formData']['ratio_news'] < 11) {
                    $text = lang('pleasechoose').lang('ratio').lang('news');$error = true;break;
                }
                if ($this->_data['formData']['ratio_album'] < 11) {
                    $text = lang('pleasechoose').lang('ratio').lang('album');$error = true;break;
                }
                if ($this->_data['formData']['ratio_video'] < 11) {
                    $text = lang('pleasechoose').lang('ratio').lang('video');$error = true;break;
                }
                if ($this->_data['formData']['ratio_product'] < 11) {
                    $text = lang('pleasechoose').lang('ratio').lang('product');$error = true;break;
                }
                if ($this->_data['formData']['use_ga'] == 1) {
                    if ($this->_data['formData']['ga_id'] == '') {
                        $text = lang('pleaseinput').' GA ID';$error = true;break;
                    }
                    if ($this->_data['formData']['ga_profile_id'] == '') {
                        $text = lang('pleaseinput').' GA Profile ID';$error = true;break;
                    }
                }
            } while (0);
            if ($error == true) {
                $notify = array(
                    'title' => lang('unsuccessful'), 
                    'text' => $text,
                    'type' => 'error'
                );
                $this->session->set_userdata('notify', $notify);
            } else {
                if ($this->msetting->edit(1,$this->_data['formData'])) {
                    $notify = array(
                        'title' => lang('success'), 
                        'text' => lang('system').' '.lang('edited'),
                        'type' => 'success'
                    );
                } else {
                    $notify = array(
                        'title' => lang('unsuccessful'), 
                        'text' => lang('checkinfo'),
                        'type' => 'error'
                    );
                }
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."setting");
            }
        }
        $this->_data['listComponent'] = $this->mcomponent->whereIn("id,component_name,component","2,3,4,6,10,11,13,16,19,20,25");
        $this->_data['listOldComponent'] = array();
        if ($this->_data['formData']['component_log'] != '') {
            $this->_data['listOldComponent'] = unserialize($this->_data['formData']['component_log']);
        }
        $this->_data['ratio_news'] = $this->msetting->dropdownlistRatio($this->_data['formData']['ratio_news']);
        $this->_data['ratio_album'] = $this->msetting->dropdownlistRatio($this->_data['formData']['ratio_album']);
        $this->_data['ratio_video'] = $this->msetting->dropdownlistRatio($this->_data['formData']['ratio_video']);
        $this->_data['ratio_product'] = $this->msetting->dropdownlistRatio($this->_data['formData']['ratio_product']);
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','switchery.min.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js','switchery.min.js'];
    	$this->my_layout->view("admin/setting/index", $this->_data);
    } 
}
