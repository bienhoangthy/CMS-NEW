<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Module extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->lang->load('module',$this->_data['language']);
        $this->load->Model("admin/mcomponent");
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
    }
    public function index()
    {
        $this->mpermission->checkPermission("module","index",$this->_data['user_active']['active_user_group']);
        $this->_data['flanguage'] = $_GET['flanguage'] ?? $this->_data['language'];
        $this->_data['flanguage'] = $this->mlanguage->getLanguage($this->_data['flanguage']);
    	$this->_data['title'] = lang('list');
        $this->_data['list'] = $this->mmodule->getModule($this->_data['flanguage']['lang_code'],'all');
    	$this->my_layout->view("admin/module/index", $this->_data);
    }   

    public function add()
    {
        $this->mpermission->checkPermission("module","add",$this->_data['user_active']['active_user_group']);
    	$this->_data['langPost'] = $_GET['lang'] ?? $this->_data['language'];
    	$this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
        $this->_data['formData'] = array( 
        	'module_parent' => 0, 
        	'module_component' => '', 
            'module_action' => '',
            'module_orderby' => 0,
            'module_icon' => '',
        	'module_status' => 1
        );
        $this->_data['formDataLang'] = array('module_name' => '');
        if (isset($_POST['module_name'])) {
        	$lang = $this->input->post('module_lang') != null ? $this->input->post('module_lang') : $this->_data['language'];
            $this->_data['formData'] = array(
                'module_parent' => $this->input->post('module_parent'), 
                'module_component' => $this->input->post('module_component'), 
                'module_action' => $this->input->post('module_action'),
                'module_orderby' => $this->input->post('module_orderby'),
                'module_icon' => $this->input->post('module_icon'),
                'module_status' => $this->input->post('module_status')
            );
            $this->_data['formDataLang'] = array('module_name' => $this->input->post('module_name'));
            //$checkModule = '';
            if ($this->_data['formData']['module_component'] != '') {
                $checkModule = $this->mmodule->getData('id',array('module_component' => $this->_data['formData']['module_component']));
            }
            $error = false;
            do {
                if ($this->_data['formDataLang']['module_name'] == null) {
                    $text = lang('pleaseinput').lang('modulename');$error = true;break;
                }
                if ($this->_data['formData']['module_parent'] == null) {
                    $text = lang('pleasechoose').lang('moduleparent');$error = true;break;
                }
                if ($checkModule && $checkModule['id'] > 0) {
                    $text = lang('checkcomponent');$error = true;break;
                }
                if ($this->_data['formData']['module_action'] == null) {
                    $text = lang('pleaseinput').' action!';$error = true;break;
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
                $insert = $this->mmodule->add($this->_data['formData']);
                if (is_numeric($insert) > 0) {
                	$insert_lang = $this->mmodule_translation->add(array('module_id' => $insert,'language_code' => $lang,'module_name' => $this->_data['formDataLang']['module_name']));
                	$titleinsertlang = is_numeric($insert_lang) > 0 ? ' | '.$lang : '';
                	$notify = array(
                        'title' => lang('success'), 
                        'text' => 'Module '.$this->_data['formDataLang']['module_name'].lang('added').$titleinsertlang,
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    $this->cache->delete('module_vietnamese');
                    $this->cache->delete('module_english');
                    redirect(my_library::admin_site()."module");
                }
            }  
        }
        $this->_data['title'] = lang('addmodule');
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
        $this->_data['component'] = $this->mcomponent->dropdownlist($this->_data['formData']['module_component']);
        $this->_data['module_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
        //$this->_data['listParent'] = $this->mmodule->getModule($this->_data['langPost']['lang_code']);
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js'];
        $this->my_layout->view("admin/module/post", $this->_data);
    }

    public function edit($id)
    {
        $this->mpermission->checkPermission("module","edit",$this->_data['user_active']['active_user_group']);
    	if (is_numeric($id) && $id > 0) {
    		$myModule = $this->mmodule->getData("",array('id' => $id));
    		if ($myModule && $myModule['id'] > 0) {
    			$langGet = $_GET['lang'] ?? $this->_data['language'];
    			$this->_data['langPost'] = $this->mlanguage->getLanguage($langGet);
                $this->_data['formData'] = array(
		        	'module_parent' => $myModule['module_parent'], 
		        	'module_component' => $myModule['module_component'], 
		            'module_action' => $myModule['module_action'],
		            'module_orderby' => $myModule['module_orderby'],
		            'module_icon' => $myModule['module_icon'],
		        	'module_status' => $myModule['module_status']
		        );
		        $myModule_lang = $this->mmodule_translation->getData("id,module_name",array('module_id' => $id,'language_code' => $this->_data['langPost']['lang_code']));
                $this->_data['formDataLang'] = array(
                	'module_name' => !empty($myModule_lang) ? $myModule_lang['module_name'] : ''
                );
		        if (isset($_POST['module_name'])) {
		        	$lang = $this->input->post('module_lang') != null ? $this->input->post('module_lang') : $this->_data['language'];
		            $this->_data['formData'] = array(
		                'module_parent' => $this->input->post('module_parent'), 
		                'module_component' => $this->input->post('module_component'), 
		                'module_action' => $this->input->post('module_action'),
		                'module_orderby' => $this->input->post('module_orderby'),
		                'module_icon' => $this->input->post('module_icon'),
		                'module_status' => $this->input->post('module_status')
		            );
		            $this->_data['formDataLang']['module_name'] = $this->input->post('module_name');
                    if ($this->_data['formData']['module_component'] != '') {
                        $checkModule = $this->mmodule->getData('id',array('module_component' => $this->_data['formData']['module_component']));
                    }
		            $error = false;
		            do {
		                if ($this->_data['formDataLang']['module_name'] == null) {
		                    $text = lang('pleaseinput').lang('modulename');$error = true;break;
		                }
		                if ($this->_data['formData']['module_parent'] == null) {
		                    $text = lang('pleasechoose').lang('moduleparent');$error = true;break;
		                }
                        if (!empty($checkModule) && $this->_data['formData']['module_component'] != $myModule['module_component']) {
                            $text = 'Module'.lang('exists');$error = true;break;
                        }
		                // if ($this->_data['formData']['module_component'] == null) {
		                //     $text = 'Vui lòng nhập component!';$error = true;break;
		                // }
		                if ($this->_data['formData']['module_action'] == null) {
		                    $text = lang('pleaseinput').' action!';$error = true;break;
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
		                if ($this->mmodule->edit($id,$this->_data['formData'])) {
		                	if (!empty($myModule_lang)) {
		                		if ($this->mmodule_translation->edit($myModule_lang['id'],array('language_code' => $lang,'module_name' => $this->_data['formDataLang']['module_name']))) {
		                			$notify = array(
				                        'title' => lang('success'), 
				                        'text' => 'Module '.$this->_data['formDataLang']['module_name'].lang('edited').' | '.$lang,
				                        'type' => 'success'
				                    );
		                		}
		                	} else {
		                		$insert_lang = $this->mmodule_translation->add(array('module_id' => $id,'language_code' => $lang,'module_name' => $this->_data['formDataLang']['module_name']));
		                		if (is_numeric($insert_lang) > 0) {
		                			$notify = array(
				                        'title' => lang('success'), 
				                        'text' => 'Module '.$this->_data['formDataLang']['module_name'].lang('addlang').' '.$lang,
				                        'type' => 'success'
				                    );
		                		} else {
		                			$notify = array(
				                        'title' => lang('success'), 
				                        'text' => 'Module '.$id.lang('edited'),
				                        'type' => 'success'
				                    );
		                		}
		                	}
		                    $this->session->set_userdata('notify', $notify);
                            $this->cache->delete('module_vietnamese');
                            $this->cache->delete('module_english');
		                    redirect(my_library::admin_site()."module");
		                }
		            }  
		        }
                $this->_data['id'] = $id;
                $this->_data['title'] = lang('editmodule')." #".$id;
                $this->_data['token_name'] = $this->security->get_csrf_token_name();
                $this->_data['token_value'] = $this->security->get_csrf_hash();
		        $this->_data['component'] = $this->mcomponent->dropdownlist($this->_data['formData']['module_component']);
		        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css'];
		        $this->_data['extraJs'] = ['validator.js','icheck.min.js'];
		        $this->_data['module_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
		        //$this->_data['listParent'] = $this->mmodule->getModule($this->_data['langPost']['lang_code']);
		        $this->my_layout->view("admin/module/post", $this->_data);
    		} else {
    			$notify = array(
                    'title' => lang('notfound'), 
                    'text' => lang('module').lang('notexists'),
                    'type' => 'warning'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."module");
    		}
    		
    	} else {
    		$notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'warning'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."module");
    	}
    }

    public function delete($id)
    {
        $this->mpermission->checkPermission("module","delete",$this->_data['user_active']['active_user_group']);
    	if (is_numeric($id) && $id != 1) {
    		$myModule = $this->mmodule->getData("",array('id' => $id));
    		if ($myModule && $myModule['id'] > 0) {
    			$this->mmodule->delete($id);
    			$this->mmodule_translation->deleteAnd(array('module_id' => $id));
    			$delChild = 0;
    			if ($myModule['module_parent'] == 0) {
                    //$this->mmodule->deleteAnd(array('module_parent' => $myModule['id']));
    				$listChild = $this->mmodule->getQuery("id", "module_parent = ".$myModule['id'], "","");
    				if (!empty($listChild)) {
    					foreach ($listChild as $key => $value) {
    						$this->mmodule->delete($value['id']);
    						$this->mmodule_translation->deleteAnd(array('module_id' => $value['id']));
    						$delChild++;
    					}
    				}
    			}
    			$delChild = $delChild > 0 ? ', '.lang('and').' '.$delChild.' module '.lang('child').' ' : ' ';
    			$title = lang('success');
                $text = 'Module '.$myModule['module_name'].$delChild.lang('deleted');
                $type = 'success';
                $this->cache->delete('module_vietnamese');
                $this->cache->delete('module_english');
    		} else {
    			$title = lang('unsuccessful');
                $text = lang('notfound').' '.lang('module');
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
        redirect(my_library::admin_site()."module");
    }
}
