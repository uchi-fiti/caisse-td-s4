<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('caisse/choix', 'HomeController::index');
$routes->post('caisse/choix', 'AchatController::index');
