<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Action extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->lang->load('action',$this->_data['language']);
        $this->load->Model("admin/maction");
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
    }
    public function index()
    {
        $this->mpermission->checkPermission("action","index",$this->_data['user_active']['active_user_group']);
        $this->_data['formData'] = array(
            'action_name' => '', 
            'action_value' => ''
        );
        if (isset($_POST['action_name'])) {
            $this->mpermission->checkPermission("action","add",$this->_data['user_active']['active_user_group']);
            $this->_data['formData'] = array(
                'action_name' => $this->input->post('action_name'), 
                'action_value' => $this->input->post('action_value')
            );
            $checkAction = $this->maction->getData("id",array('action_value' => $this->_data['formData']['action_value']));
            $error = false;
            do {
                if ($this->_data['formData']['action_name'] == null) {
                    $text = lang('pleaseinput').lang('rolename');$error = true;break;
                }
                if ($this->_data['formData']['action_value'] == null) {
                    $text = lang('pleaseinput').lang('rolevalue');$error = true;break;
                }
                if ($checkAction && $checkAction['id'] > 0) {
                    $text = lang('role').lang('doesexists');$error = true;break;
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
                $insert = $this->maction->add($this->_data['formData']);
                if (is_numeric($insert) > 0) {
                    $notify = array(
                        'title' => lang('success'), 
                        'text' => lang('role').$this->_data['formData']['action_name'].lang('added'),
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    redirect(my_library::admin_site()."action");
                }
            } 
        }
    	$this->_data['title'] = lang('title');
        $this->_data['formSearch'] = array(
            'fkeyword' => isset($_GET['fkeyword']) ? $_GET['fkeyword'] : ''
        );
        $and = '1';
        if ($this->_data['formSearch']['fkeyword'] != '') {
            $and .= ' and (action_name like "%' . $this->_data['formSearch']['fkeyword'] . '%"';
            $and .= ' or action_value like "%' . $this->_data['formSearch']['fkeyword'] . '%")';
        }
        $this->_data['list'] = $this->maction->getQuery("", $and, "action_value asc","");
        $this->_data['record'] = $this->maction->countQuery($and);
        $this->_data['extraJs'] = ['validator.js','module/action.js'];
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
    	$this->my_layout->view("admin/action/index", $this->_data);
    }   

    public function ajaxChangename()
    {
        $this->mpermission->checkPermission("action","ajaxChangename",$this->_data['user_active']['active_user_group']);
        $name = $this->input->get('name');
        $id = $this->input->get('id');
        if ($name == null || $id == null) {
            echo "no";
        } else {
            if ($this->maction->edit($id,array('action_name' => $name))) {
                echo "ok";
            } else {
                echo "no";
            }
        }
    }

    public function delete($id)
    {
        $this->mpermission->checkPermission("action","delete",$this->_data['user_active']['active_user_group']);
    	if (is_numeric($id) > 0) {
    		$myAction = $this->maction->getData("",array('id' => $id));
    		if ($myAction && $myAction['id'] > 0) {
    			$this->maction->delete($id);
                $this->mpermission->deleteAnd(array('action_value' => $myAction['action_value']));
    			$title = lang('success');
                $text = lang('role').$myAction['action_name'].lang('deleted');
                $type = 'success';
    		} else {
    			$title = lang('unsuccessful');
                $text = lang('role').lang('notexists');
                $type = 'error';
    		}
    	} else {
    		$title = lang('unsuccessful');
            $text = lang('wrongid');
            $type = 'error';
    	}
    	$notify = array(
            'title' => $title, 
            'text' => $text,
            'type' => $type
        );
        $this->session->set_userdata('notify', $notify);
        redirect(my_library::admin_site()."action");
    }
}
