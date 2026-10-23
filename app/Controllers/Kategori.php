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
            'icon'          => $this->request->getPost('icon'),
            'is_active'     => 1
        ]);

        // CATAT LOG
        $nama_kategori = $this->request->getPost('nama_kategori');
        catat_log('CREATE', 'Menambahkan kategori baru: ' . $nama_kategori);
        return redirect()->to('/kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function hapus($id)
    {
        // Ambil data dulu untuk log
        $kategori = $this->kategoriModel->find($id);

        if ($kategori) {
            // Ubah status jadi tidak aktif (Soft Delete)
            $this->kategoriModel->update($id, ['is_active' => 0]);

            // Catat log
            catat_log('DELETE', 'Menonaktifkan kategori: ' . $kategori['nama_kategori']);
        }

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil dinonaktifkan!');
    }

    public function update($id)
    {
        $nama_kategori = $this->request->getPost('nama_kategori');

        $this->kategoriModel->update($id, [
            'nama_kategori' => $nama_kategori,
            'icon'          => $this->request->getPost('icon'),
        ]);

        // 🔥 CATAT LOG
        catat_log('EDIT', 'Mengubah data kategori menjadi: ' . $nama_kategori);

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil diubah!');
    }

    public function subKategori($parent_id)
    {
        // 1. Ambil data kategori induk
        $kategoriInduk = $this->kategoriModel->find($parent_id);

        if (!$kategoriInduk) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kategori tidak ditemukan');
        }

        // 2. Ambil sub-kategori (yang parent_id-nya sesuai)
        $subKategori = $this->kategoriModel->where('parent_id', $parent_id)->findAll();

        $data = [
            'title'         => 'Sub Kategori ' . $kategoriInduk['nama_kategori'],
            'kategoriInduk' => $kategoriInduk,
            'subKategori'   => $subKategori
        ];

        return view('kategori/sub_index', $data);
    }

    public function simpanSub()
    {
        // Validasi
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_kategori' => 'required|min_length[3]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $parent_id = $this->request->getPost('parent_id');
        $nama_kategori = $this->request->getPost('nama_kategori');

        // Simpan ke database
        $this->kategoriModel->save([
            'nama_kategori' => $nama_kategori,
            'parent_id'     => $parent_id,
            'icon'          => 'bx-list-ul', // Ikon default untuk sub
            'is_active'     => 1
        ]);

        // Catat Log
        catat_log('CREATE', 'Menambahkan sub-kategori: ' . $nama_kategori);

        return redirect()->to('kategori/sub/' . $parent_id)->with('success', 'Sub-Kategori berhasil ditambahkan!');
    }
}
