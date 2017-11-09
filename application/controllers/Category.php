<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include ( APPPATH . 'core/MY_Controllerfront.php' );
class Category extends MY_Controllerfront {
	public function __construct()
    {
        parent::__construct();
        $this->load->Model("front/mcategory");
    }
	public function index($alias)
	{
		$this->_data['myCategory'] = $this->mcategory->getCategorybyAlias($alias);
		if ($this->_data['myCategory'] == null) {
			echo "Danh mục không tồn tại!";
		} else {
			// $this->load->Model("front/m".$this->_data['myCategory']['category_component']);
			var_dump($this->_data['myCategory']);die();
		}
	}
}
