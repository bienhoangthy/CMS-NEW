<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include ( APPPATH . 'core/MY_Controllerfront.php' );
class Sitemap extends MY_Controllerfront {
	public function __construct()
    {
        parent::__construct();
        // $this->load->Model("front/mnews");
    }
	
	public function sitemapXML()
	{
		$this->load->view("front/sitemap/xml", $this->_data);
	}

	public function sitemapHTML()
	{
		echo "This is sitemap HTML";
	}
}
