<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tag extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->lang->load('tag',$this->_data['language']);
        $this->load->Model("admin/mtag");
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
    }
    public function index()
    {
        $this->mpermission->checkPermission("tag","index",$this->_data['user_active']['active_user_group']);
        //Delete all
        if (isset($_POST['table_records'])) {
            $this->mpermission->checkPermission("tag","deleteall",$this->_data['user_active']['active_user_group']);
            $listDel = $this->input->post('table_records');
            if ($listDel != null) {
                $this->mtag->delete($listDel);
                $notify = array(
                    'title' => lang('success'), 
                    'text' => count($listDel).' '.lang('tag').lang('deleted'),
                    'type' => 'success'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."tag");
            }
        }
        //Add
        $this->_data['formData'] = array(
            'tag_name' => '',
            'tag_status' => 1
        );
        if (isset($_POST['tag_name'])) {
            $this->mpermission->checkPermission("tag","add",$this->_data['user_active']['active_user_group']);
            $this->load->helper('alias');
            $alias = to_alias($this->input->post('tag_name'));
            $this->_data['formData'] = array(
                'tag_name' => $this->input->post('tag_name'),
                'tag_alias' => $alias,
                'tag_status' => $this->input->post('tag_status'),
                'tag_updatedate' => date("Y-m-d")
            );
            $checkName = $this->mtag->getData("id",array('tag_name' => $this->_data['formData']['tag_name']));
            $checkAlias = $this->mtag->getData("id",array('tag_alias' => $this->_data['formData']['tag_alias']));
            $error = false;
            do {
                if ($this->_data['formData']['tag_name'] == null) {
                    $text = lang('pleaseinput').lang('tagname');$error = true;break;
                }
                if ($checkName && $checkName['id'] > 0) {
                    $text = lang('tag').lang('doesexists');$error = true;break;
                }
                if ($checkAlias && $checkAlias['id'] > 0) {
                    $this->_data['formData']['tag_alias'] = $this->_data['formData']['tag_alias'].'-1';
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
                $insert = $this->mtag->add($this->_data['formData']);
                if (is_numeric($insert) > 0) {
                    $notify = array(
                        'title' => lang('success'), 
                        'text' => lang('tag').' '.$this->_data['formData']['tag_name'].lang('added'),
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    redirect(my_library::admin_site()."tag");
                }
            }
        }
        $this->load->library("My_paging");
        $this->_data['title'] = lang('list');
        $this->_data['formDatalist'] = array(
            'fkeyword' => $_GET['fkeyword'] ?? '',
            'fstatus' => $_GET['fstatus'] ?? 0,
            'fperpage' => $_GET['fperpage'] ?? 10
        );
        $and = '1';
        if ($this->_data['formDatalist']['fkeyword'] != '') {
            $and .= ' and (tag_name like "%' . $this->_data['formDatalist']['fkeyword'] . '%"';
            $and .= ' or tag_alias like "%' . $this->_data['formDatalist']['fkeyword'] . '%")';
        }
        if ($this->_data['formDatalist']['fstatus'] > 0) {
            $and .= ' and tag_status = '. $this->_data['formDatalist']['fstatus'];
        }
        $paging['per_page'] = $this->_data['formDatalist']['fperpage'];
        $paging['num_links'] = 5;
        $paging['page'] = $this->_data['page'] = $_GET['page'] ?? 1;
        $paging['start'] = (($paging['page'] - 1) * $paging['per_page']);
        $query_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? str_replace("&page=" . $this->_data['page'], "", $_SERVER['QUERY_STRING']) : '';
        $paging['base_url'] = my_library::admin_site() . 'tag/?' . $query_string . '&page=';
        $orderby = 'id desc';
        $limit = $paging['start'] . ',' . $paging['per_page'];
        $this->_data['list'] = $this->mtag->getQuery("", $and, $orderby, $limit);
        $this->_data['record'] = $this->mtag->countQuery($and);
        $this->_data["pagination"] = $this->my_paging->paging_donturl($this->_data["record"], $paging['page'], $paging['per_page'], $paging['num_links'], $paging['base_url']);
        $this->_data['fstatus'] = $this->mtag->dropdownlistStatus($this->_data['formDatalist']['fstatus']);
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js','module/tag.js','language/'.$this->_data['language'].'_action.js'];
        $this->my_layout->view("admin/tag/index", $this->_data);
    } 

    public function edit($id)
    {
    	$this->mpermission->checkPermission("tag","edit",$this->_data['user_active']['active_user_group']);
    	if (is_numeric($id) && $id > 0) {
    		$myTag = $this->mtag->getData("",array('id' => $id));
    		if ($myTag && $myTag['id'] > 0) {
    			$this->_data['formData'] = array(
		            'tag_name' => $myTag['tag_name'],
		            'tag_alias' => $myTag['tag_alias'],
		            'tag_status' => $myTag['tag_status']
		        );
		        if (isset($_POST['tag_name'])) {
		            $this->_data['formData'] = array(
		                'tag_name' => $this->input->post('tag_name'),
		                'tag_alias' => $this->input->post('tag_alias'),
		                'tag_status' => $this->input->post('tag_status'),
		                'tag_updatedate' => date("Y-m-d")
		            );
		            $checkName = $this->mtag->getData("id",array('tag_name' => $this->_data['formData']['tag_name']));
		            $checkAlias = $this->mtag->getData("id",array('tag_alias' => $this->_data['formData']['tag_alias']));
		            $error = false;
		            do {
		                if ($this->_data['formData']['tag_name'] == null) {
		                    $text = lang('pleaseinput').lang('tagname');$error = true;break;
		                }
		                if ($checkName && $checkName['id'] != $id) {
		                    $text = lang('tag').lang('doesexists');$error = true;break;
		                }
		                if ($checkAlias && $checkAlias['id'] != $id) {
		                    $this->_data['formData']['tag_alias'] = $this->_data['formData']['tag_alias'].'-1';
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
		            	if ($this->mtag->edit($id,$this->_data['formData'])) {
		            		$notify = array(
		                        'title' => lang('success'), 
		                        'text' => lang('tag').' '.$this->_data['formData']['tag_name'].lang('edited'),
		                        'type' => 'success'
		                    );
		                    $this->session->set_userdata('notify', $notify);
		                    redirect(my_library::admin_site()."tag");
		            	} else {
		            		$notify = array(
		                        'title' => lang('unsuccessful'), 
		                        'text' => lang('checkinfo'),
		                        'type' => 'error'
		                    );
		                    $this->session->set_userdata('notify', $notify);
		            	}
		            }
		        }
		        $this->_data['title'] = lang('tagedit').' #'.$id;
		        $this->_data['token_name'] = $this->security->get_csrf_token_name();
		        $this->_data['token_value'] = $this->security->get_csrf_hash();
		        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css'];
		        $this->_data['extraJs'] = ['validator.js','icheck.min.js'];
		        $this->my_layout->view("admin/tag/post", $this->_data);
    		} else {
    			$notify = array(
                    'title' => lang('notfound'), 
                    'text' => lang('tag').' '.lang('notexists'),
                    'type' => 'warning'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."tag");
    		}
    		
    	} else {
    		$notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'warning'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."tag");
    	}
    }

    public function delete($id)
    {
    	$this->mpermission->checkPermission("tag","delete",$this->_data['user_active']['active_user_group']);
    	if (is_numeric($id) && $id > 0) {
    		$myTag = $this->mtag->getData("",array('id' => $id));
    		if ($myTag && $myTag['id'] > 0) {
    			$this->mtag->delete($id);
    			$title = lang('success');
                $text = lang('tag').' '.$myTag['tag_name'].lang('deleted');
                $type = 'success';
    		} else {
    			$title = lang('unsuccessful');
                $text = lang('tag').lang('notexists');
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
        redirect(my_library::admin_site()."tag");
    }

    public function ajaxQuickedit()
    {
    	$rs = array('status' => 0, 'message' => '');
    	if ($this->mpermission->permission("tag_ajaxQuickedit",$this->_data['user_active']['active_user_group']) == true) {
    		$id = $this->input->get('id');
    		$tag_name = $this->input->get('name');
    		if ($id != null && $tag_name != null) {
    			$myTag = $this->mtag->getData("",array('id' => $id));
	    		if ($myTag && $myTag['id'] > 0) {
	    			$this->load->helper('alias');
	    			$alias = to_alias($tag_name);
		            $dataEdit = array(
		                'tag_name' => $tag_name,
		                'tag_alias' => $alias,
		                'tag_updatedate' => date("Y-m-d")
		            );
		            $checkName = $this->mtag->getData("id",array('tag_name' => $dataEdit['tag_name']));
		            if ($checkName && $checkName['id'] != $id) {
		            	$rs = array('status' => 0, 'message' => lang('tag').lang('doesexists'));
		            } else {
		            	$checkAlias = $this->mtag->getData("id",array('tag_alias' => $dataEdit['tag_alias']));
		            	if ($checkAlias && $checkAlias['id'] != $id) {
			            	$dataEdit['tag_alias'] = $dataEdit['tag_alias'].'-1';
			            }
			            if ($this->mtag->edit($id,$dataEdit)) {
		            		$rs = array('status' => 1, 'message' => lang('tag').' '.$dataEdit['tag_name'].lang('edited'), 'alias' => $dataEdit['tag_alias']);
		            	} else {
		            		$rs = array('status' => 0, 'message' => lang('checkinfo'));
		            	}
		            }
	    		} else {
	    			$rs = array('status' => 0, 'message' => lang('tag').' '.lang('notexists'));
	    		}
    		} else {
    			$rs = array('status' => 0, 'message' => lang('checkinfo'));
    		}
    	} else {
    		$rs = array('status' => 0, 'message' => lang('notpermission'));
    	}
    	echo json_encode($rs);
    }

    public function aj_autoCompleteTag()
        {
            $key = $_GET['key'] ?? strtoupper($_GET['key']);
            $and='tag_status = 1';
            if($key)
            {
                $and .= ' and (tag_name like "%'.$key.'%"';
                $and .= ' or tag_alias like "%'.$key.'%")';          
            }
            $limit="0,10";
            $object = 'DISTINCT tag_name';
            $orderby = 'id desc';  
            $result = $this->mtag->getQuery($object, $and, $orderby, $limit);      
            $data = array();
            if($result)
            {
                foreach ($result as $value) {
                    $row_array['name'] = $value['tag_name'];                                          
                    array_push($data, $row_array);                        
                }
            }            
            echo json_encode($data);
        }
}
