<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controllerfront extends CI_Controller {
	protected $_data;
	public function __construct()
	{
		parent::__construct();
		$this->load->library("My_layout");
		$this->load->Model("front/mmenu");
		$this->load->Model("front/mlanguage");
		$this->load->Model("front/mconfig");
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		//Language
		$this->_data['listLanguage'] = $this->mlanguage->getLanguage();
		if (!$this->_data['language'] = $this->session->userdata('language')) {
			$this->_data['language'] = $this->_data['listLanguage'][0]['lang_code'];
			$this->session->set_userdata('language', $this->_data['language']);
		}
		//Menu Main id = 1
		$this->_data['submenu'] = true;
		if (!$this->_data['menuMain'] = $this->cache->get('menu1_'.$this->_data['language'])) {
			$this->_data['menuMain'] = $this->mmenu->getMenubyId(1,$this->_data['submenu'],$this->_data['language']);
			$this->cache->save('menu1_'.$this->_data['language'],$this->_data['menuMain'], 86400);
		}
		//Config
		if (!$this->_data['config'] = $this->cache->get('config_'.$this->_data['language'])) {
			$this->_data['config'] = $this->mconfig->getConfig($this->_data['language']);
			$this->cache->save('config_'.$this->_data['language'],$this->_data['config'], 86400);
		}

		

		//$this->my_layout->setLayout("front/template/index");

		// $this->_data['user_active'] = $this->session->userdata('userActive');

		$this->_data['title'] = "";
		$this->_data['extraCss'] = array();
		$this->_data['extraJs'] = array();
		var_dump($this->_data);die();
	}
}
