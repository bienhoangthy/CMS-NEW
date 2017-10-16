<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mcomponent extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_component";

    public function dropdownlist($item = '',$use=0)
    {
        $html = '';
        $and = "component_status = 1";
        if ($use > 0) {
            $and .= " and component_use = ".$use;
        }
        $data = $this->getQuery("component_name,component", $and, "", "");
        if ($data) {
            $html .= '<option value="">'.lang('choose').' component</option>';
            foreach ($data as $value) {
                $selected = $item == $value['component'] ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $value["component"] . '">- ' . $value["component_name"] . ' - ' . $value["component"] .'</option>';
            }
        }
        return $html;
    }

    public function dropdownlistID($item = '',$use=0)
    {
        $html = '';
        $and = "component_status = 1";
        if ($use > 0) {
            $and .= " and component_use = ".$use;
        }
        $data = $this->getQuery("id,component_name,component", $and, "", "");
        if ($data) {
            $html .= '<option value="">'.lang('choose').' component</option>';
            foreach ($data as $value) {
                $selected = $item == $value['id'] ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $value["id"] . '">- ' . $value["component_name"] . ' - ' . $value["component"] .'</option>';
            }
        }
        return $html;
    }

    public function whereIn($obj='',$ids)
    {
        if ($obj) {
            $obj = $obj;
        } else {
            $obj = '*';
        }
        $sql = 'select '.$obj.' from '.$this->table.' where id in('.$ids.') order by id asc';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
