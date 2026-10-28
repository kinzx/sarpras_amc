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
        $kategori_id = $this->request->getPost('kategori_id');
        $rawNames    = $this->request->getPost('nama_sub_kategori');
        $names       = is_array($rawNames) ? $rawNames : [$rawNames];
        $names       = array_values(array_filter(array_map(
            static fn ($name) => trim((string) $name),
            $names
        ), static fn ($name) => $name !== ''));

        $errors = [];

        if (!is_numeric($kategori_id) || !$this->kategoriModel->find($kategori_id)) {
            $errors['kategori_id'] = 'Kategori induk tidak valid.';
        }

        if ($names === []) {
            $errors['nama_sub_kategori'] = 'Isi minimal satu nama sub-kategori.';
        }

        foreach ($names as $index => $name) {
            if (mb_strlen($name) < 3) {
                $errors['nama_sub_kategori.' . $index] = 'Nama sub-kategori minimal 3 karakter: ' . $name;
            } elseif (mb_strlen($name) > 100) {
                $errors['nama_sub_kategori.' . $index] = 'Nama sub-kategori maksimal 100 karakter.';
            }
        }

        if ($errors !== []) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $rows = array_map(static fn ($name) => [
            'kategori_id'       => $kategori_id,
            'nama_sub_kategori' => $name,
            'is_active'         => 1,
        ], $names);

        if ($this->subKategoriModel->insertBatch($rows) === false) {
            return redirect()->back()->withInput()->with('errors', [
                'database' => 'Sub-kategori gagal disimpan. Periksa kembali data dan coba lagi.',
            ]);
        }

        catat_log('CREATE', 'Menambahkan ' . count($names) . ' sub-kategori untuk kategori ID ' . $kategori_id);

        return redirect()->to('kategori/sub/' . $kategori_id)->with(
            'success',
            count($names) . ' sub-kategori berhasil ditambahkan!'
        );
    }
}
