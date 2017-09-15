<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class News extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('news',$this->_data['language']);
        $this->load->Model("admin/mcategory");
        $this->load->Model("admin/mnews");
    }
	public function index($state=3)
	{
		$this->mpermission->checkPermission("news","index",$this->_data['user_active']['active_user_group']);
		$this->load->library("My_paging");
        $this->_data['title'] = lang('list');
        $obj = 'n.id,n.news_category,n.news_type,n.news_view,n.news_hot,n.news_status,n.news_picture,n.news_orderby,n.news_updatedate,n.news_password,n.user,nt.id as news_lang_id,nt.news_title,nt.news_alias';
        $this->_data['formData'] = array(
            'fkeyword' => $_GET['fkeyword'] ?? '',
            'forder' => $_GET['forder'] ?? '',
            'fstatus' => $_GET['fstatus'] ?? 0,
            'ftype' => $_GET['ftype'] ?? 0,
            'fuser' => $_GET['fuser'] ?? 0,
            'fcategory' => $_GET['fcategory'] ?? 0,
            'flanguage' => $_GET['flanguage'] ?? $this->_data['language']
        );
        $this->_data['flanguage'] = $this->mlanguage->getLanguage($this->_data['formData']['flanguage']);
        $this->_data['state'] = $state;
        $this->_data['stateData'] = $this->mnews->listState($state);
        $and = 'n.news_state = '. $state;
        if ($this->_data['formData']['fstatus'] > 0) {
            if ($this->_data['formData']['fstatus'] == 10) {
            	$and .= ' and n.news_hot = 1';
            } else {
            	$and .= ' and n.news_status = '. $this->_data['formData']['fstatus'];
            }
        }
        if ($this->_data['formData']['ftype'] > 0) {
            $and .= ' and n.news_type = '. $this->_data['formData']['ftype'];
        }
        if ($this->_data['formData']['fuser'] > 0) {
            $and .= ' and n.user = '. $this->_data['formData']['fuser'];
        }
        if ($this->_data['formData']['fcategory'] > 0) {
            $and .= ' and n.news_category = '. $this->_data['formData']['fcategory'];
        }
        if ($this->_data['formData']['fkeyword'] != '') {
            $and .= ' and (n.news_tag like "%' . $this->_data['formData']['fkeyword'] . '%"';
            $and .= ' or nt.news_title like "%' . $this->_data['formData']['fkeyword'] . '%"';
            $and .= ' or nt.news_alias like "%' . $this->_data['formData']['fkeyword'] . '%"';
            $and .= ' or nt.news_summary like "%' . $this->_data['formData']['fkeyword'] . '%")';
        }
        $and .= ' and nt.language_code = "'.$this->_data['flanguage']['lang_code'].'"';
        switch ($this->_data['formData']['forder']) {
        	case '':
        		$orderby = 'n.news_orderby desc,n.id desc';
        		break;
        	case 'latest':
        		$orderby = 'n.id desc';
        		break;
        	case 'oldest':
        		$orderby = 'n.id asc';
        		break;
        	case 'mostviewed':
        		$orderby = 'n.news_view desc';
        		break;
        	case 'craetedate':
        		$orderby = 'n.news_createdate desc';
        		break;
        	case 'publishdate':
        		$orderby = 'n.news_publicdate desc';
        		break;
        	case 'updatedate':
        		$orderby = 'n.news_createdate desc';
        		break;
        	default:
        		$orderby = 'n.news_orderby desc,n.id desc';
        		break;
        }
        $paging['per_page'] = 20;
        $paging['num_links'] = 5;
        $paging['page'] = $this->_data['page'] = $_GET['page'] ?? 1;
        $paging['start'] = (($paging['page'] - 1) * $paging['per_page']);
        $query_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? str_replace("&page=" . $this->_data['page'], "", $_SERVER['QUERY_STRING']) : '';
        $paging['base_url'] = my_library::admin_site() . 'news/?' . $query_string . '&page=';
        $limit = $paging['start'] . ',' . $paging['per_page'];
        $this->_data['list'] = $this->mnews->getNews($obj, $and, $orderby, $limit);
        $this->_data['record'] = $this->mnews->countNews($and);
        $this->_data["pagination"] = $this->my_paging->paging_donturl($this->_data["record"], $paging['page'], $paging['per_page'], $paging['num_links'], $paging['base_url']);
        $this->_data['fstatus'] = $this->mnews->dropdownlistStatus($this->_data['formData']['fstatus']);
        $this->_data['ftype'] = $this->mnews->dropdownlistType($this->_data['formData']['ftype']);
        $this->_data['fuser'] = $this->muser->dropdownlistUser($this->_data['formData']['fuser']);
        $this->_data['fcategory'] = $this->mcategory->dropdownlistCategory($this->_data['formData']['fcategory'],$this->_data['formData']['flanguage'],'news');
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','switchery.min.css'];
		$this->_data['extraJs'] = ['icheck.min.js','switchery.min.js','module/news.js'];
        $this->my_layout->view("admin/news/index", $this->_data);
	}

	public function add()
	{
		$this->mpermission->checkPermission("news","add",$this->_data['user_active']['active_user_group']);
		$this->_data['langPost'] = $_GET['lang'] ?? $this->_data['language'];
    	$this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
        $this->_data['formData'] = array( 
        	'news_category' => 0, 
        	'news_type' => 1, 
            'news_view' => 0,
            'news_layout' => 1,
            'news_hot' => 0,
        	'news_tag' => '',
        	'news_status' => 1,
        	'news_picture' => '',
        	'news_orderby' => 0,
        	'news_author' => '',
        	'news_source' => '',
        	'news_password' => ''
        );
        $this->_data['formDataLang'] = array(
        	'news_title' => '',
        	'news_summary' => '',
        	'news_detail' => '',
        	'news_seo_title' => '',
        	'news_seo_keyword' => '',
        	'news_seo_description' => ''
        );
        //Post
        if (isset($_POST['news_title'])) {
        	$timenow = date("Y-m-d H:i:s");
        	$this->load->helper('alias');
        	$lang = $this->input->post('news_lang') ?? $this->_data['language'];
        	$method = $this->input->post('type_submit') ?? 1;
        	$now = $this->input->post('now') ?? 0;
        	$state = $method == 3 ? 2 : 1;
        	$publicdate = $now == 1 ? $timenow : $this->input->post('date').' '.$this->input->post('time');
        	$password = $this->input->post('news_password');
        	$password = $password != null ? md5($password) : '';
        	$this->_data['formData'] = array( 
	        	'news_category' => $this->input->post('news_category'), 
	        	'news_type' => $this->input->post('news_type'), 
	            'news_view' => $this->input->post('news_view'),
	            'news_layout' => $this->input->post('news_layout'),
	            'news_hot' => $this->input->post('news_hot') ?? 0,
	        	'news_tag' => $this->input->post('news_tag') ?? '',
	        	'news_status' => $this->input->post('news_status'),
	        	'news_state' => $state,
	        	'news_picture' => '',
	        	'news_orderby' => $this->input->post('news_orderby'),
	        	'news_publicdate' => $publicdate,
	        	'news_createdate' => $timenow,
	        	'news_updatedate' => $timenow,
	        	'news_author' => $this->input->post('news_author'),
	        	'news_source' => $this->input->post('news_source'),
	        	'news_password' => $password,
	        	'user' => $this->_data['user_active']['active_user_id']
	        );
	        $alias = to_alias($this->input->post('news_title'));
	        $this->_data['formDataLang'] = array(
	        	'news_id' => 0,
	        	'language_code' => $lang,
	        	'news_title' => $this->input->post('news_title'),
	        	'news_alias' => $alias ?? time(),
	        	'news_summary' => $this->input->post('news_summary'),
	        	'news_detail' => $this->input->post('news_detail'),
	        	'news_seo_title' => $this->input->post('news_seo_title'),
	        	'news_seo_keyword' => $this->input->post('news_seo_keyword'),
	        	'news_seo_description' => $this->input->post('news_seo_description')
	        );
	        $checkName = $this->mnews_translation->getData('id',array('news_title' => $this->_data['formDataLang']['news_title']));
            $checkAlias = $this->mnews_translation->getData('id',array('news_alias' => $this->_data['formDataLang']['news_alias']));
            $error = false;
            if ($state == 1) {
            	do {
	                if ($this->_data['formDataLang']['news_title'] == null) {
	                    $text = lang('pleaseinput').lang('titlenews');$error = true;break;
	                }
	                if ($checkName && $checkName['id'] > 0) {
	                    $text = lang('titlenews').lang('exists');$error = true;break;
	                }
	                if ($checkAlias && $checkAlias['id'] > 0) {
	                    $this->_data['formDataLang']['news_alias'] = $this->_data['formDataLang']['news_alias'].'-1';
	                }
	            } while (0);
            } else {
            	do {
	                if ($this->_data['formData']['news_category'] == null || $this->_data['formData']['news_category'] < 1) {
	                    $text = lang('pleasechoose').lang('category');$error = true;break;
	                }
	                if ($this->_data['formData']['news_type'] < 1) {
	                    $text = lang('pleasechoose').lang('type');$error = true;break;
	                }
	                if ($this->_data['formData']['news_layout'] < 1) {
	                    $text = lang('pleasechoose').lang('layout');$error = true;break;
	                }
	                if ($this->_data['formData']['news_status'] < 1) {
	                    $text = lang('pleasechoose').lang('status');$error = true;break;
	                }
	                if ($this->_data['formDataLang']['news_title'] == null) {
	                    $text = lang('pleaseinput').lang('titlenews');$error = true;break;
	                }
	                if ($this->_data['formDataLang']['news_detail'] == null) {
	                    $text = lang('pleaseinput').lang('detail');$error = true;break;
	                }
	                if ($checkName && $checkName['id'] > 0) {
	                    $text = lang('titlenews').lang('exists');$error = true;break;
	                }
	                if ($checkAlias && $checkAlias['id'] > 0) {
	                    $this->_data['formDataLang']['news_alias'] = $this->_data['formDataLang']['news_alias'].'-1';
	                }
	            } while (0);
            }
            if ($error == true) {
            	$notify = array(
                    'title' => lang('unsuccessful'), 
                    'text' => $text,
                    'type' => 'error'
                );
                $this->session->set_userdata('notify', $notify);
            } else {
            	$insert = $this->mnews->add($this->_data['formData']);
            	if (is_numeric($insert) && $insert > 0) {
            		$file = $this->input->post('file');
	                if ($file != null) {
	                    $news_picture = $this->mnews->saveImage($file,$insert,$this->_data['formDataLang']['news_alias']);
	                    if ($news_picture != '') {
	                    	$this->mnews->edit($insert,array('news_picture' => $news_picture));
	                    }
	                }
	                $this->_data['formDataLang']['news_id'] = $insert;
	                $insert_lang = $this->mnews_translation->add($this->_data['formDataLang']);
	                $titleinsertlang = is_numeric($insert_lang) > 0 ? ' | '.$lang : '';
                    $notify = array(
                        'title' => lang('success'), 
                        'text' => lang('news').' #'.$insert.lang('added').$titleinsertlang,
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    switch ($method) {
                    	case 1:
                    		redirect(my_library::admin_site()."news/edit/".$insert);
                    		break;
                    	case 2:
                    		redirect(my_library::admin_site()."news/index/1");
                    		break;
                    	case 3:
                    		redirect(my_library::admin_site()."news/index/2");
                    		break;
                    	default:
                    		redirect(my_library::admin_site()."news/index/1");
                    		break;
                    }
            	}
            }
        }
        $this->_data['date'] = '';
        $this->_data['time'] = '';
        $this->_data['state'] = 1;
        $this->_data['stateOperations'] = $this->mnews->stateOperations($this->_data['state']);
        $this->_data['stateData'] = $this->mnews->listState($this->_data['state']);
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
		$this->_data['title'] = lang('newsadd');
		$this->_data['category'] = $this->mcategory->dropdownlistCategory($this->_data['formData']['news_category'],$this->_data['langPost']['lang_code'],'news');
		$this->_data['type'] = $this->mnews->dropdownlistType($this->_data['formData']['news_type']);
		$this->_data['layout'] = $this->mnews->dropdownlistLayout($this->_data['formData']['news_layout']);
        $this->_data['news_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','switchery.min.css','bootstrap-datepicker.css','jquery.timepicker.min.css','cropper.min.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js','switchery.min.js','jquery.tagsinput.js','bootstrap-datepicker.min.js','jquery.timepicker.min.js','cropper.min.js','tinymce/jquery.tinymce.min.js','tinymce/tinymce.min.js','module/news-post.js'];
		$this->my_layout->view("admin/news/post", $this->_data);
	}

	public function edit($id)
	{
		$this->mpermission->checkPermission("news","edit",$this->_data['user_active']['active_user_group']);
		if (is_numeric($id) && $id > 0) {
			$myNews = $this->mnews->getData("",array('id' => $id));
			if ($myNews && $myNews['id'] > 0) {
				if ($myNews['news_state'] == 3 && $this->mpermission->permission("news_editpublish",$this->_data['user_active']['active_user_group']) != true) {
					$notify = array(
	                    'title' => lang('unsuccessful'), 
	                    'text' => lang('nonpereditpublish'),
	                    'type' => 'warning'
	                );
	                $this->session->set_userdata('notify', $notify);
	                redirect(my_library::admin_site()."news");
				} else {
					$this->_data['langPost'] = $_GET['lang'] ?? $this->_data['language'];
	                $this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
	                $this->_data['formData'] = array( 
			        	'news_category' => $myNews['news_category'], 
			        	'news_type' => $myNews['news_type'], 
			            'news_view' => $myNews['news_view'],
			            'news_layout' => $myNews['news_layout'],
			            'news_hot' => $myNews['news_hot'],
			        	'news_tag' => $myNews['news_tag'],
			        	'news_status' => $myNews['news_status'],
			        	'news_picture' => $myNews['news_picture'],
			        	'news_orderby' => $myNews['news_orderby'],
			        	'news_author' => $myNews['news_author'],
			        	'news_source' => $myNews['news_source'],
			        	'news_password' => $myNews['news_password']
			        );
			        $myNews_lang = $this->mnews_translation->getData("",array('news_id' => $id,'language_code' => $this->_data['langPost']['lang_code']));
			        if (!empty($myNews_lang)) {
			        	$this->_data['formDataLang'] = array(
				        	'news_title' => $myNews_lang['news_title'],
				        	'news_alias' => $myNews_lang['news_alias'],
				        	'news_summary' => $myNews_lang['news_summary'],
				        	'news_detail' => $myNews_lang['news_detail'],
				        	'news_seo_title' => $myNews_lang['news_seo_title'],
				        	'news_seo_keyword' => $myNews_lang['news_seo_keyword'],
				        	'news_seo_description' => $myNews_lang['news_seo_description']
				        );
			        } else {
			        	$this->_data['formDataLang'] = array(
				        	'news_title' => '',
				        	'news_summary' => '',
				        	'news_detail' => '',
				        	'news_seo_title' => '',
				        	'news_seo_keyword' => '',
				        	'news_seo_description' => ''
				        );
			        }
			        //Post
			        if (isset($_POST['news_title'])) {
			        	$timenow = date("Y-m-d H:i:s");
			        	$lang = $this->input->post('news_lang') ?? $this->_data['language'];
			        	$method = $this->input->post('type_submit') ?? 1;
			        	$now = $this->input->post('now') ?? 0;
			        	if ($myNews['news_state'] == 3) {
			        		$state = 3;
			        	} else {
			        		if ($myNews['news_state'] == 1) {
				        		$state = $method == 3 ? 2 : 1;
				        	} else {
				        		$state = $method == 3 ? 3 : 2;
				        	}
			        	}
			        	$date = $this->input->post('date');
			        	$publicdate = $now == 1 ? $timenow : $date.' '.$this->input->post('time');
			        	$password = $this->input->post('news_password');
			        	$password = $password != null ? md5($password) : $myNews['news_password'];
			        	$this->_data['formData'] = array( 
				        	'news_category' => $this->input->post('news_category'), 
				        	'news_type' => $this->input->post('news_type'), 
				            'news_view' => $this->input->post('news_view'),
				            'news_layout' => $this->input->post('news_layout'),
				            'news_hot' => $this->input->post('news_hot') ?? 0,
				        	'news_tag' => $this->input->post('news_tag') ?? '',
				        	'news_status' => $this->input->post('news_status'),
				        	'news_picture' => $myNews['news_picture'],
				        	'news_state' => $state,
				        	'news_orderby' => $this->input->post('news_orderby'),
				        	'news_publicdate' => $publicdate,
				        	'news_updatedate' => $timenow,
				        	'news_author' => $this->input->post('news_author'),
				        	'news_source' => $this->input->post('news_source'),
				        	'news_password' => $password,
				        	'user' => $this->_data['user_active']['active_user_id']
				        );
				        $alias = $this->input->post('news_alias');
				        if ($alias == null || $alias == $this->_data['formDataLang']['news_alias']) {
				        	$this->load->helper('alias');
				        	$alias = to_alias($this->input->post('news_title'));
				        }
				        $this->_data['formDataLang'] = array(
				        	'news_id' => $id,
				        	'language_code' => $lang,
				        	'news_title' => $this->input->post('news_title'),
				        	'news_alias' => $alias ?? time(),
				        	'news_summary' => $this->input->post('news_summary'),
				        	'news_detail' => $this->input->post('news_detail'),
				        	'news_seo_title' => $this->input->post('news_seo_title'),
				        	'news_seo_keyword' => $this->input->post('news_seo_keyword'),
				        	'news_seo_description' => $this->input->post('news_seo_description')
				        );
				        $checkName = $this->mnews_translation->getData('id',array('news_title' => $this->_data['formDataLang']['news_title'],'news_id <> ' => $id));
			            $checkAlias = $this->mnews_translation->getData('id',array('news_alias' => $this->_data['formDataLang']['news_alias'],'news_id <> ' => $id));
			            $error = false;
			            if ($state == 1) {
			            	do {
				                if ($this->_data['formDataLang']['news_title'] == null) {
				                    $text = lang('pleaseinput').lang('titlenews');$error = true;break;
				                }
				                if ($checkName && $checkName['id'] > 0) {
				                    $text = lang('titlenews').lang('exists');$error = true;break;
				                }
				                if ($checkAlias && $checkAlias['id'] > 0) {
				                    $this->_data['formDataLang']['news_alias'] = $this->_data['formDataLang']['news_alias'].'-1';
				                }
				            } while (0);
			            } else {
			            	do {
			            		// if ($state == 3) {
			            		// 	if ($this->mpermission->permission("news_publish",$this->_data['user_active']['active_user_group']) != true) {
			            		// 		$text = lang('nonperpublish');$error = true;break;
			            		// 	}
			            		// 	if ($now != 1 && $date == null) {
			            		// 		$text = lang('pleasechoose').lang('publishdate');$error = true;break;
			            		// 	}
			            		// }
			            		if ($state == 3 && $now != 1 && $date == null) {
			            			$text = lang('pleasechoose').lang('publishdate');$error = true;break;
			            		}
				                if ($this->_data['formData']['news_category'] == null || $this->_data['formData']['news_category'] < 1) {
				                    $text = lang('pleasechoose').lang('category');$error = true;break;
				                }
				                if ($this->_data['formData']['news_type'] < 1) {
				                    $text = lang('pleasechoose').lang('type');$error = true;break;
				                }
				                if ($this->_data['formData']['news_layout'] < 1) {
				                    $text = lang('pleasechoose').lang('layout');$error = true;break;
				                }
				                if ($this->_data['formData']['news_status'] < 1) {
				                    $text = lang('pleasechoose').lang('status');$error = true;break;
				                }
				                if ($this->_data['formDataLang']['news_title'] == null) {
				                    $text = lang('pleaseinput').lang('titlenews');$error = true;break;
				                }
				                if ($this->_data['formDataLang']['news_detail'] == null) {
				                    $text = lang('pleaseinput').lang('detail');$error = true;break;
				                }
				                if ($checkName && $checkName['id'] > 0) {
				                    $text = lang('titlenews').lang('exists');$error = true;break;
				                }
				                if ($checkAlias && $checkAlias['id'] > 0) {
				                    $this->_data['formDataLang']['news_alias'] = $this->_data['formDataLang']['news_alias'].'-1';
				                }
				            } while (0);
			            }
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
			                    $news_picture = $this->mnews->saveImage($file,$id,$this->_data['formDataLang']['news_alias']);
			                    if ($news_picture != '') {
			                    	$this->_data['formData']['news_picture'] = $news_picture;
			                    	$this->mnews->delimage($id,$myNews['news_picture']);
			                    }
			                }
				            if ($this->mnews->edit($id,$this->_data['formData'])) {
				            	if (!empty($myNews_lang)) {
				            		if ($this->mnews_translation->edit($myNews_lang['id'],$this->_data['formDataLang'])) {
				            			$notify = array(
	                                        'title' => lang('success'), 
	                                        'text' => lang('news').' #'.$id.lang('edited').' | '.$lang,
	                                        'type' => 'success'
	                                    );
				            		}
				            	} else {
				            		$insert_lang = $this->mnews_translation->add($this->_data['formDataLang']);
				            		if (is_numeric($insert_lang) > 0) {
	                                    $notify = array(
	                                        'title' => lang('success'), 
	                                        'text' => lang('news').' #'.$id.lang('addlang').' '.$lang,
	                                        'type' => 'success'
	                                    );
	                                } else {
	                                    $notify = array(
	                                        'title' => lang('success'), 
	                                        'text' => lang('news').' #'.$id.lang('edited'),
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
				            switch ($method) {
		                    	case 1:
		                    		redirect(my_library::admin_site()."news/edit/".$id);
		                    		break;
		                    	case 2:
		                    		redirect(my_library::admin_site()."news/index/".$myNews['news_state']);
		                    		break;
		                    	case 3:
		                    		redirect(my_library::admin_site()."news/index/".$state);
		                    		break;
		                    	default:
		                    		redirect(my_library::admin_site()."news/edit/".$id);
		                    		break;
		                    }
			            }
			        }
			        //End
			        $this->_data['id'] = $id;
			        $this->_data['date'] = '';
			        $this->_data['time'] = '';
			        if ($myNews['news_publicdate'] != '0000-00-00 00:00:00') {
			        	$this->_data['date'] = date("Y-m-d",strtotime($myNews['news_publicdate']));
			        	$this->_data['time'] = date("H:i:s",strtotime($myNews['news_publicdate']));
			        }
			        $this->_data['state'] = $myNews['news_state'];
			        $this->_data['stateOperations'] = $this->mnews->stateOperations($this->_data['state']);
			        $this->_data['stateData'] = $this->mnews->listState($this->_data['state']);
			        $this->_data['token_name'] = $this->security->get_csrf_token_name();
			        $this->_data['token_value'] = $this->security->get_csrf_hash();
					$this->_data['title'] = lang('newsedit')." #".$id;
					$this->_data['category'] = $this->mcategory->dropdownlistCategory($this->_data['formData']['news_category'],$this->_data['langPost']['lang_code'],'news');
					$this->_data['type'] = $this->mnews->dropdownlistType($this->_data['formData']['news_type']);
					$this->_data['layout'] = $this->mnews->dropdownlistLayout($this->_data['formData']['news_layout']);
			        $this->_data['news_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
			        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','switchery.min.css','bootstrap-datepicker.css','jquery.timepicker.min.css','cropper.min.css'];
			        $this->_data['extraJs'] = ['validator.js','language/'.$this->_data['language'].'.js','icheck.min.js','switchery.min.js','jquery.tagsinput.js','bootstrap-datepicker.min.js','jquery.timepicker.min.js','cropper.min.js','tinymce/jquery.tinymce.min.js','tinymce/tinymce.min.js','module/news-post.js'];
					$this->my_layout->view("admin/news/post", $this->_data);
				}
			} else {
				$notify = array(
                    'title' => lang('notfound'), 
                    'text' => lang('news').lang('notexists'),
                    'type' => 'warning'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."news");
			}
		} else {
			$notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'warning'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."news");
		}
	}

	public function delete($id)
	{

	}

	// public function checkPassword()
	// {
	// 	$rs = 0;
	// 	$id = $_GET['id'];
	// 	$password = $_GET['password'];
	// 	if ($id != null && $password != null) {
	// 		$myNews = $this->mnews->getData("news_password",array('id' => $id));
	// 		if (md5($password) == $myNews['news_password']) {
	// 			$rs = 1;
	// 			$this->session->unset_userdata("news_password_".$id);
	// 			$this->session->set_userdata('news_password_'.$id, true);
	// 		}
	// 	}
	// 	echo $rs;
	// }


	public function deleteImage()
	{
		$rs = 0;
		if ($this->mpermission->permission("news_deleteimg",$this->_data['user_active']['active_user_group']) == true) {
			$id = $this->input->get('id');
			if (is_numeric($id) > 0) {
				$myNews = $this->mnews->getData("news_picture",array('id' => $id));
				if (!empty($myNews)) {
					$this->mnews->delimage($id,$myNews['news_picture']);
					if ($this->mnews->edit($id,array('news_picture' => ''))) {
						$rs = 1;
					}
				}
			}
		}
		echo $rs;
	}
}
