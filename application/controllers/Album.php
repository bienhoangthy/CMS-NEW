<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include ( APPPATH . 'core/MY_Controllerfront.php' );
class Album extends MY_Controllerfront {
	public function __construct()
    {
        parent::__construct();
        $this->load->Model("front/malbum");
    }
	public function detail($id)
	{
		$this->_data['myAlbum'] = $this->malbum->getAlbumbyID($id);
		if ($this->_data['myAlbum'] == null) {
			echo "Album không tồn tại!";
		} else {
			$this->_data['myAlbumDetail'] = $this->malbum->getAlbumDetail($id,'','picture,description');
			var_dump($this->_data['myAlbum']);
			var_dump($this->_data['myAlbumDetail']);die();
		}
	}
}
