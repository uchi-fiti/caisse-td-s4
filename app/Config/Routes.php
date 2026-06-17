<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('caisse/choix', 'HomeController::index', ['filter' => 'auth']);
$routes->post('caisse/choix', 'AchatController::index');

$routes->get("auth/index", 'AuthController::index');
$routes->post("auth/login", 'AuthController::login');

$routes->get("achat/saisie", 'AchatController::saisie', ['filter' => 'caisse']);
