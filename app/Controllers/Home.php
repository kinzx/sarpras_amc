<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return redirect()->to('/dashboard');
    }
    public function kategori(): string
    {
        return view('kategori/kategori');
    }
    public function barang(): string
    {
        return view('barang/index');
    }
    // 1. Menampilkan Halaman & Tabel Ruangan
    public function ruang()
    {
        $db = \Config\Database::connect();

        // Ambil semua data ruangan (termasuk yang non-aktif agar bisa diaktifkan lagi)
        $data = [
            'title' => 'Data Master Ruangan',
            'ruang' => $db->table('sarpras_ruang')->orderBy('nama_ruang', 'ASC')->get()->getResultArray()
        ];

        return view('ruang/index', $data);
    }

    // 2. Memproses Tambah Ruangan
    public function simpanRuang()
    {
        // Validasi
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_ruang' => 'required|min_length[3]|is_unique[sarpras_ruang.nama_ruang,is_active,1]',
            'lantai'     => 'required|numeric'
        ], [
            'nama_ruang' => [
                'is_unique' => 'Nama ruangan tersebut sudah ada.'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $db = \Config\Database::connect();
        $db->table('sarpras_ruang')->insert([
            'nama_ruang' => $this->request->getPost('nama_ruang'),
            'lantai'     => $this->request->getPost('lantai'),
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        catat_log('CREATE', 'Menambahkan ruangan baru: ' . $this->request->getPost('nama_ruang'));

        return redirect()->to('/ruang')->with('success', 'Ruangan berhasil ditambahkan!');
    }

    // 4. Memproses Edit/Update Ruangan
    public function updateRuang($id)
    {
        // Validasi
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_ruang' => 'required|min_length[3]',
            'lantai'     => 'required|numeric'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $db = \Config\Database::connect();
        $db->table('sarpras_ruang')->where('id', $id)->update([
            'nama_ruang' => $this->request->getPost('nama_ruang'),
            'lantai'     => $this->request->getPost('lantai'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        catat_log('EDIT', 'Mengubah data ruangan menjadi: ' . $this->request->getPost('nama_ruang'));

        return redirect()->to('/ruang')->with('success', 'Ruangan berhasil diubah!');
    }
    // 3. Menonaktifkan / Menghapus Ruangan (Soft Delete)
    public function hapusRuang($id)
    {
        $db = \Config\Database::connect();

        $ruang = $db->table('sarpras_ruang')->where('id', $id)->get()->getRowArray();

        if ($ruang) {
            // Ubah status jadi 0 (Non-aktif)
            $db->table('sarpras_ruang')->where('id', $id)->update(['is_active' => 0]);
            catat_log('DELETE', 'Menonaktifkan ruangan: ' . $ruang['nama_ruang']);
        }

        return redirect()->to('/ruang')->with('success', 'Ruangan berhasil dinonaktifkan!');
    }
}
