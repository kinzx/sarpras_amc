<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ==========================================
// 1. RUTE PUBLIK (Bisa diakses tanpa login)
// ==========================================

// Halaman Login
$routes->get("/", "Home::index");

// Fitur Scan Barcode/QR oleh Guest
$routes->get("scan/(:segment)", 'Scan::detail/$1');

// ==========================================
// 2. RUTE YANG WAJIB LOGIN (Admin & Teknisi)
// ==========================================
$routes->group("", ["filter" => "login"], function ($routes) {
    // Dashboard
    $routes->get("dashboard", "Dashboard::index");

    // Ruang
    $routes->get("ruang", "Home::ruang");
    $routes->post("ruang/simpan", "Home::simpanRuang");
    $routes->post("ruang/update/(:num)", 'Home::updateRuang/$1');
    $routes->get("ruang/hapus/(:num)", 'Home::hapusRuang/$1');

    // Kategori
    $routes->get("kategori", "Kategori::index");
    $routes->post("kategori/simpan", "Kategori::simpan");
    $routes->post("kategori/update/(:num)", 'Kategori::update/$1');
    $routes->get("kategori/hapus/(:num)", 'Kategori::hapus/$1');
    $routes->get("kategori/sub/(:num)", 'Kategori::subKategori/$1');
    $routes->post("kategori/simpan-sub", "Kategori::simpanSub");

    // Barang (Inventaris)
    $routes->get("barang", "Barang::index");
    $routes->get("barang/tambah", "Barang::create");
    $routes->post("barang/simpan", "Barang::simpan");
    $routes->get("barang/edit/(:num)", 'Barang::edit/$1');
    $routes->post("barang/update/(:num)", 'Barang::update/$1');
    $routes->get("barang/hapus/(:num)", 'Barang::hapus/$1');
    $routes->get("barang/getSubKategori/(:num)", 'Barang::getSubKategori/$1');
    $routes->post("barang/getSubKategori", "Barang::getSubKategori");
    $routes->get("barang/detail/(:num)", 'Barang::detail/$1');
    $routes->get("barang/label/(:num)", 'Barang::labelAset/$1');
    $routes->get("barang/qrcode/(:segment)", 'Barang::qrcode/$1');
    $routes->get("barang/barcode/(:segment)", 'Barang::barcode/$1');

    // Laporan
    $routes->get("laporan", "Laporan::index");

    // Pemeliharaan (Maintenance)
    $routes->get("maintenance", "Maintenance::index");
    $routes->get("maintenance/create", "Maintenance::create");
    $routes->post("maintenance/simpan", "Maintenance::simpan");
    $routes->get("maintenance/hapus/(:num)", 'Maintenance::hapus/$1');

    // Perbaikan
    $routes->get("perbaikan", "Perbaikan::index");
    $routes->get("perbaikan/create", "Perbaikan::create");
    $routes->post("perbaikan/simpan", "Perbaikan::simpan");
    $routes->get("perbaikan/hapus/(:num)", 'Perbaikan::hapus/$1');

    // Kalibrasi
    $routes->get("kalibrasi", "Kalibrasi::index");
    $routes->post("kalibrasi/simpan", "Kalibrasi::simpan");
    $routes->get("kalibrasi/hapus/(:num)", 'Kalibrasi::hapus/$1');

    // Manajemen Pengguna & Role
    $routes->get("pengguna", "Pengguna::index");
    $routes->post("pengguna/simpan", "Pengguna::simpan");
    $routes->post("pengguna/update/(:num)", 'Pengguna::update/$1');
    $routes->get("pengguna/hapus/(:num)", 'Pengguna::hapus/$1');

    // --- Logout ---
    $routes->get("logout", "AuthController::logout");
});
