<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\SubKategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;
    protected $subKategoriModel;

    public function __construct()
    {
        $this->kategoriModel    = new KategoriModel();
        $this->subKategoriModel = new SubKategoriModel();
    }

    public function index()
    {
        // Mengambil semua data dari tabel sarpras_kategori
        $kategori = $this->kategoriModel->findAll();

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

    public function subKategori($kategori_id)
    {
        // 1. Ambil data kategori induk
        $kategoriInduk = $this->kategoriModel->find($kategori_id);

        if (!$kategoriInduk) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Kategori tidak ditemukan');
        }

        // 2. Ambil sub-kategori dari sarpras_sub_kategori
        $subKategori = $this->subKategoriModel->where('kategori_id', $kategori_id)->findAll();

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
            'nama_sub_kategori' => 'required|min_length[3]',
            'kategori_id'       => 'required|numeric',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $kategori_id       = $this->request->getPost('kategori_id');
        $nama_sub_kategori = $this->request->getPost('nama_sub_kategori');

        // Simpan ke database sarpras_sub_kategori
        $this->subKategoriModel->save([
            'kategori_id'       => $kategori_id,
            'nama_sub_kategori' => $nama_sub_kategori,
            'is_active'         => 1
        ]);

        // Catat Log
        catat_log('CREATE', 'Menambahkan sub-kategori: ' . $nama_sub_kategori);

        return redirect()->to('kategori/sub/' . $kategori_id)->with('success', 'Sub-Kategori berhasil ditambahkan!');
    }
}
