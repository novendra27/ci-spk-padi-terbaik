<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/padi', 'PadiController::index');
$routes->get('/padi/hitung', 'PadiController::hitungWP');
