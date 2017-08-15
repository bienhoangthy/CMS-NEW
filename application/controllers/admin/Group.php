<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Group extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('group',$this->_data['language']);
        $this->load->Model("admin/mgroup");
    }
    public function index()
    {
        $this->mpermission->checkPermission("group","index",$this->_data['user_active']['active_user_group']);
    	$this->load->library("My_paging");
    	$this->_data['title'] = lang('list');
    	$this->_data['formData'] = array(
    		'fkeyword' => isset($_GET['fkeyword']) ? $_GET['fkeyword'] : '',
    		'fstatus' => isset($_GET['fstatus']) ? $_GET['fstatus'] : 0,
    		'fperpage' => isset($_GET['fperpage']) ? $_GET['fperpage'] : 10
    	);
    	$and = '1';
    	if ($this->_data['formData']['fkeyword'] != '') {
    		$and .= ' and group_name like "%' . $this->_data['formData']['fkeyword'] . '%"';
    	}
    	if ($this->_data['formData']['fstatus'] > 0) {
    		$and .= ' and group_status = '. $this->_data['formData']['fstatus'];
    	}
		$paging['per_page'] = $this->_data['formData']['fperpage'];
		$paging['num_links'] = 5;
		$paging['page'] = $this->_data['page'] = isset($_GET['page']) && $_GET['page'] ? $_GET['page'] : 1;
		$paging['start'] = (($paging['page'] - 1) * $paging['per_page']);
		$query_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? str_replace("&page=" . $this->_data['page'], "", $_SERVER['QUERY_STRING']) : '';
		$paging['base_url'] = my_library::admin_site() . 'group/?' . $query_string . '&page=';
		$orderby = 'group_status asc,id asc';
		$limit = $paging['start'] . ',' . $paging['per_page'];
		$this->_data['list'] = $this->mgroup->getQuery($object = "", $and, $orderby, $limit);
		$this->_data['record'] = $this->mgroup->countQuery($and);
		$this->_data["pagination"] = $this->my_paging->paging_donturl($this->_data["record"], $paging['page'], $paging['per_page'], $paging['num_links'], $paging['base_url']);
		$this->_data['fstatus'] = $this->mgroup->dropdownlistStatus($this->_data['formData']['fstatus']);
    	$this->my_layout->view("admin/group/index", $this->_data);
    }   

    public function add()
    {
        $this->mpermission->checkPermission("group","add",$this->_data['user_active']['active_user_group']);
    	$this->_data['title'] = lang('addgroup');
    	$this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
        $this->_data['formData'] = array(
        	'group_name' => '', 
        	'group_status' => 1, 
        	'group_createdate' => date("Y-m-d"), 
        	'group_module' => ''
        );
        if (isset($_POST['group_name'])) {
        	$module = '';
        	$module_post = $this->input->post('module');
        	if ($module_post) {
        		$module = serialize($module_post);
        	}
        	$this->_data['formData'] = array(
	        	'group_name' => $this->input->post('group_name'), 
	        	'group_status' => $this->input->post('group_status'), 
	        	'group_createdate' => date("Y-m-d"), 
	        	'group_module' => $module
	        );
        	if ($this->_data['formData']['group_name'] == null) {
        		$notify = array(
                    'title' => lang('unsuccessful'), 
                    'text' => lang('pleaseinput').lang('groupname'),
                    'type' => 'error'
                );
                $this->session->set_userdata('notify', $notify);
        	} else {
        		$insert = $this->mgroup->add($this->_data['formData']);
        		if (is_numeric($insert) > 0) {
        			$notify = array(
                        'title' => lang('success'), 
                        'text' => lang('group').' '.$this->_data['formData']['group_name'].lang('added'),
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    redirect(my_library::admin_site()."group");
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
        if ($this->_data['formData']['group_module'] != '') {
        	$this->_data['formData']['group_module'] = unserialize($this->_data['formData']['group_module']);
        }
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','switchery.min.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js','switchery.min.js','module/group.js'];
        $this->my_layout->view("admin/group/post", $this->_data);
    }

    public function edit($id)
    {
        $this->mpermission->checkPermission("group","edit",$this->_data['user_active']['active_user_group']);
    	if (is_numeric($id) && $id > 0) {
    		$myGroup = $this->mgroup->getData("",array('id' => $id));
    		if ($myGroup && $myGroup['id'] > 0) {
    			$this->_data['title'] = lang('editgroup')." #".$id;
    			$this->_data['token_name'] = $this->security->get_csrf_token_name();
                $this->_data['token_value'] = $this->security->get_csrf_hash();
                $this->_data['formData'] = array(
		        	'group_name' => $myGroup['group_name'], 
		        	'group_status' => $myGroup['group_status'],
		        	'group_module' => $myGroup['group_module']
		        );
                if (isset($_POST['group_name'])) {
		        	$module = $myGroup['group_module'];
		        	$module_post = $this->input->post('module');
		        	if ($module_post) {
		        		$module = serialize($module_post);
		        	}
		        	$this->_data['formData'] = array(
			        	'group_name' => $this->input->post('group_name'), 
			        	'group_status' => $this->input->post('group_status'),
			        	'group_module' => $module
			        );
		        	if ($this->_data['formData']['group_name'] == null) {
		        		$notify = array(
		                    'title' => lang('unsuccessful'), 
		                    'text' => lang('pleaseinput').lang('groupname'),
		                    'type' => 'error'
		                );
		                $this->session->set_userdata('notify', $notify);
		        	} else {
		        		if ($this->mgroup->edit($id,$this->_data['formData'])) {
		        			$notify = array(
		                        'title' => lang('success'), 
		                        'text' => lang('group').' '.$this->_data['formData']['group_name'].lang('edited'),
		                        'type' => 'success'
		                    );
		                    $this->session->set_userdata('notify', $notify);
		                    redirect(my_library::admin_site()."group/edit/".$id);
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
		        if ($this->_data['formData']['group_module'] != '') {
		        	$this->_data['formData']['group_module'] = unserialize($this->_data['formData']['group_module']);
		        }
		        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','switchery.min.css'];
		        $this->_data['extraJs'] = ['validator.js','icheck.min.js','switchery.min.js','module/group.js'];
		        $this->my_layout->view("admin/group/post", $this->_data);
    		} else {
    			$notify = array(
                    'title' => lang('notfound'), 
                    'text' => lang('notfound').' '.lang('group'),
                    'type' => 'warning'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."group");
    		}
    		
    	} else {
    		$notify = array(
                'title' => lang('notfound'), 
                'text' => lang('wrongid'),
                'type' => 'warning'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."group");
    	}
    }

    public function delete($id)
    {
        $this->mpermission->checkPermission("group","delete",$this->_data['user_active']['active_user_group']);
    	if (is_numeric($id) && $id != 1) {
    		$myGroup = $this->mgroup->getData("",array('id' => $id));
    		if ($myGroup && $myGroup['id'] > 0) {
    			$this->mgroup->delete($id);
                $this->mpermission->deleteAnd(array('group_id' => $myGroup['id']));
    			$title = lang('success');
                $text = lang('group').' '.$myGroup['group_name'].lang('deleted');
                $type = 'success';
    		} else {
    			$title = lang('unsuccessful');
                $text = lang('notfound').' '.lang('group');
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
        redirect(my_library::admin_site()."group");
    }

    public function permission($id)
    {
        $this->mpermission->checkPermission("group","permission",$this->_data['user_active']['active_user_group']);
        $this->load->Model("admin/mcomponent");
        $this->load->Model("admin/maction");
        if (is_numeric($id) && $id > 0) {
            $this->_data['myGroup'] = $this->mgroup->getData("",array('id' => $id));
            if ($this->_data['myGroup'] && $this->_data['myGroup']['id'] > 0) {
                $this->_data['title'] = lang('groupper')." #".$id;
                $this->_data['listComponent'] = $this->mcomponent->getQuery("id,component_name,component","component_status = 1","component_orderby asc","");
                $this->_data['extraCss'] = ['switchery.min.css'];
                $this->_data['extraJs'] = ['switchery.min.js','language/'.$this->_data['language'].'.js','module/permission.js'];
                $this->my_layout->view("admin/group/permission", $this->_data);
            } else {
                $notify = array(
                    'title' => lang('unsuccessful'), 
                    'text' => lang('notfound').' '.lang('group'),
                    'type' => 'warning'
                );
                $this->session->set_userdata('notify', $notify);
                redirect(my_library::admin_site()."group");
            }
            
        } else {
            $notify = array(
                'title' => lang('unsuccessful'), 
                'text' => lang('wrongid'),
                'type' => 'warning'
            );
            $this->session->set_userdata('notify', $notify);
            redirect(my_library::admin_site()."group");
        }
    }

}
