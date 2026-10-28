<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\RuangModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Scan extends BaseController
{
    protected $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function detail($kodeAset = null)
    {
        if (empty($kodeAset)) {
            throw PageNotFoundException::forPageNotFound('Kode aset tidak disertakan.');
        }

        $barang = $this->barangModel->getBarangForGuest($kodeAset);

        if (!$barang) {
            throw PageNotFoundException::forPageNotFound('Barang dengan kode aset ' . esc($kodeAset) . ' tidak ditemukan.');
        }

        $data = [
            'title'  => 'Detail Barang - ' . $barang['nama_barang'],
            'barang' => $barang,
        ];

        return view('scan/detail', $data);
    }
}
