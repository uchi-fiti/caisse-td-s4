<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('caisse/choix', 'HomeController::index', ['filter' => 'auth']);
$routes->post('caisse/choix', 'AchatController::index');

$routes->get("auth/index", 'AuthController::index');
$routes->post("auth/login", 'AuthController::login');
$routes->get("auth/disconnect", 'AuthController::disconnect');

$routes->get("achat/saisie", 'SaisieController::index', ['filter' => 'caisse']);

$routes->get('addToCart/(:num)/(:num)', 'AchatController::addToCart/$1/$2');
$routes->get('saisie', 'SaisieController::index');
$routes->get('saisie/confirmer', 'SaisieController::confirmer');


