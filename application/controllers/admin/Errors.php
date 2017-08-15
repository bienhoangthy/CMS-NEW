<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Errors extends MY_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->lang->load('module',$this->_data['language']);
        //$this->load->Model("admin/mgroup");
    }
    public function page404()
    {
    	$this->_data['title'] = "Not found";
    	$this->my_layout->view("admin/errors/404", $this->_data);
    }   

    public function page401()
    {
    	$this->_data['title'] = "Not permission";
    	$this->my_layout->view("admin/errors/401", $this->_data);
    }   
}
