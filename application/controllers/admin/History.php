<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class History extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('history',$this->_data['language']);
        $this->load->Model("admin/mgroup");
        $this->load->Model("admin/mhistory");
    }
	public function index()
	{
        if (isset($_POST['fsubmit'])) {
            if ($this->mpermission->permission("history_delete",$this->_data['user_active']['active_user_group']) == true) {
                $listID = $this->input->post('table_records');
                if (!empty($listID)) {
                    $this->mhistory->delete($listID);
                    $notify = array(
                        'title' => lang('success'), 
                        'text' => count($listID).' '.lang('history').lang('deleted'),
                        'type' => 'success'
                    );
                } else {
                    $notify = array(
                        'title' => lang('unsuccessful'), 
                        'text' => lang('checkinfo'),
                        'type' => 'error'
                    );
                }
            } else {
                $notify = array(
                    'title' => lang('unsuccessful'), 
                    'text' => lang('notpermission'),
                    'type' => 'error'
                );
            }
            if ($notify) {
                $this->session->set_userdata('notify', $notify);
            }
            redirect(my_library::admin_site()."history");
        }
		$this->mpermission->checkPermission("history","index",$this->_data['user_active']['active_user_group']);
		$this->load->library("My_paging");
        $this->_data['title'] = lang('title');
        $obj = '';
        $this->_data['formData'] = array(
            'fuser' => $_GET['fuser'] ?? 0,
            'fgroup' => $_GET['fgroup'] ?? 0,
            'fdepartment' => $_GET['fdepartment'] ?? 0
        );
        $and = '1';
        if ($this->_data['formData']['fuser'] > 0) {
            $and .= ' and history_user_id = '. $this->_data['formData']['fuser'];
        }
        if ($this->_data['formData']['fgroup'] > 0) {
            $and .= ' and history_group = '. $this->_data['formData']['fgroup'];
        }
        if ($this->_data['formData']['fdepartment'] > 0) {
            $and .= ' and history_department = '. $this->_data['formData']['fdepartment'];
        }
        
        $orderby = 'id desc';
        $paging['per_page'] = 20;
        $paging['num_links'] = 5;
        $paging['page'] = $this->_data['page'] = $_GET['page'] ?? 1;
        $paging['start'] = (($paging['page'] - 1) * $paging['per_page']);
        $query_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? str_replace("&page=" . $this->_data['page'], "", $_SERVER['QUERY_STRING']) : '';
        $paging['base_url'] = my_library::admin_site() . 'history/?' . $query_string . '&page=';
        $limit = $paging['start'] . ',' . $paging['per_page'];
        $this->_data['list'] = $this->mhistory->getQuery($obj, $and, $orderby, $limit);
        $this->_data['record'] = $this->mhistory->countQuery($and);
        $this->_data["pagination"] = $this->my_paging->paging_donturl($this->_data["record"], $paging['page'], $paging['per_page'], $paging['num_links'], $paging['base_url']);

        $this->_data['fuser'] = $this->muser->dropdownlistUser($this->_data['formData']['fuser']);
        $this->_data['fgroup'] = $this->mgroup->dropdownlist($this->_data['formData']['fgroup']);
        $this->_data['fdepartment'] = $this->muser->dropdownlistDepartment($this->_data['formData']['fdepartment']);

        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
        
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css'];
        $this->_data['extraJs'] = ['icheck.min.js','module/history.js'];
        $this->my_layout->view("admin/history/index", $this->_data);
	}

    public function clearall()
    {
        if ($this->mpermission->permission("history_clearall",$this->_data['user_active']['active_user_group']) == true) {
            $this->mhistory->clear();
            $notify = array(
                'title' => lang('success'), 
                'text' => lang('historydeleted'),
                'type' => 'success'
            );
        } else {
            $notify = array(
                'title' => lang('unsuccessful'), 
                'text' => lang('notpermission'),
                'type' => 'error'
            );
        }
        if ($notify) {
            $this->session->set_userdata('notify', $notify);
        }
        redirect(my_library::admin_site()."history");
    }
}
