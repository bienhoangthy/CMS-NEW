<?php

error_reporting(0); // Set E_ALL for debuging

//CI
define('ENVIRONMENT', 'development');

$ds = DIRECTORY_SEPARATOR;
define('BASEPATH', dirname(dirname(dirname(__FILE__))));
define('APPPATH', BASEPATH . $ds . 'application' . $ds);
define('LIBBATH', BASEPATH . "{$ds}system{$ds}libraries{$ds}Session{$ds}");

require_once LIBBATH . 'Session_driver.php';
require_once LIBBATH . "drivers{$ds}Session_files_driver.php";
require_once BASEPATH . "{$ds}system{$ds}core{$ds}Common.php";

$config = get_config();

if (empty($config['sess_save_path'])) {
    $config['sess_save_path'] = rtrim(ini_get('session.save_path'), '/\\');
}

$config = array(
    'cookie_lifetime'   => $config['sess_expiration'],
    'cookie_name'       => $config['sess_cookie_name'],
    'cookie_path'       => $config['cookie_path'],
    'cookie_domain'     => $config['cookie_domain'],
    'cookie_secure'     => $config['cookie_secure'],
    'expiration'        => $config['sess_expiration'],
    'match_ip'          => $config['sess_match_ip'],
    'save_path'         => $config['sess_save_path'],
    '_sid_regexp'       => '[0-9a-v]{32}',
);


$class = new CI_Session_files_driver($config);

if (is_php('5.4')) {
    session_set_save_handler($class, TRUE);
} else {
    session_set_save_handler(
        array($class, 'open'),
        array($class, 'close'),
        array($class, 'read'),
        array($class, 'write'),
        array($class, 'destroy'),
        array($class, 'gc')
    );
    register_shutdown_function('session_write_close');
}
session_name($config['cookie_name']);
session_start();
if ($_SESSION['userActive'] == null) {
	exit();
}
//


// load composer autoload before load elFinder autoload If you need composer
//require './vendor/autoload.php';

// elFinder autoload
require './php/autoload.php';
// ===============================================

// Enable FTP connector netmount
elFinder::$netDrivers['ftp'] = 'FTP';
// ===============================================

// // Required for Dropbox network mount
// // Installation by composer
// // `composer require kunalvarma05/dropbox-php-sdk`
// // Enable network mount
// elFinder::$netDrivers['dropbox2'] = 'Dropbox2';
// // Dropbox2 Netmount driver need next two settings. You can get at https://www.dropbox.com/developers/apps
// // AND reuire regist redirect url to "YOUR_CONNECTOR_URL?cmd=netmount&protocol=dropbox2&host=1"
// define('ELFINDER_DROPBOX_APPKEY',    '');
// define('ELFINDER_DROPBOX_APPSECRET', '');
// ===============================================

// // Required for Google Drive network mount
// // Installation by composer
// // `composer require google/apiclient:^2.0`
// // Enable network mount
// elFinder::$netDrivers['googledrive'] = 'GoogleDrive';
// // GoogleDrive Netmount driver need next two settings. You can get at https://console.developers.google.com
// // AND reuire regist redirect url to "YOUR_CONNECTOR_URL?cmd=netmount&protocol=googledrive&host=1"
// define('ELFINDER_GOOGLEDRIVE_CLIENTID',     '');
// define('ELFINDER_GOOGLEDRIVE_CLIENTSECRET', '');
// // Required case of without composer
// define('ELFINDER_GOOGLEDRIVE_GOOGLEAPICLIENT', '/path/to/google-api-php-client/vendor/autoload.php');
// ===============================================

// // Required for Google Drive network mount with Flysystem
// // Installation by composer
// // `composer require nao-pon/flysystem-google-drive:~1.1 nao-pon/elfinder-flysystem-driver-ext`
// // Enable network mount
// elFinder::$netDrivers['googledrive'] = 'FlysystemGoogleDriveNetmount';
// // GoogleDrive Netmount driver need next two settings. You can get at https://console.developers.google.com
// // AND reuire regist redirect url to "YOUR_CONNECTOR_URL?cmd=netmount&protocol=googledrive&host=1"
// define('ELFINDER_GOOGLEDRIVE_CLIENTID',     '');
// define('ELFINDER_GOOGLEDRIVE_CLIENTSECRET', '');
// ===============================================

// // Required for One Drive network mount
// //  * cURL PHP extension required
// //  * HTTP server PATH_INFO supports required
// // Enable network mount
// elFinder::$netDrivers['onedrive'] = 'OneDrive';
// // GoogleDrive Netmount driver need next two settings. You can get at https://dev.onedrive.com
// // AND reuire regist redirect url to "YOUR_CONNECTOR_URL/netmount/onedrive/1"
// define('ELFINDER_ONEDRIVE_CLIENTID',     '');
// define('ELFINDER_ONEDRIVE_CLIENTSECRET', '');
// ===============================================

// // Required for Box network mount
// //  * cURL PHP extension required
// // Enable network mount
// elFinder::$netDrivers['box'] = 'Box';
// // Box Netmount driver need next two settings. You can get at https://developer.box.com
// // AND reuire regist redirect url to "YOUR_CONNECTOR_URL"
// define('ELFINDER_BOX_CLIENTID',     '');
// define('ELFINDER_BOX_CLIENTSECRET', '');
// ===============================================

/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 * This method will disable accessing files/folders starting from '.' (dot)
 *
 * @param  string    $attr    attribute name (read|write|locked|hidden)
 * @param  string    $path    absolute file path
 * @param  string    $data    value of volume option `accessControlData`
 * @param  object    $volume  elFinder volume driver object
 * @param  bool|null $isDir   path is directory (true: directory, false: file, null: unknown)
 * @param  string    $relpath file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function access($attr, $path, $data, $volume, $isDir, $relpath) {
	$basename = basename($path);
	return $basename[0] === '.'                  // if file/folder begins with '.' (dot)
			 && strlen($relpath) !== 1           // but with out volume root
		? !($attr == 'read' || $attr == 'write') // set read+write to false, other (locked+hidden) set to true
		:  null;                                 // else elFinder decide it itself
}


// Documentation for connector options:
// https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options
$opts = array(
	// 'debug' => true,
	'roots' => array(
		// Items volume
		array(
			'driver'        => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
			'path'          => "../uploads/",                // path to files (REQUIRED)
			'URL'           => dirname($_SERVER['PHP_SELF']) . '/../uploads/', // URL to files (REQUIRED)
			'alias'     	=> 'Media',
			'winHashFix'    => DIRECTORY_SEPARATOR !== '/', // to make hash same to Linux one on windows too
			'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
			'uploadAllow'   => array('image', 'text/plain'),// Mimetype `image` and `text/plain` allowed to upload
			'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
			'accessControl' => 'access'                     // disable and hide dot starting files (OPTIONAL)
		)
	)
);

// run elFinder
$connector = new elFinderConnector(new elFinder($opts));
$connector->run();

