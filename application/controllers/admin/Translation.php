<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Translation extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->lang->load('translation',$this->_data['language']);
        // $this->load->Model("admin/maction");
        // $this->mpermission->checkPermissionModule($this->uri->segment(2),$this->_data['user_active']['active_user_module']);
    }
    public function index()
    {
        $dir = APPPATH . '/language/english';
        $this->_data['files'] = scandir($dir);
        unset($this->_data['files'][0],$this->_data['files'][1]);
        $this->_data['filename'] = $this->input->get('file') ?? '';
        if ($this->_data['filename'] != null && $this->_data['filename'] != '') {
            $this->load->helper('file');
            $filePathen = APPPATH . '/language/english/'.$this->_data['filename'].'.php';
            $filePathvn = APPPATH . '/language/vietnamese/'.$this->_data['filename'].'.php';
            $contenten = read_file($filePathen);
            $this->_data['arrEN'] = explode(';', $contenten);
            array_shift($this->_data['arrEN']);
            array_pop($this->_data['arrEN']);
            //VN
            $contentvn = read_file($filePathvn);
            $this->_data['arrContent'] = explode(';', $contentvn);
            array_shift($this->_data['arrContent']);
            array_pop($this->_data['arrContent']);
        }
        $this->_data['title'] = lang('title');
        $this->_data['extraJs'] = ['module/translation.js'];
        $this->my_layout->view("admin/translation/index", $this->_data);
    }

    public function edit()
    {
    	$rs = array("status" => 0,"title" => lang('unsuccessful'),"message" => lang('nonpermission'));
    	if ($this->mpermission->permission("translation_edit",$this->_data['user_active']['active_user_group']) == true) {
    		$lang = $this->input->get('lang');
	    	$filename = $this->input->get('filename');
	    	$content = $this->input->get('content');
	    	$newcontent = $this->input->get('newcontent');
	    	if ($lang && $filename && $content) {
	    		$filePath = APPPATH . '/language/'.$lang.'/'.$filename.'.php';
	    		$file_contents = file_get_contents($filePath);
	    		$file_contents = str_replace($content, $newcontent, $file_contents);
	    		if (file_put_contents($filePath, $file_contents)) {
	    			$rs = array("status" => 1,"title" => lang('success'),"message" => lang('editsuccess'));
	    		} else {
	    			$rs = array("status" => 0,"title" => lang('unsuccessful'),"message" => lang('editunsuccess'));
	    		}
	    	} else {
	    		$rs = array("status" => 0,"title" => lang('unsuccessful'),"message" => lang('checkinfo'));
	    	}
    	}
    	echo json_encode($rs);
    }
}
