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
	public function index()
	{
		$this->mpermission->checkPermission("news","index",$this->_data['user_active']['active_user_group']);
		$this->load->library("My_paging");
        $this->_data['title'] = lang('title');
        $obj = 'n.id,n.news_category,n.news_status,n.news_state,n.news_picture,n.news_publicdate,n.news_password,n.user,nt.id as news_lang_id,nt.news_title,nt.news_alias';
        $this->_data['formData'] = array(
            'fkeyword' => $_GET['fkeyword'] ?? '',
            'fstatus' => $_GET['fstatus'] ?? 0,
            'fstate' => $_GET['fstate'] ?? 3,
            'fhot' => $_GET['fhot'] ?? 0,
            'fcategory' => $_GET['fcategory'] ?? 0,
            'fpublicdate' => $_GET['fpublicdate'] ?? '',
            'flanguage' => $_GET['flanguage'] ?? $this->_data['language'],
            'fperpage' => $_GET['fperpage'] ?? 20
        );
        $this->_data['flanguage'] = $this->mlanguage->getLanguage($this->_data['formData']['flanguage']);
        $and = 'n.news_state = '. $this->_data['formData']['fstate'];
        //$and = '1';
        if ($this->_data['formData']['fstatus'] > 0) {
            $and .= ' and n.news_status = '. $this->_data['formData']['fstatus'];
        }
        if ($this->_data['formData']['fhot'] == 1) {
            $and .= ' and n.news_hot = 1';
        }
        if ($this->_data['formData']['fcategory'] > 0) {
            $and .= ' and n.news_category = '. $this->_data['formData']['fcategory'];
        }
        if ($this->_data['formData']['fkeyword'] != '') {
            $and .= ' and (n.news_tag like "%' . $this->_data['formData']['fkeyword'] . '%"';
            $and .= ' or nl.news_title like "%' . $this->_data['formData']['fkeyword'] . '%"';
            $and .= ' or nl.news_alias like "%' . $this->_data['formData']['fkeyword'] . '%"';
            $and .= ' or nl.news_summary like "%' . $this->_data['formData']['fkeyword'] . '%")';
        }
        // if ($this->_data['formData']['fpublicdate'] != '') {
        //     $and .= ' and n.news_publicdate = '. $this->_data['formData']['fpublicdate'];
        // }
        $paging['per_page'] = $this->_data['formData']['fperpage'];
        $paging['num_links'] = 5;
        $paging['page'] = $this->_data['page'] = $_GET['page'] ?? 1;
        $paging['start'] = (($paging['page'] - 1) * $paging['per_page']);
        $query_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? str_replace("&page=" . $this->_data['page'], "", $_SERVER['QUERY_STRING']) : '';
        $paging['base_url'] = my_library::admin_site() . 'news/?' . $query_string . '&page=';
        $orderby = 'n.news_orderby desc,n.id desc';
        $limit = $paging['start'] . ',' . $paging['per_page'];
        $this->_data['list'] = $this->mnews->getNews($obj, $and, $orderby, $limit);
        //var_dump($this->_data['list']);die();
        //Lỗi count
        $this->_data['record'] = $this->mnews->countQuery($and);
        $this->_data["pagination"] = $this->my_paging->paging_donturl($this->_data["record"], $paging['page'], $paging['per_page'], $paging['num_links'], $paging['base_url']);
        //$this->_data['extraJs'] = ['jquery.smartWizard.js'];
        $this->my_layout->view("admin/news/index", $this->_data);
	}

	public function add()
	{

	}

	public function edit($id)
	{

	}

	public function delete($id)
	{

	}

	public function deleteImage()
	{
		// $rs = 0;
		// if ($this->mpermission->permission("category_deleteimg",$this->_data['user_active']['active_user_group']) == true) {
		// 	$id = $this->input->get('id');
		// 	if (is_numeric($id) > 0) {
		// 		$myCategory = $this->mcategory->getData("category_picture",array('id' => $id));
		// 		if (!empty($myCategory)) {
		// 			$this->mcategory->delimage($myCategory['category_picture']);
		// 			if ($this->mcategory->edit($id,array('category_picture' => ''))) {
		// 				$rs = 1;
		// 			}
		// 		}
		// 	}
		// }
		// echo $rs;
	}
}
