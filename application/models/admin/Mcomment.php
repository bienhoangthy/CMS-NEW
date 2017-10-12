<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mcomment extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_comment";

    public function editArray($id, $data) {
        $this->open();
        $this->db->where_in("id", $id);
        $this->db->update($this->table, $data);
        return true;
    }

    public function listStatusName($item = "")
    {
        $arr = array(
            1 => array(
                'name'  => lang('approved'),
                'color' => 'success'
            ),
            2 => array(
                'name'  => lang('pending'),
                'color' => 'primary'
            ),
            3 => array(
                'name'  => 'Spam',
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
}
