<?php if (!defined('BASEPATH')) exit('No direct script access
	allowed');

 // include_once 'elfinder/php/elFinderConnector.class.php';
 // include_once 'elfinder/php/elFinder.class.php';
 // include_once 'elfinder/php/elFinderVolumeDriver.class.php';
 // include_once 'elfinder/php/elFinderVolumeLocalFileSystem.class.php';
include_once 'elfinder/php/autoload.php';

class My_elfinder{
	public function __construct(){
		// $opts = array(
		// 	'bind' => array('upload' => array($this, 'setToken')),
		// 	'roots' => $opts);
		$opts = array(
			'bind' => array('upload' => array($this, 'setToken')),
            'roots' => array(
                array( 
                    'driver'        => 'LocalFileSystem',
                    'path'          => realpath(APPPATH . "../public/files"),
                    'URL'           => my_library::base_public()."files",
                    'uploadDeny'    => array('all'),                  // All Mimetypes not allowed to upload
                    'uploadAllow'   => array('image', 'text/plain', 'application/pdf'),// Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder'   => array('deny', 'allow'),        // allowed Mimetype `image` and `text/plain` only
                    'accessControl' => array($this, 'elfinderAccess'),// disable and hide dot starting files (OPTIONAL)
                    // more elFinder options here
                ) 
            ),
        );
		$connector = new elFinderConnector(new elFinder($opts));
		$connector->run();   
	}

	public function setToken($cmd, &$result, $args, $elfinder) {
	    $token_name = $this->security->get_csrf_token_name(); //return string 'token'
	    $hash = $this->security->get_csrf_hash();
	    $result[$token_name] = $hash;
	}
}