<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mpermission extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_permission";

    public function checkPermissionModule($module,$listModule = array())
    {
        $myModule = $this->mmodule->getData("id",array('module_component' => $module));
        if (!$myModule || !in_array($myModule['id'],$listModule)) {
            redirect(base_url() . 'non-permission');
        }
    }

    public function checkPermission($controller,$resource,$id_group)
    {
    	$action_value = $controller.'_'.$resource;
    	$per = $this->getData("id",array('action_value' => $action_value, 'group_id' => $id_group, 'permission_status' => 1));
    	if (!$per) {
    		redirect(base_url() . 'non-permission');
    	}
    }

    public function permission($action_value,$id_group)
    {
    	$per = $this->getData("id",array('action_value' => $action_value, 'group_id' => $id_group, 'permission_status' => 1));
    	if ($per) {
    		return true;
    	} else {
    		return false;
    	}
    }
}