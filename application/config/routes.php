<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'login/index';

$route['adminlogin'] = 'login/adminindex';

$route['student/dashboard'] = 'student/index';

$route['admin/dashboard'] = 'admin/index';
$route['admin/batch'] = 'admin/batchindex';
$route['batch/add'] = 'admin/batchadd';
$route['batch/edit/(:any)'] = 'admin/batchedit/$1';

$route['admin/department'] = 'admin/departmentindex';
$route['department/add'] = 'admin/departmentadd';
$route['department/edit/(:any)'] = 'admin/departmentedit/$1';


$route['auth/logout'] = 'login/logout';
$route['ajaxsearch/fetch'] = 'student/search';
$route['admin/ajaxsearch/fetch'] = 'admin/studentsearch';
$route['myprofile'] = 'student/profile';


$route['student/edit/(:any)'] = 'admin/studentedit/$1';
$route['student/add'] = 'admin/studentadd';


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
