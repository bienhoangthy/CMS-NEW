<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mmail extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_mail";

    // public function listMailUnread()
    // {
    //     $listMailUnread = $this->getQuery("id,mail_fullname,mail_email,mail_title,mail_senddate","mail_status = 1","","0,5");
    //     return $listMailUnread;
    // }

    public function countUnread()
    {
        $sql = 'select count(*) as total from '.$this->table.' where mail_status = 1';
        $query = $this->db->query($sql);
        $total = $query->row_array();
        return $total['total'];
    }

    public function listStatusName($item = "")
    {
        $arr = array(
            1 => array(
                'name'  => lang('unread'),
                'color' => 'success'
            ),
            2 => array(
                'name'  => lang('read'),
                'color' => 'default'
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

    public function listType($item = "")
    {
        $arr = array(
            1 => array(
                'name'  => lang('mailfeedback'),
                'icon' => 'fa-comment'
            ),
            2 => array(
                'name'  => lang('mailregister'),
                'icon' => 'fa-bell'
            )
        );
        if (is_numeric($item)) {
            return $arr[$item];
        } else {
            return $arr;
        }
    }

    public function dropdownlistType($active = '')
    {
        $html = '';
        $data = $this->listType();
        if ($data) {
            $html .= '<option value="0">'.lang('choosetype').'</option>';
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
