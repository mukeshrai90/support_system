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

$route['employees/list'] = "home/users";
$route['employees/view/(:any)'] = "home/user_view/$1";
$route['employees/edit/(:any)'] = "admin/register_user/$1";

$route['emails/list'] = "home/email_templates";
$route['emails/edit/(:any)'] = "home/edit_email_templates/$1";

$route['tickets/list'] = "home/tickets";
$route['tickets/list/(:any)'] = "home/tickets/$1";
$route['tickets/add'] = "home/manage_tickets";
$route['tickets/add/invoices'] = "auth/upload_ticket_invoice";
$route['tickets/add/invoices/(:any)'] = "auth/upload_ticket_invoice/$1";
$route['tickets/edit/(:any)'] = "home/manage_tickets/$1";
$route['tickets/view/(:any)'] = "auth/view_ticket_details/$1";
$route['tickets/change/status'] = "auth/change_ticket_status";
$route['tickets/change/close'] = "auth/close_ticket";
$route['tickets/print/(:any)'] = "home/genetare_ticket_pdf/$1";

$route['categories/list'] = "home/categories";
$route['categories/add'] = "home/manage_categories";
$route['categories/edit/(:any)'] = "home/manage_categories/$1";

$route['request-types/list'] = "home/request_types";
$route['request-types/add'] = "home/manage_request_types";
$route['request-types/edit/(:any)'] = "home/manage_request_types/$1";

$route['machine-types/list'] = "home/machine_types";
$route['machine-types/add'] = "home/manage_machine_types";
$route['machine-types/edit/(:any)'] = "home/manage_machine_types/$1";

$route['machine-parts/list'] = "home/machine_parts";
$route['machine-parts/add'] = "home/manage_machine_parts";
$route['machine-parts/edit/(:any)'] = "home/manage_machine_parts/$1";

$route['csv-user_registration'] = "admin/index";
$route['users/upload'] = "admin/upload_users";
$route['users/register'] = "admin/register_user";
$route['general-settings'] = "home/site_settings";

$route['surrender-devices'] = "home/surrender_devices";
$route['surrender-fnf'] = "home/surrender_fnf";
$route['surrender-devices-logs/list'] = "home/surrender_device_logs";

$route['ticket-reports/list'] = "admin/ticket_reports";
$route['ticket-reports/list/(:any)'] = "admin/ticket_reports/$1";
$route['ticket-reports/view/(:any)'] = "auth/view_ticket_details/$1";

$route['expense-reports/list'] = "admin/expense_reports";
$route['expense-reports/list/(:any)'] = "admin/expense_reports/$1";
$route['expense-reports/view/(:any)'] = "admin/expense_report_details/$1";

$route['csv-devices-upload'] = "admin/upload_devices";
$route['devices-inventory/list'] = "admin/devices";
$route['devices-inventory/list/(:any)'] = "admin/devices/$1";
$route['devices-inventory/add'] = "admin/register_devices";
$route['devices-inventory/edit/(:any)'] = "admin/register_devices/$1";
$route['device-details/view/(:any)'] = "admin/device_details/$1";

$route['assign-devices'] = "admin/assign_devices_to_user";

$route['admin/list'] = "subadmin/index";
$route['admin/add'] = "subadmin/manage_admin";
$route['admin/edit/(:any)'] = "subadmin/manage_admin/$1";
$route['admin/view/(:any)'] = "subadmin/admin_view/$1";
$route['admin/access/manage/(:any)'] = "subadmin/manage_access/$1";
$route['admin/access/update'] = "subadmin/access_update";
