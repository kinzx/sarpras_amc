<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Halaman Utama (Login)
$routes->get('/', 'Home::index');

// Ruang
$routes->get('/ruang', 'Home::ruang');

// Kategori
$routes->get('/kategori', 'Kategori::index');
$routes->post('kategori/simpan', 'Kategori::simpan');
$routes->post('kategori/update/(:num)', 'Kategori::update/$1');
$routes->get('kategori/hapus/(:num)', 'Kategori::hapus/$1');
$routes->get('kategori/sub/(:num)', 'Kategori::subKategori/$1');
$routes->post('kategori/simpan-sub', 'Kategori::simpanSub');

// Barang (PERBAIKAN: Hanya daftarkan sekali)
$routes->get('barang', 'Barang::index');
$routes->get('barang/detail/(:num)', 'Barang::detail/$1');

// Dashboard (Wajib Login)
$routes->group('', ['filter' => 'login'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
});

// Logout
$routes->get('logout', 'AuthController::logout');
