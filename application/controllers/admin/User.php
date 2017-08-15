<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('user',$this->_data['language']);
        $this->load->Model("admin/mgroup");
    }
    public function index()
    {
        $this->mpermission->checkPermission("user","index",$this->_data['user_active']['active_user_group']);
    	if (isset($_POST['delAll'])) {
            $this->mpermission->checkPermission("user","deleteall",$this->_data['user_active']['active_user_group']);
			$listDel = $this->input->post('table_records');
            $countDel = 0;
			if (!empty($listDel)) {
                foreach ($listDel as $key => $value) {
                    $myUser = $this->muser->getData("id,user_folder",array('id' => $value));
                    if ($myUser && $myUser['id'] > 1) {
                        $this->muser->delete($myUser['id']);
                        $this->muser->delavatar($myUser['user_folder']);
                        $countDel++;
                    }
                }
            }
            if ($countDel > 0) {
                    $notify = array(
                    'title' => lang('success'), 
                    'text' => $countDel.' user'.lang('deleted'),
                    'type' => 'success'
                );
            } else {
                $notify = array(
                    'title' => lang('unsuccessful'), 
                    'text' => lang('nondelete'),
                    'type' => 'warning'
                );
            }
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."user");
		}
    	$this->load->library("My_paging");
    	$this->_data['title'] = lang('list');
    	$this->_data['formData'] = array(
    		'fkeyword' => isset($_GET['fkeyword']) ? $_GET['fkeyword'] : '',
    		'fstatus' => isset($_GET['fstatus']) ? $_GET['fstatus'] : 0,
    		'fgroup' => isset($_GET['fgroup']) ? $_GET['fgroup'] : 0,
    		'fperpage' => isset($_GET['fperpage']) ? $_GET['fperpage'] : 10
    	);
    	$and = '1';
    	if ($this->_data['formData']['fkeyword'] != '') {
    		$and .= ' and (user_username like "%' . $this->_data['formData']['fkeyword'] . '%"';
			$and .= ' or user_fullname like "%' . $this->_data['formData']['fkeyword'] . '%"';
			$and .= ' or user_email like "%' . $this->_data['formData']['fkeyword'] . '%"';
			$and .= ' or user_phone like "%' . $this->_data['formData']['fkeyword'] . '%"';
			$and .= ' or user_address like "%' . $this->_data['formData']['fkeyword'] . '%")';
    	}
    	if ($this->_data['formData']['fstatus'] > 0) {
    		$and .= ' and user_status = '. $this->_data['formData']['fstatus'];
    	}
    	if ($this->_data['formData']['fgroup'] > 0) {
    		$and .= ' and user_group = '. $this->_data['formData']['fgroup'];
    	}
		$paging['per_page'] = $this->_data['formData']['fperpage'];
		$paging['num_links'] = 5;
		$paging['page'] = $this->_data['page'] = isset($_GET['page']) && $_GET['page'] ? $_GET['page'] : 1;
		$paging['start'] = (($paging['page'] - 1) * $paging['per_page']);
		$query_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? str_replace("&page=" . $this->_data['page'], "", $_SERVER['QUERY_STRING']) : '';
		$paging['base_url'] = my_library::admin_site() . 'user/?' . $query_string . '&page=';

		$orderby = 'user_status asc,user_group asc';
		$limit = $paging['start'] . ',' . $paging['per_page'];
		$this->_data['list'] = $this->muser->getQuery($object = "", $and, $orderby, $limit);
		$this->_data['record'] = $this->muser->countQuery($and);
		$this->_data["pagination"] = $this->my_paging->paging_donturl($this->_data["record"], $paging['page'], $paging['per_page'], $paging['num_links'], $paging['base_url']);

		$this->_data['fstatus'] = $this->muser->dropdownlistStatus($this->_data['formData']['fstatus']);
		$this->_data['fgroup'] = $this->mgroup->dropdownlist($this->_data['formData']['fgroup']);
		$this->_data['extraCss'] = ['iCheck/skins/flat/green.css'];
		$this->_data['extraJs'] = ['icheck.min.js'];
		$this->_data['token_name'] = $this->security->get_csrf_token_name();
		$this->_data['token_value'] = $this->security->get_csrf_hash();
    	$this->my_layout->view("admin/user/index", $this->_data);
    }

    public function add()
    {
        $this->mpermission->checkPermission("user","add",$this->_data['user_active']['active_user_group']);
    	$this->_data['title'] = lang('adduser');
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
        $this->_data['formData'] = array(
            'user_username' => '',
            'user_fullname' => '', 
            'user_gender' => 1, 
            'user_birthday' => date("Y-m-d"), 
            'user_avatar' => '', 
            'user_email' => '', 
            'user_phone' => '', 
            'user_address' => '', 
            'user_introduction' => '', 
            'user_group' => 0, 
            'user_status' => 1, 
            'user_department' => 0
        );
        if (isset($_POST['user_username'])) {
            $fullname = $this->input->post('user_fullname');
            $username = $this->input->post('user_username');
            $email = $this->input->post('user_email');
            $checkUsername = $this->muser->getData('user_username', array('user_username' => trim($username)));
            $checkEmail = $this->muser->getData('user_email', array('user_email' => trim($email)));
            $pass = $this->input->post('user_password');
            $re_pass = $this->input->post('re-password');
            $group = $this->input->post('user_group');
            $error = false;
            $this->_data['formData'] = array(
                'user_username' => $username,
                'user_fullname' => $fullname, 
                'user_gender' => $this->input->post('user_gender'), 
                'user_birthday' => date("Y-m-d",strtotime($this->input->post('user_birthday'))),
                'user_avatar' => '', 
                'user_email' => $email, 
                'user_phone' => $this->input->post('user_phone'), 
                'user_address' => $this->input->post('user_address'), 
                'user_introduction' => $this->input->post('user_introduction'), 
                'user_group' => $group, 
                'user_status' => $this->input->post('user_status'), 
                'user_department' => $this->input->post('user_department')
            );
            do {
                if ($fullname == null) {
                    $text = lang('pleaseinput').lang('fullname');$error = true;break;
                }
                if ($username == null) {
                    $text = lang('pleaseinput').'username!';$error = true;break;
                }
                if (!empty($checkUsername)) {
                    $text = 'Username'.lang('exists');$error = true;break;
                }
                if ($email == null) {
                    $text = lang('pleaseinput').'email!';$error = true;break;
                }
                if (!empty($checkEmail)) {
                    $text = 'Email'.lang('exists');$error = true;break;
                }
                if ($pass == null || $pass != $re_pass) {
                    $text = lang('checkpass');$error = true;break;
                }
                if (strlen($pass) < 6) {
                    $text = lang('passshort');$error = true;break;
                }
                if ($group < 1) {
                    $text = lang('pleasechoose').lang('group');$error = true;break;
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
                $this->_data['formData']['user_password'] = md5($pass);
                $this->_data['formData']['user_avatar'] = '';
                $this->_data['formData']['user_createdate'] = date("Y-m-d H:i:s");
                $this->_data['formData']['user_updatedate'] = date("Y-m-d H:i:s");
                $this->_data['formData']['user_folder'] = '';
                $this->_data['formData']['user'] = $this->_data['user_active']['active_user_id'];
                $insert = $this->muser->add($this->_data['formData']);
                if (is_numeric($insert) > 0) {
                    $folder_name = $insert.$username;
                    $this->muser->create_folder($folder_name);
                    $upload_avatar = $this->muser->do_upload($folder_name);
                    $avatar = $upload_avatar ? $upload_avatar['file_name'] : '';
                    $this->muser->edit($insert, array("user_avatar" => $avatar,"user_folder" => $folder_name));
                    $notify = array(
                        'title' => lang('success'), 
                        'text' => $username.lang('added'),
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    redirect(my_library::admin_site()."user/profile/".$insert);
                }
            }
        }
        $this->_data['action'] = 1;//Add
        $this->_data['user_department'] = $this->muser->dropdownlistDepartment($this->_data['formData']['user_department']);
        $this->_data['user_group'] = $this->mgroup->dropdownlist($this->_data['formData']['user_group']);
    	$this->_data['extraCss'] = ['iCheck/skins/flat/green.css','bootstrap-datepicker.css'];
		$this->_data['extraJs'] = ['validator.js','bootstrap-datepicker.min.js','icheck.min.js','module/user.js'];
    	$this->my_layout->view("admin/user/post", $this->_data);
    }

    public function edit($id)
    {
        $this->mpermission->checkPermission("user","edit",$this->_data['user_active']['active_user_group']);
        if (is_numeric($id) && $id > 0) {
            $myUser = $this->muser->getData("",array('id' => $id));
            if ($myUser && $myUser['id'] > 0) {
                $this->_data['title'] = lang('edituser')." #".$id;
                $this->_data['token_name'] = $this->security->get_csrf_token_name();
                $this->_data['token_value'] = $this->security->get_csrf_hash();
                $avatar = $myUser['user_avatar'] != '' ? base_url().'media/user/'.$myUser['user_folder'].'/'.$myUser['user_avatar'] : '';
                $this->_data['formData'] = array(
                    'user_username' => $myUser['user_username'],
                    'user_fullname' => $myUser['user_fullname'], 
                    'user_gender' => $myUser['user_gender'], 
                    'user_birthday' => $myUser['user_birthday'], 
                    'user_avatar' => $avatar, 
                    'user_email' => $myUser['user_email'], 
                    'user_phone' => $myUser['user_phone'], 
                    'user_address' => $myUser['user_address'], 
                    'user_introduction' => $myUser['user_introduction'], 
                    'user_group' => $myUser['user_group'], 
                    'user_status' => $myUser['user_status'], 
                    'user_department' => $myUser['user_department']
                );
                if (isset($_POST['user_email'])) {
                    $fullname = $this->input->post('user_fullname');
                    $email = $this->input->post('user_email');
                    $checkEmail = $this->muser->getData('user_email', array('user_email' => trim($email)));
                    if ($this->input->post('checkchangePass') == 1) {
                        $pass = $this->input->post('user_password');
                        $re_pass = $this->input->post('re-password');
                    }
                    $group = $this->input->post('user_group');
                    $error = false;
                    $this->_data['formData'] = array(
                        'user_username' => $myUser['user_username'],
                        'user_fullname' => $fullname, 
                        'user_gender' => $this->input->post('user_gender'), 
                        'user_birthday' => date("Y-m-d",strtotime($this->input->post('user_birthday'))),
                        'user_avatar' => '', 
                        'user_email' => $email, 
                        'user_phone' => $this->input->post('user_phone'), 
                        'user_address' => $this->input->post('user_address'), 
                        'user_introduction' => $this->input->post('user_introduction'), 
                        'user_group' => $group, 
                        'user_status' => $this->input->post('user_status'), 
                        'user_department' => $this->input->post('user_department')
                    );
                    do {
                        if ($fullname == null) {
                            $text = lang('pleaseinput').lang('fullname');$error = true;break;
                        }
                        if ($email == null) {
                            $text = lang('pleaseinput').'email!';$error = true;break;
                        }
                        if (!empty($checkEmail) && $email != $myUser['user_email']) {
                            $text = 'Email'.lang('exists');$error = true;break;
                        }
                        if ($this->input->post('checkchangePass') == 1) {
                            if ($pass == null || $pass != $re_pass) {
                                $text = lang('checkpass');$error = true;break;
                            }
                            if (strlen($pass) < 6) {
                                $text = lang('passshort');$error = true;break;
                            }
                        }
                        if ($group < 1) {
                            $text = lang('pleasechoose').lang('group');$error = true;break;
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
                        $pass = $this->input->post('checkchangePass') == 1 ? md5($pass) : $myUser['user_password'];
                        $avatar = $myUser['user_avatar'];
                        if (isset($_FILES['user_avatar']) && $_FILES['user_avatar']['name'] != "") {
                            $upload_avatar = $this->muser->do_upload($myUser['user_folder']);
                            if ($upload_avatar) {
                                $avatar = $upload_avatar['file_name'];
                                $this->muser->delimage($myUser['user_folder'],$myUser['user_avatar']);
                            }
                        }
                        $dataEdit = array(
                            'user_password' => $pass,
                            'user_fullname' => $this->_data['formData']['user_fullname'],
                            'user_gender' => $this->_data['formData']['user_gender'],
                            'user_birthday' => $this->_data['formData']['user_birthday'],
                            'user_avatar' => $avatar,
                            'user_email' => $this->_data['formData']['user_email'],
                            'user_phone' => $this->_data['formData']['user_phone'],
                            'user_address' => $this->_data['formData']['user_address'],
                            'user_introduction' => $this->_data['formData']['user_introduction'],
                            'user_group' => $this->_data['formData']['user_group'],
                            'user_status' => $this->_data['formData']['user_status'],
                            'user_department' => $this->_data['formData']['user_department'],
                            'user' => $this->_data['user_active']['active_user_id']
                        );
                        if ($this->muser->edit($id,$dataEdit)) {
                                $notify = array(
                                'title' => lang('success'), 
                                'text' => $myUser['user_username'].lang('edited'),
                                'type' => 'success'
                            );
                            $this->session->set_userdata('notify', $notify);
                            redirect(my_library::admin_site()."user/profile/".$id);
                        }
                    }
                }
                $this->_data['action'] = 2;//Edit
                $this->_data['user_department'] = $this->muser->dropdownlistDepartment($this->_data['formData']['user_department']);
                $this->_data['user_group'] = $this->mgroup->dropdownlist($this->_data['formData']['user_group']);
                $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','bootstrap-datepicker.css'];
                $this->_data['extraJs'] = ['validator.js','bootstrap-datepicker.min.js','icheck.min.js','module/user.js'];
                $this->my_layout->view("admin/user/post", $this->_data);
            } else {
                $notify = array(
                    'title' => lang('unsuccessful'), 
                    'text' => 'User'.lang('notexists'),
                    'type' => 'warning'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."user");
            }
        } else {
            $notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'warning'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."user");
        }
    }

    public function profile($id)
    {
        if ($this->_data['user_active']['active_user_id'] != $id) {
            $this->mpermission->checkPermission("user","profile",$this->_data['user_active']['active_user_group']);
        }
    	if (is_numeric($id) && $id > 0) {
    		$this->_data['myUser'] = $this->muser->getData("",array('id' => $id));
    		if ($this->_data['myUser'] && $this->_data['myUser']['id'] > 0) {
    			if (isset($_POST['old_password'])) {
    				$oldPass = $this->input->post('old_password');
    				$newPass = $this->input->post('new_password');
    				$renewPass = $this->input->post('renew_password');
    				$error = false;
    				do {
		                if (md5($oldPass) != $this->_data['myUser']['user_password']) {
		                    $text = lang('passwrong');$error = true;break;
		                }
		                if ($newPass == null || $newPass != $renewPass) {
		                    $text = lang('checkpass');$error = true;break;
		                }
		                if (strlen($newPass) < 6) {
		                    $text = lang('passshort');$error = true;break;
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
		            	if ($this->muser->edit($id,array('user_password' => md5($newPass)))) {
                                $notify = array(
                                'title' => lang('success'), 
                                'text' => $this->_data['myUser']['user_username'].lang('changepass'),
                                'type' => 'success'
                            );
                            $this->session->set_userdata('notify', $notify);
                            redirect(my_library::admin_site()."user/profile/".$id);
                        }
		            }
		            
    			}
    			$this->_data['title'] = lang('profileuser').' #'.$id;
    			$this->_data['token_name'] = $this->security->get_csrf_token_name();
                $this->_data['token_value'] = $this->security->get_csrf_hash();
    			$this->_data['extraJs'] = ['validator.js'];
        		$this->my_layout->view("admin/user/profile", $this->_data);
    		} else {
    			$notify = array(
                    'title' => lang('unsuccessful'),
                    'text' => 'User'.lang('notexists'),
                    'type' => 'warning'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."user");
    		}
    	} else {
    		$notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'warning'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."user");
    	}
    }

    public function delete($id)
    {
        $this->mpermission->checkPermission("user","delete",$this->_data['user_active']['active_user_group']);
        if (is_numeric($id) && $id != 1) {
            $myUser = $this->muser->getData("",array('id' => $id));
            if ($myUser && $myUser['id'] > 0) {
                $this->muser->delete($id);
                $this->muser->delavatar($myUser['user_folder']);
                $title = lang('success');
                $text = $myUser['user_username'].lang('deleted');
                $type = 'success';
            } else {
                $title = lang('unsuccessful');
                $text = 'User'.lang('notexists');
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
        redirect(my_library::admin_site()."user");
    }    
}
