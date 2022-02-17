<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Access::login');

//Dashboard Routes
// $routes->match(['get','post','put','delete'], '/', 'Dashboard::index', ['filter' => 'auth']);
// $routes->match(['get','post','put','delete'], 'dashboard', 'Dashboard::index', ['filter' => 'auth']);

// //Admin Routes
// $routes->match(['get','post','put','delete'], 'admin', 'Admin::index', ['filter' => 'auth']);
// $routes->match(['get','post','put','delete'], 'admin/add', 'Admin::add', ['filter' => 'auth']);
// $routes->match(['get','post','put','delete'], 'admin/detail/(:num)', 'Admin::detail/$1', ['filter' => 'auth']);
// $routes->match(['get','post','put','delete'], 'admin/edit/(:num)', 'Admin::edit/$1', ['filter' => 'auth']);
// $routes->match(['get','post','put','delete'], 'admin/delete/(:num)', 'Admin::delete/$1', ['filter' => 'auth']);

// //User Routes
// $routes->match(['get','post','put','delete'], 'user', 'User::index', ['filter' => 'auth']);
// $routes->match(['get','post','put','delete'], 'user/add', 'User::add', ['filter' => 'auth']);
// $routes->match(['get','post','put','delete'], 'user/detail/(:num)', 'User::detail/$1', ['filter' => 'auth']);
// $routes->match(['get','post','put','delete'], 'user/edit/(:num)', 'User::edit/$1', ['filter' => 'auth']);
// $routes->match(['get','post','put','delete'], 'user/delete/(:num)', 'User::delete/$1', ['filter' => 'auth']);

// //Product Routes
// $routes->match(['get','post','put','delete'], 'product', 'Product::index', ['filter' => 'auth']);
// $routes->match(['get','post','put','delete'], 'product/add', 'Product::add', ['filter' => 'auth']);
// $routes->match(['get','post','put','delete'], 'product/detail/(:num)', 'Product::detail/$1', ['filter' => 'auth']);
// $routes->match(['get','post','put','delete'], 'product/edit/(:num)', 'Product::edit/$1', ['filter' => 'auth']);
// $routes->match(['get','post','put','delete'], 'product/delete/(:num)', 'Product::delete/$1', ['filter' => 'auth']);

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
