<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/abstracs/(:num)/reviews/', 'Reviews::index');
$routes->get('/abstracs/(:num)/reviews/create', 'Reviews::create');
$routes->post('/abstracs/(:num)/reviews/store', 'Reviews::store');
$routes->get('/abstracs/(:num)/reviews/edit/(:num)', 'Reviews::edit/$2');
$routes->post('/abstracs/(:num)/reviews/update/(:num)', 'Reviews::update/$2');
$routes->get('/abstracs/(:num)/reviews/delete/(:num)', 'Reviews::delete/$2');
$routes->get('/abstracs/(:num)/reviews/restore/(:num)', 'Reviews::restore/$2');

$routes->setAutoRoute(true);
