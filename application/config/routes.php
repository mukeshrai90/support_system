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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'home/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = "home/login";
$route['profile/view'] = "home/admin_profile";
$route['dashboard'] = "home/index";
$route['auth/user/password/forgot'] = "welcome/forget_password";

$route['users/list'] = "home/users";
$route['users/view/(:any)'] = "home/user_view/$1";
$route['users/add'] = "user/register_user";
$route['users/edit/(:any)'] = "user/register_user/$1";

$route['emails/list'] = "home/email_templates";
$route['emails/edit/(:any)'] = "home/edit_email_templates/$1";

$route['admins/list'] = "admin/index";
$route['admins/add'] = "admin/manage_admin";
$route['admins/edit/(:any)'] = "admin/manage_admin/$1";
$route['admins/view/(:any)'] = "admin/admin_view/$1";
$route['admins/access/manage/(:any)'] = "admin/manage_access/$1";
$route['admins/access/update'] = "admin/access_update";

$route['afe-users/list'] = "admin/afe_users";
$route['afe-users/add'] = "admin/manage_afe";
$route['afe-users/edit/(:any)'] = "admin/manage_afe/$1";


