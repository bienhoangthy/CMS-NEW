<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mail extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('mail',$this->_data['language']);
        $this->load->Model("admin/mactivity");
    }
	public function index($id=0)
	{
		$this->mpermission->checkPermission("mail","index",$this->_data['user_active']['active_user_group']);
        if (is_numeric($id)) {
            $orderby = 'id desc';
            $this->load->library("My_paging");
            $this->_data['title'] = lang('list');
            $obj = 'id,mail_fullname,mail_email,mail_title,mail_status,mail_type,mail_important,mail_senddate';
            $this->_data['formData'] = array(
                'fkeyword' => $_GET['fkeyword'] ?? '',
                'fstatus' => $_GET['fstatus'] ?? 0,
                'ftype' => $_GET['ftype'] ?? 0,
                'fimportant' => $_GET['fimportant'] ?? 0
            );
            $and = '1';
            if ($this->_data['formData']['fkeyword'] != '') {
                $and .= ' and (mail_fullname like "%' . $this->_data['formData']['fkeyword'] . '%"';
                $and .= ' or mail_email like "%' . $this->_data['formData']['fkeyword'] . '%"';
                $and .= ' or mail_title like "%' . $this->_data['formData']['fkeyword'] . '%")';
            }
            if ($this->_data['formData']['fstatus'] > 0) {
                $and .= ' and mail_status = '. $this->_data['formData']['fstatus'];
            }
            if ($this->_data['formData']['ftype'] > 0) {
            	if ($this->_data['formData']['ftype'] == 10) {
            		$and .= ' and mail_important = 1';
            	} else {
            		$and .= ' and mail_type = '. $this->_data['formData']['ftype'];
            	}
            }
            if ($this->_data['formData']['fimportant'] > 0) {
                $and .= ' and mail_important = '. $this->_data['formData']['fimportant'];
            }
            $paging['per_page'] = 10;
            $paging['num_links'] = 5;
            $paging['page'] = $this->_data['page'] = $_GET['page'] ?? 1;
            $paging['start'] = (($paging['page'] - 1) * $paging['per_page']);
            $query_string = '';
            $this->_data['query'] = '';
            if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']) {
                $this->_data['query'] = $_SERVER['QUERY_STRING'];
                $query_string = str_replace("&page=" . $this->_data['page'], "", $_SERVER['QUERY_STRING']);
            }
            $query_string = $this->_data['query_string'] = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? str_replace("&page=" . $this->_data['page'], "", $_SERVER['QUERY_STRING']) : '';
            $id_url = $id > 0 ? '/index/'.$id : '';
            $paging['base_url'] = my_library::admin_site() . 'mail' .$id_url. '?' . $query_string . '&page=';
            $limit = $paging['start'] . ',' . $paging['per_page'];
            $this->_data['list'] = $this->mmail->getQuery($obj, $and, $orderby, $limit);
            //My Mail
            if ($id == 0) {
                $this->_data['myMail'] = $this->mmail->getQuery("", $and, $orderby, 1);
                $this->_data['myMail'] = $this->_data['myMail'][0];
                $id = $this->_data['myMail']['id'];
            } else {
                $this->_data['myMail'] = $this->mmail->getData("",array('id' => $id));
                $id = $this->_data['myMail']['id'];
            }
            if (empty($this->_data['myMail'])) {
                $notify = array(
                    'title' => lang('notfound'), 
                    'text' => lang('mail').lang('notexists'),
                    'type' => 'error'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."mail");
                exit();
            }
            $this->_data['id'] = $id;
            //Read
            if ($this->_data['myMail']['mail_status'] == 1) {
                $dataEdit = array(
                    'mail_status' => 2,
                    'user_read' => $this->_data['user_active']['active_user_id'],
                    'readdate' => date("Y-m-d H:i:s")
                );
                $this->mmail->edit($id,$dataEdit);
            }
            //End
            $this->_data['record'] = $this->mmail->countQuery($and);
            $this->_data["pagination"] = $this->my_paging->paging_donturl($this->_data["record"], $paging['page'], $paging['per_page'], $paging['num_links'], $paging['base_url']);
            $this->_data['fstatus'] = $this->mmail->dropdownlistStatus($this->_data['formData']['fstatus']);
            $this->_data['ftype'] = $this->mmail->dropdownlistType($this->_data['formData']['ftype']);
            $this->_data['fimportant'] = $this->_data['formData']['ftype'];
            //$this->_data['extraCss'] = ['fancybox/jquery.fancybox.css'];
            $this->_data['extraJs'] = ['language/'.$this->_data['language'].'.js','module/mail.js'];
            $this->my_layout->view("admin/mail/index", $this->_data);
        } else {
            $notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'error'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."mail");
        }  
	}

	public function ajaxMailimportant()
	{
		$rs = array('success' => 0,'html' => '');
		if ($this->mpermission->permission("mail_ajaxMailimportant",$this->_data['user_active']['active_user_group']) == true) {
			$id = $this->input->get('id');
			$imp = $this->input->get('imp');
			if ($id != null && $imp != null) {
				if ($this->mmail->edit($id,array('mail_important' => $imp))) {
					$mailimportant = lang('mailimportant');
					if ($imp == 1) {
						$title = lang('cancel').' '.lang('tick').lang('mailimportant');
					} else {
						$title = lang('tick').lang('mailimportant');
					}
					$rs = array('success'=>1,'html' => $title,'mailimportant' => $mailimportant);
				} else {
					$rs = array('success' => 0,'html' => lang('edit').' '.lang('unsuccessful'));
				}
			} else {
				$rs = array('success' => 0,'html' => lang('checkinfo'));
			}
		} else {
			$rs = array('success' => 0,'html' => lang('notpermission'));
		}
		echo json_encode($rs);
	}

	public function ajaxDeletemail()
	{
		$rs = array('success' => 0,'message' => '' );
		if ($this->mpermission->permission("mail_ajaxDeletemail",$this->_data['user_active']['active_user_group']) == true) {
			$id = $this->input->get('id');
			if ($id != null) {
				$this->mmail->delete($id);
                $this->mactivity->addActivity(13,$id,3,$this->_data['user_active']['active_user_id']);
				$rs = array('success' => 1,'html' => lang('mail').lang('deleted'));
			} else {
				$rs = array('success' => 0,'html' => lang('checkinfo'));
			}
		} else {
			$rs = array('success' => 0,'html' => lang('notpermission'));
		}
		echo json_encode($rs);
	}
}
