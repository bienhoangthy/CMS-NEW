<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mbanner extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->Model("admin/mbanner_translation");
        $this->load->Model("admin/mposition");
    }
    protected $table = "cms_banner";
    protected $table_translation = "cms_banner_translation";

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
                'name'  => 'IMAGE',
                'color' => 'primary'
            ),
            2 => array(
                'name'  => 'HTML',
                'color' => 'info'
            ),
            3 => array(
                'name'  => 'IFRAME',
                'color' => 'success'
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

    public function dropdownlistPosition($active = '')
    {
        $html = '';
        $data = $this->mposition->getQuery("","position_status = 1","","");
        if ($data) {
            $html .= '<option value="0">'.lang('chooseposition').'</option>';
            foreach ($data as $value) {
                $selected = $active == $value['id'] ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $value['id'] . '">'.$value["position_name"].' ('.$value["position_width"].'px x '.$value["position_height"].'px)'.'</option>';
            }
        } else {
            $html .= '<option value="0">Data empty</option>';
        }
        return $html;
    }

    public function do_resize($source_path,$target_path)
    {
        if ($source_path != '' && $target_path != '') {
            $config_resize = array(
                'image_library' => 'gd2',
                'source_image' => $source_path,
                'new_image' => $target_path,
                'maintain_ratio' => TRUE,
                'create_thumb' => TRUE,
                'width' => 320
            );
            $this->load->library('image_lib', $config_resize);
            if (!$this->image_lib->resize()) {
                echo $this->image_lib->display_errors();
            }
            $this->image_lib->clear();
        }
    }

    public function uploadBanner($id,$filename)
    {
        $path = realpath(APPPATH . "../media/banner/".$id."/");
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
            chmod($path, 0777);
        }
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = $filename;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload()){
            $data = array('upload_data' => $this->upload->data());
            $this->do_resize($path.$filename,$path);
        }
        //$this->upload->do_upload();
    }

    public function delimage($id,$image_name)
    {
        $link_image = realpath(APPPATH . "../media/banner/")."/".$id."/".$image_name;
        //$link_image_thumb = realpath(APPPATH . "../media/banner/")."/".$id.'/thumb-'.$image_name;
        if (file_exists($link_image)) {
            unlink($link_image);
        }
        // if (file_exists($link_image_thumb)) {
        //     unlink($link_image_thumb);
        // }
    }
}
