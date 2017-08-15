<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mcategory extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->Model("admin/mcategory_translation");
    }
    protected $table = "cms_category";
    protected $table_translation = "cms_category_translation";

    public function getCategory($lang='vietnamese')
    {
        $select = 'c.id,c.category_component,c.category_status,c.category_updatedate,c.category_status,c.user,ct.category_name,ct.category_alias';
        $sql = 'select '.$select.' from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.category_id where c.category_parent = 0 and ct.language_code = "'.$lang.'" order by c.category_orderby asc,c.id asc';
        $query = $this->db->query($sql);
        $list = $query->result_array();
        foreach ($list as $key => $value) {
            $sqlsub = 'select '.$select.' from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.category_id where c.category_parent = '.$value['id'].' and ct.language_code = "'.$lang.'" order by c.category_orderby asc,c.id asc';
            $querysub = $this->db->query($sqlsub);
            $list_lv2 = $querysub->result_array();
            if (!empty($list_lv2)) {
                foreach ($list_lv2 as $k => $val) {
                    $sqlsub_sub = 'select '.$select.' from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.category_id where c.category_parent = '.$val['id'].' and ct.language_code = "'.$lang.'" order by c.category_orderby asc,c.id asc';
                    $querysub_sub = $this->db->query($sqlsub_sub);
                    $list_lv3 = $querysub_sub->result_array();
                    if (!empty($list_lv3)) {
                        $list_lv2[$k]['sub_subcate'] = $list_lv3;
                    }
                }
                $list[$key]['subcate'] = $list_lv2;
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
