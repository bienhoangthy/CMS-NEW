<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Comment extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('comment',$this->_data['language']);
        $this->load->Model("admin/mcomment");
    }
	public function index()
	{
        if (isset($_POST['fsubmit'])) {
            $operation = $this->input->post('fsubmit');
            $listComment = $this->input->post('table_records');
            if ($listComment != null && !empty($listComment)) {
                switch ($operation) {
                    case 1:
                        $this->mpermission->checkPermission("comment","approval",$this->_data['user_active']['active_user_group']);
                        if ($this->mcomment->editArray($listComment,array('comment_status' => 1,'user' => $this->_data['user_active']['active_user_id']))) {
                            $notify = array(
                                'title' => lang('success'), 
                                'text' => count($listComment).' '.lang('comment').' '.lang('approved'),
                                'type' => 'success'
                            );
                        }
                        break;

                    case 2:
                        $this->mpermission->checkPermission("comment","pending",$this->_data['user_active']['active_user_group']);
                        if ($this->mcomment->editArray($listComment,array('comment_status' => 2,'user' => 0))) {
                            $notify = array(
                                'title' => lang('success'), 
                                'text' => count($listComment).' '.lang('comment').' '.lang('pending'),
                                'type' => 'success'
                            );
                        }
                        break;

                    case 3:
                        $this->mpermission->checkPermission("comment","spam",$this->_data['user_active']['active_user_group']);
                        if ($this->mcomment->editArray($listComment,array('comment_status' => 3,'user' => $this->_data['user_active']['active_user_id']))) {
                            $notify = array(
                                'title' => lang('success'), 
                                'text' => count($listComment).' '.lang('comment').' spam',
                                'type' => 'success'
                            );
                        }
                        break;

                    case 5:
                        $this->mpermission->checkPermission("comment","delete",$this->_data['user_active']['active_user_group']);
                        $this->mcomment->delete($listComment);
                        $notify = array(
                            'title' => lang('success'), 
                            'text' => count($listComment).' '.lang('comment').lang('deleted'),
                            'type' => 'success'
                        );
                        break;
                    
                    default:
                        $notify = array(
                            'title' => lang('unsuccessful'), 
                            'text' => lang('checkinfo'),
                            'type' => 'error'
                        );
                        break;
                }
            }
            if ($notify) {
                $this->session->set_userdata('notify', $notify);
            }
            redirect(my_library::admin_site()."comment");
        }
		$this->mpermission->checkPermission("comment","index",$this->_data['user_active']['active_user_group']);
        $this->load->Model("admin/mcomponent");
        $this->load->helper('text');
		$this->load->library("My_paging");
        $this->_data['title'] = lang('title');
        $obj = '';
        $this->_data['formData'] = array(
            'fkeyword' => $_GET['fkeyword'] ?? '',
            'fcom' => $_GET['fcom'] ?? '',
            'fstatus' => $_GET['fstatus'] ?? 0,
            'fuser' => $_GET['fuser'] ?? 0
        );
        $and = 'comment_parent = 0';
        if ($this->_data['formData']['fkeyword'] != '') {
            $and .= ' and comment_content like "%' . $this->_data['formData']['fkeyword'] . '%"';
        }
        if ($this->_data['formData']['fcom'] != '') {
            $and .= ' and comment_component = "'. $this->_data['formData']['fcom'].'"';
        }
        if ($this->_data['formData']['fstatus'] > 0) {
            $and .= ' and comment_status = '. $this->_data['formData']['fstatus'];
        }
        if ($this->_data['formData']['fuser'] > 0) {
            $and .= ' and user = '. $this->_data['formData']['fuser'];
        }
        $orderby = 'id desc';
        $paging['per_page'] = 20;
        $paging['num_links'] = 5;
        $paging['page'] = $this->_data['page'] = $_GET['page'] ?? 1;
        $paging['start'] = (($paging['page'] - 1) * $paging['per_page']);
        $query_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? str_replace("&page=" . $this->_data['page'], "", $_SERVER['QUERY_STRING']) : '';
        $paging['base_url'] = my_library::admin_site() . 'comment/?' . $query_string . '&page=';
        $limit = $paging['start'] . ',' . $paging['per_page'];
        $this->_data['list'] = $this->mcomment->getQuery($obj, $and, $orderby, $limit);
        $this->_data['record'] = $this->mcomment->countQuery($and);
        $this->_data["pagination"] = $this->my_paging->paging_donturl($this->_data["record"], $paging['page'], $paging['per_page'], $paging['num_links'], $paging['base_url']);
        $this->_data['fstatus'] = $this->mcomment->dropdownlistStatus($this->_data['formData']['fstatus']);
        $this->_data['fuser'] = $this->muser->dropdownlistUser($this->_data['formData']['fuser']);
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
        $this->_data['fcom'] = $this->mcomponent->dropdownlist($this->_data['formData']['fcom'],1);
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css'];
        $this->_data['extraJs'] = ['icheck.min.js','module/comment.js'];
        $this->my_layout->view("admin/comment/index", $this->_data);
	}

    public function ajaxOperation()
    {
        $rs = array('status' => 0,'message' => '');
        $id = $this->input->get('id');
        $operation = $this->input->get('operation');
        if ($id != null && $operation != null) {
            if ($operation == 1) {
                if ($this->mpermission->permission("comment_approval",$this->_data['user_active']['active_user_group']) == true) {
                    if ($this->mcomment->edit($id,array('comment_status' => 1,'user' => $this->_data['user_active']['active_user_id']))) {
                        $status = $this->mcomment->listStatusName(1);
                        $user = $this->muser->getData("user_fullname","id = ".$this->_data['user_active']['active_user_id']);
                        $rs = array('status' => 1,'message' => lang('comment').' #'.$id.' '.lang('approved'));
                        $rs = array_merge($rs,$status,$user);
                    } else {
                        $rs = array('status' => 0,'message' => lang('checkinfo'));
                    }
                } else {
                    $rs = array('status' => 0,'message' => lang('notpermission'));
                }
            } else {
                if ($this->mpermission->permission("comment_spam",$this->_data['user_active']['active_user_group']) == true) {
                    if ($this->mcomment->edit($id,array('comment_status' => 3,'user' => $this->_data['user_active']['active_user_id']))) {
                        $status = $this->mcomment->listStatusName(3);
                        $user = $this->muser->getData("user_fullname","id = ".$this->_data['user_active']['active_user_id']);
                        $rs = array('status' => 1,'message' => lang('comment').' #'.$id.' spam');
                        $rs = array_merge($rs,$status,$user);
                    } else {
                        $rs = array('status' => 0,'message' => lang('checkinfo'));
                    }
                } else {
                    $rs = array('status' => 0,'message' => lang('notpermission'));
                }
            }
        } else {
            $rs = array('status' => 0,'message' => lang('checkinfo'));
        }
        echo json_encode($rs);
    }

    public function ajaxDelete()
    {
        $rs = array('status' => 0,'message' => '');
        $id = $this->input->get('id');
        if ($id != null) {
            if ($this->mpermission->permission("comment_delete",$this->_data['user_active']['active_user_group']) == true) {
                $this->mcomment->delete($id);
                $rs = array('status' => 1,'message' => lang('comment').' #'.$id.lang('deleted'));
            } else {
                $rs = array('status' => 0,'message' => lang('notpermission'));
            }
        } else {
            $rs = array('status' => 0,'message' => lang('checkinfo'));
        }
        echo json_encode($rs);
    }
}
