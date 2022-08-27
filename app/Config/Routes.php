<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
  require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function () {
  return view('errors/html/404');
});
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// Auth Controller
$routes->get('/auth', 'Auth::index', ['filter' => 'guest']);
$routes->post('/auth/login', 'Auth::doLogin', ['filter' => 'guest']);
$routes->get('auth/logout', 'Auth::doLogout', ['filter' => 'member']);

$routes->get('/auth/forgot', 'Auth::forgot');
$routes->post('/auth/forgot', 'Auth::doForgot');
$routes->get('/auth/question', 'Auth::question', ['filter' => 'reset']);
$routes->post('/auth/question', 'Auth::checkQuestion');
$routes->get('/auth/reset', 'Auth::reset', ['filter' => 'reset']);
$routes->post('/auth/reset', 'Auth::doReset');


// User Controller 
$routes->get('/user', 'User::index', ['filter' => 'member']);

$routes->get('/user/new', 'User::new');
$routes->post('/user/new', 'User::create');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
  require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
