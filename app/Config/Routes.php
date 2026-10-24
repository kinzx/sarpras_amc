<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');

$routes->get('/ruang', 'Home::ruang');


$routes->get('/kategori', 'Kategori::index');
$routes->post('kategori/simpan', 'Kategori::simpan');
$routes->post('kategori/update/(:num)', 'Kategori::update/$1');
$routes->get('kategori/hapus/(:num)', 'Kategori::hapus/$1');

$routes->get('kategori/sub/(:num)', 'Kategori::subKategori/$1');
$routes->post('kategori/simpan-sub', 'Kategori::simpanSub');


$routes->get('/barang', 'Home::barang');
// $routes->get('', vars(''));