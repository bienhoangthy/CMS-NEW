<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mlink extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->Model("admin/mlink_translation");
    }
    protected $table = "cms_link";
    protected $table_translation = "cms_link_translation";

    public function getLink($lang='vietnamese')
    {
        $sql = 'select l.id,l.link,l.link_status,l.link_createdate,l.user,lt.link_name,lt.link_description from '.$this->table.' l inner join '.$this->table_translation.' lt on l.id = lt.link_id where lt.language_code = "'.$lang.'" order by l.id desc';
        $query = $this->db->query($sql);
        $list = $query->result_array();
        return $list;
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
