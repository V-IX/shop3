<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['catalog/set_view'] = 'catalog/set_view';
$route['catalog/index'] = 'catalog/index';
$route['catalog/index/(:num)'] = 'catalog/index/$3';
$route['catalog(/[a-z0-9-_/]+)?'] = 'catalog/view/$1';
//$route['catalog/(:any)'] = 'catalog/view/$2';
$route['catalog/(:any)/(:num)'] = 'catalog/view/$3';

$route['product/ajaxSend'] = 'product/ajaxSend';
$route['product/(:any)'] = 'product/index/$2';

$route['order/(:any)'] = 'order/index/$2';

$route['news/index'] = 'news/index';
$route['news/index/(:num)'] = 'news/index/$3';
$route['news/(:any)'] = 'news/view/$2';

$route['articles/index'] = 'articles/index';
$route['articles/index/(:num)'] = 'articles/index/$3';
$route['articles/(:any)'] = 'articles/view/$2';

$route['mfrs/index'] = 'mfrs/index';
$route['mfrs/index/(:num)'] = 'mfrs/index/$3';
$route['mfrs/(:any)'] = 'mfrs/view/$2';

$route['pages/(:any)'] = 'pages/index/$2';

/* 404 */

$__admin = false;
$uri = isset($_SERVER['REQUEST_URI']) ? explode('/', $_SERVER['REQUEST_URI']) : '';
if(array_key_exists(1, $uri) and $uri[1] == 'admin') $__admin = true;

$route['404_override'] = $__admin === false ? 'errors/index' : '';
