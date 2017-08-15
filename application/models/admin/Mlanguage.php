<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mlanguage extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_language";

    public function getLanguage($item = '')
    {
        if ($item === '') {
            $listLanguage = $this->getQuery("lang_name,lang_code,lang_flag", "lang_staus = 1", "","");
            return $listLanguage;
        } else {
            $language = $this->getData("lang_name,lang_code,lang_flag",array('lang_code' => $item,'lang_staus' => 1));
            if (empty($language)) {
                $language = array('lang_name' => lang('showall'), 'lang_code' => 'show_all', 'lang_flag' => '');
            }
            return $language;
        }
    }

    public function dropdownlist($item = '',$listLanguage = array())
    {
        $html = '';
        if (!empty($listLanguage)) {
            foreach ($listLanguage as $key => $value) {
                $selected = $item == $value['lang_code'] ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $value["lang_code"] . '">' . $value["lang_name"] . '</option>';
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
            $html .= '<option value="0">-- '.lang('choosestatus').' --</option>';
            foreach ($data as $key => $value) {
                $selected = $active == $key ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $key . '">- ' . $value["name"] . '</option>';
            }
        } else {
            $html .= '<option value="0">Data empty</option>';
        }
        return $html;
    }

    public function do_upload($file_name,$delold = false)
    {
        $this->load->library('upload');
        $folder = realpath(APPPATH . "../media/language/");
        if ($delold == true) {
        	$link_icon = $folder.'/'.$file_name;
	        if (file_exists($link_icon)) {
	            unlink($link_icon);
	        }
        }
        $config['upload_path']          = $folder;
        $config['allowed_types']        = 'jpg|png|swf';
        $config['max_size']             = 1000;
        $config['file_name'] = $file_name;
        $this->upload->initialize($config);
        if ( ! $this->upload->do_upload('lang_flag'))
        {
            $error = array('error' => $this->upload->display_errors());
        }
        else
        {
            $data = $this->upload->data();
            return $data;
        }
    }

    public function delete_flag($file_name)
    {
        $folder = realpath(APPPATH . "../media/language/");
        $link_icon_flag = $folder.'/'.$file_name;
        if (file_exists($link_icon_flag)) {
            unlink($link_icon_flag);
        }
    }
}
