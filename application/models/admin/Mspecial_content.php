<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mspecial_content extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->Model("admin/mspecial_content_translation");
    }
    protected $table = "cms_special_content";
    protected $table_translation = "cms_special_content_translation";

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
            $html .= '<option value="0">'.lang('choosestatus').'</option>';
            foreach ($data as $key => $value) {
                $selected = $active == $key ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $key . '">- ' . $value["name"] . '</option>';
            }
        } else {
            $html .= '<option value="0">Data empty</option>';
        }
        return $html;
    }

    public function listSOrderBy($item = "")
    {
        $arr = array(
            1 => array(
                'name'  => lang('latest'),
                'color' => 'primary'
            ),
            2 => array(
                'name'  => lang('oldest'),
                'color' => 'info'
            ),
            3 => array(
                'name'  => lang('hot'),
                'color' => 'danger'
            ),
            4 => array(
                'name'  => lang('mostview'),
                'color' => 'success'
            ),
            5 => array(
                'name'  => lang('chooseitem'),
                'color' => 'warning'
            ),
            6 => array(
                'name'  => lang('code').'html',
                'color' => 'info'
            )
        );
        if (is_numeric($item)) {
            return $arr[$item];
        } else {
            return $arr;
        }
    }

    public function dropdownlistOrderBy($active = '')
    {
        $html = '';
        $data = $this->listSOrderBy();
        if ($data) {
            $html .= '<option value="0">'.lang('chooseitem').'</option>';
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
