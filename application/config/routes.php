<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/

$config['route']['GUEST'] = [
    'init' => 'welcome/index',
    'staff/list' => 'staff/lists/index',
    'api/generate' => 'api/key/index',
    'staff/login' => 'staff/login/index',
    'outlet/login' => 'outlet/login/index',
];

$config['route']['OUTLET'] = [
    'staff/detail' => 'staff/detail/index',
    'building/detail' => 'building/detail/index',
    'building/update' => 'staff/update/index',
    'issue/outlet/insert' => 'issue/insert/index',
    'issue/outlet/update' => 'issue/update/update',
    'issue/outlet/detail' => 'issue/detail/index',
    'issue/outlet/history' => 'issue/outletreport/history',
    'issue/outlet/pending' => 'issue/outletreport/pending',
];

$config['route']['ENGINEER'] = [
    'staff/update' => 'staff/update/index',
    'issue/engineer/pending' => 'issue/staffreport/pending',
    'issue/engineer/history' => 'issue/staffreport/history',
    'issue/engineer/done' => 'issue/done/index',
];

$config['route']['ADMINISTRATOR'] = [
    'staff/register' => 'staff/register/index',
//    'staff/list' => 'staff/lists/index',
    'staff/available' => 'staff/lists/available',
    'building/insert' => 'building/insert/index',
    'building/list' => 'building/lists/index',
    'issue/administrator/queue' => 'issue/administratorreport/queue',
    'issue/administrator/pending' => 'issue/administratorreport/pending',
    'issue/administrator/process' => 'issue/administratorreport/history',
    'issue/administrator/select-staff' => 'issue/update/staff',
];

$route = array_merge(
    $config['route']['GUEST'],
    $config['route']['OUTLET'],
    $config['route']['ENGINEER'],
    $config['route']['ADMINISTRATOR']
);