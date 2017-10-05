<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
	protected $_data;
	public function __construct()
	{
		parent::__construct();
		$this->load->library("My_layout");
		$this->load->helper("language");
		$this->load->Model("admin/muser");
		$this->load->Model("admin/mmodule");
		$this->load->Model("admin/mpermission");
		$this->load->Model("admin/mlanguage");
		$this->load->Model("admin/mmail");
		// $this->load->Model("admin/mactivity");
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		$this->my_layout->setLayout("admin/template/index");
		$this->_data['user_active'] = $this->session->userdata('userActive');
		if ($this->uri->segment(2) != "" && $this->_data['user_active'] == NULL) {
			redirect(my_library::admin_site() . '?redirect=' . base64_encode(my_library::base_url() . ltrim($_SERVER["REQUEST_URI"],'/')));
		}
		$this->_data['title'] = "";
		$this->_data['mailUnread'] = $this->mmail->countUnread();
		$this->_data['listMailUnread'] = $this->mmail->getQuery("id,mail_fullname,mail_email,mail_title,mail_senddate","mail_status = 1","id desc","0,5");
		if (!$this->_data['language'] = $this->session->userdata('language')) {
			$this->_data['language'] = 'vietnamese';
			$this->session->set_userdata('language', $this->_data['language']);
		}
		//$this->_data['myModule'] = $this->mmodule->getModule($this->_data['language']);
		if (!$this->_data['myModule'] = $this->cache->get('module')) {
	        $this->_data['myModule'] = $this->mmodule->getModule($this->_data['language']);
	        $this->cache->save('module', $this->_data['myModule'], 3600);
		}
		//$this->session->set_userdata('language', 'vietnamese');
		$this->_data['listLanguage'] = $this->mlanguage->getLanguage();
		$this->_data['controller'] = $this->uri->segment(2);
		$this->_data['extraCss'] = array();
		$this->_data['extraJs'] = array();
	}
}
