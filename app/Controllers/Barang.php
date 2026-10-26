<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Barang extends BaseController
{
    protected $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Daftar Aset Sarpras',
            'barang' => $this->barangModel->getBarangWithRelations(),
        ];

        return view('barang/index', $data);
    }

    public function detail($id = null)
    {
        $item = $this->barangModel->getBarangWithRelations($id);

        if (!$item) {
            throw PageNotFoundException::forPageNotFound('Barang tidak ditemukan: ' . $id);
        }

        $data = [
            'title'  => 'Detail Barang - ' . $item['nama_barang'],
            'item'   => $item,
        ];

        return view('barang/index', $data);
    }
}
