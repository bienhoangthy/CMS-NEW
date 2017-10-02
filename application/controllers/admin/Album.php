<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Album extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('album',$this->_data['language']);
        $this->load->Model("admin/mcategory");
        $this->load->Model("admin/malbum");
        $this->load->Model("admin/malbum_detail");
        $this->load->Model("admin/mactivity");
    }
	public function index()
	{
		$this->mpermission->checkPermission("album","index",$this->_data['user_active']['active_user_group']);
		$this->load->library("My_paging");
        $this->_data['title'] = lang('list');
        $obj = 'a.id,a.album_parent,a.album_status,a.album_hot,a.album_view,a.album_picture,a.album_updatedate,a.user,at.album_name';
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
                $and .= ' and a.album_hot = 1';
            } else {
                $and .= ' and a.album_status = '. $this->_data['formData']['fstatus'];
            }
        }
        if ($this->_data['formData']['fuser'] > 0) {
            $and .= ' and a.user = '. $this->_data['formData']['fuser'];
        }
        if ($this->_data['formData']['fcategory'] > 0) {
            $and .= ' and a.album_parent = '. $this->_data['formData']['fcategory'];
        }
        if ($this->_data['formData']['fkeyword'] != '') {
            $and .= ' and (at.album_name like "%' . $this->_data['formData']['fkeyword'] . '%"';
            $and .= ' or at.album_alias like "%' . $this->_data['formData']['fkeyword'] . '%")';
        }
        $and .= ' and at.language_code = "'.$this->_data['flanguage']['lang_code'].'"';
        $orderby = 'a.album_orderby desc, a.id desc';
        $paging['per_page'] = 20;
        $paging['num_links'] = 5;
        $paging['page'] = $this->_data['page'] = $_GET['page'] ?? 1;
        $paging['start'] = (($paging['page'] - 1) * $paging['per_page']);
        $query_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? str_replace("&page=" . $this->_data['page'], "", $_SERVER['QUERY_STRING']) : '';
        $paging['base_url'] = my_library::admin_site() . 'album/?' . $query_string . '&page=';
        $limit = $paging['start'] . ',' . $paging['per_page'];
        $this->_data['list'] = $this->malbum->getAlbum($obj, $and, $orderby, $limit);
        $this->_data['record'] = $this->malbum->countAlbum($and);
        $this->_data["pagination"] = $this->my_paging->paging_donturl($this->_data["record"], $paging['page'], $paging['per_page'], $paging['num_links'], $paging['base_url']);
        $this->_data['fstatus'] = $this->malbum->dropdownlistStatus($this->_data['formData']['fstatus']);
        $this->_data['fuser'] = $this->muser->dropdownlistUser($this->_data['formData']['fuser']);
        $this->_data['fcategory'] = $this->mcategory->dropdownlistCategory($this->_data['formData']['fcategory'],$this->_data['formData']['flanguage'],'album');
        $this->my_layout->view("admin/album/index", $this->_data);
	}

	public function add()
	{
		$this->mpermission->checkPermission("album","add",$this->_data['user_active']['active_user_group']);
		$this->_data['langPost'] = $_GET['lang'] ?? $this->_data['language'];
    	$this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
        $this->_data['formData'] = array( 
        	'album_parent' => 0, 
        	'album_status' => 1, 
            'album_hot' => 0,
            'album_view' => 0,
            'album_orderby' => 0,
        	'album_picture' => ''
        );
        $this->_data['formDataLang'] = array(
        	'album_name' => '',
        	'album_alias' => '',
        	'album_description' => ''
        );
        //Post
        if (isset($_POST['album_name'])) {
        	$lang = $this->input->post('album_lang') ?? $this->_data['language'];
        	$this->_data['formData'] = array( 
	        	'album_parent' => $this->input->post('album_parent'), 
	        	'album_status' => $this->input->post('album_status'), 
                'album_hot' => $this->input->post('album_hot') ?? 0,
	            'album_view' => $this->input->post('album_view'),
	            'album_orderby' => $this->input->post('album_orderby'),
	            'album_picture' => '',
                'album_createdate' => date("Y-m-d H:i:s"),
	        	'album_updatedate' => date("Y-m-d H:i:s"),
	        	'user' => $this->_data['user_active']['active_user_id']
	        );
            $this->load->helper('alias');
	        $alias = to_alias($this->input->post('album_name'));
	        $this->_data['formDataLang'] = array(
	        	'album_id' => 0,
	        	'language_code' => $lang,
	        	'album_name' => $this->input->post('album_name'),
	        	'album_alias' => $alias ?? time(),
	        	'album_description' => $this->input->post('album_description')
	        );
            $checkAlias = $this->malbum_translation->getData('id',array('album_alias' => $this->_data['formDataLang']['album_alias']));
            $error = false;
            do {
                if ($this->_data['formDataLang']['album_name'] == null) {
                    $text = lang('pleaseinput').lang('albumname');$error = true;break;
                }
                if ($checkAlias && $checkAlias['id'] > 0) {
                    $this->_data['formDataLang']['album_alias'] = $this->_data['formDataLang']['album_alias'].'-1';
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
            	$insert = $this->malbum->add($this->_data['formData']);
            	if (is_numeric($insert) && $insert > 0) {
                    $this->mactivity->addActivity(10,$insert,1,$this->_data['user_active']['active_user_id']);
            		$file = $this->input->post('file');
	                if ($file != null) {
	                    $album_picture = $this->malbum->saveImage($file,$insert,$this->_data['formDataLang']['album_alias']);
	                    if ($album_picture != '') {
	                    	$this->malbum->edit($insert,array('album_picture' => $album_picture));
	                    }
	                }
	                $this->_data['formDataLang']['album_id'] = $insert;
	                $insert_lang = $this->malbum_translation->add($this->_data['formDataLang']);
	                $titleinsertlang = is_numeric($insert_lang) > 0 ? ' | '.$lang : '';
                    $notify = array(
                        'title' => lang('success'), 
                        'text' => lang('album').' #'.$insert.lang('added').$titleinsertlang,
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    redirect(my_library::admin_site()."album/index");
            	}
            }
        }
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
		$this->_data['title'] = lang('albumadd');
		$this->_data['category'] = $this->mcategory->dropdownlistCategory($this->_data['formData']['album_parent'],$this->_data['langPost']['lang_code'],'album');
        $this->_data['album_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','switchery.min.css','cropper.min.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js','language/'.$this->_data['language'].'.js','switchery.min.js','cropper.min.js','tinymce/jquery.tinymce.min.js','tinymce/tinymce.min.js','module/album.js'];
		$this->my_layout->view("admin/album/post", $this->_data);
	}

	public function edit($id)
	{
		$this->mpermission->checkPermission("album","edit",$this->_data['user_active']['active_user_group']);
		if (is_numeric($id) && $id > 0) {
			$myAlbum = $this->malbum->getData("",array('id' => $id));
			if ($myAlbum && $myAlbum['id'] > 0) {
				$this->_data['langPost'] = $_GET['lang'] ?? $this->_data['language'];
                $this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
                $this->_data['formData'] = array( 
                    'album_parent' => $myAlbum['album_parent'], 
                    'album_status' => $myAlbum['album_status'], 
                    'album_hot' => $myAlbum['album_hot'],
                    'album_view' => $myAlbum['album_view'],
                    'album_orderby' => $myAlbum['album_orderby'],
                    'album_picture' => $myAlbum['album_picture']
                );
                $myAlbum_lang = $this->malbum_translation->getData("",array('album_id' => $id,'language_code' => $this->_data['langPost']['lang_code']));
                if (!empty($myAlbum_lang)) {
                    $this->_data['formDataLang'] = array(
                        'album_name' => $myAlbum_lang['album_name'],
                        'album_alias' => $myAlbum_lang['album_alias'],
                        'album_description' => $myAlbum_lang['album_description']
                    );
                } else {
                    $this->_data['formDataLang'] = array(
                        'album_name' => '',
                        'album_alias' => '',
                        'album_description' => ''
                    );
                }
                //Post
                if (isset($_POST['album_name'])) {
                    $lang = $this->input->post('album_lang') ?? $this->_data['language'];
                    $this->_data['formData'] = array( 
                        'album_parent' => $this->input->post('album_parent'), 
                        'album_status' => $this->input->post('album_status'), 
                        'album_hot' => $this->input->post('album_hot'),
                        'album_view' => $this->input->post('album_view'),
                        'album_orderby' => $this->input->post('album_orderby'),
                        'album_picture' => $myAlbum['album_picture'],
                        'album_updatedate' => date("Y-m-d H:i:s"),
                        'user' => $this->_data['user_active']['active_user_id']
                    );
                    $alias = $this->input->post('album_alias');
                    if ($alias == null) {
                        $this->load->helper('alias');
                        $alias = to_alias($this->input->post('album_name'));
                    }
                    $this->_data['formDataLang'] = array(
                        'album_id' => $id,
                        'language_code' => $lang,
                        'album_name' => $this->input->post('album_name'),
                        'album_alias' => $alias ?? time(),
                        'album_description' => $this->input->post('album_description')
                    );
                    $checkAlias = $this->malbum_translation->getData('id',array('album_alias' => $this->_data['formDataLang']['album_alias'],'album_id <> ' => $id));
                    $error = false;
                    do {
                        if ($this->_data['formDataLang']['album_name'] == null) {
                            $text = lang('pleaseinput').lang('albumname');$error = true;break;
                        }
                        if ($checkAlias && $checkAlias['id'] > 0) {
                            $this->_data['formDataLang']['album_alias'] = $this->_data['formDataLang']['album_alias'].'-1';
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
                            $album_picture = $this->malbum->saveImage($file,$id,$this->_data['formDataLang']['album_alias']);
                            if ($album_picture != '') {
                                $this->_data['formData']['album_picture'] = $album_picture;
                                $this->malbum->delimage($id,$myAlbum['album_picture']);
                            }
                        }
                        if ($this->malbum->edit($id,$this->_data['formData'])) {
                            $this->mactivity->addActivity(10,$id,2,$this->_data['user_active']['active_user_id']);
                            if (!empty($myAlbum_lang)) {
                                if ($this->malbum_translation->edit($myAlbum_lang['id'],$this->_data['formDataLang'])) {
                                    $notify = array(
                                        'title' => lang('success'), 
                                        'text' => lang('album').' #'.$id.lang('edited').' | '.$lang,
                                        'type' => 'success'
                                    );
                                }
                            } else {
                                $insert_lang = $this->malbum_translation->add($this->_data['formDataLang']);
                                if (is_numeric($insert_lang) > 0) {
                                    $notify = array(
                                        'title' => lang('success'), 
                                        'text' => lang('album').' #'.$id.lang('addlang').' '.$lang,
                                        'type' => 'success'
                                    );
                                } else {
                                    $notify = array(
                                        'title' => lang('success'), 
                                        'text' => lang('album').' #'.$id.lang('edited'),
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
                        redirect(my_library::admin_site()."album/index");
                    }
                }
                //End
                $this->_data['id'] = $id;
                $this->_data['token_name'] = $this->security->get_csrf_token_name();
                $this->_data['token_value'] = $this->security->get_csrf_hash();
                $this->_data['title'] = lang('albumedit');
                $this->_data['category'] = $this->mcategory->dropdownlistCategory($this->_data['formData']['album_parent'],$this->_data['langPost']['lang_code'],'album');
                $this->_data['album_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
                $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','switchery.min.css','cropper.min.css'];
                $this->_data['extraJs'] = ['validator.js','icheck.min.js','language/'.$this->_data['language'].'.js','switchery.min.js','cropper.min.js','tinymce/jquery.tinymce.min.js','tinymce/tinymce.min.js','module/album-alias.js','module/album.js'];
                $this->my_layout->view("admin/album/post", $this->_data);
			} else {
				$notify = array(
                    'title' => lang('notfound'), 
                    'text' => lang('album').lang('notexists'),
                    'type' => 'warning'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."album");
			}
		} else {
			$notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'warning'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."album");
		}
	}

	public function delete($id)
	{
		$this->mpermission->checkPermission("album","delete",$this->_data['user_active']['active_user_group']);
		if (is_numeric($id) && $id > 0) {
            $myAlbum = $this->malbum->getData("",array('id' => $id));
            if ($myAlbum) {
                $this->malbum->delete($id);
                $this->malbum_translation->deleteAnd(array('album_id' => $id));
                $this->malbum_detail->deleteAnd(array('album_id' => $id));
                $folderName = realpath(APPPATH . "../media/album/")."/".$id;
                $this->malbum->delFolder($folderName);
                $this->mactivity->deleteAnd(array('activity_component' => 10,'activity_id_com' => $id));
                $this->mactivity->addActivity(10,$id,3,$this->_data['user_active']['active_user_id']);
                $title = lang('success');
                $text = lang('album').lang('deleted');
                $type = 'success';
            } else {
                $title = lang('unsuccessful');
                $text = lang('notfound').' '.lang('album');
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
        redirect(my_library::admin_site()."album/index/");
	}

    public function upload($id)
    {
        $this->mpermission->checkPermission("album","upload",$this->_data['user_active']['active_user_group']);
        if (is_numeric($id) && $id > 0) {
            $myAlbum = $this->malbum->getData("id",array('id' => $id));
            if ($myAlbum && $myAlbum['id'] > 0) {
            	$this->_data['listPhotos'] = $this->malbum_detail->getQuery("","album_id = ".$id,"","");
                $this->_data['id'] = $id;
                $this->_data['token_name'] = $this->security->get_csrf_token_name();
                $this->_data['token_value'] = $this->security->get_csrf_hash();
                $this->_data['title'] = lang('detailphoto').' #'.$id;
                $this->_data['extraJs'] = ['language/'.$this->_data['language'].'.js','module/album-upload.js'];
                $this->my_layout->view("admin/album/upload-detail", $this->_data);
            } else {
                $notify = array(
                    'title' => lang('notfound'), 
                    'text' => lang('album').lang('notexists'),
                    'type' => 'warning'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."album");
            }
        } else {
            $notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'warning'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."album");
        }
    }

    public function editDescription()
    {
    	$rs = 0;
    	if ($this->mpermission->permission("album_editdescription",$this->_data['user_active']['active_user_group']) == true) {
    		$id = $this->input->get('id');
    		$description = $this->input->get('description');
    		if ($id != null && $description != null) {
    			if ($this->malbum_detail->edit($id,array('description' => $description))) {
    				$rs = 1;
    			}
    		}
    	}
    	echo $rs;
    }

    public function uploadAction()
    {
        $this->mpermission->checkPermission("album","upload",$this->_data['user_active']['active_user_group']);
        $id = $this->input->post("id");
        $num = 0;
        if ($id) {
            $this->load->library('upload');
            $files = $_FILES;
            $cpt = count($_FILES['userfile']['name']);
            //Config
            $path = realpath(APPPATH . "../media/album").'/'.$id;
            if (!is_dir($path)) {
	            mkdir($path, 0777, true);
	            chmod($path, 0777);
	        }
	        $config = array();
	        $config['upload_path'] = $path;
	        $config['allowed_types'] = 'gif|jpg|png|jpeg';
	        $config['max_size']      = '0';
	        $config['overwrite']     = FALSE;
            for($i=0; $i<$cpt; $i++)
            {         
            	if ($files['userfile']['name'][$i] != '') {
            		$_FILES['userfile']['name']= time().$files['userfile']['name'][$i];
	                $_FILES['userfile']['type']= $files['userfile']['type'][$i];
	                $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
	                $_FILES['userfile']['error']= $files['userfile']['error'][$i];
	                $_FILES['userfile']['size']= $files['userfile']['size'][$i];    

	                $this->upload->initialize($config);
	                if ($this->upload->do_upload()) {
	                	$dataAdd = array(
		                    'album_id' => $id,
		                    'picture' => $_FILES['userfile']['name'],
		                    'description' => ''
		                );
		                $rs = $this->malbum_detail->add($dataAdd);
		                if ($rs) {
		                	// $myPhoto = $this->malbum_detail->getData("picture",array('id' => $rs));
		                	// if ($myPhoto && $myPhoto['picture'] != '') {
		                	// 	$this->malbum->do_resize_detail($path.'/'.$myPhoto['picture'],$path);
		                	// }
		                    $num++;
		                }
	                }
            	}
            }
            if ($num > 0) {
                $notify = array(
                    'title' => lang('success'), 
                    'text' => lang('upload').' '.$num.lang('photo'),
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
        }
        redirect(my_library::admin_site()."album/upload/".$id);
    }

	public function deleteImage()
	{
		$rs = 0;
		if ($this->mpermission->permission("album_deleteimg",$this->_data['user_active']['active_user_group']) == true) {
			$id = $this->input->get('id');
			if (is_numeric($id) > 0) {
				$myAlbum = $this->malbum->getData("album_picture",array('id' => $id));
				if (!empty($myAlbum)) {
					$this->malbum->delimage($id,$myAlbum['album_picture']);
					if ($this->malbum->edit($id,array('album_picture' => ''))) {
						$rs = 1;
					}
				}
			}
		}
		echo $rs;
	}

	public function deleteImageDetail()
	{
		$rs = 0;
		if ($this->mpermission->permission("album_deleteimg",$this->_data['user_active']['active_user_group']) == true) {
			$id = $this->input->get('id');
			if (is_numeric($id) > 0) {
				$myPhoto = $this->malbum_detail->getData("album_id,picture",array('id' => $id));
				if (!empty($myPhoto)) {
					$this->malbum->delimage($myPhoto['album_id'],$myPhoto['picture']);
					$this->malbum_detail->delete($id);
					$rs = 1;
				}
			}
		}
		echo $rs;
	}
}
