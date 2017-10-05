<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Video extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('video',$this->_data['language']);
        $this->load->Model("admin/mcategory");
        $this->load->Model("admin/mvideo");
        $this->load->Model("admin/mactivity");
    }
	public function index()
	{
		$this->mpermission->checkPermission("video","index",$this->_data['user_active']['active_user_group']);
		$this->load->library("My_paging");
        $this->_data['title'] = lang('list');
        $obj = 'v.id,v.video_parent,v.video_link,v.video_status,v.video_hot,v.video_picture,v.video_view,v.video_updatedate,v.user,vt.video_name';
        $this->_data['formData'] = array(
            'fkeyword' => $_GET['fkeyword'] ?? '',
            'fstatus' => $_GET['fstatus'] ?? 0,
            'fuser' => $_GET['fuser'] ?? 0,
            'fcategory' => $_GET['fcategory'] ?? 0,
            'flanguage' => $_GET['flanguage'] ?? $this->_data['language']
        );
        $this->_data['flanguage'] = $this->mlanguage->getLanguage($this->_data['formData']['flanguage']);
        $and = '1';
        if ($this->_data['formData']['fstatus'] > 0) {
            if ($this->_data['formData']['fstatus'] == 10) {
                $and .= ' and v.video_hot = 1';
            } else {
                $and .= ' and v.video_status = '. $this->_data['formData']['fstatus'];
            }
        }
        if ($this->_data['formData']['fuser'] > 0) {
            $and .= ' and v.user = '. $this->_data['formData']['fuser'];
        }
        if ($this->_data['formData']['fcategory'] > 0) {
            $and .= ' and v.video_parent = '. $this->_data['formData']['fcategory'];
        }
        if ($this->_data['formData']['fkeyword'] != '') {
            $and .= ' and (vt.video_name like "%' . $this->_data['formData']['fkeyword'] . '%"';
            $and .= ' or vt.video_alias like "%' . $this->_data['formData']['fkeyword'] . '%")';
        }
        $and .= ' and vt.language_code = "'.$this->_data['flanguage']['lang_code'].'"';
        $orderby = 'v.video_orderby desc, v.id desc';
        $paging['per_page'] = 20;
        $paging['num_links'] = 5;
        $paging['page'] = $this->_data['page'] = $_GET['page'] ?? 1;
        $paging['start'] = (($paging['page'] - 1) * $paging['per_page']);
        $query_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? str_replace("&page=" . $this->_data['page'], "", $_SERVER['QUERY_STRING']) : '';
        $paging['base_url'] = my_library::admin_site() . 'video/?' . $query_string . '&page=';
        $limit = $paging['start'] . ',' . $paging['per_page'];
        $this->_data['list'] = $this->mvideo->getVideo($obj, $and, $orderby, $limit);
        $this->_data['record'] = $this->mvideo->countVideo($and);
        $this->_data["pagination"] = $this->my_paging->paging_donturl($this->_data["record"], $paging['page'], $paging['per_page'], $paging['num_links'], $paging['base_url']);
        $this->_data['fstatus'] = $this->mvideo->dropdownlistStatus($this->_data['formData']['fstatus']);
        $this->_data['fuser'] = $this->muser->dropdownlistUser($this->_data['formData']['fuser']);
        $this->_data['fcategory'] = $this->mcategory->dropdownlistCategory($this->_data['formData']['fcategory'],$this->_data['formData']['flanguage'],'video');
        $this->_data['extraCss'] = ['fancybox/jquery.fancybox.css'];
        $this->_data['extraJs'] = ['fancybox/jquery.mousewheel.pack.js','fancybox/jquery.fancybox.pack.js','fancybox/helpers/jquery.fancybox-media.js','fancybox.js'];
        $this->my_layout->view("admin/video/index", $this->_data);
	}

	public function add()
	{
		$this->mpermission->checkPermission("video","add",$this->_data['user_active']['active_user_group']);
		$this->_data['langPost'] = $_GET['lang'] ?? $this->_data['language'];
    	$this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
        $this->_data['formData'] = array( 
            'video_parent' => 0, 
        	'video_link' => '', 
        	'video_status' => 1, 
            'video_hot' => 0,
            'video_picture' => '',
            'video_view' => 0,
            'video_orderby' => 0
        );
        $this->_data['formDataLang'] = array(
        	'video_name' => '',
        	'video_alias' => '',
        	'video_description' => ''
        );
        //Post
        if (isset($_POST['video_name'])) {
        	$lang = $this->input->post('video_lang') ?? $this->_data['language'];
        	$this->_data['formData'] = array( 
                'video_parent' => $this->input->post('video_parent'), 
	        	'video_link' => $this->input->post('video_link'), 
	        	'video_status' => $this->input->post('video_status'), 
                'video_hot' => $this->input->post('video_hot') ?? 0,
                'video_picture' => '',
	            'video_view' => $this->input->post('video_view'),
	            'video_orderby' => $this->input->post('video_orderby'),
                'video_createdate' => date("Y-m-d H:i:s"),
	        	'video_updatedate' => date("Y-m-d H:i:s"),
	        	'user' => $this->_data['user_active']['active_user_id']
	        );
            $this->load->helper('alias');
	        $alias = to_alias($this->input->post('video_name'));
	        $this->_data['formDataLang'] = array(
	        	'video_id' => 0,
	        	'language_code' => $lang,
	        	'video_name' => $this->input->post('video_name'),
	        	'video_alias' => $alias ?? time(),
	        	'video_description' => $this->input->post('video_description')
	        );
            $checkAlias = $this->mvideo_translation->getData('id',array('video_alias' => $this->_data['formDataLang']['video_alias']));
            $error = false;
            do {
                if ($this->_data['formData']['video_link'] == null) {
                    $text = lang('pleaseinput').'link';$error = true;break;
                }
                if ($this->_data['formDataLang']['video_name'] == null) {
                    $text = lang('pleaseinput').lang('videoname');$error = true;break;
                }
                if ($checkAlias && $checkAlias['id'] > 0) {
                    $this->_data['formDataLang']['video_alias'] = $this->_data['formDataLang']['video_alias'].'-1';
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
            	$insert = $this->mvideo->add($this->_data['formData']);
            	if (is_numeric($insert) && $insert > 0) {
                    $this->mactivity->addActivity(11,$insert,1,$this->_data['user_active']['active_user_id']);
            		$file = $this->input->post('file');
	                if ($file != null) {
	                    $video_picture = $this->mvideo->saveImage($file,$insert,$this->_data['formDataLang']['video_alias']);
	                    if ($video_picture != '') {
	                    	$this->mvideo->edit($insert,array('video_picture' => $video_picture));
	                    }
	                }
	                $this->_data['formDataLang']['video_id'] = $insert;
	                $insert_lang = $this->mvideo_translation->add($this->_data['formDataLang']);
	                $titleinsertlang = is_numeric($insert_lang) > 0 ? ' | '.$lang : '';
                    $notify = array(
                        'title' => lang('success'), 
                        'text' => lang('video').' #'.$insert.lang('added').$titleinsertlang,
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    redirect(my_library::admin_site()."video");
            	}
            }
        }
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
		$this->_data['title'] = lang('videoadd');
		$this->_data['category'] = $this->mcategory->dropdownlistCategory($this->_data['formData']['video_parent'],$this->_data['langPost']['lang_code'],'video');
        $this->_data['video_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','switchery.min.css','cropper.min.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js','language/'.$this->_data['language'].'.js','switchery.min.js','cropper.min.js','tinymce/jquery.tinymce.min.js','tinymce/tinymce.min.js','module/video.js'];
		$this->my_layout->view("admin/video/post", $this->_data);
	}

	public function edit($id)
	{
		$this->mpermission->checkPermission("video","edit",$this->_data['user_active']['active_user_group']);
		if (is_numeric($id) && $id > 0) {
			$myVideo = $this->mvideo->getData("",array('id' => $id));
			if ($myVideo && $myVideo['id'] > 0) {
				$this->_data['langPost'] = $_GET['lang'] ?? $this->_data['language'];
                $this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
                $this->_data['formData'] = array( 
                    'video_parent' => $myVideo['video_parent'], 
                    'video_link' => $myVideo['video_link'], 
                    'video_status' => $myVideo['video_status'], 
                    'video_hot' => $myVideo['video_hot'],
                    'video_picture' => $myVideo['video_picture'],
                    'video_view' => $myVideo['video_view'],
                    'video_orderby' => $myVideo['video_orderby']
                );
                $myVideo_lang = $this->mvideo_translation->getData("",array('video_id' => $id,'language_code' => $this->_data['langPost']['lang_code']));
                if (!empty($myVideo_lang)) {
                    $this->_data['formDataLang'] = array(
                        'video_name' => $myVideo_lang['video_name'],
                        'video_alias' => $myVideo_lang['video_alias'],
                        'video_description' => $myVideo_lang['video_description']
                    );
                } else {
                    $this->_data['formDataLang'] = array(
                        'video_name' => '',
                        'video_alias' => '',
                        'video_description' => ''
                    );
                }
                //Post
                if (isset($_POST['video_name'])) {
                    $lang = $this->input->post('video_lang') ?? $this->_data['language'];
                    $this->_data['formData'] = array( 
                        'video_parent' => $this->input->post('video_parent'), 
                        'video_link' => $this->input->post('video_link'), 
                        'video_status' => $this->input->post('video_status'), 
                        'video_hot' => $this->input->post('video_hot'),
                        'video_picture' => $myVideo['video_picture'],
                        'video_view' => $this->input->post('video_view'),
                        'video_orderby' => $this->input->post('video_orderby'),
                        'video_updatedate' => date("Y-m-d H:i:s"),
                        'user' => $this->_data['user_active']['active_user_id']
                    );
                    $alias = $this->input->post('video_alias');
                    if ($alias == null) {
                        $this->load->helper('alias');
                        $alias = to_alias($this->input->post('video_name'));
                    }
                    $this->_data['formDataLang'] = array(
                        'video_id' => $id,
                        'language_code' => $lang,
                        'video_name' => $this->input->post('video_name'),
                        'video_alias' => $alias ?? time(),
                        'video_description' => $this->input->post('video_description')
                    );
                    $checkAlias = $this->mvideo_translation->getData('id',array('video_alias' => $this->_data['formDataLang']['video_alias'],'video_id <> ' => $id));
                    $error = false;
                    do {
                        if ($this->_data['formData']['video_link'] == null) {
                            $text = lang('pleaseinput').'link';$error = true;break;
                        }
                        if ($this->_data['formDataLang']['video_name'] == null) {
                            $text = lang('pleaseinput').lang('videoname');$error = true;break;
                        }
                        if ($checkAlias && $checkAlias['id'] > 0) {
                            $this->_data['formDataLang']['video_alias'] = $this->_data['formDataLang']['video_alias'].'-1';
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
                        $file = $this->input->post('file');
                        if ($file != null) {
                            $video_picture = $this->mvideo->saveImage($file,$id,$this->_data['formDataLang']['video_alias']);
                            if ($video_picture != '') {
                                $this->_data['formData']['video_picture'] = $video_picture;
                                $this->mvideo->delimage($id,$myVideo['video_picture']);
                            }
                        }
                        if ($this->mvideo->edit($id,$this->_data['formData'])) {
                            $this->mactivity->addActivity(11,$id,2,$this->_data['user_active']['active_user_id']);
                            if (!empty($myVideo_lang)) {
                                if ($this->mvideo_translation->edit($myVideo_lang['id'],$this->_data['formDataLang'])) {
                                    $notify = array(
                                        'title' => lang('success'), 
                                        'text' => lang('video').' #'.$id.lang('edited').' | '.$lang,
                                        'type' => 'success'
                                    );
                                }
                            } else {
                                $insert_lang = $this->mvideo_translation->add($this->_data['formDataLang']);
                                if (is_numeric($insert_lang) > 0) {
                                    $notify = array(
                                        'title' => lang('success'), 
                                        'text' => lang('video').' #'.$id.lang('addlang').' '.$lang,
                                        'type' => 'success'
                                    );
                                } else {
                                    $notify = array(
                                        'title' => lang('success'), 
                                        'text' => lang('video').' #'.$id.lang('edited'),
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
                        redirect(my_library::admin_site()."video");
                    }
                }
                //End
                $this->_data['id'] = $id;
                $this->_data['token_name'] = $this->security->get_csrf_token_name();
                $this->_data['token_value'] = $this->security->get_csrf_hash();
                $this->_data['title'] = lang('videoedit');
                $this->_data['category'] = $this->mcategory->dropdownlistCategory($this->_data['formData']['video_parent'],$this->_data['langPost']['lang_code'],'video');
                $this->_data['video_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
                $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','switchery.min.css','cropper.min.css'];
                $this->_data['extraJs'] = ['validator.js','icheck.min.js','language/'.$this->_data['language'].'.js','switchery.min.js','cropper.min.js','tinymce/jquery.tinymce.min.js','tinymce/tinymce.min.js','alias.js','module/video-alias.js','module/video.js'];
                $this->my_layout->view("admin/video/post", $this->_data);
			} else {
				$notify = array(
                    'title' => lang('notfound'), 
                    'text' => lang('video').lang('notexists'),
                    'type' => 'warning'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."video");
			}
		} else {
			$notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'warning'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."video");
		}
	}

	public function delete($id)
	{
		$this->mpermission->checkPermission("video","delete",$this->_data['user_active']['active_user_group']);
		if (is_numeric($id) && $id > 0) {
            $myVideo = $this->mvideo->getData("",array('id' => $id));
            if ($myVideo) {
                $this->mvideo->delete($id);
                $this->mvideo_translation->deleteAnd(array('video_id' => $id));
                $folderName = realpath(APPPATH . "../media/video/")."/".$id;
                $this->mvideo->delFolder($folderName);
                $this->mactivity->deleteAnd(array('activity_component' => 11,'activity_id_com' => $id));
                $this->mactivity->addActivity(11,$id,3,$this->_data['user_active']['active_user_id']);
                $title = lang('success');
                $text = lang('video').lang('deleted');
                $type = 'success';
            } else {
                $title = lang('unsuccessful');
                $text = lang('notfound').' '.lang('video');
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
        redirect(my_library::admin_site()."video");
	}

	public function deleteImage()
	{
		$rs = 0;
		if ($this->mpermission->permission("video_deleteimg",$this->_data['user_active']['active_user_group']) == true) {
			$id = $this->input->get('id');
			if (is_numeric($id) > 0) {
				$myVideo = $this->mvideo->getData("video_picture",array('id' => $id));
				if (!empty($myVideo)) {
					$this->mvideo->delimage($id,$myVideo['video_picture']);
					if ($this->mvideo->edit($id,array('video_picture' => ''))) {
						$rs = 1;
					}
				}
			}
		}
		echo $rs;
	}
}
