<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mactivity extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->Model("admin/msetting");
    }
    protected $table = "cms_activity";

    public function addActivity($component,$id_com,$active,$user_id)
    {
        $mySetting = $this->msetting->getSetting("component_log");
        if ($mySetting['component_log'] != '') {
            $allow_log = unserialize($mySetting['component_log']);
            if (in_array($component, $allow_log)) {
                $dataAdd = array(
                    'activity_component' => $component,
                    'activity_id_com' => $id_com,
                    'activity_action' => $active,
                    'activity_user' => $user_id,
                    'activity_ip' => $this->input->ip_address(),
                    'activity_datetime' => date("Y-m-d H:i:s")
                );
                $this->add($dataAdd);
            }
        }
    }

    public function clear()
    {
    	$this->db->empty_table($this->table);
    }

    public function listAction($item = "")
    {
        $arr = array(
            1 => array(
                'name'  => lang('add'),
                'color' => 'success'
            ),
            2 => array(
                'name'  => lang('edit'),
                'color' => 'primary'
            ),
            3 => array(
                'name'  => lang('delete'),
                'color' => 'danger'
            ),
            4 => array(
                'name'  => lang('quickedit'),
                'color' => 'info'
            ),
            5 => array(
                'name'  => lang('draft'),
                'color' => 'default'
            ),
            6 => array(
                'name'  => lang('pending'),
                'color' => 'primary'
            ),
            7 => array(
                'name'  => lang('publish'),
                'color' => 'success'
            ),
            8 => array(
                'name'  => lang('unpublished'),
                'color' => 'danger'
            )
        );
        if (is_numeric($item)) {
            return $arr[$item];
        } else {
            return $arr;
        }
    }

    public function dropdownlistAction($active = '')
    {
        $html = '';
        $data = $this->listAction();
        if ($data) {
            $html .= '<option value="all">-- '.lang('chooseaction').' --</option>';
            foreach ($data as $key => $value) {
                $selected = $active == $key ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $key . '">- ' . $value["name"] . '</option>';
            }
        } else {
            $html .= '<option value="0">Data empty</option>';
        }
        return $html;
    }

}
