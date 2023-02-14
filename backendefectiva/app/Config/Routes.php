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
// http://localhost:8080/login
$routes->post('/login', 'Login::index');
// http://localhost:8080/captcha
$routes->get('/newcaptcha', 'Login::newCaptcha');
// http://localhost:8080/captcha
$routes->post('/validaCaptcha', 'Login::validaCaptcha');
// http://localhost:8080/register
$routes->post('/register', 'Register::register', ['filter' => 'authFilter']);


// http://localhost:8080/api/
$routes->group('/api',['namespace' => 'App\Controllers'], function ($routes) {
    $routes->post('logout/(:num)', 'Login::logout/$1',['filter' => 'authFilter']);
    
    $routes->post('change_pass', 'Login::change_pass',['filter' => 'authFilter']);
    $routes->get('dashboard', 'Home::dashboard',['filter' => 'authFilter']);
    $routes->get('getConfigPass', 'Home::getConfigPass',['filter' => 'authFilter']);
    $routes->post('addConfigPass', 'Home::addConfigPass',['filter' => 'authFilter']);
    $routes->post('addUser', 'Home::addUser',['filter' => 'authFilter']);
    $routes->put('updateEstadoUser', 'Home::updateEstadoUser', ['filter' => 'authFilter']);
    $routes->put('updateUser/(:num)', 'Home::updateUser/$1', ['filter' => 'authFilter']);
    $routes->delete('deleteUser/(:num)', 'Home::deleteUser/$1', ['filter' => 'authFilter']);
    $routes->get('getUsers', 'Home::getUsers',['filter' => 'authFilter']);
    $routes->get('getUser/(:num)', 'Home::getUser/$1',['filter' => 'authFilter']);
    $routes->get('getPerfiles/', 'Home::getPerfiles',['filter' => 'authFilter']);
    $routes->post('addPerfil', 'Home::addPerfil',['filter' => 'authFilter']);
    $routes->post('validarPerfil', 'Home::validarPerfil',['filter' => 'authFilter']);
    $routes->post('updatePerfil', 'Home::updatePerfil',['filter' => 'authFilter']);
    $routes->delete('deletePerfil', 'Home::deletePerfil',['filter' => 'authFilter']);
    $routes->get('getDetPerfil', 'Home::getDetPerfil',['filter' => 'authFilter']);

    $routes->get('getModulos', 'Home::getModulos',['filter' => 'authFilter']);
    $routes->get('getOpcion', 'Home::getOpcion',['filter' => 'authFilter']);
    $routes->get('getItem', 'Home::getItem',['filter' => 'authFilter']);

    //reportes
    $routes->get('dataUser', 'Home::dataUser',['filter' => 'authFilter']);
   

    $routes->post('updateView', 'Home::updateView',['filter' => 'authFilter']);
    $routes->post('updateCreate', 'Home::updateCreate',['filter' => 'authFilter']);
    $routes->post('updateUpdate', 'Home::updateUpdate',['filter' => 'authFilter']);
    $routes->post('updateDelete', 'Home::updateDelete',['filter' => 'authFilter']);

    //crud de empresa
    $routes->get('getEmpresas', 'Activo::getEmpresas',['filter' => 'authFilter']);
    $routes->get('getEmpresasByActivo', 'Activo::getEmpresasByActivo',['filter' => 'authFilter']);
    $routes->post('addEmpresa', 'Activo::addEmpresa',['filter' => 'authFilter']);
    $routes->post('updateEmpresa', 'Activo::updateEmpresa',['filter' => 'authFilter']);
    $routes->delete('deleteEmpresa', 'Activo::deleteEmpresa',['filter' => 'authFilter']);
    //crud de area
    
    $routes->get('getArea', 'Activo::getArea',['filter' => 'authFilter']);
    $routes->post('addArea', 'Activo::addArea',['filter' => 'authFilter']);
    $routes->post('updateArea', 'Activo::updateArea',['filter' => 'authFilter']);
    $routes->get('getAreasByActivo', 'Activo::getAreasByActivo',['filter' => 'authFilter']);
    $routes->delete('deleteArea', 'Activo::deleteArea',['filter' => 'authFilter']);

    // $routes->get('getAreasEmpresa', 'Activo::getAreasEmpresa',['filter' => 'authFilter']);
    // $routes->post('addAreaEmpresa', 'Activo::addAreaEmpresa',['filter' => 'authFilter']);
    // $routes->post('updateAreaEmpresa', 'Activo::updateAreaEmpresa',['filter' => 'authFilter']);


    //CRUD Valor Activo
    $routes->post('validarValorActivo', 'Activo::validarValorActivo',['filter' => 'authFilter']);
    $routes->get('getValorActivoByActivo', 'Activo::getValorActivoByActivo',['filter' => 'authFilter']);
    $routes->get('getValorActivo', 'Activo::getValorActivo',['filter' => 'authFilter']);
    $routes->post('addValorActivo', 'Activo::addValorActivo',['filter' => 'authFilter']);
    $routes->post('updateValorActivo', 'Activo::updateValorActivo',['filter' => 'authFilter']);
    $routes->delete('deleteValorActivo', 'Activo::deleteValorActivo',['filter' => 'authFilter']);

    //CRUD Tipo Activo
    $routes->post('validarTipoActivo', 'Activo::validarTipoActivo',['filter' => 'authFilter']);
    $routes->get('getTipoActivoByActivo', 'Activo::getTipoActivoByActivo',['filter' => 'authFilter']);
    $routes->get('getTipoActivo', 'Activo::getTipoActivo',['filter' => 'authFilter']);
    $routes->post('addTipoActivo', 'Activo::addTipoActivo',['filter' => 'authFilter']);
    $routes->post('updateTipoActivo', 'Activo::updateTipoActivo',['filter' => 'authFilter']);
    $routes->delete('deleteTipoActivo', 'Activo::deleteTipoActivo',['filter' => 'authFilter']);

    //CRUD Clasificacion de informacion
    $routes->post('validarClasInfo', 'Activo::validarClasInfo',['filter' => 'authFilter']);
    $routes->get('getClasInformacion', 'Activo::getClasInformacion',['filter' => 'authFilter']);
    $routes->post('addClasInformacion', 'Activo::addClasInformacion',['filter' => 'authFilter']);
    $routes->post('updateClasInformacion', 'Activo::updateClasInformacion',['filter' => 'authFilter']);
    $routes->delete('deleteClasInfo', 'Activo::deleteClasInfo',['filter' => 'authFilter']);

    //CRUD Aspectos de Seguridad
    $routes->post('validarApectoSeg', 'Activo::validarApectoSeg',['filter' => 'authFilter']);
    $routes->get('getAspectoByActivo', 'Activo::getAspectoByActivo',['filter' => 'authFilter']);
    $routes->get('getAspectoSeg', 'Activo::getAspectoSeg',['filter' => 'authFilter']);
    $routes->post('addAspectoSeg', 'Activo::addAspectoSeg',['filter' => 'authFilter']);
    $routes->post('updateAspectoSeg', 'Activo::updateAspectoSeg',['filter' => 'authFilter']);
    $routes->delete('deleteAspectoSeg', 'Activo::deleteAspectoSeg',['filter' => 'authFilter']);

    //CRUD Unidades
    $routes->get('getUnidades', 'Activo::getUnidades',['filter' => 'authFilter']);
    $routes->get('getUnidadByActivo', 'Activo::getUnidadByActivo',['filter' => 'authFilter']);
    $routes->post('addUnidades', 'Activo::addUnidades',['filter' => 'authFilter']);
    $routes->post('updateUnidades', 'Activo::updateUnidades',['filter' => 'authFilter']);
    $routes->delete('deleteUnidad', 'Activo::deleteUnidad',['filter' => 'authFilter']);
    $routes->get('getEmpresaAreaUnidades', 'Activo::getEmpresaAreaUnidades',['filter' => 'authFilter']);
    

    //CRUD Macroprocesos
    $routes->get('getMacroproceso', 'Activo::getMacroproceso',['filter' => 'authFilter']);
    $routes->post('addMacroproceso', 'Activo::addMacroproceso',['filter' => 'authFilter']);
    $routes->post('updateMacroproceso', 'Activo::updateMacroproceso',['filter' => 'authFilter']);
    $routes->get('getMacroprocesoByActivo', 'Activo::getMacroprocesoByActivo',['filter' => 'authFilter']);
    $routes->delete('deleteMacroproceso', 'Activo::deleteMacroproceso',['filter' => 'authFilter']);

    //CRUD Procesos
    $routes->get('getProceso', 'Activo::getProceso',['filter' => 'authFilter']);
    $routes->post('addProceso', 'Activo::addProceso',['filter' => 'authFilter']);
    $routes->post('updateProceso', 'Activo::updateProceso',['filter' => 'authFilter']);
    $routes->get('getProcesoByActivo', 'Activo::getProcesoByActivo',['filter' => 'authFilter']);
    $routes->delete('deleteProceso', 'Activo::deleteProceso',['filter' => 'authFilter']);


    //CRUD Posicion/Puesto
    $routes->post('validarPosicion', 'Activo::validarPosicion',['filter' => 'authFilter']);
    $routes->get('getPosicionByActivo', 'Activo::getPosicionByActivo',['filter' => 'authFilter']);
    $routes->get('getPosicion', 'Activo::getPosicion',['filter' => 'authFilter']);
    $routes->post('addPosicion', 'Activo::addPosicion',['filter' => 'authFilter']);
    $routes->post('updatePosicion', 'Activo::updatePosicion',['filter' => 'authFilter']);
    $routes->delete('deletePosicion', 'Activo::deletePosicion',['filter' => 'authFilter']);

    //CRUD Valoracion de activo
    $routes->post('validarValActivo', 'Activo::validarValActivo',['filter' => 'authFilter']);
    $routes->get('getValActivo', 'Activo::getValActivo',['filter' => 'authFilter']);
    $routes->post('addValActivo', 'Activo::addValActivo',['filter' => 'authFilter']);
    $routes->post('updateValActivo', 'Activo::updateValActivo',['filter' => 'authFilter']);
    $routes->delete('deleteValActivo', 'Activo::deleteValActivo',['filter' => 'authFilter']);

    //CRUD Categoria de activo
    $routes->post('validarCatActivo', 'Activo::validarCatActivo',['filter' => 'authFilter']);
    $routes->get('getCatActivo', 'Activo::getCatActivo',['filter' => 'authFilter']);
    $routes->post('addCatActivo', 'Activo::addCatActivo',['filter' => 'authFilter']);
    $routes->post('updateCatActivo', 'Activo::updateCatActivo',['filter' => 'authFilter']);
    $routes->delete('deleteCatActivo', 'Activo::deleteCatActivo',['filter' => 'authFilter']);

      //CRUD Ubicacion de activo
    $routes->post('validarUbiActivo', 'Activo::validarUbiActivo',['filter' => 'authFilter']);
    $routes->get('getUbiActivo', 'Activo::getUbiActivo',['filter' => 'authFilter']);
    $routes->post('addUbiActivo', 'Activo::addUbiActivo',['filter' => 'authFilter']);
    $routes->post('updateUbiActivo', 'Activo::updateUbiActivo',['filter' => 'authFilter']);
    $routes->delete('deleteUbiActivo', 'Activo::deleteUbiActivo',['filter' => 'authFilter']);

    //CONTINENTE
    $routes->get('getContinente', 'Activo::getContinente',['filter' => 'authFilter']);
    $routes->get('getPais', 'Activo::getPais',['filter' => 'authFilter']);
    $routes->get('getCiudad', 'Activo::getCiudad',['filter' => 'authFilter']);


    // CRUD TIPO RIESGOS
    $routes->get('getTipoRiesgos', 'TipoRiesgosController::index',['filter' => 'authFilter']);
    $routes->get('showTipoRiesgo/(:num)','TipoRiesgosController::show/$1',['filter' => 'authFilter']);
    $routes->post('addTipoRiesgo', 'TipoRiesgosController::store',['filter' => 'authFilter']);
    $routes->post('updateTipoRiesgo', 'TipoRiesgosController::update',['filter' => 'authFilter']);
    $routes->delete('deleteTipoRiesgo/(:num)', 'TipoRiesgosController::destroy/$1', ['filter' => 'authFilter']);

    // CRUD PROBABILIDAD RIESGOS
    $routes->get('getProbabilidadRiesgo/(:num)','ProbabilidadRiesgoController::index/$1',['filter' => 'authFilter']);
    $routes->get('showProbabilidadRiesgo/(:num)','ProbabilidadRiesgoController::show/$1',['filter' => 'authFilter']);
    $routes->post('addProbabilidadRiesgo1','ProbabilidadRiesgoController::store_escenario_1',['filter' => 'authFilter']);
    $routes->post('addProbabilidadRiesgo2','ProbabilidadRiesgoController::store_escenario_2',['filter' => 'authFilter']);
    $routes->post('updateProbabilidadRiesgo1','ProbabilidadRiesgoController::edit_escenario_1',['filter' => 'authFilter']);
    $routes->post('updateProbabilidadRiesgo2','ProbabilidadRiesgoController::edit_escenario_2',['filter' => 'authFilter']);
    $routes->delete('deleteProbabilidadRiesgo/(:num)', 'ProbabilidadRiesgoController::destroy/$1', ['filter' => 'authFilter']);

    // CRUD IMPACTO RIESGOS
    $routes->get('getImpactoRiesgo/(:num)','ImpactoRiesgoController::index/$1',['filter' => 'authFilter']);
    $routes->get('showImpactoRiesgo/(:num)','ImpactoRiesgoController::show/$1',['filter' => 'authFilter']);
    $routes->post('addImpactoRiesgo1','ImpactoRiesgoController::store_escenario_1',['filter' => 'authFilter']);
    $routes->post('addImpactoRiesgo2','ImpactoRiesgoController::store_escenario_2',['filter' => 'authFilter']);
    $routes->post('updateImpactoRiesgo1','ImpactoRiesgoController::edit_escenario_1',['filter' => 'authFilter']);
    $routes->post('updateImpactoRiesgo2','ImpactoRiesgoController::edit_escenario_2',['filter' => 'authFilter']);
    $routes->delete('deleteImpactoRiesgo/(:num)', 'ImpactoRiesgoController::destroy/$1', ['filter' => 'authFilter']);

    // CRUD NIVEL RIESGO
    $routes->get('getNivelRiesgo','NivelRiesgoController::index',['filter' => 'authFilter']);
    $routes->get('showNivelRiesgo/(:num)','NivelRiesgoController::show/$1',['filter' => 'authFilter']);
    $routes->post('addNivelRiesgo','NivelRiesgoController::store',['filter' => 'authFilter']);
    $routes->post('updateNivelRiesgo/(:num)','NivelRiesgoController::update/$1',['filter' => 'authFilter']);
    $routes->delete('deleteNivelRiesgo/(:num)', 'NivelRiesgoController::destroy/$1', ['filter' => 'authFilter']);

    // CRUD TIPO DE AMENAZA
    $routes->get('getTiposAmenaza','TipoAmenazaController::index',['filter' => 'authFilter']);
    $routes->get('showTipoAmenaza/(:num)','TipoAmenazaController::show/$1',['filter' => 'authFilter']);
    $routes->post('addTipoAmenaza','TipoAmenazaController::store',['filter' => 'authFilter']);
    $routes->post('updateTipoAmenaza/(:num)','TipoAmenazaController::update/$1',['filter' => 'authFilter']);
    $routes->delete('deleteTipoAmenaza/(:num)', 'TipoAmenazaController::destroy/$1', ['filter' => 'authFilter']);
    
    // CRUD DESC DE AMENAZA
    $routes->get('getDescAmenaza','DescripcionAmenazaController::index',['filter' => 'authFilter']);
    $routes->get('showDescAmenaza/(:num)','DescripcionAmenazaController::show/$1',['filter' => 'authFilter']);
    $routes->post('addDescAmenaza','DescripcionAmenazaController::store',['filter' => 'authFilter']);
    $routes->post('updateDescAmenaza/(:num)','DescripcionAmenazaController::update/$1',['filter' => 'authFilter']);
    $routes->delete('deleteDescAmenaza/(:num)', 'DescripcionAmenazaController::destroy/$1', ['filter' => 'authFilter']);
    
    // CRUD CATEGORIAS VULNERABILIDAD
    $routes->get('getCategoriasVulnerabilidad','CategoriasVulnerabilidadController::index',['filter' => 'authFilter']);
    $routes->get('showCategoriasVulnerabilidad/(:num)','CategoriasVulnerabilidadController::show/$1',['filter' => 'authFilter']);
    $routes->post('addCategoriasVulnerabilidad','CategoriasVulnerabilidadController::store',['filter' => 'authFilter']);
    $routes->post('updateCategoriasVulnerabilidad/(:num)','CategoriasVulnerabilidadController::update/$1',['filter' => 'authFilter']);
    $routes->delete('deleteCategoriasVulnerabilidad/(:num)', 'CategoriasVulnerabilidadController::destroy/$1', ['filter' => 'authFilter']);
    
    // CRUD DESC VULNERABILIDAD
    $routes->get('getDescVulnerabilidad','DescripcionVulnerabilidadController::index',['filter' => 'authFilter']);
    $routes->get('showDescVulnerabilidad/(:num)','DescripcionVulnerabilidadController::show/$1',['filter' => 'authFilter']);
    $routes->post('addDescVulnerabilidad','DescripcionVulnerabilidadController::store',['filter' => 'authFilter']);
    $routes->post('updateDescVulnerabilidad/(:num)','DescripcionVulnerabilidadController::update/$1',['filter' => 'authFilter']);
    $routes->delete('deleteDescVulnerabilidad/(:num)', 'DescripcionVulnerabilidadController::destroy/$1', ['filter' => 'authFilter']);
});

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