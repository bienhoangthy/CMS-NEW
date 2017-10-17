<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class msetting extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_setting";

    public function getSetting($obj="")
    {
    	$mySetting = $this->getData($obj,array('id' => 1));
    	return $mySetting;
    }

    public function listRatio($item = "")
    {
        $arr = array(
            169 => array(
                'w'  => 16,
                'h' => 9,
                'height' => 180
            ),
            43 => array(
                'w'  => 4,
                'h' => 3,
                'height' => 240
            ),
            11 => array(
                'w'  => 1,
                'h' => 1,
                'height' => 320
            )
        );
        if (is_numeric($item)) {
            return $arr[$item];
        } else {
            return $arr;
        }
    }

    public function dropdownlistRatio($active = '')
    {
        $html = '';
        $data = $this->listRatio();
        if ($data) {
            $html .= '<option value="0">'.lang('chooseratio').'</option>';
            foreach ($data as $key => $value) {
                $selected = $active == $key ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $key . '">' . $value["w"] . ' : ' . $value["h"] . '</option>';
            }
        } else {
            $html .= '<option value="0">Data empty</option>';
        }
        return $html;
    }
}
