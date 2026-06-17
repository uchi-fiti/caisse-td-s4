<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('caisse/choix', 'HomeController::index');
$routes->post('caisse/choix', 'AchatController::index');
$routes->get('addToCart/(:num)/(:num)', 'AchatController::addToCart/$1/$2');
$routes->get('saisie', 'SaisieController::index');
$routes->get('saisie/confirmer', 'SaisieController::confirmer');
