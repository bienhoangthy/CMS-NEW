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
        $this->_data['fcomponent'] = $this->mcomponent->dropdownlist($this->_data['formData']['fcomponent'],1);
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
                'sc_cache' => $this->input->post('sc_cache') ?? 0,
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
        $this->_data['component'] = $this->mcomponent->dropdownlist($this->_data['formData']['sc_component'],1);
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
                    $arr_item = '';
                    if ($this->input->post('sc_orderby') == 5 && $this->input->post('sc_category') == $mySpecial_content['sc_category']) {
                    	$arr_item = $mySpecial_content['sc_array_item'];
                    }
                    $time_cache = $this->input->post('sc_cache') == 1 ? $this->input->post('sc_time_cache') : 0;
                    $this->_data['formData'] = array( 
                        'code_position' => $this->input->post('code_position'), 
                        'sc_component' => $this->input->post('sc_component'), 
                        'sc_quantity' => $this->input->post('sc_quantity'),
                        'sc_orderby' => $this->input->post('sc_orderby'),
                        'sc_status' => $this->input->post('sc_status'),
                        'sc_category' => $this->input->post('sc_category'),
                        'sc_array_item' => $arr_item,
                        'sc_cache' => $this->input->post('sc_cache') ?? 0,
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
                $this->_data['component'] = $this->mcomponent->dropdownlist($this->_data['formData']['sc_component'],1);
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
                if (isset($_POST['table_records'])) {
                    $listItem = $this->input->post('table_records');
                    if ($listItem != null && is_array($listItem)) {
                    	$countItemAdd = 0;
                        if ($this->_data['mySpecial_content']['sc_array_item'] != '') {
                        	$oldList = unserialize($this->_data['mySpecial_content']['sc_array_item']);
                            $newList = array_unique(array_merge($oldList,$listItem));
                            $count = count($newList);
                            $countItemAdd = $count - count($oldList);
                            $newList = serialize($newList);
                        } else {
                            $count = count($listItem);
                            $countItemAdd = $count;
                            $newList = serialize($listItem);
                        }
                        if ($count > $this->_data['mySpecial_content']['sc_quantity']) {
                            $notify = array(
                                'title' => lang('unsuccessful'), 
                                'text' => lang('overload'),
                                'type' => 'error'
                            );
                        } else {
                            if ($this->mspecial_content->edit($id,array('sc_array_item' => $newList))) {
                            	$duplicate = count($listItem) - $countItemAdd;
                            	$textDup = $duplicate > 0 ? ', '.$duplicate.lang('duplicate') : '';
                            	if ($countItemAdd > 0) {
                            		$notify = array(
	                                    'title' => lang('success'), 
	                                    'text' => lang('itemadded').$countItemAdd.' '.lang('item').$textDup.' | #'.$id,
	                                    'type' => 'success'
	                                );
                            	} else {
                            		$notify = array(
	                                    'title' => lang('unsuccessful'), 
	                                    'text' => lang('itemadded').$countItemAdd.' '.lang('item').$textDup.' | #'.$id,
	                                    'type' => 'error'
	                                );
                            	}
                            } else {
                                $notify = array(
                                    'title' => lang('unsuccessful'), 
                                    'text' => lang('checkinfo'),
                                    'type' => 'error'
                                );
                            }
                        }
                    } else {
                        $notify = array(
                            'title' => lang('unsuccessful'), 
                            'text' => lang('pleasechoose').lang('item'),
                            'type' => 'error'
                        );
                    }
                    $this->session->set_userdata('notify', $notify);
                    redirect(my_library::admin_site()."special_content/item/".$id);
                    exit();
                }
                //Paging
                $this->load->library("My_paging");
                $paging['per_page'] = 20;
                $paging['num_links'] = 5;
                $paging['page'] = $this->_data['page'] = $_GET['page'] ?? 1;
                $paging['start'] = (($paging['page'] - 1) * $paging['per_page']);
                $query_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? str_replace("&page=" . $this->_data['page'], "", $_SERVER['QUERY_STRING']) : '';
                $paging['base_url'] = my_library::admin_site() . 'special_content/item/'.$id.'?' . $query_string . '&page=';
                $limit = $paging['start'] . ',' . $paging['per_page'];
                $this->_data['listItem'] = array();
                $this->_data['currentItem'] = array();
                $this->_data['record'] = 0;
                $this->_data['titleCom'] = '';
                //Item
                $ids = '';
                if ($this->_data['mySpecial_content']['sc_array_item'] != '') {
                    $arrItem = unserialize($this->_data['mySpecial_content']['sc_array_item']);
                    $ids = '';
                    foreach ($arrItem as $value) {
                        $ids .= $value.',';
                    }
                    $ids = rtrim($ids,',');
                }
                switch ($this->_data['mySpecial_content']['sc_component']) {
                    case 'news':
                        $this->load->Model("admin/mnews");
                        if ($ids != '') {
                        	$this->_data['currentItem'] = $this->mnews->whereIn("n.id,n.news_status as status,nt.news_title as name",$ids,$this->_data['language']);
                        }
                        $this->_data['listItem'] = $this->mnews->getNews("n.id,nt.news_title as name",'n.news_status = 1 and n.news_state = 3 and n.news_category = '.$this->_data['mySpecial_content']['sc_category'].' and nt.language_code = "'.$this->_data['language'].'"',"n.id desc",$limit);
                        $this->_data['record'] = $this->mnews->countNews('n.news_status = 1 and n.news_state = 3 and n.news_category = '.$this->_data['mySpecial_content']['sc_category'].' and nt.language_code = "'.$this->_data['language'].'"');
                        $this->_data['titleCom'] = lang('news');
                        break;
                    case 'album':
                        $this->load->Model("admin/malbum");
                        if ($ids != '') {
                        	$this->_data['currentItem'] = $this->malbum->whereIn("a.id,a.album_status as status,at.album_name as name",$ids,$this->_data['language']);
                        }
                        $this->_data['listItem'] = $this->malbum->getAlbum("a.id,at.album_name as name",'a.album_status = 1 and a.album_parent = '.$this->_data['mySpecial_content']['sc_category'].' and at.language_code = "'.$this->_data['language'].'"',"a.id desc",$limit);
                        $this->_data['record'] = $this->malbum->countAlbum('a.album_status = 1 and a.album_parent = '.$this->_data['mySpecial_content']['sc_category'].' and at.language_code = "'.$this->_data['language'].'"');
                        $this->_data['titleCom'] = lang('album');
                        break;
                    case 'video':
                        $this->load->Model("admin/mvideo");
                        if ($ids != '') {
                        	$this->_data['currentItem'] = $this->mvideo->whereIn("v.id,v.video_status as status,vt.video_name as name",$ids,$this->_data['language']);
                        }
                        $this->_data['listItem'] = $this->mvideo->getVideo("v.id,vt.video_name as name",'v.video_status = 1 and v.video_parent = '.$this->_data['mySpecial_content']['sc_category'].' and vt.language_code = "'.$this->_data['language'].'"',"v.id desc",$limit);
                        $this->_data['record'] = $this->mvideo->countVideo('v.video_status = 1 and v.video_parent = '.$this->_data['mySpecial_content']['sc_category'].' and vt.language_code = "'.$this->_data['language'].'"');
                        $this->_data['titleCom'] = 'Video';
                        break;
                    default:
                        $this->_data['listItem'] = array();
                        $this->_data['currentItem'] = array();
                        $this->_data['record'] = 0;
                        $this->_data['listTitle'] = '';
                        break;
                }
                $this->_data["pagination"] = $this->my_paging->paging_donturl($this->_data["record"], $paging['page'], $paging['per_page'], $paging['num_links'], $paging['base_url']);
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

    public function deleteAllItem($id)
    {
        $this->mpermission->checkPermission("special_content","deleteItem",$this->_data['user_active']['active_user_group']);
        if (is_numeric($id) && $id > 0) {
            $mySpecial_content = $this->mspecial_content->getData("",array('id' => $id));
            if ($mySpecial_content) {
                if ($this->mspecial_content->edit($id,array('sc_array_item' => ''))) {
                	$title = lang('success');
	                $text = lang('all').' '.lang('item').lang('deleted');
	                $type = 'success';
                } else {
                	$title = lang('unsuccessful');
	                $text = lang('checkinfo');
	                $type = 'error';
                }
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
        redirect(my_library::admin_site()."special_content/item/".$id);
    }

    public function deleteItem()
    {
    	$rs = array('status' => 0,'message' => '');
    	if ($this->mpermission->permission("special_content_deleteItem",$this->_data['user_active']['active_user_group']) == true) {
    		$id = $this->input->get('id');
	    	$id_item = $this->input->get('id_item');
	    	if ($id != null && $id_item != null) {
	    		$mySpecial_content = $this->mspecial_content->getData("sc_array_item",array('id' => $id));
	    		if ($mySpecial_content) {
	    			if ($mySpecial_content['sc_array_item'] == '') {
	    				$rs = array('status' => 0,'message' => lang('listempty'));
	    			} else {
	    				$listItem = unserialize($mySpecial_content['sc_array_item']);
	    				$listItem = array_diff($listItem, array($id_item));
	    				$countItem = count($listItem);
	    				$serEdit = $countItem > 0 ? serialize($listItem) : '';
    					if ($this->mspecial_content->edit($id,array('sc_array_item' => $serEdit))) {
    						$rs = array('status' => 1,'message' => lang('item').' '.$id_item.lang('deleted'),'total' => $countItem);
    					} else {
    						$rs = array('status' => 0,'message' => lang('checkinfo'));
    					}
	    			}
	    		} else {
	    			$rs = array('status' => 0,'message' => lang('specialcontent').lang('notexists'));
	    		}
	    	} else {
	    		$rs = array('status' => 0,'message' => lang('checkinfo'));
	    	}
    	} else {
    		$rs = array('status' => 0,'message' => lang('notpermission'));
    	}
    	echo json_encode($rs);
    }

    public function code($id)
    {
        $this->mpermission->checkPermission("special_content","code",$this->_data['user_active']['active_user_group']);
        if (is_numeric($id) && $id > 0) {
            $this->_data['mySpecial_content'] = $this->mspecial_content->getData("",array('id' => $id,'sc_orderby' => 6));
            if ($this->_data['mySpecial_content'] && $this->_data['mySpecial_content']['id'] > 0) {
                $this->_data['formData'] = array('sc_array_item' => $this->_data['mySpecial_content']['sc_array_item']);
                if (isset($_POST['code'])) {
                    $this->_data['formData']['sc_array_item'] = $this->input->post('code');
                    if ($this->mspecial_content->edit($id,array('sc_array_item' => $this->_data['formData']['sc_array_item']))) {
                        $notify = array(
                            'title' => lang('success'), 
                            'text' => lang('specialcontent').' #'.$id.lang('edited'),
                            'type' => 'success'
                        );
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
                $this->_data['title'] = lang('code').'html #'.$id;
                $this->_data['token_name'] = $this->security->get_csrf_token_name();
                $this->_data['token_value'] = $this->security->get_csrf_hash();
                $this->_data['extraCss'] = ['codemirror.css'];
                $this->_data['extraJs'] = ['codemirror.js','htmlmixed.js','module/codemirror.js'];
                $this->my_layout->view("admin/special_content/code", $this->_data);
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
