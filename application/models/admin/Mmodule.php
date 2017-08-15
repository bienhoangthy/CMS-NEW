<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mmodule extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->Model("admin/mmodule_translation");
    }
    protected $table = "cms_module";
    protected $table_translation = "cms_module_translation";

    public function getModule($lang='vietnamese')
    {
        $sql = 'select m.id,m.module_component,m.module_action,m.module_icon,m.module_status,mt.module_name from '.$this->table.' m inner join '.$this->table_translation.' mt on m.id = mt.module_id where m.module_parent = 0 and m.module_status = 1 and mt.language_code = "'.$lang.'" order by m.module_orderby asc,m.id asc';
        $query = $this->db->query($sql);
        $list = $query->result_array();
        foreach ($list as $key => $value) {
            $sqlsub = 'select m.id,m.module_component,m.module_action,m.module_status,mt.module_name from '.$this->table.' m inner join '.$this->table_translation.' mt on m.id = mt.module_id where m.module_parent = '.$value['id'].' and m.module_status = 1 and mt.language_code = "'.$lang.'" order by m.module_orderby asc,m.id asc';
            $querysub = $this->db->query($sqlsub);
            $list_lv2 = $querysub->result_array();
            if (!empty($list_lv2)) {
                $list[$key]['submodule'] = $list_lv2;
            }
        }
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
