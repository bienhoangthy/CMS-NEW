<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mvideo extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->Model("admin/mvideo_translation");
    }
    protected $table = "cms_video";
    protected $table_translation = "cms_video_translation";

    public function getVideo($obj='',$and='',$orderby='',$limit='')
    {
        if ($obj) {
            $obj = $obj;
        } else {
            $obj = '*';
        }
        $sql = 'select '.$obj.' from '.$this->table.' v inner join '.$this->table_translation.' vt on v.id = vt.video_id where '.$and.' order by '.$orderby;
        if ($limit) {
            $sql .= ' limit ' . $limit;
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function whereIn($obj='',$ids='',$language='vietnamese')
    {
        if ($obj) {
            $obj = $obj;
        } else {
            $obj = '*';
        }
        $sql = 'select '.$obj.' from '.$this->table.' v inner join '.$this->table_translation.' vt on v.id = vt.video_id where v.id in('.$ids.') and vt.language_code = "'.$language.'" order by v.id desc';
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function countVideo($and='')
    {
        $sql = 'select count(*) as total from '.$this->table.' v inner join '.$this->table_translation.' vt on v.id = vt.video_id where '.$and;
        $query = $this->db->query($sql);
        $total = $query->row_array();
        return $total['total'];
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

    public function saveImage($file,$id,$alias)
    {
        $rs = '';
        $file = str_replace('data:image/jpeg;base64,', '', $file);
        $file = str_replace(' ', '+', $file);
        $fileData = base64_decode($file);
        $name = $alias.time().".jpeg";
        $folderName = realpath(APPPATH . "../media/video/")."/".$id;
        if (!is_dir($folderName)) {
            mkdir($folderName, 0777, true);
            chmod($folderName, 0777);
        }
        $fileName = $folderName."/".$name;
        $transFile = file_put_contents($fileName, $fileData);
        if ($transFile != false) {
            $this->do_resize($fileName,$folderName);
            $rs = $name;
        }
        return $rs;
    }

    public function delimage($id,$image_name)
    {
        $link_image = realpath(APPPATH . "../media/video/")."/".$id."/".$image_name;
        $link_image_thumb = realpath(APPPATH . "../media/video/")."/".$id.'/thumb-'.$image_name;
        if (file_exists($link_image)) {
            unlink($link_image);
        }
        if (file_exists($link_image_thumb)) {
            unlink($link_image_thumb);
        }
    }
}
