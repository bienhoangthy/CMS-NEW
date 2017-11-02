<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->library("user_agent");
        $this->load->Model("admin/muser");
        $this->load->Model("admin/mhistory");
        $this->load->Model("admin/mgroup");
        $this->load->Model("admin/msetting");
    }

	public function login()
	{
		$user_active = $this->session->userdata('userActive');
		if ($user_active) {
			redirect(my_library::admin_site() . "home");
		} else {
			$data['title'] = 'Đăng nhập CMS';
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
							$group = $this->mgroup->getData('group_module',array('id' => $myUser['user_group'],'group_status' => 1));
							if (!empty($group)) {
								//History Login
								$mySetting = $this->msetting->getSetting("write_history_login");
								if ($mySetting['write_history_login'] == 1) {
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
									$dataAddHistory = array(
										'history_user_id' => $myUser['id'],
										'history_group' => $myUser['user_group'],
										'history_department' => $myUser['user_department'],
										'history_ip' => $this->input->ip_address(),
										'history_time' => date('Y-m-d H:i:s'),
										'history_agent' => $agent,
										'history_platform' => $this->agent->platform()
									);
									$this->mhistory->add($dataAddHistory);
								}
								//End
								$module_view = array();
								if ($group['group_module'] != '') {
									$module_view = unserialize($group['group_module']);
								}
								$avatar = $myUser['user_avatar'] != '' ? base_url().'media/user/'.$myUser['user_folder'].'/thumb-'.$myUser['user_avatar'] : my_library::base_public().'admin/images/user.png';
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
									redirect(my_library::admin_site() . "home");
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

	public function lock()
	{
		$user_active = $data['user_active'] = $this->session->userdata('userActive');
		if ($user_active) {
			if ($user_active['logged'] == TRUE) {
				$user_active['logged'] = FALSE;
				$this->session->unset_userdata("userActive");
				$this->session->set_userdata('userActive', $user_active);
				redirect(my_library::admin_site() . "index/lock");
			} else {
				if (isset($_POST['password'])) {
					$password = $this->input->post('password');
					if ($password != null) {
						$myUser = $this->muser->getData("id,user_password,user_status", array("id" => $user_active['active_user_id']));
						if ($myUser && isset($myUser['id']) && is_numeric($myUser['id']) > 0) {
							if ($myUser['user_status'] == 1) {
								if ($myUser['user_password'] == md5($password)) {
									$user_active['logged'] = TRUE;
									$this->session->unset_userdata("userActive");
									$this->session->set_userdata('userActive', $user_active);
									$notify = array(
										'title' => 'Thành công', 
										'text' => 'Chào mừng quay trở lại '.$user_active['active_user_fullname'].'!',
										'type' => 'success'
									);
									$this->session->set_userdata('notify', $notify);
									redirect(my_library::admin_site() . "home");
								} else {
									$data['error'] = "Mật khẩu không chính xác!";
								}
							} else {
								$data['error'] = "Tài khoản đã bị khóa!";
							}
						} else {
							$data['error'] = "Tài khoản không tồn tại!";
						}
					} else {
						$data['error'] = "Vui lòng nhập mật khẩu!";
					}
				}
				$data['title'] = 'Khóa CMS';
				$data['token_name'] = $this->security->get_csrf_token_name();
				$data['token_value'] = $this->security->get_csrf_hash();
				$this->load->view("admin/index/lock", $data);
			}
		} else {
			redirect(my_library::admin_site());
		}
	}

	public function forgot()
	{
		$user_active = $this->session->userdata('userActive');
		if ($user_active) {
			redirect(my_library::admin_site() . "home");
		} else {
			$data['title'] = 'Quên mật khẩu CMS';
			$data['formData'] = array(
				'email' => ''
			);
			if (isset($_POST['fsend'])) {
				$email = $this->input->post('email');
				if ($email == null || $email == '') {
					$data['error'] = "Vui lòng nhập email!";
				} else {
					$myUser = $data['myUser'] = $this->muser->getData("",array('user_email' => $email));
					if ($myUser && isset($myUser['id']) && is_numeric($myUser['id']) > 0) {
						if ($myUser['user_status'] == 1) {
							$tempPass = md5(uniqid());
							$content = '<p>Dear '.$myUser['user_fullname'].',</p><p>Tài khoản '.$myUser['user_username'].' của bạn yêu cầu đổi mật khẩu.</p><p>Vui lòng <a href="'.my_library::admin_site().'index/reset_password/'.$myUser['id'].'/'.$tempPass.'">nhấn vào đây</a> để đổi mật khẩu mới!</p><p>Cảm ơn bạn đã sử dụng CMS</p><p>ITS Group</p>';
							if ($this->sendmail($email,"","Đổi mật khẩu tài khoản CMS ITS Group",$content) == TRUE) {
								if ($this->muser->edit($myUser['id'],array('user_reset_pass' => $tempPass))) {
									$data['success'] = "Thành công, vui lòng kiểm tra email!";
								} else {
									$data['error'] = "Không cập nhật được tài khoản!";
								}
							} else {
								$data['error'] = "Hệ thống không thể gửi email!";
							}
						} else {
							$data['error'] = "Tài khoản đang bị khóa!";
						}
					} else {
						$data['error'] = "Tài khoản không tồn tại!";
					}
				}
			}
			$data['token_name'] = $this->security->get_csrf_token_name();
			$data['token_value'] = $this->security->get_csrf_hash();
			$this->load->view("admin/index/forgot", $data);
		}
	}

	public function reset_password($id,$reset_pass)
	{
		if ($id != null && $reset_pass != null) {
			$myUser = $data['myUser'] = $this->muser->getData("",array('id' => $id));
			if ($myUser) {
				if (isset($myUser['user_reset_pass']) && $myUser['user_reset_pass'] == $reset_pass) {
					if (isset($_POST['fchange'])) {
						$newpass = $this->input->post('password');
						$re_newpass = $this->input->post('re-password');
						$error = false;
						do {
							if ($newpass == null) {
								$data['error'] = "Vui lòng nhập mật khẩu mới!";$error = true;break;
							}
							if ($re_newpass == null) {
								$data['error'] = "Vui lòng nhập lại mật khẩu!";$error = true;break;
							}
							if ($newpass != $re_newpass) {
								$data['error'] = "Mật khẩu không trùng khớp!";$error = true;break;
							}
							if (md5($newpass) == $myUser['user_password']) {
								$data['error'] = "Hãy đặt mật khẩu mới khác mật khẫu cũ!";$error = true;break;
							}
						} while (0);
						if ($error == false) {
							if ($this->muser->edit($id,array('user_password' => md5($newpass),'user_reset_pass' => null))) {
								redirect(my_library::admin_site() . "index/login");
							} else {
								$data['error'] = "Không thể đổi mật khẩu!";
							}
						}
					}
					$data['title'] = 'Đổi mật khẩu mới CMS';
					$data['token_name'] = $this->security->get_csrf_token_name();
					$data['token_value'] = $this->security->get_csrf_hash();
					$this->load->view("admin/index/changpass", $data);
				}
			}
		}
	}

	public function sendmail($to,$cc,$subject,$content)
    {
        $this->load->Model("admin/msetting");
        $mySetting = $this->msetting->getSetting("email,alias,smtp_user,smtp_server,smtp_password,smtp_port,smtp_use_ssl");
        $configMail = Array(
            'protocol' => 'smtp',
            'smtp_host' => $mySetting['smtp_server'],
            'smtp_port' => $mySetting['smtp_port'],
            'smtp_user' => $mySetting['smtp_user'],
            'smtp_pass' => $mySetting['smtp_password'],
            'mailtype'  => 'html', 
            'charset'   => 'utf-8'
        );
        $this->load->library('email', $configMail);
        $this->email->set_newline("\r\n");

        $this->email->from($mySetting['email'], $mySetting['alias']);
        $this->email->to($to);
        if ($cc != '') {
            $this->email->cc($cc);
        }
        $this->email->subject($subject);
        $this->email->message($content);

        $result = $this->email->send();
        return $result;
    }
}
