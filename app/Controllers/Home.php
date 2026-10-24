<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('dashboard/dashboard');
    }
    public function kategori(): string
    {
        return view('kategori/kategori');
    }
    public function barang(): string
    {
        return view('barang/index');
    }
    public function ruang(): string
    {
        return view('ruang/index');
    }
}
