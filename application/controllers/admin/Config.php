<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Config extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('config',$this->_data['language']);
        $this->load->Model("admin/mconfig");
    }

    public function index()
    {
    	$this->mpermission->checkPermission("config","index",$this->_data['user_active']['active_user_group']);
    	$this->load->helper('text');
        $this->_data['title'] = lang('list');
    	$this->_data['flanguage'] = isset($_GET['flanguage']) ? $_GET['flanguage'] : $this->_data['language'];
        $this->_data['flanguage'] = $this->mlanguage->getLanguage($this->_data['flanguage']);
        $this->_data['list'] = $this->mconfig->getConfig($this->_data['flanguage']['lang_code']);
        $this->my_layout->view("admin/config/index", $this->_data);
    }

    public function add()
    {
    	$this->mpermission->checkPermission("config","add",$this->_data['user_active']['active_user_group']);
    	$this->_data['title'] = lang('configadd');
    	$this->_data['langPost'] = isset($_GET['lang']) ? $_GET['lang'] : $this->_data['language'];
    	$this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
    	$this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
        $this->_data['formData'] = array(
        	'config_code' => '', 
        	'config_status' => 1
        );
        $this->_data['formDataLang'] = array(
        	'config_name' => '', 
        	'config_value' => '' 
        );
        if (isset($_POST['config_name'])) {
        	$lang = $this->input->post('config_lang') != null ? $this->input->post('config_lang') : $this->_data['language'];
        	$this->_data['formData'] = array(
	        	'config_code' => $this->input->post('config_code'), 
	        	'config_createdate' => date("Y-m-d"), 
	        	'config_status' => $this->input->post('config_status'),
	        	'config_user' => $this->_data['user_active']['active_user_id']
	        );
	        $this->_data['formDataLang'] = array(
	        	'config_id' => 0, 
	        	'language_code' => $lang, 
	        	'config_name' => $this->input->post('config_name'), 
	        	'config_value' => $this->input->post('config_value')
	        );
	        $checkCode = $this->mconfig->getData('id',array('config_code' => $this->_data['formData']['config_code']));
	        $error = false;
	        do {
                if ($this->_data['formData']['config_code'] == null) {
                    $text = lang('pleaseinput').lang('code');$error = true;break;
                }
                if ($checkCode && $checkCode['id'] > 0) {
                    $text = lang('code').lang('exists');$error = true;break;
                }
                if ($this->_data['formDataLang']['config_name'] == null) {
                    $text = lang('pleaseinput').lang('name');$error = true;break;
                }
                if ($this->_data['formDataLang']['config_value'] == null) {
                    $text = lang('pleaseinput').lang('value');$error = true;break;
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
            	$insert = $this->mconfig->add($this->_data['formData']);
            	if (is_numeric($insert) > 0) {
            		$this->_data['formDataLang']['config_id'] = $insert;
            		$insert_lang = $this->mconfig_translation->add($this->_data['formDataLang']);
                	$titleinsertlang = is_numeric($insert_lang) > 0 ? ' | '.$lang : '';
                	$notify = array(
                        'title' => lang('success'), 
                        'text' => lang('config').$this->_data['formDataLang']['config_name'].lang('added').$titleinsertlang,
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    redirect(my_library::admin_site()."config");
            	} else {
            		$notify = array(
                        'title' => lang('unsuccessful'), 
                        'text' => lang('checkinfo'),
                        'type' => 'error'
                    );
            	}
            }
        }
        $this->_data['action'] = 1;//Add
        $this->_data['config_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js'];
        $this->my_layout->view("admin/config/post", $this->_data);
    } 

    public function edit($id)
    {
    	$this->mpermission->checkPermission("config","edit",$this->_data['user_active']['active_user_group']);
    	if (is_numeric($id) && $id > 0) {
    		$myConfig = $this->mconfig->getData("",array('id' => $id));
    		if ($myConfig && $myConfig['id'] > 0) {
    			$this->_data['langPost'] = isset($_GET['lang']) ? $_GET['lang'] : $this->_data['language'];
		    	$this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
		        $this->_data['formData'] = array(
		        	'config_code' => $myConfig['config_code'], 
		        	'config_status' => $myConfig['config_status']
		        );
		        $myConfig_lang = $this->mconfig_translation->getData("id,config_name,config_value",array('config_id' => $id,'language_code' => $this->_data['langPost']['lang_code']));
		        if (!empty($myConfig_lang)) {
		        	$this->_data['formDataLang'] = array(
			        	'config_name' => $myConfig_lang['config_name'], 
			        	'config_value' => $myConfig_lang['config_value']
			        );
		        } else {
		        	$this->_data['formDataLang'] = array(
			        	'config_name' => '', 
			        	'config_value' => '' 
			        );
		        }
		        if (isset($_POST['config_name'])) {
		        	$lang = $this->input->post('config_lang') != null ? $this->input->post('config_lang') : $this->_data['language'];
		        	$this->_data['formData'] = array(
			        	'config_code' => $myConfig['config_code'],
			        	'config_status' => $this->input->post('config_status'),
			        	'config_user' => $this->_data['user_active']['active_user_id']
			        );
			        $this->_data['formDataLang'] = array(
			        	'config_id' => $id, 
			        	'language_code' => $lang, 
			        	'config_name' => $this->input->post('config_name'), 
			        	'config_value' => $this->input->post('config_value')
			        );
			        $error = false;
			        do {
		                if ($this->_data['formDataLang']['config_name'] == null) {
		                    $text = lang('pleaseinput').lang('name');$error = true;break;
		                }
		                if ($this->_data['formDataLang']['config_value'] == null) {
		                    $text = lang('pleaseinput').lang('value');$error = true;break;
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
		            	if ($this->mconfig->edit($id,$this->_data['formData'])) {
		            		if (!empty($myConfig_lang)) {
		            			if ($this->mconfig_translation->edit($myConfig_lang['id'],$this->_data['formDataLang'])) {
		            				$notify = array(
				                        'title' => lang('success'), 
				                        'text' => lang('config').$this->_data['formDataLang']['config_name'].lang('edited').' | '.$lang,
				                        'type' => 'success'
				                    );
		            			}
		            		} else {
		            			$insert_lang = $this->mconfig_translation->add($this->_data['formDataLang']);
		            			if (is_numeric($insert_lang) > 0) {
		                			$notify = array(
				                        'title' => lang('success'), 
				                        'text' => lang('config').$this->_data['formDataLang']['config_name'].lang('addlang').' '.$lang,
				                        'type' => 'success'
				                    );
		                		} else {
		                			$notify = array(
				                        'title' => lang('success'), 
				                        'text' => lang('config').' '.$id.lang('edited'),
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
	                    redirect(my_library::admin_site()."config");
		            }
		        }
                $this->_data['id'] = $id;
                $this->_data['title'] = lang('editconfig')." #".$id;
                $this->_data['token_name'] = $this->security->get_csrf_token_name();
                $this->_data['token_value'] = $this->security->get_csrf_hash();
		        $this->_data['config_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
		        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css'];
		        $this->_data['extraJs'] = ['validator.js','icheck.min.js'];
		        $this->my_layout->view("admin/config/post", $this->_data);
    		} else {
    			$notify = array(
                    'title' => lang('notfound'), 
                    'text' => lang('config').lang('notexists'),
                    'type' => 'warning'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."config");
    		}
    	} else {
    		$notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'warning'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."config");
    	}
    }

    public function delete($id)
    {
    	$this->mpermission->checkPermission("config","delete",$this->_data['user_active']['active_user_group']);
    	if (is_numeric($id) && $id > 0) {
    		$myConfig = $this->mconfig->getData("",array('id' => $id));
    		if ($myConfig && $myConfig['id']) {
    			$this->mconfig->delete($id);
    			$this->mconfig_translation->deleteAnd(array('config_id' => $id));
    			$title = lang('success');
                $text = lang('config').$myConfig['config_code'].lang('deleted');
                $type = 'success';
    		} else {
    			$title = lang('unsuccessful');
                $text = lang('notfound').' '.lang('config');
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
        redirect(my_library::admin_site()."config");
    }

    public function logo_favion()
    {
        $this->mpermission->checkPermission("config","logofavicon",$this->_data['user_active']['active_user_group']);
        if (isset($_FILES['logo']) && $_FILES['logo']['name'] != "") {
            $upload_logo = $this->mconfig->editLogo();
            if ($upload_logo) {
                $notify = array(
                    'title' => lang('success'), 
                    'text' => 'Logo '.lang('edited').' | '.lang('please').'Shift+F5',
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
            redirect(my_library::admin_site()."config/logo_favion");
        }
        if (isset($_FILES['favicon']) && $_FILES['favicon']['name'] != "") {
            $upload_favicon = $this->mconfig->editFavicon();
            if ($upload_favicon) {
                $notify = array(
                    'title' => lang('success'), 
                    'text' => 'Favicon '.lang('edited').' | '.lang('please').'Shift+F5',
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
            redirect(my_library::admin_site()."config/logo_favion");
        }
        $this->_data['title'] = lang('logo_favicon');
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
        $this->_data['extraJs'] = ['module/config.js'];
        $this->my_layout->view("admin/config/logo_favicon", $this->_data);
    }
}
