<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include ( APPPATH . 'core/MY_Controllerfront.php' );
class Video extends MY_Controllerfront {
	public function __construct()
    {
        parent::__construct();
        $this->load->Model("front/mvideo");
    }
	public function detail($id)
	{
		$this->_data['myVideo'] = $this->mvideo->getVideobyID($id,'v.id,vt.video_name');
		if ($this->_data['myVideo'] == null) {
			echo "Video không tồn tại!";
		} else {
			var_dump($this->_data['myVideo']);die();
		}
	}
}
