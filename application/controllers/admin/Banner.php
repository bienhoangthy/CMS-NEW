<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class banner extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
        $this->lang->load('banner',$this->_data['language']);
        $this->load->Model("admin/mbanner");
        $this->load->Model("admin/mactivity");
    }
	public function index()
	{
		$this->mpermission->checkPermission("banner","index",$this->_data['user_active']['active_user_group']);
		$this->load->library("My_paging");
        $this->_data['title'] = lang('list');
        $obj = 'id,banner_status,banner_position,banner_link,banner_type,banner_updatedate,user';
        $this->_data['formData'] = array(
            'fposition' => $_GET['fposition'] ?? 0,
            'ftype' => $_GET['ftype'] ?? 0,
            'fstatus' => $_GET['fstatus'] ?? 0,
            'fuser' => $_GET['fuser'] ?? 0
        );
        //$this->_data['flanguage'] = $this->mlanguage->getLanguage($this->_data['formData']['flanguage']);
        $and = '1';
        if ($this->_data['formData']['fposition'] > 0) {
            $and .= ' and banner_position = '. $this->_data['formData']['fposition'];
        }
        if ($this->_data['formData']['ftype'] > 0) {
            $and .= ' and banner_type = '. $this->_data['formData']['ftype'];
        }
        if ($this->_data['formData']['fstatus'] > 0) {
            $and .= ' and banner_status = '. $this->_data['formData']['fstatus'];
        }
        if ($this->_data['formData']['fuser'] > 0) {
            $and .= ' and user = '. $this->_data['formData']['fuser'];
        }
        // if ($this->_data['formData']['fkeyword'] != '') {
        //     $and .= ' and (vt.banner_name like "%' . $this->_data['formData']['fkeyword'] . '%"';
        //     $and .= ' or vt.banner_alias like "%' . $this->_data['formData']['fkeyword'] . '%")';
        // }
        $orderby = 'id desc';
        $paging['per_page'] = 20;
        $paging['num_links'] = 5;
        $paging['page'] = $this->_data['page'] = $_GET['page'] ?? 1;
        $paging['start'] = (($paging['page'] - 1) * $paging['per_page']);
        $query_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? str_replace("&page=" . $this->_data['page'], "", $_SERVER['QUERY_STRING']) : '';
        $paging['base_url'] = my_library::admin_site() . 'banner/?' . $query_string . '&page=';
        $limit = $paging['start'] . ',' . $paging['per_page'];
        $this->_data['list'] = $this->mbanner->getQuery($obj, $and, $orderby, $limit);
        $this->_data['record'] = $this->mbanner->countQuery($and);
        $this->_data["pagination"] = $this->my_paging->paging_donturl($this->_data["record"], $paging['page'], $paging['per_page'], $paging['num_links'], $paging['base_url']);
        $this->_data['fposition'] = $this->mbanner->dropdownlistPosition($this->_data['formData']['fposition']);
        $this->_data['ftype'] = $this->mbanner->dropdownlistType($this->_data['formData']['ftype']);
        $this->_data['fstatus'] = $this->mbanner->dropdownlistStatus($this->_data['formData']['fstatus']);
        $this->_data['fuser'] = $this->muser->dropdownlistUser($this->_data['formData']['fuser']);
        $this->my_layout->view("admin/banner/index", $this->_data);
	}

    public function add()
    {
        $this->mpermission->checkPermission("banner","add",$this->_data['user_active']['active_user_group']);
        $this->_data['langPost'] = $_GET['lang'] ?? $this->_data['language'];
        $this->_data['langPost'] = $this->mlanguage->getLanguage($this->_data['langPost']);
        $this->_data['formData'] = array( 
            'banner_status' => 1, 
            'banner_position' => 0, 
            'banner_link' => '', 
            'banner_type' => 0,
            'banner_html' => '',
            'banner_iframe' => '',
            'banner_picture' => '',
            'banner_orderby' => 0
        );
        $this->_data['formDataLang'] = array(
            'banner_title' => '',
            'banner_description' => ''
        );
        //Post
        if (isset($_POST['banner_status'])) {
            $lang = $this->input->post('banner_lang') ?? $this->_data['language'];
            $error = true;
            $width = 0;
            $height = 0;
            $position = $this->mposition->getData("",array('id' => $this->input->post('banner_position')));
            if ($position) {
                $width = $position['position_width'];
                $height = $position['position_height'];
                $error = false;
                $text = lang('position').lang('notexists');
            }
            switch ($this->input->post('banner_type')) {
                case 1:
                    $fields = 'banner_picture';$value_fields = $this->input->post('banner_picture') ?? '';
                    break;
                case 2:
                    $fields = 'banner_html';$value_fields = $this->input->post('banner_html') ?? '';
                    break;
                case 3:
                    $fields = 'banner_iframe';$value_fields = $this->input->post('banner_iframe') ?? '';
                    break;
                default:
                    $fields = 'banner_picture';$value_fields = '';
                    break;
            }
            $this->_data['formData'] = array( 
                'banner_status' => $this->input->post('banner_status'),
                'banner_position' => $this->input->post('banner_position'),
                'banner_link' => $this->input->post('banner_link'),
                'banner_type' => $this->input->post('banner_type'),
                $fields => $value_fields,
                'banner_width' => $width,
                'banner_height' => $height,
                'banner_display_all' => 0,
                'banner_orderby' => $this->input->post('banner_orderby'),
                'banner_createdate' => date("Y-m-d H:i:s"),
                'banner_updatedate' => date("Y-m-d H:i:s"),
                'user' => $this->_data['user_active']['active_user_id']
            );
            $this->_data['formDataLang'] = array(
                'banner_id' => 0,
                'language_code' => $lang,
                'banner_title' => $this->input->post('banner_title'),
                'banner_description' => $this->input->post('banner_description')
            );
            do {
                if ($this->_data['formData']['banner_position'] == null || $this->_data['formData']['banner_position'] < 1) {
                    $text = lang('pleasechoose').lang('position');$error = true;break;
                }
                if ($this->_data['formData']['banner_type'] == null || $this->_data['formData']['banner_type'] < 1) {
                    $text = lang('pleasechoose').lang('type');$error = true;break;
                }
                if ($this->_data['formData'][$fields] == null) {
                    $text = lang('pleaseinput').lang('content').lang('type');$error = true;break;
                }
                if ($this->_data['formDataLang']['banner_title'] == null) {
                    $text = lang('pleaseinput').lang('bannertitle');$error = true;break;
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
                $insert = $this->mbanner->add($this->_data['formData']);
                if (is_numeric($insert) && $insert > 0) {
                    if ($this->_data['formData']['banner_type'] == 1) {
                        $this->mbanner->uploadBanner($insert,$value_fields);
                    }
                    $this->_data['formDataLang']['banner_id'] = $insert;
                    $insert_lang = $this->mbanner_translation->add($this->_data['formDataLang']);
                    $titleinsertlang = is_numeric($insert_lang) > 0 ? ' | '.$lang : '';
                    $notify = array(
                        'title' => lang('success'), 
                        'text' => lang('banner').' #'.$insert.lang('added').$titleinsertlang,
                        'type' => 'success'
                    );
                    $this->session->set_userdata('notify', $notify);
                    redirect(my_library::admin_site()."banner/index");
                }
            }  
        }
        $this->_data['type'] = $this->mbanner->dropdownlistType($this->_data['formData']['banner_type']);
        $this->_data['position'] = $this->mbanner->dropdownlistPosition($this->_data['formData']['banner_position']);
        $this->_data['token_name'] = $this->security->get_csrf_token_name();
        $this->_data['token_value'] = $this->security->get_csrf_hash();
        $this->_data['title'] = lang('banneradd');
        $this->_data['banner_lang'] = $this->mlanguage->dropdownlist($this->_data['langPost']['lang_code'],$this->_data['listLanguage']);
        $this->_data['extraCss'] = ['iCheck/skins/flat/green.css','switchery.min.css'];
        $this->_data['extraJs'] = ['validator.js','icheck.min.js','language/'.$this->_data['language'].'.js','switchery.min.js','module/banner.js'];
        $this->my_layout->view("admin/banner/post", $this->_data);
    }
}
