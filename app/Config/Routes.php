<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//  home routes
$routes->get('/', 'Home::index', ['filter' => 'auth']);

// login and logout routes
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login', ['filer'  => 'redirect']);
$routes->get('logout', 'AuthController::logout');

// cart routes
$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
  $routes->get('', 'TransaksiController::index');
  $routes->post('', 'TransaksiController::cart_add');
  $routes->post('edit', 'TransaksiController::cart_edit');
  $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
  $routes->get('clear', 'TransaksiController::cart_clear');
});

// checkout routes in v_keranjang.php
$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);

// profil routes
$routes->get('profile', 'Home::profile', ['filter' => 'auth']);

// product routes
$routes->group('produk', function ($routes) {
  $routes->get('/', 'ProdukController::index');
  $routes->post('/', 'ProdukController::create');
  $routes->get('download', 'ProdukController::download');
  $routes->post('edit/(:num)', 'ProdukController::edit/$1');
  $routes->get('delete/(:num)', 'ProdukController::delete/$1');
});

// diskon routes
$routes->group('diskon', ['filter' => 'auth'], function ($routes) {
  $routes->get('', 'DiskonController::index');
  $routes->post('', 'DiskonController::create');
  $routes->post('edit/(:any)', 'DiskonController::edit/$1');
  $routes->get('delete/(:any)', 'DiskonController::delete/$1');
});

// kategori routes
$routes->group('kategori', ['filter' => 'auth'], function ($routes) {
  $routes->get('', 'KategoriController::index');
  $routes->post('', 'KategoriController::create');
  $routes->post('edit/(:any)', 'KategoriController::edit/$1');
  $routes->get('delete/(:any)', 'KategoriController::delete/$1');
});

// rajaongkir api routes
$routes->get('get-location', 'TransaksiController::getLocation', ['filter' => 'auth']);
$routes->get('get-cost', 'TransaksiController::getCost', ['filter' => 'auth']);

// faq routes
$routes->get('faq', 'faqController::index', ['filter' => 'auth']);

// Api routes
$routes->resource('api', ['controller' => 'apiController']);