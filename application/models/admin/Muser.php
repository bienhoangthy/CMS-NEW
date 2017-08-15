<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class muser extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->_file_url = base_url() . "/media/user/";
        $this->_file_path = realpath(APPPATH . "../media/user");
    }
    protected $table = "cms_user";

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

    public function listDepartment($item = "")
    {
        $arr = array(
            1 => array(
                'name'  => lang('director')
            ),
            2 => array(
                'name'  => lang('hr')
            ),
            3 => array(
                'name'  => lang('accountant')
            ),
            4 => array(
                'name'  => lang('business')
            ),
            5 => array(
                'name'  => lang('technical')
            )
        );
        if (is_numeric($item)) {
            return $arr[$item];
        } else {
            return $arr;
        }
    }

    public function dropdownlistDepartment($active = '')
    {
        $html = '';
        $data = $this->listDepartment();
        if ($data) {
            $html .= '<option value="0">-- '.lang('choosedepertment').' --</option>';
            foreach ($data as $key => $value) {
                $selected = $active == $key ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $key . '">- ' . $value["name"] . '</option>';
            }
        } else {
            $html .= '<option value="0">Data empty</option>';
        }
        return $html;
    }

    public function create_folder($folder_name)
    {
        $folder = $this->_file_path.'/'.$folder_name;
        if (!is_dir($folder)) {
            mkdir($folder, 0777);
            chmod($folder, 0777);
        }
    }

    public function do_upload($folder_name)
    {
        $this->load->library('upload');
        $folder = $this->_file_path.'/'.$folder_name.'/';
        $config['upload_path']          = $folder;
        $config['allowed_types']        = 'gif|jpg|png|swf';
        $config['max_size']             = 2000;
        $config['max_width']             = 1000;
        $config['max_height']             = 1000;
        $this->upload->initialize($config);
        if ( ! $this->upload->do_upload('user_avatar'))
        {
            $error = array('error' => $this->upload->display_errors());
        }
        else
        {
            $data = $this->upload->data();
            return $data;
        }
    }

    public function delavatar($folder_name)
    {
        $folder = $this->_file_path.'/'.$folder_name;
        $this->delFolder($folder);
    }

    public function delimage($folder_name,$image_name)
    {
        $link_image = $this->_file_path.'/'.$folder_name.'/'.$image_name;
        if (file_exists($link_image)) {
            unlink($link_image);
        }
    }
}
