<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include ( APPPATH . 'core/MY_Controllerfront.php' );
class Page extends MY_Controllerfront {
	public function __construct()
    {
        parent::__construct();
        $this->load->Model("front/mpage");
    }
	public function index($alias)
	{
		$this->_data['myPage'] = $this->mpage->getPagebyAlias($alias);
		if ($this->_data['myPage'] == null) {
			echo "Trang không tồn tại!";
		} else {
			var_dump($this->_data['myPage']);die();
		}
	}
}
