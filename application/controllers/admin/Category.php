<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('category',$this->_data['language']);
        $this->load->Model("admin/mcategory");
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

	}

	public function edit($id)
	{

	}

	public function delete($id)
	{
		
	}
}
