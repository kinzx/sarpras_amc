<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        // Mengambil semua data dari tabel sarpras_kategori yang parent_id-nya NULL (Kategori Utama)
        $kategori = $this->kategoriModel->where('parent_id', null)->findAll();

        $data = [
            'title'    => 'Data Master Kategori',
            'kategori' => $kategori
        ];

        return view('kategori/index', $data);
    }

    public function simpan()
    {
        // Validasi
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_kategori' => 'required|min_length[3]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Simpan data
        $this->kategoriModel->save([
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'parent_id'     => $this->request->getPost('parent_id') ?: null,
            'is_active'     => 1
        ]);

        return redirect()->to('kategori/kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }
}
