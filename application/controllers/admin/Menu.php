<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->lang->load('menu',$this->_data['language']);
        $this->load->Model("admin/mmenu");
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
    }
    public function index()
    {
        $this->mpermission->checkPermission("menu","index",$this->_data['user_active']['active_user_group']);
        $this->_data['formData'] = array(
            'menu_name' => '', 
            'menu_status' => 1
        );
        if (isset($_POST['menu_name'])) {
            $this->mpermission->checkPermission("menu","add",$this->_data['user_active']['active_user_group']);
            $this->_data['formData'] = array(
                'menu_name' => $this->input->post('menu_name'), 
                'menu_status' => $this->input->post('menu_status'),
                'menu_updatedate' => date("Y-m-d"),
                'user' => $this->_data['user_active']['active_user_id']
            );
            $error = false;
            do {
                if ($this->_data['formData']['menu_name'] == null) {
                    $text = lang('pleaseinput').lang('menuname');$error = true;break;
                }
            } while (0);
            if ($error == true) {
                $notify = array(
                    'title' => lang('unsuccessful'), 
                    'text' => $text,
                    'type' => 'error'
                );
                $this->session->set_userdata('notify', $notify);
            } else {
                $insert = $this->mmenu->add($this->_data['formData']);
                if (is_numeric($insert) > 0) {
                    $notify = array(
                        'title' => lang('success'), 
                        'text' => lang('menu').' '.$this->_data['formData']['menu_name'].lang('added'),
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    redirect(my_library::admin_site()."menu");
                }
            } 
        }
    	$this->_data['title'] = lang('list');
        $this->_data['list'] = $this->mmenu->getQuery("", "1", "","");
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js'];
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
    	$this->my_layout->view("admin/menu/index", $this->_data);
    } 

    public function edit($id)
    {
    	$this->load->Model("admin/mcategory");
        $this->load->Model("admin/mpage");
        $this->load->Model("admin/mlink");
        $this->load->Model("admin/mmenu_detail");
        $this->mpermission->checkPermission("menu","edit",$this->_data['user_active']['active_user_group']);
        if (is_numeric($id) && $id > 0) {
            $myMenu = $this->mmenu->getData("",array('id' => $id));
            if ($myMenu && $myMenu['id'] > 0) {
                $this->_data['formData'] = array(
                    'menu_name' => $myMenu['menu_name'],
                    'menu_status' => $myMenu['menu_status']
                );
                if (isset($_POST['menu_name'])) {
                    $order_menu = $this->input->post('menu_order');
                    $order_menu = json_decode($order_menu,true);
                    //var_dump($order_menu);die();
                    foreach ($order_menu as $key => $value) {
                        echo $value['id'];
                        if (isset($value['children'])) {
                            echo "child";
                            foreach ($value['children'] as $key => $val) {
                                echo $val['id'];
                            }
                        }
                    }
                    die();
                }
                $this->_data['id'] = $id;
                $this->_data['title'] = lang('editmenu').' #'.$id;
                $this->_data['listCategory'] = $this->mcategory->getCategory($this->_data['language'],1);
                $this->_data['listPage'] = $this->mpage->getPage($this->_data['language'],1);
                $this->_data['listLink'] = $this->mlink->getLink($this->_data['language'],1);
                $this->_data['menuDetail'] = $this->mmenu_detail->getMenuDetail($id);
                //var_dump($this->_data['menuDetail']);die();
                $this->_data['token_name'] = $this->security->get_csrf_token_name();
                $this->_data['token_value'] = $this->security->get_csrf_hash();
                $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','nestable.css'];
                $this->_data['extraJs'] = ['validator.js','icheck.min.js','jquery.nestable.js','module/menu.js','language/'.$this->_data['language'].'_action.js'];
                $this->my_layout->view("admin/menu/post", $this->_data);
            } else {
                $notify = array(
                    'title' => lang('notfound'), 
                    'text' => lang('menu').lang('notexists'),
                    'type' => 'warning'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."menu");
            }
        } else {
            $notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'warning'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."menu");
        }
    }

    public function ajaxAddtoMenu()
    {
        $rs = 0;
        if ($this->mpermission->permission("menu_ajaxAddtoMenu",$this->_data['user_active']['active_user_group']) == true) {
            $menu_id = $this->input->get('menu_id');
            $ingredient = $this->input->get('ingredient');
            $ingredient_id = $this->input->get('ingredient_id');
            if ($menu_id != null && $ingredient != null && $ingredient_id != null) {
                $this->load->Model("admin/mmenu_detail");
                $dataAdd = array(
                    'menu_id' => $menu_id,
                    'parent' => 0,
                    'ingredient' => $ingredient,
                    'ingredient_id' => $ingredient_id,
                    'icon' => '',
                    'click_allow' => 1,
                    'target' => '_self',
                    'order_by' =>0
                );
                $rs = $this->mmenu_detail->add($dataAdd);
            }
        }
        echo $rs;
    }

    public function delete($id)
    {
        $this->mpermission->checkPermission("menu","delete",$this->_data['user_active']['active_user_group']);
    }
}
