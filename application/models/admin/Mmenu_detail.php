<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class mmenu_detail extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    protected $table = "cms_menu_detail";

    public function getMenuDetail($id)
    {
    	$list = $this->getQuery("id,ingredient,ingredient_id,icon,click_allow,target","parent = 0 and menu_id = ".$id,"order_by asc,id asc","");
    	if (!empty($list)) {
    		foreach ($list as $key => $value) {
    			$listChild = $this->getQuery("id,ingredient,ingredient_id,icon,click_allow,target","parent = ".$value['id']." and menu_id = ".$id,"order_by asc,id asc","");
    			if (!empty($listChild)) {
                    foreach ($listChild as $k => $val) {
                        $listsubChild = $this->getQuery("id,ingredient,ingredient_id,icon,click_allow,target","parent = ".$val['id']." and menu_id = ".$id,"order_by asc,id asc","");
                        if (!empty($listsubChild)) {
                            $listChild[$k]['subchild'] = $listsubChild;
                        }
                    }
    				$list[$key]['child'] = $listChild;
    			}
    		}
    		return $list;
    	} else {
    		return $list = array();
    	}
    }

    public function listIngredient($item = "")
    {
        $arr = array(
            1 => array(
                'name'  => lang('category')
            ),
            2 => array(
                'name'  => lang('page')
            ),
            3 => array(
                'name'  => lang('link')
            )
        );
        if (is_numeric($item)) {
            return $arr[$item];
        } else {
            return $arr;
        }
    }
}
