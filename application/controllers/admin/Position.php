<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Position extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('position',$this->_data['language']);
        $this->load->Model("admin/mposition");
    }
	public function index()
	{
		$this->mpermission->checkPermission("position","index",$this->_data['user_active']['active_user_group']);
        $this->_data['formData'] = array(
            'position_name' => '', 
            'position_width' => 0,
            'position_height' => 0,
            'position_status' => 1
        );
        if (isset($_POST['position_name'])) {
            $this->mpermission->checkPermission("position","add",$this->_data['user_active']['active_user_group']);
            $this->_data['formData'] = array(
                'position_name' => $this->input->post('position_name'), 
                'position_width' => $this->input->post('position_width'),
                'position_height' => $this->input->post('position_height'),
                'position_status' => $this->input->post('position_status')
            );
            $error = false;
            do {
                if ($this->_data['formData']['position_name'] == null) {
                    $text = lang('pleaseinput').lang('positionname');$error = true;break;
                }
                if ($this->_data['formData']['position_width'] < 1) {
                    $text = lang('pleaseinput').lang('width');$error = true;break;
                }
                if ($this->_data['formData']['position_height'] < 1) {
                    $text = lang('pleaseinput').lang('height');$error = true;break;
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
                $insert = $this->mposition->add($this->_data['formData']);
                if (is_numeric($insert) > 0) {
                    $notify = array(
                        'title' => lang('success'), 
                        'text' => lang('position').' '.$this->_data['formData']['position_name'].lang('added'),
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    redirect(my_library::admin_site()."position");
                }
            }
        }
        $this->_data['title'] = lang('list');
        $obj = '';
        $this->_data['formSearch'] = array(
            'fkeyword' => $_GET['fkeyword'] ?? '',
            'fstatus' => $_GET['fstatus'] ?? 0
        );
        $and = '1';
        if ($this->_data['formSearch']['fkeyword'] != '') {
            $and .= ' and position_name like "%' . $this->_data['formSearch']['fkeyword'] . '%"';
        }
        if ($this->_data['formSearch']['fstatus'] > 0) {
            $and .= ' and position_status = '. $this->_data['formSearch']['fstatus'];
        }
        $orderby = 'id desc';
        $this->_data['list'] = $this->mposition->getQuery($obj, $and, $orderby, "");
        $this->_data['record'] = $this->mposition->countQuery($and);
        $this->_data['fstatus'] = $this->mposition->dropdownlistStatus($this->_data['formSearch']['fstatus']);
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js'];
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
        $this->my_layout->view("admin/position/index", $this->_data);
	}

    public function edit($id)
    {
        $this->mpermission->checkPermission("position","edit",$this->_data['user_active']['active_user_group']);
        if (is_numeric($id) && $id > 0) {
            $myPosition = $this->mposition->getData("",array('id' => $id));
            if ($myPosition && $myPosition['id'] > 0) {
                $this->_data['formData'] = array(
                    'position_name' => $myPosition['position_name'], 
                    'position_width' => $myPosition['position_width'],
                    'position_height' => $myPosition['position_height'],
                    'position_status' => $myPosition['position_status']
                );
                if (isset($_POST['position_name'])) {
                    $this->mpermission->checkPermission("position","add",$this->_data['user_active']['active_user_group']);
                    $this->_data['formData'] = array(
                        'position_name' => $this->input->post('position_name'), 
                        'position_width' => $this->input->post('position_width'),
                        'position_height' => $this->input->post('position_height'),
                        'position_status' => $this->input->post('position_status')
                    );
                    $error = false;
                    do {
                        if ($this->_data['formData']['position_name'] == null) {
                            $text = lang('pleaseinput').lang('positionname');$error = true;break;
                        }
                        if ($this->_data['formData']['position_width'] < 1) {
                            $text = lang('pleaseinput').lang('width');$error = true;break;
                        }
                        if ($this->_data['formData']['position_height'] < 1) {
                            $text = lang('pleaseinput').lang('height');$error = true;break;
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
                        if ($this->mposition->edit($id,$this->_data['formData'])) {
                            $notify = array(
                                'title' => lang('success'), 
                                'text' => lang('position').' '.$this->_data['formData']['position_name'].lang('edited'),
                                'type' => 'success'
                            );
                            $this->session->set_userdata('notify', $notify);
                            redirect(my_library::admin_site()."position");
                        }
                    }
                }
                $this->_data['title'] = lang('list');
                $obj = '';
                $this->_data['formSearch'] = array(
                    'fkeyword' => $_GET['fkeyword'] ?? '',
                    'fstatus' => $_GET['fstatus'] ?? 0
                );
                $and = '1';
                if ($this->_data['formSearch']['fkeyword'] != '') {
                    $and .= ' and position_name like "%' . $this->_data['formSearch']['fkeyword'] . '%"';
                }
                if ($this->_data['formSearch']['fstatus'] > 0) {
                    $and .= ' and position_status = '. $this->_data['formSearch']['fstatus'];
                }
                $orderby = 'id desc';
                $this->_data['id'] = $id;
                $this->_data['list'] = $this->mposition->getQuery($obj, $and, $orderby, "");
                $this->_data['record'] = $this->mposition->countQuery($and);
                $this->_data['fstatus'] = $this->mposition->dropdownlistStatus($this->_data['formSearch']['fstatus']);
                $this->_data['extraCss'] = ['iCheck/skins/flat/green.css'];
                $this->_data['extraJs'] = ['validator.js','icheck.min.js'];
                $this->_data['token_name'] = $this->security->get_csrf_token_name();
                $this->_data['token_value'] = $this->security->get_csrf_hash();
                $this->my_layout->view("admin/position/index", $this->_data);
            } else {
                $notify = array(
                    'title' => lang('unsuccessful'), 
                    'text' => lang('position').lang('notexists'),
                    'type' => 'error'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."position");
            }
            
        } else {
            $notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'error'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."position");
        }
    }

    public function delete($id)
    {
        $this->mpermission->checkPermission("position","delete",$this->_data['user_active']['active_user_group']);
        if (is_numeric($id) && $id > 0) {
            $myPosition = $this->mposition->getData("",array('id' => $id));
            if ($myPosition && $myPosition['id'] > 0) {
                $this->mposition->delete($id);
                $title = lang('success');
                $text = $myPosition['position_name'].lang('deleted');
                $type = 'success';
            } else {
                $title = lang('notfound');
                $text = lang('position').lang('notexists');
                $type = 'error';
            } 
        } else {
            $title = lang('notfound');
            $text = lang('wrongid');
            $type = 'error';
        }
        $notify = array(
            'title' => $title, 
            'text' => $text,
            'type' => $type
        );
        $this->session->set_userdata('notify', $notify);
        redirect(my_library::admin_site()."position");
    } 
}
