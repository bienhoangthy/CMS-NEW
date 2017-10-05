<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Page extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->lang->load('page',$this->_data['language']);
        $this->load->Model("admin/mpage");
        $this->load->Model("admin/mactivity");
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
    }

    public function index()
    {
    	$this->mpermission->checkPermission("page","index",$this->_data['user_active']['active_user_group']);
    	$this->_data['flanguage'] = $_GET['flanguage'] ?? $this->_data['language'];
    	$this->_data['title'] = lang('list');
        $this->_data['flanguage'] = $this->mlanguage->getLanguage($this->_data['flanguage']);
    	$this->_data['list'] = $this->mpage->getPage($this->_data['flanguage']['lang_code']);
    	$this->my_layout->view("admin/page/index", $this->_data);
    }

    public function add()
    {
    	$this->mpermission->checkPermission("page","add",$this->_data['user_active']['active_user_group']);
    	$this->_data['langPost'] = $_GET['lang'] ?? $this->_data['language'];
    	$this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
        $this->_data['formData'] = array( 
        	'page_template' => 0, 
        	'page_status' => 1, 
            'page_picture' => '',
            'page_orderby' => 0
        );
        $this->_data['formDataLang'] = array(
        	'page_title' => '',
        	'page_alias' => '',
        	'page_detail' => '',
        	'page_seo_title' => '',
        	'page_seo_description' => '',
        	'page_seo_keyword' => ''
        );
        if (isset($_POST['page_title'])) {
        	$this->load->helper('alias');
            $lang = $this->input->post('page_lang') ?? $this->_data['language'];
            $this->_data['formData'] = array( 
                'page_template' => $this->input->post('page_template'), 
                'page_status' => $this->input->post('page_status'), 
                'page_picture' => '',
                'page_orderby' => $this->input->post('page_orderby'),
                'page_updatedate' => date("Y-m-d"),
                'user' => $this->_data['user_active']['active_user_id']
            );
            $alias = to_alias($this->input->post('page_title'));
            $this->_data['formDataLang'] = array(
                'page_id' => 0,
                'language_code' => $lang,
                'page_title' => $this->input->post('page_title'),
                'page_alias' => $alias ?? time(),
                'page_detail' => $this->input->post('page_detail'),
                'page_seo_title' => $this->input->post('page_seo_title'),
                'page_seo_description' => $this->input->post('page_seo_description'),
                'page_seo_keyword' => $this->input->post('page_seo_keyword')
            );
            $checkName = $this->mpage_translation->getData('id',array('page_title' => $this->_data['formDataLang']['page_title']));
            $checkAlias = $this->mpage_translation->getData('id',array('page_alias' => $this->_data['formDataLang']['page_alias']));
            $error = false;
            do {
                if ($this->_data['formData']['page_template'] == 0) {
                    $text = lang('pleasechoose').lang('template');$error = true;break;
                }
                if ($this->_data['formDataLang']['page_title'] == null) {
                    $text = lang('pleaseinput').lang('titlepage');$error = true;break;
                }
                if ($this->_data['formDataLang']['page_alias'] == null) {
                    $text = lang('pleaseinput').'alias';$error = true;break;
                }
                if ($checkName && $checkName['id'] > 0) {
                    $text = lang('titlepage').lang('exists');$error = true;break;
                }
                if ($checkAlias && $checkAlias['id'] > 0) {
                    $this->_data['formDataLang']['page_alias'] = $this->_data['formDataLang']['page_alias'].'-1';
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
                    $this->_data['formData']['page_picture'] = $this->mpage->saveImage($file,$this->_data['formDataLang']['page_alias']);
                }
                $insert = $this->mpage->add($this->_data['formData']);
                if (is_numeric($insert)  && $insert > 0) {
                    $this->mactivity->addActivity(19,$insert,1,$this->_data['user_active']['active_user_id']);
                    $this->_data['formDataLang']['page_id'] = $insert;
                    $insert_lang = $this->mpage_translation->add($this->_data['formDataLang']);
                    $titleinsertlang = is_numeric($insert_lang) > 0 ? ' | '.$lang : '';
                    $notify = array(
                        'title' => lang('success'), 
                        'text' => lang('page').' '.$this->_data['formDataLang']['page_title'].lang('added').$titleinsertlang,
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    redirect(my_library::admin_site()."page");
                }
            }
        }
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
		$this->_data['title'] = lang('addpage');
		$this->_data['template'] = $this->mpage->dropdownlistTemplate($this->_data['formData']['page_template']);
        $this->_data['page_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','cropper.min.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js','cropper.min.js','tinymce/jquery.tinymce.min.js','tinymce/tinymce.min.js','module/page.js'];
		$this->my_layout->view("admin/page/post", $this->_data);
    }

    public function edit($id)
    {
        $this->mpermission->checkPermission("page","edit",$this->_data['user_active']['active_user_group']);
        if (is_numeric($id) && $id > 0) {
            $myPage = $this->mpage->getData("",array('id' => $id));
            if ($myPage && $myPage['id'] > 0) {
                $this->_data['langPost'] = $_GET['lang'] ?? $this->_data['language'];
                $this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
                $this->_data['formData'] = array( 
                    'page_template' => $myPage['page_template'], 
                    'page_status' => $myPage['page_status'], 
                    'page_picture' => $myPage['page_picture'],
                    'page_orderby' => $myPage['page_orderby'],
                    'page_updatedate' => date("Y-m-d"),
                    'user' => $this->_data['user_active']['active_user_id']
                );
                $myPage_lang = $this->mpage_translation->getData("",array('page_id' => $id,'language_code' => $this->_data['langPost']['lang_code']));
                if (!empty($myPage_lang)) {
                    $this->_data['formDataLang'] = array(
                        'page_title' => $myPage_lang['page_title'],
                        'page_alias' => $myPage_lang['page_alias'],
                        'page_detail' => $myPage_lang['page_detail'],
                        'page_seo_title' => $myPage_lang['page_seo_title'],
                        'page_seo_description' => $myPage_lang['page_seo_description'],
                        'page_seo_keyword' => $myPage_lang['page_seo_keyword']
                    );
                } else {
                    $this->_data['formDataLang'] = array(
                        'page_title' => '',
                        'page_alias' => '',
                        'page_detail' => '',
                        'page_seo_title' => '',
                        'page_seo_description' => '',
                        'page_seo_keyword' => ''
                    );
                }
                if (isset($_POST['page_title'])) {
                    $this->load->helper('alias');
                    $lang = $this->input->post('page_lang') ?? $this->_data['language'];
                    $this->_data['formData'] = array( 
                        'page_template' => $this->input->post('page_template'), 
                        'page_status' => $this->input->post('page_status'), 
                        'page_picture' => $myPage['page_picture'],
                        'page_orderby' => $this->input->post('page_orderby'),
                        'page_updatedate' => date("Y-m-d"),
                        'user' => $this->_data['user_active']['active_user_id']
                    );
                    $alias = to_alias($this->input->post('page_title'));
                    $this->_data['formDataLang'] = array(
                        'page_id' => $id,
                        'language_code' => $lang,
                        'page_title' => $this->input->post('page_title'),
                        'page_alias' => $alias ?? time(),
                        'page_detail' => $this->input->post('page_detail'),
                        'page_seo_title' => $this->input->post('page_seo_title'),
                        'page_seo_description' => $this->input->post('page_seo_description'),
                        'page_seo_keyword' => $this->input->post('page_seo_keyword')
                    );
                    $checkName = $this->mpage_translation->getData('id',array('page_id <> ' => $id,'page_title' => $this->_data['formDataLang']['page_title']));
                    $checkAlias = $this->mpage_translation->getData('id',array('page_id <> ' => $id,'page_alias' => $this->_data['formDataLang']['page_alias']));
                    $error = false;
                    do {
                        if ($this->_data['formData']['page_template'] == 0) {
                            $text = lang('pleasechoose').lang('template');$error = true;break;
                        }
                        if ($this->_data['formDataLang']['page_title'] == null) {
                            $text = lang('pleaseinput').lang('titlepage');$error = true;break;
                        }
                        if ($this->_data['formDataLang']['page_alias'] == null) {
                            $text = lang('pleaseinput').'alias';$error = true;break;
                        }
                        if ($checkName && $checkName['id'] > 0) {
                            $text = lang('titlepage').lang('exists');$error = true;break;
                        }
                        if ($checkAlias && $checkAlias['id'] > 0) {
                            $this->_data['formDataLang']['page_alias'] = $this->_data['formDataLang']['page_alias'].'-1';
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
                            $this->_data['formData']['page_picture'] = $this->mpage->saveImage($file,$this->_data['formDataLang']['page_alias']);
                            $this->mpage->delimage($myPage['page_picture']);
                        }
                        if ($this->mpage->edit($id,$this->_data['formData'])) {
                            $this->mactivity->addActivity(19,$id,2,$this->_data['user_active']['active_user_id']);
                            if (!empty($myPage_lang)) {
                                if ($this->mpage_translation->edit($myPage_lang['id'],$this->_data['formDataLang'])) {
                                    $notify = array(
                                        'title' => lang('success'), 
                                        'text' => lang('page').' '.$this->_data['formDataLang']['page_title'].lang('edited').' | '.$lang,
                                        'type' => 'success'
                                    );
                                }
                            } else {
                                $insert_lang = $this->mpage_translation->add($this->_data['formDataLang']);
                                if (is_numeric($insert_lang) > 0) {
                                    $notify = array(
                                        'title' => lang('success'), 
                                        'text' => lang('page').' '.$this->_data['formDataLang']['page_title'].lang('addlang').' '.$lang,
                                        'type' => 'success'
                                    );
                                } else {
                                    $notify = array(
                                        'title' => lang('success'), 
                                        'text' => lang('page').' #'.$id.lang('edited'),
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
                        redirect(my_library::admin_site()."page");
                    }
                }
                $this->_data['id'] = $id;
                $this->_data['token_name'] = $this->security->get_csrf_token_name();
                $this->_data['token_value'] = $this->security->get_csrf_hash();
                $this->_data['title'] = lang('pageedit')." #".$id;
                $this->_data['template'] = $this->mpage->dropdownlistTemplate($this->_data['formData']['page_template']);
                $this->_data['page_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
                $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','cropper.min.css'];
                $this->_data['extraJs'] = ['validator.js','language/'.$this->_data['language'].'.js','icheck.min.js','cropper.min.js','tinymce/jquery.tinymce.min.js','tinymce/tinymce.min.js','module/page.js'];
                $this->my_layout->view("admin/page/post", $this->_data);
            } else {
                $notify = array(
                    'title' => lang('notfound'), 
                    'text' => lang('page').lang('notexists'),
                    'type' => 'warning'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."page");
            }
        } else {
            $notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'warning'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."page");
        }
    }

    public function delete($id)
    {
        $this->mpermission->checkPermission("page","delete",$this->_data['user_active']['active_user_group']);
        if (is_numeric($id) && $id > 0) {
            $myPage = $this->mpage->getData("",array('id' => $id));
            if ($myPage && $myPage['id'] > 0) {
                $this->mpage->delete($id);
                $this->mpage_translation->deleteAnd(array('page_id' => $id));
                $this->mpage->delimage($myPage['page_picture']);
                $this->mactivity->deleteAnd(array('activity_component' => 19,'activity_id_com' => $id));
                $this->mactivity->addActivity(19,$id,3,$this->_data['user_active']['active_user_id']);
                $title = lang('success');
                $text = lang('page').lang('deleted');
                $type = 'success';
            } else {
                $title = lang('unsuccessful');
                $text = lang('notfound').' '.lang('page');
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
        redirect(my_library::admin_site()."page");
    }

    public function deleteImage()
    {
    	$rs = 0;
		if ($this->mpermission->permission("page_deleteimg",$this->_data['user_active']['active_user_group']) == true) {
			$id = $this->input->get('id');
			if (is_numeric($id) > 0) {
				$myPage = $this->mpage->getData("page_picture",array('id' => $id));
				if (!empty($myPage)) {
					$this->mpage->delimage($myPage['page_picture']);
					if ($this->mpage->edit($id,array('page_picture' => ''))) {
						$rs = 1;
					}
				}
			}
		}
		echo $rs;
    }
}
