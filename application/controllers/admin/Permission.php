<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Permission extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('permission',$this->_data['language']);
    }
    public function index()
    {
        $this->mpermission->checkPermission("permission","index",$this->_data['user_active']['active_user_group']);
        $this->load->Model("admin/maction");
        $this->load->Model("admin/mgroup");
        $this->_data['title'] = lang('list');
        $this->_data['formSearch'] = array(
            'fkeyword' => isset($_GET['fkeyword']) ? $_GET['fkeyword'] : '',
            'fgroup' => isset($_GET['fgroup']) ? $_GET['fgroup'] : 0
        );
        $and = '1';
        if ($this->_data['formSearch']['fkeyword'] != '') {
            $and .= ' and (action_name like "%' . $this->_data['formSearch']['fkeyword'] . '%"';
            $and .= ' or action_value like "%' . $this->_data['formSearch']['fkeyword'] . '%")';
        }
        $andGroup = "group_status = 1";
        if ($this->_data['formSearch']['fgroup'] > 0) {
            $andGroup .= " and id = ".$this->_data['formSearch']['fgroup'];
        }
        $this->_data['listAction'] = $this->maction->getQuery("", $and, "action_value asc","");
        $this->_data['record'] = $this->maction->countQuery($and);
        $this->_data['listGroup'] = $this->mgroup->getQuery("id,group_name",$andGroup,"","");
        $this->_data['fgroup'] = $this->mgroup->dropdownlist($this->_data['formSearch']['fgroup']);
        $this->_data['extraCss'] = ['switchery.min.css'];
        $this->_data['extraJs'] = ['switchery.min.js','language/'.$this->_data['language'].'.js','module/permission.js'];
        $this->my_layout->view("admin/permission/index", $this->_data);
    }

    public function ajaxEnablePer()
    {
        $this->mpermission->checkPermission("permission","ajaxEnablePer",$this->_data['user_active']['active_user_group']);
        $rs = "no";
        $group_id = $this->input->get('group_id');
        $action_value = $this->input->get('action_value');
        $myPermission = $this->mpermission->getData("id,permission_status",array('action_value' => $action_value, 'group_id' => $group_id));
        if ($myPermission && $myPermission['id'] > 0) {
            if ($this->mpermission->edit($myPermission['id'],array('permission_status' => 1))) {
                $rs = "ok";
            }
            
        } else {
            $dataAdd = array(
                'action_value' => $action_value, 
                'group_id' => $group_id, 
                'permission_status' => 1
            );
            $insert = $this->mpermission->add($dataAdd);
            if (is_numeric($insert) > 0) {
                $rs = "ok";
            }
        }
        echo $rs;
    }

    public function ajaxDisabalePer()
    {
        $this->mpermission->checkPermission("permission","ajaxDisabalePer",$this->_data['user_active']['active_user_group']);
        $rs = "ok";
        $group_id = $this->input->get('group_id');
        $action_value = $this->input->get('action_value');
        $myPermission = $this->mpermission->getData("id,permission_status",array('action_value' => $action_value, 'group_id' => $group_id));
        if ($myPermission && $myPermission['id'] > 0) {
            if ($this->mpermission->edit($myPermission['id'],array('permission_status' => 0))) {
                $rs = "ok";
            } else {
                $rs = "no";
            }
        }
        echo $rs;
    }
}
