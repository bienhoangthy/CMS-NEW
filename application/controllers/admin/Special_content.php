<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Special_content extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('sc',$this->_data['language']);
        $this->load->Model("admin/mcategory");
        $this->load->Model("admin/mcomponent");
        $this->load->Model("admin/mspecial_content");
    }

    public function index()
    {
        $this->mpermission->checkPermission("special_content","index",$this->_data['user_active']['active_user_group']);
        $this->load->library("My_paging");
        $this->_data['title'] = lang('list');
        $obj = '';
        $this->_data['formData'] = array(
            'fcomponent' => $_GET['fcomponent'] ?? '',
            'forderby' => $_GET['forderby'] ?? 0,
            'fstatus' => $_GET['fstatus'] ?? 0,
            'fcategory' => $_GET['fcategory'] ?? 0,
            'fuser' => $_GET['fuser'] ?? 0
        );
        $and = '1';
        if ($this->_data['formData']['fcomponent'] != '') {
            $and .= ' and sc_component = '. $this->_data['formData']['fcomponent'];
        }
        if ($this->_data['formData']['forderby'] > 0) {
            $and .= ' and sc_orderby = '. $this->_data['formData']['forderby'];
        }
        if ($this->_data['formData']['fstatus'] > 0) {
            $and .= ' and sc_status = '. $this->_data['formData']['fstatus'];
        }
        if ($this->_data['formData']['fcategory'] > 0) {
            $and .= ' and sc_category = '. $this->_data['formData']['fcategory'];
        }
        if ($this->_data['formData']['fuser'] > 0) {
            $and .= ' and user = '. $this->_data['formData']['fuser'];
        }
        $orderby = 'id desc';
        $this->_data['list'] = $this->mspecial_content->getQuery($obj, $and, $orderby, "");
        $this->_data['record'] = $this->mspecial_content->countQuery($and);

        //$this->_data['fposition'] = $this->mspecial_content->dropdownlistPosition($this->_data['formData']['fposition']);
        //$this->_data['ftype'] = $this->mspecial_content->dropdownlistType($this->_data['formData']['ftype']);
        $this->_data['fstatus'] = $this->mspecial_content->dropdownlistStatus($this->_data['formData']['fstatus']);
        $this->_data['fcategory'] = $this->mcategory->dropdownlistCategory($this->_data['formData']['fcategory'],$this->_data['language']);
        $this->_data['fuser'] = $this->muser->dropdownlistUser($this->_data['formData']['fuser']);
        $this->_data['extraCss'] = [];
        $this->_data['extraJs'] = [];
        $this->my_layout->view("admin/special_content/index", $this->_data);
    }

    public function add()
    {
        $this->mpermission->checkPermission("special_content","add",$this->_data['user_active']['active_user_group']);
        $this->_data['langPost'] = $_GET['lang'] ?? $this->_data['language'];
        $this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
        $this->_data['formData'] = array( 
            'code_position' => '', 
            'sc_component' => '', 
            'sc_quantity' => 0,
            'sc_orderby' => 0,
            'sc_status' => 1,
            'sc_category' => 0,
            'sc_cache' => 0,
            'sc_time_cache' => 0
        );
        $this->_data['formDataLang'] = array(
            'sc_name' => '',
            'sc_description' => ''
        );
        //Post
        if (isset($_POST['sc_name'])) {
            var_dump($_POST);die();
            //Dùng ajax để load category dựa vào component để chính xác hơn
        }
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
        $this->_data['title'] = lang('specialcontentadd');
        $this->_data['category'] = $this->mcategory->dropdownlistCategory($this->_data['formData']['sc_category'],$this->_data['langPost']['lang_code']);
        $this->_data['special_content_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
        $this->_data['component'] = $this->mcomponent->dropdownlist($this->_data['formData']['sc_component']);
        $this->_data['orderby'] = $this->mspecial_content->dropdownlistOrderBy($this->_data['formData']['sc_orderby']);
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','switchery.min.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js','switchery.min.js'];
        $this->my_layout->view("admin/special_content/post", $this->_data);
    }
}
