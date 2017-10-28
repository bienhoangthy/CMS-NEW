<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = 'admin/errors/page404';
$route['non-permission'] = 'admin/errors/page401';
$route['translate_uri_dashes'] = FALSE;

#CMS
$route['admin/(:any)'] = 'admin/$1';
$route['admin'] = 'admin/index/login';

#Front
$route['(:any)-post(:num).html'] = "front/news/detail/$2";
$route['(:any)-cate(:num).html'] = "front/category/list/$2";
$route['(:any).html'] = "front/page/index/$1";