<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include ( APPPATH . 'core/MY_Controllerfront.php' );
class News extends MY_Controllerfront {
	public function __construct()
    {
        parent::__construct();
        $this->load->Model("front/mnews");
    }
	public function detail($id)
	{
		$this->_data['myNews'] = $this->mnews->getNewsbyID($id);
		if ($this->_data['myNews'] == null) {
			echo "Bài viết không tồn tại!";
		} else {
			var_dump($this->_data['myNews']);die();
		}
	}
}
