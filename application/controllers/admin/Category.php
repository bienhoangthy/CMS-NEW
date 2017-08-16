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
        	'category_status' => 1
        );


		//POST
		$this->_data['title'] = lang('categoryadd');
		$this->_data['component'] = $this->mcomponent->dropdownlist($this->_data['formData']['category_component']);
        $this->_data['category_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','cropper.min.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js','cropper.min.js','module/category.js'];
		$this->my_layout->view("admin/category/post", $this->_data);
	}

	public function edit($id)
	{

	}

	public function delete($id)
	{
		
	}
}
