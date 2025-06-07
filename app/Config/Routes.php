<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//  home routes
$routes->get('/', 'Home::index', ['filter' => 'auth']);

// profile routes
$routes->group('profil', ['filter' => 'auth'], function ($routes) {
  $routes->get('', 'ProfilController::index');
  $routes->get('hapus/foto', 'ProfilController::hapusFoto');      // for foto_profil
  $routes->post('edit/info', 'ProfilController::editInfo');      // for username, email, bio
  $routes->post('edit/foto', 'ProfilController::editFoto');      // for foto_profil
  $routes->post('edit/password', 'ProfilController::editPassword'); // for password
});

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


// product routes
$routes->group('produk', function ($routes) {
  $routes->get('/', 'ProdukController::index');
  $routes->post('/', 'ProdukController::create');
  $routes->get('download', 'ProdukController::download');
  $routes->post('edit/(:num)', 'ProdukController::edit/$1');
  $routes->get('delete/(:num)', 'ProdukController::delete/$1');
});

// kategori routes
$routes->group('kategori', ['filter' => 'auth'], function ($routes) {
  $routes->get('', 'KategoriController::index');
  $routes->post('', 'KategoriController::create');
  $routes->post('edit/(:any)', 'KategoriController::edit/$1');
  $routes->get('delete/(:any)', 'KategoriController::delete/$1');
});


// faq routes
$routes->get('faq', 'faqController::index', ['filter' => 'auth']);
