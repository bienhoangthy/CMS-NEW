<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mnews extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->Model("admin/mnews_translation");
    }
    protected $table = "cms_news";
    protected $table_translation = "cms_news_translation";

    public function getNews($obj='',$and='',$orderby='',$limit='')
    {
        if ($obj) {
            $obj = $obj;
        } else {
            $obj = '*';
        }
        $sql = 'select '.$obj.' from '.$this->table.' n inner join '.$this->table_translation.' nt on n.id = nt.news_id where '.$and.' order by '.$orderby;
        if ($limit) {
            $sql .= ' limit ' . $limit;
        }
        $query = $this->db->query($sql);
        return $query->result_array();
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

    public function listState($item = "")
    {
        $arr = array(
            1 => array(
                'name'  => lang('draft'),
                'color' => 'default'
            ),
            2 => array(
                'name'  => lang('pending'),
                'color' => 'danger'
            ),
            3 => array(
                'name'  => lang('publish'),
                'color' => 'success'
            )
        );
        if (is_numeric($item)) {
            return $arr[$item];
        } else {
            return $arr;
        }
    }

    public function dropdownlistState($active = '')
    {
        $html = '';
        $data = $this->listState();
        if ($data) {
            $html .= '<option value="all">-- '.lang('choosestate').' --</option>';
            foreach ($data as $key => $value) {
                $selected = $active == $key ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $key . '">- ' . $value["name"] . '</option>';
            }
        } else {
            $html .= '<option value="0">Data empty</option>';
        }
        return $html;
    }

    // public function listType($item = "")
    // {
    //     $arr = array(
    //         1 => array(
    //             'name'  => lang('tlist'),
    //             'color' => 'primary'
    //         ),
    //         2 => array(
    //             'name'  => lang('detail'),
    //             'color' => 'info'
    //         )
    //     );
    //     if (is_numeric($item)) {
    //         return $arr[$item];
    //     } else {
    //         return $arr;
    //     }
    // }

    // public function dropdownlistType($active = '')
    // {
    //     $html = '';
    //     $data = $this->listType();
    //     if ($data) {
    //         foreach ($data as $key => $value) {
    //             $selected = $active == $key ? 'selected' : '';
    //             $html .= '<option ' . $selected . ' value="' . $key . '">' . $value["name"] . '</option>';
    //         }
    //     } else {
    //         $html .= '<option value="0">Data empty</option>';
    //     }
    //     return $html;
    // }

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
        $fileName = realpath(APPPATH . "../media/news/")."/".$name;
        $transFile = file_put_contents($fileName, $fileData);
        if ($transFile != false) {
            $this->do_resize($fileName,realpath(APPPATH . "../media/news/"));
            $rs = $name;
        }
        return $rs;
    }

    public function delimage($image_name)
    {
        $link_image = realpath(APPPATH . "../media/news/")."/".$image_name;
        $link_image_thumb = realpath(APPPATH . "../media/news/").'/thumb-'.$image_name;
        if (file_exists($link_image)) {
            unlink($link_image);
        }
        if (file_exists($link_image_thumb)) {
            unlink($link_image_thumb);
        }
    }
}
