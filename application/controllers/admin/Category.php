<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('category',$this->_data['language']);
        $this->load->Model("admin/mcategory");
        $this->load->Model("admin/mcomponent");
    }
	public function index()
	{
		$this->mpermission->checkPermission("category","index",$this->_data['user_active']['active_user_group']);
        $this->_data['flanguage'] = isset($_GET['flanguage']) ? $_GET['flanguage'] : $this->_data['language'];
        $this->_data['flanguage'] = $this->mlanguage->getLanguage($this->_data['flanguage']);
    	$this->_data['title'] = lang('list');
		$this->_data['list'] = $this->mcategory->getCategory($this->_data['flanguage']['lang_code']);
		//var_dump($this->_data['list']);die();
		$this->my_layout->view("admin/category/index", $this->_data);
	}

	public function add()
	{
		$this->mpermission->checkPermission("category","add",$this->_data['user_active']['active_user_group']);
		$this->_data['langPost'] = isset($_GET['lang']) ? $_GET['lang'] : $this->_data['language'];
    	$this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
        $this->_data['formData'] = array( 
        	'category_parent' => 0, 
        	'category_component' => '', 
            'category_icon' => '',
            'category_view_type' => 1,
            'category_orderby' => 0,
        	'category_status' => 1,
        	'category_picture' => ''
        );
        $this->_data['formDataLang'] = array(
        	'category_name' => '',
        	'category_alias' => '',
        	'category_detail' => '',
        	'category_seo_title' => '',
        	'category_seo_description' => '',
        	'category_seo_keyword' => ''
        );
        if (isset($_POST['category_name'])) {
        	$this->load->helper('alias');
        	$lang = $this->input->post('category_lang') != null ? $this->input->post('category_lang') : $this->_data['language'];
        	$this->_data['formData'] = array( 
	        	'category_parent' => $this->input->post('category_parent'),
	        	'category_component' => $this->input->post('category_component'),
	            'category_icon' => $this->input->post('category_icon'),
	            'category_view_type' => $this->input->post('category_view_type'),
	            'category_orderby' => $this->input->post('category_orderby'),
	        	'category_status' => $this->input->post('category_status'),
	        	'category_picture' => '',
	        	'category_createdate' => date("Y-m-d"),
	        	'category_updatedate' => date("Y-m-d"),
	        	'user' => $this->_data['user_active']['active_user_id']
	        );
	        $alias = to_alias($this->input->post('category_name'));
	        $this->_data['formDataLang'] = array(
	        	'category_id' => 0,
	        	'language_code' => $lang,
	        	'category_name' => $this->input->post('category_name'),
	        	'category_alias' => $alias,
	        	'category_detail' => $this->input->post('category_detail'),
	        	'category_seo_title' => $this->input->post('category_seo_title'),
	        	'category_seo_description' => $this->input->post('category_seo_description'),
	        	'category_seo_keyword' => $this->input->post('category_seo_keyword')
	        );
	        $checkName = $this->mcategory_translation->getData('id',array('category_name' => $this->_data['formDataLang']['category_name']));
	        $checkAlias = $this->mcategory_translation->getData('id',array('category_alias' => $this->_data['formDataLang']['category_alias']));
	        $error = false;
	        do {
	        	if ($this->_data['formData']['category_parent'] == null) {
	        		$text = lang('pleasechoose').lang('categoryparent');$error = true;break;
	        	}
	        	if ($this->_data['formData']['category_component'] == null) {
	        		$text = lang('pleasechoose').'component';$error = true;break;
	        	}
	        	if ($this->_data['formDataLang']['category_name'] == null) {
	        		$text = lang('pleaseinput').lang('categoryname');$error = true;break;
	        	}
	        	if ($this->_data['formDataLang']['category_alias'] == null) {
	        		$text = lang('pleaseinput').'alias';$error = true;break;
	        	}
	        	if ($checkName && $checkName['id'] > 0) {
	        		$text = lang('categoryname').lang('exists');$error = true;break;
	        	}
	        	if ($checkAlias && $checkAlias['id'] > 0) {
	        		//$text = 'Alias'.lang('exists');$error = true;break;
	        		$this->_data['formDataLang']['category_alias'] = $this->_data['formDataLang']['category_alias'].'-1';
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
					$this->_data['formData']['category_picture'] = $this->mcategory->saveImage($file,$this->_data['formDataLang']['category_alias']);
				}
				$insert = $this->mcategory->add($this->_data['formData']);
				if (is_numeric($insert) > 0) {
					$this->_data['formDataLang']['category_id'] = $insert;
					$insert_lang = $this->mcategory_translation->add($this->_data['formDataLang']);
					$titleinsertlang = is_numeric($insert_lang) > 0 ? ' | '.$lang : '';
                	$notify = array(
                        'title' => lang('success'), 
                        'text' => lang('category').' '.$this->_data['formDataLang']['category_name'].lang('added').$titleinsertlang,
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    redirect(my_library::admin_site()."category");
				}
	        }
        }
		$this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
		$this->_data['title'] = lang('categoryadd');
		$this->_data['typeview'] = $this->mcategory->dropdownlistType($this->_data['formData']['category_view_type']);
		$this->_data['parent'] = $this->mcategory->selectParent($this->_data['language'],$this->_data['formData']['category_parent']);
		$this->_data['component'] = $this->mcomponent->dropdownlist($this->_data['formData']['category_component']);
        $this->_data['category_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','cropper.min.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js','cropper.min.js','tinymce/jquery.tinymce.min.js','tinymce/tinymce.min.js','module/category.js'];
		$this->my_layout->view("admin/category/post", $this->_data);
	}

	public function edit($id)
	{
		$this->mpermission->checkPermission("category","edit",$this->_data['user_active']['active_user_group']);
		if (is_numeric($id) && $id > 0) {
			$myCategory = $this->mcategory->getData("",array('id' => $id));
			if ($myCategory && $myCategory['id'] > 0) {
				$this->_data['langPost'] = isset($_GET['lang']) ? $_GET['lang'] : $this->_data['language'];
				$this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
				$this->_data['formData'] = array( 
		        	'category_parent' => $myCategory['category_parent'], 
		        	'category_component' => $myCategory['category_component'], 
		            'category_icon' => $myCategory['category_icon'],
		            'category_view_type' => $myCategory['category_view_type'],
		            'category_orderby' => $myCategory['category_orderby'],
		        	'category_status' => $myCategory['category_status'],
		        	'category_picture' => $myCategory['category_picture'],
		        	'category_updatedate' => date("Y-m-d"),
	        		'user' => $this->_data['user_active']['active_user_id']
		        );
		        $myCategory_lang = $this->mcategory_translation->getData("id,category_name,category_alias,category_detail,category_seo_title,category_seo_description,category_seo_keyword",array('category_id' => $id,'language_code' => $this->_data['langPost']['lang_code']));
		        if (!empty($myCategory_lang)) {
		        	$this->_data['formDataLang'] = array(
			        	'category_name' => $myCategory_lang['category_name'],
			        	'category_alias' => $myCategory_lang['category_alias'],
			        	'category_detail' => $myCategory_lang['category_detail'],
			        	'category_seo_title' => $myCategory_lang['category_seo_title'],
			        	'category_seo_description' => $myCategory_lang['category_seo_description'],
			        	'category_seo_keyword' => $myCategory_lang['category_seo_keyword']
			        );
		        } else {
		        	$this->_data['formDataLang'] = array(
			        	'category_name' => '',
			        	'category_alias' => '',
			        	'category_detail' => '',
			        	'category_seo_title' => '',
			        	'category_seo_description' => '',
			        	'category_seo_keyword' => ''
			        );
		        }
		        if (isset($_POST['category_name'])) {
		        	$this->load->helper('alias');
		        	$lang = $this->input->post('category_lang') != null ? $this->input->post('category_lang') : $this->_data['language'];
		        	$this->_data['formData'] = array( 
			        	'category_parent' => $this->input->post('category_parent'),
			        	'category_component' => $this->input->post('category_component'),
			            'category_icon' => $this->input->post('category_icon'),
			            'category_view_type' => $this->input->post('category_view_type'),
			            'category_orderby' => $this->input->post('category_orderby'),
			        	'category_status' => $this->input->post('category_status'),
			        	'category_picture' => $myCategory['category_picture'],
			        	'category_updatedate' => date("Y-m-d"),
			        	'user' => $this->_data['user_active']['active_user_id']
			        );
			        $alias = to_alias($this->input->post('category_name'));
			        $this->_data['formDataLang'] = array(
			        	'category_id' => $id,
			        	'language_code' => $lang,
			        	'category_name' => $this->input->post('category_name'),
			        	'category_alias' => $alias,
			        	'category_detail' => $this->input->post('category_detail'),
			        	'category_seo_title' => $this->input->post('category_seo_title'),
			        	'category_seo_description' => $this->input->post('category_seo_description'),
			        	'category_seo_keyword' => $this->input->post('category_seo_keyword')
			        );
			        $checkName = $this->mcategory_translation->getData('id',array('category_id <>' => $id,'category_name' => $this->_data['formDataLang']['category_name']));
			        $checkAlias = $this->mcategory_translation->getData('id',array('category_id <>' => $id,'category_alias' => $this->_data['formDataLang']['category_alias']));
			        $error = false;
			        do {
			        	if ($this->_data['formData']['category_parent'] == null) {
			        		$text = lang('pleasechoose').lang('categoryparent');$error = true;break;
			        	}
			        	if ($this->_data['formData']['category_component'] == null) {
			        		$text = lang('pleasechoose').'component';$error = true;break;
			        	}
			        	if ($this->_data['formDataLang']['category_name'] == null) {
			        		$text = lang('pleaseinput').lang('categoryname');$error = true;break;
			        	}
			        	if ($this->_data['formDataLang']['category_alias'] == null) {
			        		$text = lang('pleaseinput').'alias';$error = true;break;
			        	}
			        	if ($checkName && $checkName['id'] > 0) {
			        		$text = lang('categoryname').lang('exists');$error = true;break;
			        	}
			        	if ($checkAlias && $checkAlias['id'] > 0) {
			        		$this->_data['formDataLang']['category_alias'] = $this->_data['formDataLang']['category_alias'].'-1';
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
							$this->_data['formData']['category_picture'] = $this->mcategory->saveImage($file,$this->_data['formDataLang']['category_alias']);
							$this->mcategory->delimage($myCategory['category_picture']);
						}
						if ($this->mcategory->edit($id,$this->_data['formData'])) {
							if (!empty($myCategory_lang)) {
								if ($this->mcategory_translation->edit($myCategory_lang['id'],$this->_data['formDataLang'])) {
									$notify = array(
				                        'title' => lang('success'), 
				                        'text' => lang('category').' '.$this->_data['formDataLang']['category_name'].lang('edited').' | '.$lang,
				                        'type' => 'success'
				                    );
								}
							} else {
								$insert_lang = $this->mcategory_translation->add($this->_data['formDataLang']);
								if (is_numeric($insert_lang) > 0) {
									$notify = array(
				                        'title' => lang('success'), 
				                        'text' => lang('category').' '.$this->_data['formDataLang']['category_name'].lang('addlang').' '.$lang,
				                        'type' => 'success'
				                    );
								} else {
									$notify = array(
				                        'title' => lang('success'), 
				                        'text' => lang('category').' '.$id.lang('edited'),
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
		                redirect(my_library::admin_site()."category");
			        }
		        }
		        $this->_data['id'] = $id;
		        $this->_data['title'] = lang('categoryedit')." #".$id;
		        $this->_data['token_name'] = $this->security->get_csrf_token_name();
		        $this->_data['token_value'] = $this->security->get_csrf_hash();
		        $this->_data['typeview'] = $this->mcategory->dropdownlistType($this->_data['formData']['category_view_type']);
				$this->_data['parent'] = $this->mcategory->selectParent($this->_data['language'],$this->_data['formData']['category_parent']);
				$this->_data['component'] = $this->mcomponent->dropdownlist($this->_data['formData']['category_component']);
		        $this->_data['category_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
		        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','cropper.min.css'];
		        $this->_data['extraJs'] = ['validator.js','icheck.min.js','cropper.min.js','language/'.$this->_data['language'].'.js','tinymce/jquery.tinymce.min.js','tinymce/tinymce.min.js','module/category.js'];
				$this->my_layout->view("admin/category/post", $this->_data);
			} else {
				$notify = array(
                    'title' => lang('notfound'), 
                    'text' => lang('category').lang('notexists'),
                    'type' => 'warning'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."category");
			}
		} else {
			$notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'warning'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."category");
		}
	}

	public function delete($id)
	{
		if (is_numeric($id) && $id > 1) {
				$myCategory = $this->mcategory->getData("",array('id' => $id));
				if ($myCategory && $myCategory['id'] > 1) {
					# code...
				} else {
					# code...
				}
				
			} else {
				# code...
			}
				
	}

	public function deleteImage()
	{
		$rs = 0;
		if ($this->mpermission->permission("category_deleteimg",$this->_data['user_active']['active_user_group']) == true) {
			$id = $this->input->get('id');
			if (is_numeric($id) > 0) {
				$myCategory = $this->mcategory->getData("category_picture",array('id' => $id));
				if (!empty($myCategory)) {
					$this->mcategory->delimage($myCategory['category_picture']);
					if ($this->mcategory->edit($id,array('category_picture' => ''))) {
						$rs = 1;
					}
				}
			}
		}
	}
}
