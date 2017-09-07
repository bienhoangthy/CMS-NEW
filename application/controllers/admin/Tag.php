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
        if (isset($_POST['delAll'])) {
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
            $checkAlias = $this->mtag->getData("id",array('tag_alias' => $this->_data['formData']['tag_alias']));
            $error = false;
            do {
                if ($this->_data['formData']['tag_name'] == null) {
                    $text = lang('pleaseinput').lang('tagname');$error = true;break;
                }
                if ($checkAlias && $checkAlias['id'] > 0) {
                    $text = lang('tag').lang('doesexists');$error = true;break;
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
        var_dump($this->_data['list']);
    } 
}
