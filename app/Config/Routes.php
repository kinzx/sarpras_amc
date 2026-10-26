<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ==========================================
// 1. RUTE PUBLIK (Bisa diakses tanpa login)
// ==========================================

// Halaman Login
$routes->get('/', 'Home::index');

// Fitur Scan Barcode/QR oleh Guest
$routes->get('scan/(:segment)', 'Scan::detail/$1');


// ==========================================
// 2. RUTE YANG WAJIB LOGIN (Admin & Teknisi)
// ==========================================
$routes->group('', ['filter' => 'login'], function ($routes) {

    // --- Dashboard ---
    $routes->get('dashboard', 'Dashboard::index');

    // --- Ruang ---
    $routes->get('ruang', 'Home::ruang');

    // --- Kategori ---
    $routes->get('kategori', 'Kategori::index');
    $routes->post('kategori/simpan', 'Kategori::simpan');
    $routes->post('kategori/update/(:num)', 'Kategori::update/$1');
    $routes->get('kategori/hapus/(:num)', 'Kategori::hapus/$1');
    $routes->get('kategori/sub/(:num)', 'Kategori::subKategori/$1');
    $routes->post('kategori/simpan-sub', 'Kategori::simpanSub');

    // --- Barang (Inventaris) ---
    $routes->get('barang', 'Barang::index');
    $routes->get('barang/tambah', 'Barang::create');
    $routes->post('barang/simpan', 'Barang::simpan');
    $routes->post('barang/getSubKategori', 'Barang::getSubKategori');
    $routes->get('barang/detail/(:num)', 'Barang::detail/$1');
    $routes->get('barang/barcode/(:segment)', 'Barang::barcode/$1'); // Route untuk generate gambar barcode

    // --- Logout ---
    $routes->get('logout', 'AuthController::logout');
});
