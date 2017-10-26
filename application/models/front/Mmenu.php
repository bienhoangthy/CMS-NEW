<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mmenu extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_menu_detail";


    public function getMenubyId($id,$submenu=true,$language='vietnamese')
    {
        $this->load->Model("admin/mcategory_translation");
        $this->load->Model("admin/mpage_translation");
        $this->load->Model("admin/mlink");
        $this->load->Model("admin/mlink_translation");
        $sql = 'select id,ingredient,ingredient_id,click_allow,target from '.$this->table.' where parent = 0 and menu_id = '.$id.' order by order_by asc';
        $query = $this->db->query($sql);
        $rs = $query->result_array();
        if ($rs) {
            foreach ($rs as $key => $value) {
                $name = '';
                $alias = '';
                switch ($value['ingredient']) {
                    case 1:
                        $ingredient = $this->mcategory_translation->getData("category_name,category_alias",array('category_id' => $value['ingredient_id'],'language_code' => $language));
                        if (!empty($ingredient)) {
                            $name = $ingredient['category_name'];
                            $alias = $ingredient['category_alias'];
                        }
                        break;
                    case 2:
                        $ingredient = $this->mpage_translation->getData("page_title,page_alias",array('page_id' => $value['ingredient_id'],'language_code' => $language));
                        if (!empty($ingredient)) {
                            $name = $ingredient['page_title'];
                            $alias = $ingredient['page_alias'];
                        }
                        break;
                    case 3:
                        $ingredient_link = $this->mlink->getData("link",array('id' => $value['ingredient_id']));
                        $ingredient_link_name = $this->mlink_translation->getData("link_name",array('link_id' => $value['ingredient_id'],'language_code' => $language));
                        if (!empty($ingredient_link)) {
                            $alias = $ingredient_link['link'];
                        }
                        if (!empty($ingredient_link_name)) {
                            $name = $ingredient_link_name['link_name'];
                        }
                        break;
                }
                $rs[$key]['name'] = $name;
                $rs[$key]['alias'] = $alias;
                if ($submenu==true) {
                    $sqlsub = 'select ingredient,ingredient_id,click_allow,target from '.$this->table.' where parent = '.$value['id'].' and menu_id = '.$id.' order by order_by asc';
                    $querysub = $this->db->query($sqlsub);
                    $rssub = $querysub->result_array();
                    if ($rssub) {
                        foreach ($rssub as $k => $val) {
                            $name = '';
                            $alias = '';
                            switch ($val['ingredient']) {
                                case 1:
                                    $ingredient = $this->mcategory_translation->getData("category_name,category_alias",array('category_id' => $val['ingredient_id'],'language_code' => $language));
                                    if (!empty($ingredient)) {
                                        $name = $ingredient['category_name'];
                                        $alias = $ingredient['category_alias'];
                                    }
                                    break;
                                case 2:
                                    $ingredient = $this->mpage_translation->getData("page_title,page_alias",array('page_id' => $val['ingredient_id'],'language_code' => $language));
                                    if (!empty($ingredient)) {
                                        $name = $ingredient['page_title'];
                                        $alias = $ingredient['page_alias'];
                                    }
                                    break;
                                case 3:
                                    $ingredient_link = $this->mlink->getData("link",array('id' => $val['ingredient_id']));
                                    $ingredient_link_name = $this->mlink_translation->getData("link_name",array('link_id' => $val['ingredient_id'],'language_code' => $language));
                                    if (!empty($ingredient_link)) {
                                        $alias = $ingredient_link['link'];
                                    }
                                    if (!empty($ingredient_link_name)) {
                                        $name = $ingredient_link_name['link_name'];
                                    }
                                    break;
                            }
                            $rssub[$k]['name'] = $name;
                            $rssub[$k]['alias'] = $alias;
                        }
                        $rs[$key]['child'] = $rssub;
                    }
                }
            }
        }
        return $rs;
    }
}
