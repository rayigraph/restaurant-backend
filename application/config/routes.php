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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['translate_uri_dashes'] = FALSE;

$route['logout'] = 'login/logout';
$route['sub_categories'] = 'Sub_Categories';
$route['sub_categories/add_new'] = 'Sub_Categories/add_new';
$route['sub_categories/add_new/(:num)'] = 'Sub_Categories/add_new/$1';
$route['sub_categories/edit_sub_category/(:num)'] = 'Sub_Categories/edit_sub_category/$1';
$route['sub_categories/(:num)'] = 'Sub_Categories/index/$1';
$route['sub_categories/delete_sub_category'] = 'Sub_Categories/delete_sub_category';
$route['sub_categories/update_sub_category_availability'] = 'Sub_Categories/update_sub_category_availability';

$route['categories'] = 'Categories';
$route['categories/add_new'] = 'Categories/add_new';
$route['categories/add_new/(:num)'] = 'Categories/add_new/$1';
$route['categories/edit_category/(:num)'] = 'Categories/edit_category/$1';
$route['categories/(:num)'] = 'Categories/index/$1';
$route['categories/delete_category'] = 'Categories/delete_category';
$route['categories/update_category_availability'] = 'Categories/update_category_availability';

$route['items/(:num)'] = 'Items/index/$1';
//API
$route['api/signup']['POST'] = 'api/users/signUp';
$route['api/login']['POST'] = 'api/users/login';
$route['api/verifyEmail']['POST'] = 'api/users/verifyEmail';
$route['api/orders']['POST'] = 'api/orders/createOrder';
$route['api/orders']['GET'] = 'api/orders/viewOrders';
$route['api/orders/(:num)']['GET'] = 'api/orders/orderDetails/$1';
$route['api/suppliers']['GET'] = 'api/SupplierController/list_suppliers';
$route['api/categories/(:num)']['GET'] = 'api/CategoryController/list_categories/$1';
$route['api/sub_categories/(:num)']['GET'] = 'api/SubCategoryController/list_sub_categories/$1';
$route['api/items/(:num)']['GET'] = 'api/ItemsController/list_items/$1';