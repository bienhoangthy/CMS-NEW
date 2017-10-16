<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Activity extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('activity',$this->_data['language']);
        $this->load->Model("admin/mcomponent");
        $this->load->Model("admin/mactivity");
    }
	public function index()
	{
        if (isset($_POST['fsubmit'])) {
            if ($this->mpermission->permission("activity_delete",$this->_data['user_active']['active_user_group']) == true) {
                $listID = $this->input->post('table_records');
                if (!empty($listID)) {
                    $this->mactivity->delete($listID);
                    $notify = array(
                        'title' => lang('success'), 
                        'text' => count($listID).' '.lang('activity').lang('deleted'),
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
            redirect(my_library::admin_site()."activity");
        }
		$this->mpermission->checkPermission("activity","index",$this->_data['user_active']['active_user_group']);
		$this->load->library("My_paging");
        $this->_data['title'] = lang('title');
        $obj = '';
        $this->_data['formData'] = array(
            'fcomponent' => $_GET['fcomponent'] ?? 0,
            'faction' => $_GET['faction'] ?? 0,
            'fuser' => $_GET['fuser'] ?? 0
        );
        $and = '1';
        if ($this->_data['formData']['fcomponent'] > 0) {
            $and .= ' and activity_component = '. $this->_data['formData']['fcomponent'];
        }
        if ($this->_data['formData']['faction'] > 0) {
            $and .= ' and activity_action = '. $this->_data['formData']['faction'];
        }
        if ($this->_data['formData']['fuser'] > 0) {
            $and .= ' and activity_user = '. $this->_data['formData']['fuser'];
        }
        $orderby = 'id desc';
        $paging['per_page'] = 20;
        $paging['num_links'] = 5;
        $paging['page'] = $this->_data['page'] = $_GET['page'] ?? 1;
        $paging['start'] = (($paging['page'] - 1) * $paging['per_page']);
        $query_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? str_replace("&page=" . $this->_data['page'], "", $_SERVER['QUERY_STRING']) : '';
        $paging['base_url'] = my_library::admin_site() . 'activity/?' . $query_string . '&page=';
        $limit = $paging['start'] . ',' . $paging['per_page'];
        $this->_data['list'] = $this->mactivity->getQuery($obj, $and, $orderby, $limit);
        $this->_data['record'] = $this->mactivity->countQuery($and);
        $this->_data["pagination"] = $this->my_paging->paging_donturl($this->_data["record"], $paging['page'], $paging['per_page'], $paging['num_links'], $paging['base_url']);

        $this->_data['fcomponent'] = $this->mcomponent->dropdownlistID($this->_data['formData']['fcomponent']);
        $this->_data['faction'] = $this->mactivity->dropdownlistAction($this->_data['formData']['faction']);
        $this->_data['fuser'] = $this->muser->dropdownlistUser($this->_data['formData']['fuser']);

        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
        
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css'];
        $this->_data['extraJs'] = ['icheck.min.js','module/activity.js'];
        $this->my_layout->view("admin/activity/index", $this->_data);
	}

    public function clearall()
    {
        if ($this->mpermission->permission("activity_clearall",$this->_data['user_active']['active_user_group']) == true) {
            $this->mactivity->clear();
            $notify = array(
                'title' => lang('success'), 
                'text' => lang('activitydeleted'),
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
        redirect(my_library::admin_site()."activity");
    }
}
