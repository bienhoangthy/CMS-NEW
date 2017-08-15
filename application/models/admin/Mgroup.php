<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mgroup extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_group";

    public function dropdownlist($item = '')
    {
        $html = '';
        $data = $this->mgroup->getQuery("id,group_name", "group_status = 1", "", "");
        if ($data) {
            $html .= '<option value="0"> -- '.lang('choosegroup').' -- </option>';
            foreach ($data as $key => $value) {
                $selected = $item == $value['id'] ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $value["id"] . '">' . $value["group_name"] . '</option>';
            }
        }
        return $html;
    }

    public function listStatusName($item = "")
    {
        $arr = array(
            1 => array(
                'name'  => lang('active'),
                'color' => 'success'
            ),
            2 => array(
                'name'  => lang('inactive'),
                'color' => 'danger'
            )
        );
        if (is_numeric($item)) {
            return $arr[$item];
        } else {
            return $arr;
        }
    }

    public function dropdownlistStatus($active = '')
    {
        $html = '';
        $data = $this->listStatusName();
        if ($data) {
            $html .= '<option value="all">-- '.lang('choosestatus').' --</option>';
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
