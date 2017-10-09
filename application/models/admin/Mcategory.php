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

    public function getCategory($lang='vietnamese',$status = 0)
    {
        $andStatus = ' ';
        if ($status > 0) {
            $andStatus = ' c.category_status = '.$status.' and ';
        }
        $select = 'c.id,c.category_component,c.category_status,c.category_updatedate,c.category_status,c.user,ct.category_name,ct.category_alias';
        $sql = 'select '.$select.' from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.category_id where'.$andStatus.'c.category_parent = 0 and ct.language_code = "'.$lang.'" order by c.category_orderby asc,c.id asc';
        $query = $this->db->query($sql);
        $list = $query->result_array();
        foreach ($list as $key => $value) {
            $sqlsub = 'select '.$select.' from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.category_id where'.$andStatus.'c.category_parent = '.$value['id'].' and ct.language_code = "'.$lang.'" order by c.category_orderby asc,c.id asc';
            $querysub = $this->db->query($sqlsub);
            $list_lv2 = $querysub->result_array();
            if (!empty($list_lv2)) {
                foreach ($list_lv2 as $k => $val) {
                    $sqlsub_sub = 'select '.$select.' from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.category_id where'.$andStatus.'c.category_parent = '.$val['id'].' and ct.language_code = "'.$lang.'" order by c.category_orderby asc,c.id asc';
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

    public function dropdownlistCategory($active=0,$lang='vietnamese',$component='')
    {
        $and = ' c.category_status = 1';
        if ($component != '') {
            $and .= ' and c.category_component = "'.$component.'"';
        }
        $select = 'c.id,c.category_component,ct.category_name';
        $sql = 'select '.$select.' from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.category_id where'.$and.' and c.category_parent = 0 and ct.language_code = "'.$lang.'" order by c.category_orderby asc,c.id asc';
        $query = $this->db->query($sql);
        $list = $query->result_array();
        $html = '<option value="0">'.lang('choosecate').'</option>';
        $selected = $active == 1 ? 'selected' : '';
        $html .= '<option '.$selected.' value="1">- '.lang('uncategorized').'</option>';
        if (!empty($list)) {
            foreach ($list as $value) {
                $selected = $active == $value['id'] ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $value['id'] . '">- ' . $value["category_name"] . ' ('.$value['category_component'].')' . '</option>';
                //Sub
                $sqlsub = 'select '.$select.' from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.category_id where'.$and.' and c.category_parent = '.$value['id'].' and ct.language_code = "'.$lang.'" order by c.category_orderby asc,c.id asc';
                $querysub = $this->db->query($sqlsub);
                $list_lv2 = $querysub->result_array();
                if (!empty($list_lv2)) {
                    foreach ($list_lv2 as $val) {
                        $selected = $active == $val['id'] ? 'selected' : '';
                        $html .= '<option ' . $selected . ' value="' . $val['id'] . '">-- ' . $val["category_name"] . ' ('.$val['category_component'].')' . '</option>';
                        //Sub-sub
                        $sqlsub_sub = 'select '.$select.' from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.category_id where'.$and.' and c.category_parent = '.$val['id'].' and ct.language_code = "'.$lang.'" order by c.category_orderby asc,c.id asc';
                        $querysub_sub = $this->db->query($sqlsub_sub);
                        $list_lv3 = $querysub_sub->result_array();
                        if (!empty($list_lv3)) {
                            foreach ($list_lv3 as $v) {
                                $selected = $active == $v['id'] ? 'selected' : '';
                                $html .= '<option ' . $selected . ' value="' . $v['id'] . '">---- ' . $v["category_name"] . ' ('.$v['category_component'].')' . '</option>';
                            }
                        }
                    }
                }
            }
        } else {
            $html = '<option value="0">'.lang('listempty').'</option>';
        }
        return $html;
    }

    // public function getOther($lang='',$component='')
    // {
    //     $and = ' c.category_status = 1';
    //     if ($component != '') {
    //         $and .= ' and c.category_component = "'.$component.'"';
    //     }
    //     $select = 'c.id,ct.category_name';
    //     $sql = 'select '.$select.' from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.category_id where'.$and.' and c.category_parent = 0 and ct.language_code = "'.$lang.'" order by c.category_orderby asc,c.id asc';
    //     $query = $this->db->query($sql);
    //     $list = $query->result_array();
    //     foreach ($list as $key => $value) {
    //         $sqlsub = 'select '.$select.' from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.category_id where'.$and.' and c.category_parent = '.$value['id'].' and ct.language_code = "'.$lang.'" order by c.category_orderby asc,c.id asc';
    //         $querysub = $this->db->query($sqlsub);
    //         $list_lv2 = $querysub->result_array();
    //         if (!empty($list_lv2)) {
    //             foreach ($list_lv2 as $k => $val) {
    //                 $sqlsub_sub = 'select '.$select.' from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.category_id where'.$and.' and c.category_parent = '.$val['id'].' and ct.language_code = "'.$lang.'" order by c.category_orderby asc,c.id asc';
    //                 $querysub_sub = $this->db->query($sqlsub_sub);
    //                 $list_lv3 = $querysub_sub->result_array();
    //                 if (!empty($list_lv3)) {
    //                     $list_lv2[$k]['sub_subcate'] = $list_lv3;
    //                 }
    //             }
    //             $list[$key]['subcate'] = $list_lv2;
    //         }
    //     }
    //     return $list;
    // }

    // public function dropdownlistCategory($active=0,$lang='vietnamese',$component='')
    // {
    //     $html = '';
    //     $list = $this->getOther($lang,$component);
    //     if ($list) {
    //         $html .= '<option value="all">-- '.lang('choosecate').' --</option>';
    //         foreach ($data as $value) {
    //             $selected = $active == $value['id'] ? 'selected' : '';
    //             $html .= '<option ' . $selected . ' value="' . $value['id'] . '">- ' . $value["category_name"] . '</option>';
    //             if (isset($value['subcate'])) {
    //                 foreach ($value['subcate'] as $val) {
    //                     $selected = $active == $val['id'] ? 'selected' : '';
    //                     $html .= '<option ' . $selected . ' value="' . $val['id'] . '">-- ' . $val["category_name"] . '</option>';
    //                     if (isset($val['sub_subcate'])) {
    //                         foreach ($val['sub_subcate'] as $v) {
    //                             $selected = $active == $v['id'] ? 'selected' : '';
    //                             $html .= '<option ' . $selected . ' value="' . $v['id'] . '">-- ' . $v["category_name"] . '</option>';
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     } else {
    //         $html .= '<option value="0">Data empty</option>';
    //     }
    //     return $html;
    // }

    public function selectParent($lang="vietnamese",$item = "")
    {
        $html = '<option value="0">-- '.lang('chooseparent').' --</option>';
        $select = 'c.id,ct.category_name';
        $sql = 'select '.$select.' from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.category_id where c.category_parent = 0 and ct.language_code = "'.$lang.'" order by c.category_orderby asc,c.id asc';
        $query = $this->db->query($sql);
        $list = $query->result_array();
        foreach ($list as $key => $value) {
            $selected = $item == $value['id'] ? 'selected' : '';
            $html .= '<option ' . $selected . ' value="' . $value['id'] . '">- ' . $value["category_name"] . '</option>';
            $sqlsub = 'select '.$select.' from '.$this->table.' c inner join '.$this->table_translation.' ct on c.id = ct.category_id where c.category_parent = '.$value['id'].' and ct.language_code = "'.$lang.'" order by c.category_orderby asc,c.id asc';
            $querysub = $this->db->query($sqlsub);
            $list_lv2 = $querysub->result_array();
            if (!empty($list_lv2)) {
                foreach ($list_lv2 as $key => $val) {
                    $selected = $item == $val['id'] ? 'selected' : '';
                    $html .= '<option ' . $selected . ' value="' . $val['id'] . '">---- ' . $val["category_name"] . '</option>';
                }
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
            $html .= '<option value="all">-- '.lang('choosestatus').' --</option>';
            foreach ($data as $key => $value) {
                $selected = $active == $key ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $key . '">- ' . $value["name"] . '</option>';
            }
        } else {
            $html .= '<option value="0">'.lang('listempty').'</option>';
        }
        return $html;
    }

    public function listType($item = "")
    {
        $arr = array(
            1 => array(
                'name'  => lang('tlist'),
                'color' => 'primary'
            ),
            2 => array(
                'name'  => lang('detail'),
                'color' => 'info'
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
            foreach ($data as $key => $value) {
                $selected = $active == $key ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $key . '">' . $value["name"] . '</option>';
            }
        } else {
            $html .= '<option value="0">'.lang('listempty').'</option>';
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
        $fileName = realpath(APPPATH . "../media/category/")."/".$name;
        $transFile = file_put_contents($fileName, $fileData);
        if ($transFile != false) {
            $this->do_resize($fileName,realpath(APPPATH . "../media/category/"));
            $rs = $name;
        }
        return $rs;
    }

    public function delimage($image_name)
    {
        $link_image = realpath(APPPATH . "../media/category/")."/".$image_name;
        $link_image_thumb = realpath(APPPATH . "../media/category/").'/thumb-'.$image_name;
        if (file_exists($link_image)) {
            unlink($link_image);
        }
        if (file_exists($link_image_thumb)) {
            unlink($link_image_thumb);
        }
    }
}
