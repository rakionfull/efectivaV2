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

$routes->get('/', 'Home::index');
// rutas login

$routes->get('/login', 'Auth::index');
$routes->get('/inicio', 'Main::inicio');
$routes->get('/logout', 'Auth::logout');
$routes->get('/change_pass', 'Auth::change_pass');
$routes->post('/updatePass', 'Auth::updatePass');
$routes->get('auth/getNewCaptcha', 'Auth::getNewCaptcha');
$routes->post('auth/validaCaptcha', 'Auth::validaCaptcha');

// rutas panel principal
$routes->get('/listUsers', 'Main::listUsers');
$routes->get('/createUser', 'Main::createUser');
$routes->get('/modifyUser/(:num)', 'Main::modifyUser/$1');
$routes->get('/deleteUser/(:num)', 'Main::deleteUser/$1');
$routes->get('/configPass', 'Main::configPass');
$routes->post('/main/addUser', 'Main::addUser');
$routes->post('/updateUser/(:num)', 'Main::updateUser/$1');
$routes->get('perfiles', 'Main::perfiles');
$routes->get('main/getPerfiles', 'Main::getPerfiles');
$routes->get('main/getDetPerfil/(:num)', 'Main::getDetPerfil/$1');
$routes->post('/main/addPerfil', 'Main::addPerfil');
$routes->post('/main/updatePerfil', 'Main::updatePerfil');
$routes->post('/main/updateView', 'Main::updateView');
$routes->post('/main/updateCreate', 'Main::updateCreate');
$routes->post('/main/updateUpdate', 'Main::updateUpdate');
$routes->post('/main/updateDelete', 'Main::updateDelete');


// rutas para paremetrizacion
$routes->get('/activos', 'Main::activos');
$routes->get('/riesgos', 'Main::riesgos');
$routes->get('/controles', 'Main::controles');
$routes->get('main/getEmpresas', 'Main::getEmpresas');
$routes->post('/main/addEmpresa', 'Main::addEmpresa');
$routes->post('/main/updateEmpresa', 'Main::updateEmpresa');

$routes->get('main/getValorActivo', 'Main::getValorActivo');
$routes->post('/main/addValorActivo', 'Main::addValorActivo');
$routes->post('/main/updateValorActivo', 'Main::updateValorActivo');

$routes->get('main/getTipoActivo', 'Main::getTipoActivo');
$routes->post('/main/addTipoActivo', 'Main::addTipoActivo');
$routes->post('/main/updateTipoActivo', 'Main::updateTipoActivo');

$routes->get('main/getClasInformacion', 'Main::getClasInformacion');
$routes->post('/main/addClasInformacion', 'Main::addClasInformacion');
$routes->post('/main/updateClasInformacion', 'Main::updateClasInformacion');


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
