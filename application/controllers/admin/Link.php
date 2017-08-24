<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Link extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->lang->load('link',$this->_data['language']);
        $this->load->Model("admin/mlink");
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
    }
    public function index()
    {
        $this->mpermission->checkPermission("link","index",$this->_data['user_active']['active_user_group']);
        $this->_data['langPost'] = $_GET['flanguage'] ?? $this->_data['language'];
    	$this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
        $this->_data['formData'] = array(
            'link' => '', 
            'link_status' => 1
        );
        $this->_data['formDataLang'] = array(
        	'link_name' => '',
        	'link_description' => ''
        );
        if (isset($_POST['link_name'])) {
        	$this->mpermission->checkPermission("link","add",$this->_data['user_active']['active_user_group']);
        	$lang = $this->input->post('link_lang') ?? $this->_data['language'];
        	$this->_data['formData'] = array(
        		'link' => $this->input->post('link'),
        		'link_status' => $this->input->post('link_status'),
        		'link_createdate' => date("Y-m-d"),
        		'user' => $this->_data['user_active']['active_user_id']
        	);
        	$this->_data['formDataLang'] = array(
	        	'link_id' => 0,
	        	'language_code' => $lang,
	        	'link_name' => $this->input->post('link_name'),
	        	'link_description' => $this->input->post('link_description')
	        );
	        $checkLink = $this->mlink->getData('id',array('link' => $this->_data['formData']['link']));
	        $error = false;
	        do {
	        	if ($this->_data['formData']['link'] == null) {
                    $text = lang('pleaseinput').lang('link');$error = true;break;
                }
                if ($this->_data['formDataLang']['link_name'] == null) {
                    $text = lang('pleaseinput').lang('titlelink');$error = true;break;
                }
                if ($checkLink && $checkLink['id'] > 0) {
                	$text = lang('link').lang('exists');$error = true;break;
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
	        	$insert = $this->mlink->add($this->_data['formData']);
	        	if (is_numeric($insert) > 0) {
	        		$this->_data['formDataLang']['link_id'] = $insert;
	        		$insert_lang = $this->mlink_translation->add($this->_data['formDataLang']);
	        		$titleinsertlang = is_numeric($insert_lang) > 0 ? ' | '.$lang : '';
	        		$notify = array(
                        'title' => lang('success'), 
                        'text' => lang('link').' '.$this->_data['formDataLang']['link_name'].lang('added').$titleinsertlang,
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    redirect(my_library::admin_site()."link");
	        	} else {
	        		$notify = array(
                        'title' => lang('unsuccessful'), 
                        'text' => lang('checkinfo'),
                        'type' => 'error'
                    );
	        	}
	        }
        }
        $this->_data['title'] = lang('list');
        $this->_data['list'] = $this->mlink->getLink($this->_data['langPost']['lang_code']);
        $this->_data['record'] = $this->mlink->countQuery('1');
        $this->_data['link_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
        //$this->_data['extraJs'] = ['validator.js','module/action.js','language/'.$this->_data['language'].'_action.js'];
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js'];
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
    	$this->my_layout->view("admin/link/index", $this->_data);
    }   

    public function edit($id)
    {
    	$this->mpermission->checkPermission("link","edit",$this->_data['user_active']['active_user_group']);
    	if (is_numeric($id) && $id > 0) {
    		$myLink = $this->mlink->getData("",array('id' => $id));
    		if ($myLink && $myLink['id'] > 0) {
    			//
    			$this->_data['langPost'] = $_GET['flanguage'] ?? $this->_data['language'];
		    	$this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
		        $this->_data['formData'] = array(
		            'link' => $myLink['link'], 
		            'link_status' => $myLink['link_status']
		        );
		        $myLink_lang = $this->mlink_translation->getData("",array('link_id' => $id,'language_code' => $this->_data['langPost']['lang_code']));
		        if (!empty($myLink_lang)) {
		        	$this->_data['formDataLang'] = array(
			        	'link_name' => $myLink_lang['link_name'],
			        	'link_description' => $myLink_lang['link_description']
			        );
		        } else {
		        	$this->_data['formDataLang'] = array(
			        	'link_name' => '',
			        	'link_description' => ''
			        );
		        }
		        if (isset($_POST['link_name'])) {
		        	$lang = $this->input->post('link_lang') ?? $this->_data['language'];
		        	$this->_data['formData'] = array(
		        		'link' => $this->input->post('link'),
		        		'link_status' => $this->input->post('link_status'),
		        		'user' => $this->_data['user_active']['active_user_id']
		        	);
		        	$this->_data['formDataLang'] = array(
			        	'link_id' => $id,
			        	'language_code' => $lang,
			        	'link_name' => $this->input->post('link_name'),
			        	'link_description' => $this->input->post('link_description')
			        );
			        $checkLink = $this->mlink->getData('id',array('link' => $this->_data['formData']['link']));
			        $error = false;
			        do {
			        	if ($this->_data['formData']['link'] == null) {
		                    $text = lang('pleaseinput').lang('link');$error = true;break;
		                }
		                if ($this->_data['formDataLang']['link_name'] == null) {
		                    $text = lang('pleaseinput').lang('titlelink');$error = true;break;
		                }
		                if (!empty($checkLink) && $this->_data['formData']['link'] != $myLink['link']) {
		                	$text = lang('link').lang('exists');$error = true;break;
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
			        	if ($this->mlink->edit($id,$this->_data['formData'])) {
			        		if (!empty($myLink_lang)) {
			        			if ($this->mlink_translation->edit($myLink_lang['id'],$this->_data['formDataLang'])) {
			        				$notify = array(
				                        'title' => lang('success'), 
				                        'text' => lang('link').' '.$this->_data['formDataLang']['link_name'].lang('edited').' | '.$lang,
				                        'type' => 'success'
				                    );
			        			}
			        		} else {
			        			$insert_lang = $this->mlink_translation->add($this->_data['formDataLang']);
			        			if (is_numeric($insert_lang) > 0) {
			        				$notify = array(
				                        'title' => lang('success'), 
				                        'text' => lang('link').' '.$this->_data['formDataLang']['config_name'].lang('addlang').' '.$lang,
				                        'type' => 'success'
				                    );
			        			} else {
			        				$notify = array(
				                        'title' => lang('success'), 
				                        'text' => lang('link').' '.$id.lang('edited'),
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
	                    redirect(my_library::admin_site()."link");
			        }
		        }
		        $this->_data['id'] = $id;
		        $this->_data['title'] = lang('editlink')." #".$id;
		        $this->_data['link_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
		        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css'];
		        $this->_data['extraJs'] = ['validator.js','icheck.min.js'];
		        $this->_data['token_name'] = $this->security->get_csrf_token_name();
		        $this->_data['token_value'] = $this->security->get_csrf_hash();
		    	$this->my_layout->view("admin/link/post", $this->_data);
    			//
    		} else {
    			$notify = array(
                    'title' => lang('notfound'), 
                    'text' => lang('link').lang('notexists'),
                    'type' => 'warning'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."link");
    		}
    	} else {
    		$notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'warning'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."link");
    	}
    }

    public function delete($id)
    {
        $this->mpermission->checkPermission("link","delete",$this->_data['user_active']['active_user_group']);
    	if (is_numeric($id) > 0) {
    		$myLink = $this->mlink->getData("",array('id' => $id));
    		if ($myLink && $myLink['id'] > 0) {
    			$this->mlink->delete($id);
                $this->mlink_translation->deleteAnd(array('link_id' => $id));
    			$title = lang('success');
                $text = lang('link').' #'.$myLink['id'].lang('deleted');
                $type = 'success';
    		} else {
    			$title = lang('unsuccessful');
                $text = lang('link').lang('notexists');
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
        redirect(my_library::admin_site()."link");
    }
}
