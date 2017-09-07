<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->lang->load('menu',$this->_data['language']);
        $this->load->Model("admin/mmenu");
        $this->load->Model("admin/mmenu_detail");
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
        $this->mpermission->checkPermission("menu","edit",$this->_data['user_active']['active_user_group']);
        if (is_numeric($id) && $id > 0) {
            $myMenu = $this->mmenu->getData("",array('id' => $id));
            if ($myMenu && $myMenu['id'] > 0) {
                $this->_data['formData'] = array(
                    'menu_name' => $myMenu['menu_name'],
                    'menu_status' => $myMenu['menu_status']
                );
                if (isset($_POST['menu_name'])) {
                    $this->_data['formData'] = array(
                        'menu_name' => $this->input->post('menu_name'), 
                        'menu_status' => $this->input->post('menu_status'),
                        'menu_updatedate' => date("Y-m-d"),
                        'user' => $this->_data['user_active']['active_user_id']
                    );
                    $this->mmenu->edit($id,$this->_data['formData']);
                    $countEdit = 0;
                    $order_menu = $this->input->post('menu_order');
                    if ($order_menu != null) {
                        $order_menu = json_decode($order_menu,true);
                        foreach ($order_menu as $key => $value) {
                            if ($this->mmenu_detail->edit($value['id'],array('parent' => 0,'icon' => $this->input->post('icon'.$value['id']),'click_allow' =>  $this->input->post('allow'.$value['id']),'target' => $this->input->post('target'.$value['id']),'order_by' => $key))) {
                                $countEdit++;
                            }
                            if (isset($value['children'])) {
                                foreach ($value['children'] as $k => $val) {
                                    if ($this->mmenu_detail->edit($val['id'],array('parent' => $value['id'],'icon' => $this->input->post('icon'.$val['id']),'click_allow' => $this->input->post('allow'.$val['id']),'target' => $this->input->post('target'.$val['id']),'order_by' => $k))) {
                                        $countEdit++;
                                    }
                                }
                            }
                        }
                    } else {
                        $listMenuDetail = $this->mmenu_detail->getQuery("id","menu_id = ".$id,"","");
                        if (!empty($listMenuDetail)) {
                            foreach ($listMenuDetail as $key => $value) {
                                if ($this->mmenu_detail->edit($value['id'],array('icon' => $this->input->post('icon'.$value['id']),'click_allow' =>  $this->input->post('allow'.$value['id']),'target' => $this->input->post('target'.$value['id'])))) {
                                    $countEdit++;
                                }
                            }
                        }
                    }
                    $notify = array(
                        'title' => lang('success'), 
                        'text' => lang('updated').$countEdit.' '.lang('ingredient').' '.lang('of').$this->_data['formData']['menu_name'],
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    redirect(my_library::admin_site()."menu/edit/".$id);
                }
                $this->_data['id'] = $id;
                $this->_data['title'] = lang('editmenu').' #'.$id;
                $this->_data['listCategory'] = $this->mcategory->getCategory($this->_data['language'],1);
                $this->_data['listPage'] = $this->mpage->getPage($this->_data['language'],1);
                $this->_data['listLink'] = $this->mlink->getLink($this->_data['language'],1);
                $this->_data['menuDetail'] = $this->mmenu_detail->getMenuDetail($id);
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
        $rs = -1;
        if ($this->mpermission->permission("menu_ajaxAddtoMenu",$this->_data['user_active']['active_user_group']) == true) {
            $menu_id = $this->input->get('menu_id');
            $ingredient = $this->input->get('ingredient');
            $ingredient_id = $this->input->get('ingredient_id');
            if ($menu_id != null && $ingredient != null && $ingredient_id != null) {
                $checkIngredient = $this->mmenu_detail->getData("id",array('menu_id' => $menu_id,'ingredient' => $ingredient,'ingredient_id' => $ingredient_id));
                if ($checkIngredient && $checkIngredient['id'] > 0) {
                    $rs = 0;
                } else {
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
        }
        echo $rs;
    }

    public function ajaxDeleteMenu()
    {
    	$rs = 0;
    	if ($this->mpermission->permission("menu_ajaxDeleteMenu",$this->_data['user_active']['active_user_group']) == true) {
    		$id = $this->input->get('id');
    		if ($id != null) {
    			$this->mmenu_detail->delete($id);
    			$this->mmenu_detail->deleteAnd(array('parent' => $id));
    			$rs = 1;
    		}
    	}
    	echo $rs;
    }

    public function delete($id)
    {
        $this->mpermission->checkPermission("menu","delete",$this->_data['user_active']['active_user_group']);
        if (is_numeric($id) && $id > 1) {
        	$myMenu = $this->mmenu->getData("",array('id' => $id));
        	if ($myMenu && $myMenu['id'] > 1) {
        		$this->mmenu->delete($id);
        		$this->mmenu_detail->deleteAnd(array('menu_id' => $id));
        		$title = lang('success');
                $text = lang('menu').lang('deleted');
                $type = 'success';
        	} else {
        		$title = lang('unsuccessful');
                $text = lang('notfound').' '.lang('menu');
                $type = 'error';
        	}
        } else {
        	$title = lang('unsuccessful');
            $text = lang('wrongid');
            $type = 'error';
        }
        $notify = array(
            'title' => $title, 
            'text' => $text,
            'type' => $type
        );
		$this->session->set_userdata('notify', $notify);
        redirect(my_library::admin_site()."menu");
    }
}
