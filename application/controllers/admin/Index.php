<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->library("user_agent");
        $this->load->helper("language");
        $this->load->Model("admin/muser");
        $this->load->Model("admin/mhistory");
        $this->load->Model("admin/mgroup");
    }

	public function login()
	{
		$user_active = $this->session->userdata('userActive');
		if ($user_active) {
			redirect(my_library::admin_site() . "home/");
		} else {
			$data['title'] = 'Login CMS';
			$data['token_name'] = $this->security->get_csrf_token_name();
			$data['token_value'] = $this->security->get_csrf_hash();
			$data['formData'] = array('username' => "",'password' => "");
			if (isset($_POST['flogin'])) {
				$data['formData']['username'] = $this->input->post('username');
				$data['formData']['password'] = $this->input->post('password');
				if ($data['formData']['username'] && $data['formData']['password']) {
					$myUser = $this->muser->getData("", array("user_username" => $data['formData']['username'], "user_password" => md5($data['formData']['password'])));
					if ($myUser && isset($myUser['id']) && is_numeric($myUser['id']) > 0) {
						if ($myUser['user_status'] == 1) {
							$group = $this->mgroup->getData('group_name,group_module',array('id' => $myUser['user_group'],'group_status' => 1));
							if (!empty($group)) {
								if ($this->agent->is_browser())
								{
								    $agent = $this->agent->browser().' '.$this->agent->version();
								}
								elseif ($this->agent->is_robot())
								{
								    $agent = $this->agent->robot();
								}
								elseif ($this->agent->is_mobile())
								{
								    $agent = $this->agent->mobile();
								}
								else
								{
								    $agent = 'Unidentified User Agent';
								}
								$module_view = array();
								$group_name = $group['group_name'];
								if ($group['group_module'] != '') {
									$module_view = unserialize($group['group_module']);
								}
								//$department_name = $this->muser->listDepartment($myUser['user_department']);
								$dataAddHistory = array(
									'history_username' => $myUser['user_username'],
									'history_group' => $group_name,
									'history_department' => $myUser['user_department'],
									'history_ip' => $_SERVER['REMOTE_ADDR'],
									'history_time' => date('Y-m-d H:i:s'),
									'history_agent' => $agent,
									'history_platform' => $this->agent->platform()
								);
								$this->mhistory->add($dataAddHistory);
								$avatar = $myUser['user_avatar'] != '' ? base_url().'media/user/'.$myUser['user_folder'].'/'.$myUser['user_avatar'] : my_library::base_public().'admin/images/user.png';
								$dataUserActive = array(
									'active_user_id' => $myUser['id'],
									'active_user_username' => $myUser['user_username'],
									'active_user_fullname' => $myUser['user_fullname'],
									'active_user_avatar' => $avatar,
									'active_user_group' => $myUser['user_group'],
									'active_user_email' => $myUser['user_email'],
									'active_user_folder' => $myUser['user_folder'],
									'active_user_module' => $module_view,
									'logged' => TRUE
								);
								$this->muser->edit($myUser['id'], array('user_updatedate' => date("Y-m-d H:i:s")));
								$notify = array(
									'title' => 'Đăng nhập thành công', 
									'text' => 'Xin chào '.$myUser['user_fullname'].'!',
									'type' => 'success'
								);
								$this->session->set_userdata('userActive', $dataUserActive);
								$this->session->set_userdata('notify', $notify);
								if ($this->input->get('redirect')) {
									redirect(base64_decode($this->input->get('redirect')));
								} else {
									redirect(my_library::admin_site() . "home/");
								}
							} else {
								$data['error'] = "Tài khoản này đã khóa!";
							}
						} else {
							$data['error'] = "Tài khoản đang bị khóa!";
						}
					} else {
						$data['error'] = "Tên đăng nhập hoặc mật khẩu không chính xác!";
					}
				} else {
					$data['error'] = "Vui lòng nhập đầy đủ thông tin!";
				}
			}
			$this->load->view("admin/index/login", $data);
		}
	}

	public function logout()
	{
		$this->session->unset_userdata("userActive");
        redirect(my_library::admin_site());
	}
}
