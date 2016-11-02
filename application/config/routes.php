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
    'init' => 'Welcome/index',
    'api/generate' => 'api/Key/index',
    'staff/login' => 'staff/Login/index',
    'outlet/login' => 'outlet/Login/index',
];

$config['route']['OUTLET'] = [
    'outlet/update' => 'outlet/Update/index',
    'outlet/update-password' => 'outlet/UpdatePassword/index',
    'outlet/detail' => 'outlet/Detail/index',
    'building/detail' => 'building/Detail/index',
    'building/update' => 'staff/Update/index',
    'issue/outlet/insert' => 'issue/Insert/index',
    'issue/outlet/update' => 'issue/Update/index',
    'issue/outlet/detail' => 'issue/Detail/index',
    'issue/outlet/all' => 'issue/OutletReport/all',
    'issue/outlet/open' => 'issue/OutletReport/open',
    'issue/outlet/pending' => 'issue/OutletReport/pending',
    'issue/outlet/progress' => 'issue/OutletReport/progress',
    'issue/outlet/history' => 'issue/OutletReport/history',
    'notification/outlet/all' => 'notification/Outlet/all',
    'notification/outlet/pending' => 'notification/Outlet/pending',
    'notification/outlet/checkin' => 'notification/Outlet/checkin',
    'notification/outlet/checkout' => 'notification/Outlet/checkout',
    'notification/read/outlet' => 'notification/Read/outlet',
];

$config['route']['ENGINEER'] = [
    'staff/detail' => 'staff/Detail/index',
    'staff/update' => 'staff/Update/index',
    'staff/update-password' => 'staff/UpdatePassword/index',
    'issue/engineer/pending' => 'issue/StaffReport/pending',
    'issue/engineer/history' => 'issue/StaffReport/history',
    'issue/engineer/progress' => 'issue/Progress/index',
    'issue/engineer/done' => 'issue/Done/index',
    'notification/staff/pending' => 'notification/Staff/pending',
    'notification/read/staff' => 'notification/Read/staff',
];

$config['route']['ADMINISTRATOR'] = [
    'staff/register' => 'staff/Register/index',
    'staff/delete' => 'staff/Delete/index',
    'staff/list' => 'staff/Lists/index',
    'staff/available' => 'staff/lists/available',
    'staff/transaction/report' => 'issue/StaffReport/transaction',
    'outlet/insert' => 'outlet/Insert/index',
    'outlet/list' => 'outlet/Lists/index',
    'outlet/transaction/report' => 'issue/OutletReport/transaction',
    'outlet/delete' => 'outlet/Delete/index',
    'building/insert' => 'building/Insert/index',
    'building/list' => 'building/Lists/index',
    'issue/administrator/all' => 'issue/AdministratorReport/all',
    'issue/administrator/queue' => 'issue/AdministratorReport/queue',
    'issue/administrator/pending' => 'issue/AdministratorReport/pending',
    'issue/administrator/progress' => 'issue/AdministratorReport/progress',
    'issue/administrator/process' => 'issue/AdministratorReport/history',
    'issue/transaction/report' => 'issue/AdministratorReport/transaction',
    'issue/administrator/select-staff' => 'issue/Update/staff',
    'notification/administrator/all' => 'notification/Administrator/all',
    'notification/administrator/pending' => 'notification/Administrator/pending',
    'notification/administrator/checkin' => 'notification/Administrator/checkin',
    'notification/administrator/checkout' => 'notification/Administrator/checkout',
    'notification/read/administrator' => 'notification/Read/administrator',
    'issue/administrator/recurrence/weekly' => 'issue/insert/recurrenceWeekly',
    'issue/administrator/recurrence/monthly' => 'issue/insert/recurrenceMonthly'
];

$route = array_merge(
    $config['route']['GUEST'],
    $config['route']['OUTLET'],
    $config['route']['ENGINEER'],
    $config['route']['ADMINISTRATOR']
);