<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mcomponent extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_component";

    public function dropdownlist($item = '')
    {
        $html = '';
        $data = $this->getQuery("component_name,component", "component_status = 1", "", "");
        if ($data) {
            $html .= '<option value=""> -- '.lang('choose').' component -- </option>';
            foreach ($data as $key => $value) {
                $selected = $item == $value['component'] ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $value["component"] . '">' . $value["component_name"] . ' - ' . $value["component"] .'</option>';
            }
        }
        return $html;
    }
}
