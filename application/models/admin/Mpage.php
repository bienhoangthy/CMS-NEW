<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mpage extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->Model("admin/mpage_translation");
    }
    protected $table = "cms_page";
    protected $table_translation = "cms_page_translation";

    public function getPage($lang='vietnamese')
    {
        $sql = 'select p.id,p.page_template,p.page_status,p.page_updatedate,p.user,pt.id as page_id,pt.page_title,pt.page_alias from '.$this->table.' p inner join '.$this->table_translation.' pt on p.id = pt.page_id where pt.language_code = "'.$lang.'" order by p.page_orderby asc, p.id desc';
        $query = $this->db->query($sql);
        $list = $query->result_array();
        return $list;
    }

    public function listTemplate($item = "")
    {

        $arr = array(
            1 => array(
                'name'  => lang('home'),
                'file' => 'home-view'
            ),
            2 => array(
                'name'  => lang('intro'),
                'file' => 'intro-view'
            ),
            3 => array(
                'name'  => lang('contact'),
                'file' => 'contact-view'
            )
        );
        if (is_numeric($item)) {
            return $arr[$item];
        } else {
            return $arr;
        }
    }

    public function dropdownlistTemplate($active = '')
    {
        $html = '';
        $data = $this->listTemplate();
        if ($data) {
            $html .= '<option value="0">-- '.lang('choosetemplate').' --</option>';
            foreach ($data as $key => $value) {
                $selected = $active == $key ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $key . '">- ' . $value["name"] . '</option>';
            }
        } else {
            $html .= '<option value="0">Data empty</option>';
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

    public function do_resize($source_path,$target_path)
    {
        if ($source_path != '' && $target_path != '') {
            $config_resize = array(
                'image_library' => 'gd2',
                'source_image' => $source_path,
                'new_image' => $target_path,
                'maintain_ratio' => TRUE,
                'create_thumb' => TRUE,
                'width' => 320,
                'height' => 180
            );
            $this->load->library('image_lib', $config_resize);
            if (!$this->image_lib->resize()) {
                echo $this->image_lib->display_errors();
            }
            $this->image_lib->clear();
        }
    }

    public function saveImage($file,$alias)
    {
        $rs = '';
        $file = str_replace('data:image/jpeg;base64,', '', $file);
        $file = str_replace(' ', '+', $file);
        $fileData = base64_decode($file);
        $name = $alias.time().".jpeg";
        $fileName = realpath(APPPATH . "../media/page/")."/".$name;
        $transFile = file_put_contents($fileName, $fileData);
        if ($transFile != false) {
            $this->do_resize($fileName,realpath(APPPATH . "../media/page/"));
            $rs = $name;
        }
        return $rs;
    }

    public function delimage($image_name)
    {
        $link_image = realpath(APPPATH . "../media/page/")."/".$image_name;
        $link_image_thumb = realpath(APPPATH . "../media/page/").'/thumb-'.$image_name;
        if (file_exists($link_image)) {
            unlink($link_image);
        }
        if (file_exists($link_image_thumb)) {
            unlink($link_image_thumb);
        }
    }
}
