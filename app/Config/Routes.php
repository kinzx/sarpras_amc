<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');

$routes->get('/barang', 'Home::barang');
$routes->get('/ruang', 'Home::ruang');


$routes->get('/kategori', 'Kategori::index');
$routes->post('kategori/simpan', 'Kategori::simpan');