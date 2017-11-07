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
$route['dashboard'] = "home/index";
$route['auth/user/password/forgot'] = "welcome/forget_password";

$route['profile/view'] = "admin/loggedAdmin_profile";

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
$route['afe-users/view/(:any)'] = "admin/afe_users_details/$1";

$route['leads/list'] = "user/list_leads";
$route['leads/view/(:any)'] = "user/view_lead/$1";
$route['leads/new-lead'] = "user/manage_lead";
$route['leads/edit/(:any)'] = "user/manage_lead/$1";
$route['leads/change/status'] = "user/change_lead_status";

$route['cms/circles/list'] = "cms/circles_list";
$route['cms/circles/add'] = "cms/manage_circles";
$route['cms/circles/edit/(:any)'] = "cms/manage_circles/$1";

$route['cms/ssa/list'] = "cms/ssa_list";
$route['cms/ssa/add'] = "cms/manage_ssa";
$route['cms/ssa/edit/(:any)'] = "cms/manage_ssa/$1";

$route['cms/plans/list'] = "cms/all_plans";
$route['cms/plans/add'] = "cms/manage_plans";
$route['cms/plans/edit/(:any)'] = "cms/manage_plans/$1";

$route['commissions/afe/list'] = "commission/afe_commissions";
$route['commissions/afe/view/leads'] = "commission/get_afe_leads";
$route['commissions/get/status'] = "commission/get_commissions_allowed_sts";
$route['commissions/change/status'] = "commission/changet_commissions_sts";

$route['incentives/fe/list'] = "incentive/fe_incentives";
$route['incentives/cbh/list'] = "incentive/cbh_incentives";
$route['incentives/cbh/view/leadsincentives/cbh/view/leads'] = "incentive/get_cbh_incentive_leads";
$route['incentives/view/leads'] = "incentive/get_incentive_leads";

$route['reports/leads'] = "report/get_leads_reports";
