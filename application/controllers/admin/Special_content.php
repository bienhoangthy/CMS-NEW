<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Special_content extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('sc',$this->_data['language']);
        $this->load->Model("admin/mcategory");
        $this->load->Model("admin/mcomponent");
        $this->load->Model("admin/mspecial_content");
    }

    public function index()
    {
        $this->mpermission->checkPermission("special_content","index",$this->_data['user_active']['active_user_group']);
        $this->load->library("My_paging");
        $this->_data['title'] = lang('list');
        $obj = 'id,code_position,sc_component,sc_quantity,sc_orderby,sc_status,sc_category,sc_cache,sc_updatedate,user';
        $this->_data['formData'] = array(
            'fcomponent' => $_GET['fcomponent'] ?? '',
            'forderby' => $_GET['forderby'] ?? 0,
            'fstatus' => $_GET['fstatus'] ?? 0,
            'fcategory' => $_GET['fcategory'] ?? 0,
            'fuser' => $_GET['fuser'] ?? 0
        );
        $and = '1';
        if ($this->_data['formData']['fcomponent'] != '') {
            $and .= ' and sc_component = "'. $this->_data['formData']['fcomponent'] .'"';
        }
        if ($this->_data['formData']['forderby'] > 0) {
            $and .= ' and sc_orderby = '. $this->_data['formData']['forderby'];
        }
        if ($this->_data['formData']['fstatus'] > 0) {
            $and .= ' and sc_status = '. $this->_data['formData']['fstatus'];
        }
        if ($this->_data['formData']['fcategory'] > 0) {
            $and .= ' and sc_category = '. $this->_data['formData']['fcategory'];
        }
        if ($this->_data['formData']['fuser'] > 0) {
            $and .= ' and user = '. $this->_data['formData']['fuser'];
        }
        $orderby = 'id desc';
        $this->_data['list'] = $this->mspecial_content->getQuery($obj, $and, $orderby, "");
        $this->_data['record'] = $this->mspecial_content->countQuery($and);
        $this->_data['fcomponent'] = $this->mcomponent->dropdownlist($this->_data['formData']['fcomponent']);
        $this->_data['forderby'] = $this->mspecial_content->dropdownlistOrderBy($this->_data['formData']['forderby']);
        $this->_data['fstatus'] = $this->mspecial_content->dropdownlistStatus($this->_data['formData']['fstatus']);
        $this->_data['fcategory'] = $this->mcategory->dropdownlistCategory($this->_data['formData']['fcategory'],$this->_data['language']);
        $this->_data['fuser'] = $this->muser->dropdownlistUser($this->_data['formData']['fuser']);
        $this->_data['extraCss'] = [];
        $this->_data['extraJs'] = [];
        $this->my_layout->view("admin/special_content/index", $this->_data);
    }

    public function add()
    {
        $this->mpermission->checkPermission("special_content","add",$this->_data['user_active']['active_user_group']);
        $this->_data['langPost'] = $_GET['lang'] ?? $this->_data['language'];
        $this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
        $this->_data['formData'] = array( 
            'code_position' => '', 
            'sc_component' => '', 
            'sc_quantity' => 0,
            'sc_orderby' => 0,
            'sc_status' => 1,
            'sc_category' => 0,
            'sc_cache' => 0,
            'sc_time_cache' => 0
        );
        $this->_data['formDataLang'] = array(
            'sc_name' => '',
            'sc_description' => ''
        );
        //Post
        if (isset($_POST['sc_name'])) {
            $lang = $this->input->post('special_content_lang') ?? $this->_data['language'];
            $time_cache = $this->input->post('sc_cache') == 1 ? $this->input->post('sc_time_cache') : 0;
            $this->_data['formData'] = array( 
                'code_position' => $this->input->post('code_position'), 
                'sc_component' => $this->input->post('sc_component'), 
                'sc_quantity' => $this->input->post('sc_quantity'),
                'sc_orderby' => $this->input->post('sc_orderby'),
                'sc_status' => $this->input->post('sc_status'),
                'sc_category' => $this->input->post('sc_category'),
                'sc_array_item' => '',
                'sc_cache' => $this->input->post('sc_cache'),
                'sc_time_cache' => $time_cache,
                'sc_createdate' => date("Y-m-d H:i:s"),
                'sc_updatedate' => date("Y-m-d H:i:s"),
                'user' => $this->_data['user_active']['active_user_id']
            );
            $this->_data['formDataLang'] = array(
                'sc_id' => 0,
                'language_code' => $lang,
                'sc_name' => $this->input->post('sc_name'),
                'sc_description' => $this->input->post('sc_description')
            );
            $checkCode = $this->mspecial_content->getData('id',array('code_position' => $this->_data['formData']['code_position']));
            $error = false;
            do {
                if ($this->_data['formData']['code_position'] == null) {
                    $text = lang('pleaseinput').lang('positioncode');$error = true;break;
                }
                if ($checkCode && $checkCode['id'] > 0) {
                    $text = lang('positioncode').lang('exists');$error = true;break;
                }
                if ($this->_data['formData']['sc_component'] == null) {
                    $text = lang('pleasechoose').'component';$error = true;break;
                }
                if ($this->_data['formData']['sc_quantity'] < 1) {
                    $text = lang('pleaseinput').lang('quantity');$error = true;break;
                }
                if ($this->_data['formData']['sc_orderby'] < 1) {
                    $text = lang('pleasechoose').lang('item');$error = true;break;
                }
                if ($this->_data['formData']['sc_category'] < 1) {
                    $text = lang('pleasechoose').lang('category');$error = true;break;
                }
                if ($this->_data['formDataLang']['sc_name'] == null) {
                    $text = lang('pleaseinput').lang('specialcontenttitle');$error = true;break;
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
                $insert = $this->mspecial_content->add($this->_data['formData']);
                if (is_numeric($insert) && $insert > 0) {
                    //$this->mactivity->addActivity(11,$insert,1,$this->_data['user_active']['active_user_id']);
                    $this->_data['formDataLang']['sc_id'] = $insert;
                    $insert_lang = $this->mspecial_content_translation->add($this->_data['formDataLang']);
                    $titleinsertlang = is_numeric($insert_lang) > 0 ? ' | '.$lang : '';
                    $notify = array(
                        'title' => lang('success'), 
                        'text' => lang('specialcontent').' #'.$insert.lang('added').$titleinsertlang,
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    redirect(my_library::admin_site()."special_content");
                }
            }
        }
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
        $this->_data['title'] = lang('specialcontentadd');
        if ($this->_data['formData']['sc_component'] != '') {
            $this->_data['category'] = $this->mcategory->dropdownlistCategory($this->_data['formData']['sc_category'],$this->_data['langPost']['lang_code'],$this->_data['formData']['sc_component']);
        }
        $this->_data['special_content_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
        $this->_data['component'] = $this->mcomponent->dropdownlist($this->_data['formData']['sc_component']);
        $this->_data['orderby'] = $this->mspecial_content->dropdownlistOrderBy($this->_data['formData']['sc_orderby']);
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','switchery.min.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js','switchery.min.js','module/sc.js'];
        $this->my_layout->view("admin/special_content/post", $this->_data);
    }

    public function edit($id)
    {
        $this->mpermission->checkPermission("special_content","edit",$this->_data['user_active']['active_user_group']);
        if (is_numeric($id) && $id > 0) {
            $mySpecial_content = $this->mspecial_content->getData("",array('id' => $id));
            if ($mySpecial_content && $mySpecial_content['id'] > 0) {
                $this->_data['langPost'] = $_GET['lang'] ?? $this->_data['language'];
                $this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
                $this->_data['formData'] = array( 
                    'code_position' => $mySpecial_content['code_position'], 
                    'sc_component' => $mySpecial_content['sc_component'], 
                    'sc_quantity' => $mySpecial_content['sc_quantity'],
                    'sc_orderby' => $mySpecial_content['sc_orderby'],
                    'sc_status' => $mySpecial_content['sc_status'],
                    'sc_category' => $mySpecial_content['sc_category'],
                    'sc_cache' => $mySpecial_content['sc_cache'],
                    'sc_time_cache' => $mySpecial_content['sc_time_cache']
                );
                $mySpecial_content_lang = $this->mspecial_content_translation->getData("",array('sc_id' => $id,'language_code' => $this->_data['langPost']['lang_code']));
                if (!empty($mySpecial_content_lang)) {
                    $this->_data['formDataLang'] = array(
                        'sc_name' => $mySpecial_content_lang['sc_name'],
                        'sc_description' => $mySpecial_content_lang['sc_description']
                    );
                } else {
                    $this->_data['formDataLang'] = array(
                        'sc_name' => '',
                        'sc_description' => ''
                    );
                }
                //Post
                if (isset($_POST['sc_name'])) {
                    $lang = $this->input->post('special_content_lang') ?? $this->_data['language'];
                    $time_cache = $this->input->post('sc_cache') == 1 ? $this->input->post('sc_time_cache') : 0;
                    $this->_data['formData'] = array( 
                        'code_position' => $this->input->post('code_position'), 
                        'sc_component' => $this->input->post('sc_component'), 
                        'sc_quantity' => $this->input->post('sc_quantity'),
                        'sc_orderby' => $this->input->post('sc_orderby'),
                        'sc_status' => $this->input->post('sc_status'),
                        'sc_category' => $this->input->post('sc_category'),
                        'sc_array_item' => $mySpecial_content['sc_array_item'],
                        'sc_cache' => $this->input->post('sc_cache'),
                        'sc_time_cache' => $time_cache,
                        'sc_updatedate' => date("Y-m-d H:i:s"),
                        'user' => $this->_data['user_active']['active_user_id']
                    );
                    $this->_data['formDataLang'] = array(
                        'sc_id' => $id,
                        'language_code' => $lang,
                        'sc_name' => $this->input->post('sc_name'),
                        'sc_description' => $this->input->post('sc_description')
                    );
                    $checkCode = $this->mspecial_content->getData('id',array('code_position' => $this->_data['formData']['code_position'],'id <> ' => $id));
                    $error = false;
                    do {
                        if ($this->_data['formData']['code_position'] == null) {
                            $text = lang('pleaseinput').lang('positioncode');$error = true;break;
                        }
                        if ($checkCode && $checkCode['id'] > 0) {
                            $text = lang('positioncode').lang('exists');$error = true;break;
                        }
                        if ($this->_data['formData']['sc_component'] == null) {
                            $text = lang('pleasechoose').'component';$error = true;break;
                        }
                        if ($this->_data['formData']['sc_quantity'] < 1) {
                            $text = lang('pleaseinput').lang('quantity');$error = true;break;
                        }
                        if ($this->_data['formData']['sc_orderby'] < 1) {
                            $text = lang('pleasechoose').lang('item');$error = true;break;
                        }
                        if ($this->_data['formData']['sc_category'] < 1) {
                            $text = lang('pleasechoose').lang('category');$error = true;break;
                        }
                        if ($this->_data['formDataLang']['sc_name'] == null) {
                            $text = lang('pleaseinput').lang('specialcontenttitle');$error = true;break;
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
                        if ($this->mspecial_content->edit($id,$this->_data['formData'])) {
                            //$this->mactivity->addActivity(11,$id,2,$this->_data['user_active']['active_user_id']);
                            if (!empty($mySpecial_content_lang)) {
                                if ($this->mspecial_content_translation->edit($mySpecial_content_lang['id'],$this->_data['formDataLang'])) {
                                    $notify = array(
                                        'title' => lang('success'), 
                                        'text' => lang('specialcontent').' #'.$id.lang('edited').' | '.$lang,
                                        'type' => 'success'
                                    );
                                }
                            } else {
                                $insert_lang = $this->mspecial_content_translation->add($this->_data['formDataLang']);
                                if (is_numeric($insert_lang) > 0) {
                                    $notify = array(
                                        'title' => lang('success'), 
                                        'text' => lang('specialcontent').' #'.$id.lang('addlang').' '.$lang,
                                        'type' => 'success'
                                    );
                                } else {
                                    $notify = array(
                                        'title' => lang('success'), 
                                        'text' => lang('specialcontent').' #'.$id.lang('edited'),
                                        'type' => 'success'
                                    );
                                }
                            }   
                        } else {
                            $notify = array(
                                'title' => lang('unsuccessful'), 
                                'text' => lang('checkinfo'),
                                'type' => 'error'
                            );
                        }
                        $this->session->set_userdata('notify', $notify);
                        redirect(my_library::admin_site()."special_content");
                    }
                }
                //End
                $this->_data['id'] = $id;
                $this->_data['token_name'] = $this->security->get_csrf_token_name();
                $this->_data['token_value'] = $this->security->get_csrf_hash();
                $this->_data['title'] = lang('edit').' #'.$id;
                if ($this->_data['formData']['sc_component'] != '') {
                    $this->_data['category'] = $this->mcategory->dropdownlistCategory($this->_data['formData']['sc_category'],$this->_data['langPost']['lang_code'],$this->_data['formData']['sc_component']);
                }
                $this->_data['special_content_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
                $this->_data['component'] = $this->mcomponent->dropdownlist($this->_data['formData']['sc_component']);
                $this->_data['orderby'] = $this->mspecial_content->dropdownlistOrderBy($this->_data['formData']['sc_orderby']);
                $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','switchery.min.css'];
                $this->_data['extraJs'] = ['validator.js','icheck.min.js','switchery.min.js','module/sc.js'];
                $this->my_layout->view("admin/special_content/post", $this->_data);
            } else {
                $notify = array(
                    'title' => lang('notfound'), 
                    'text' => lang('specialcontent').lang('notexists'),
                    'type' => 'error'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."special_content");
            }
        } else {
            $notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'error'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."special_content");
        }
    }

    public function delete($id)
    {
        $this->mpermission->checkPermission("special_content","delete",$this->_data['user_active']['active_user_group']);
        if (is_numeric($id) && $id > 0) {
            $mySpecial_content = $this->mspecial_content->getData("",array('id' => $id));
            if ($mySpecial_content) {
                $this->mspecial_content->delete($id);
                $this->mspecial_content_translation->deleteAnd(array('sc_id' => $id));
                //$this->mactivity->deleteAnd(array('activity_component' => 11,'activity_id_com' => $id));
                //$this->mactivity->addActivity(11,$id,3,$this->_data['user_active']['active_user_id']);
                $title = lang('success');
                $text = lang('specialcontent').lang('deleted');
                $type = 'success';
            } else {
                $title = lang('unsuccessful');
                $text = lang('notfound').' '.lang('specialcontent');
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
        redirect(my_library::admin_site()."special_content");
    }

    public function item($id)
    {
        $this->mpermission->checkPermission("special_content","item",$this->_data['user_active']['active_user_group']);
        if (is_numeric($id) && $id > 0) {
            $this->_data['mySpecial_content'] = $this->mspecial_content->getData("",array('id' => $id,'sc_orderby' => 5));
            if ($this->_data['mySpecial_content'] && $this->_data['mySpecial_content']['id'] > 0) {
                $this->_data['title'] = lang('listitem').' #'.$id;
                $this->_data['token_name'] = $this->security->get_csrf_token_name();
                $this->_data['token_value'] = $this->security->get_csrf_hash();
                $this->_data['extraCss'] = ['iCheck/skins/flat/green.css'];
                $this->_data['extraJs'] = ['icheck.min.js','module/sc.js'];
                $this->my_layout->view("admin/special_content/item", $this->_data);
            } else {
                $notify = array(
                    'title' => lang('notfound'), 
                    'text' => lang('specialcontent').lang('notexists'),
                    'type' => 'error'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."special_content");
            }
        } else {
            $notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'error'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."special_content");
        }
    }
}
