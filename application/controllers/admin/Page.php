<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Page extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->lang->load('page',$this->_data['language']);
        $this->load->Model("admin/mpage");
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
    }

    public function index()
    {
    	$this->mpermission->checkPermission("page","index",$this->_data['user_active']['active_user_group']);
    	$this->_data['flanguage'] = $_GET['flanguage'] ?? $this->_data['language'];
    	$this->_data['title'] = lang('list');
        $this->_data['flanguage'] = $this->mlanguage->getLanguage($this->_data['flanguage']);
    	$this->_data['list'] = $this->mpage->getPage($this->_data['flanguage']['lang_code']);
    	$this->my_layout->view("admin/page/index", $this->_data);
    }

    public function add()
    {
    	$this->mpermission->checkPermission("page","add",$this->_data['user_active']['active_user_group']);
    	$this->_data['langPost'] = $_GET['lang'] ?? $this->_data['language'];
    	$this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
        $this->_data['formData'] = array( 
        	'page_template' => 0, 
        	'page_status' => 1, 
            'page_picture' => '',
            'page_orderby' => 0
        );
        $this->_data['formDataLang'] = array(
        	'page_title' => '',
        	'page_alias' => '',
        	'page_detail' => '',
        	'page_seo_title' => '',
        	'page_seo_description' => '',
        	'page_seo_keyword' => ''
        );
        if (isset($_POST['page_title'])) {
        	var_dump($_POST);die();
        }
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
		$this->_data['title'] = lang('addpage');
		$this->_data['template'] = $this->mpage->dropdownlistTemplate($this->_data['formData']['page_template']);
        $this->_data['page_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','cropper.min.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js','cropper.min.js','tinymce/jquery.tinymce.min.js','tinymce/tinymce.min.js','module/page.js'];
		$this->my_layout->view("admin/page/post", $this->_data);
    }

    public function deleteImage()
    {
    	$rs = 0;
		if ($this->mpermission->permission("page_deleteimg",$this->_data['user_active']['active_user_group']) == true) {
			$id = $this->input->get('id');
			if (is_numeric($id) > 0) {
				$myPage = $this->mpage->getData("page_picture",array('id' => $id));
				if (!empty($myPage)) {
					$this->mpage->delimage($myPage['page_picture']);
					if ($this->mpage->edit($id,array('page_picture' => ''))) {
						$rs = 1;
					}
				}
			}
		}
		echo $rs;
    }
}
