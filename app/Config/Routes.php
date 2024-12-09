<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'PadiController::tampilkanAlternatif');

$routes->get('/padi', 'PadiController::index');
$routes->get('/alternatif', 'PadiController::tampilkanAlternatif');
$routes->get('/kriteria', 'PadiController::tampilkanKriteria');
$routes->get('/penilaian', 'PadiController::tampilkanPenilaian');
$routes->get('/padi/wp', 'PadiController::hitungWP');
$routes->get('/padi/topsis', 'PadiController::hitungTOPSIS');
