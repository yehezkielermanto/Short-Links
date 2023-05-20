<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'UserController::index');
$routes->post('/generate', 'Home::Generate');
$routes->get('/:segment', 'Home::Redirect');

$routes->get('/link/testing', 'Home::index');

// user
$routes->post('/user/login/auth', 'UserController::auth');
$routes->get('/user/register', 'UserController::register');
$routes->post('/user/register/store', 'UserController::register_store');
$routes->get('/user/dashboard', 'UserController::dashboard');
$routes->post('/user/generate', 'UserController::generate');
$routes->get('/user/links/(:num)', 'UserController::getAllLinks/$1');
$routes->get('/user/logout', 'UserController::logout');
$routes->post('/user/change', 'UserController::changeUrl');
$routes->post('/user/delete', 'UserController::deleteUrl');

// send email to user
$routes->post('/user/email/', 'UserController::sendEmail');
$routes->get('/user/email/view', 'UserController::viewEmail');
$routes->get('/verif/(:segment)', 'UserController::verifEmail/$1');

$routes->get('/user/testing-email', 'UserController::viewTesting');
$routes->post('/user/kirim-email', 'UserController::testingEmail');

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
