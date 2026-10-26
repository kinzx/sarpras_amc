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

        return view('barang/index', $data); // Pastikan view detail kamu benar
    }

    // ==========================================
    // FUNGSI BARU UNTUK TAMBAH BARANG
    // ==========================================

    // 1. Menampilkan Halaman Form
    public function create()
    {
        $db = \Config\Database::connect();

        // Ambil data untuk dropdown
        $kategori = $db->table('sarpras_kategori')->where('is_active', 1)->get()->getResultArray();
        $ruang    = $db->table('sarpras_ruang')->where('is_active', 1)->get()->getResultArray();

        $data = [
            'title'    => 'Tambah Barang Baru',
            'kategori' => $kategori,
            'ruang'    => $ruang
        ];

        return view('barang/create', $data);
    }

    // 2. AJAX: Mengambil Sub-Kategori berdasarkan Kategori ID
    public function getSubKategori()
    {
        $kategori_id = $this->request->getPost('kategori_id');

        $db = \Config\Database::connect();
        $subKategori = $db->table('sarpras_sub_kategori')
            ->where('kategori_id', $kategori_id)
            ->where('is_active', 1)
            ->get()->getResultArray();

        return $this->response->setJSON($subKategori);
    }

    // 3. Memproses Data Form Tambah Barang
    public function simpan()
    {
        // --- Validasi Input ---
        $validation = \Config\Services::validation();
        $validation->setRules([
            'kategori_id' => 'required',
            'nama_barang' => 'required|min_length[3]',
            'ruang_id'    => 'required',
            'foto'        => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // --- Proses Upload Foto ---
        $fileFoto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            // Generate nama random agar tidak bentrok
            $namaFoto = $fileFoto->getRandomName();
            // Pastikan folder public/uploads/barang sudah dibuat!
            $fileFoto->move('uploads/barang', $namaFoto);
        }

        // --- Simpan ke Database ---
        $this->barangModel->save([
            'kategori_id'               => $this->request->getPost('kategori_id'),
            'sub_kategori_id'           => $this->request->getPost('sub_kategori_id') ?: null,
            'ruang_id'                  => $this->request->getPost('ruang_id'),
            'kode_aset'                 => 'AMC-' . strtoupper(substr(md5(uniqid()), 0, 8)), // Auto-generate kode unik
            'nama_barang'               => $this->request->getPost('nama_barang'),
            'merek'                     => $this->request->getPost('merek'),
            'tipe'                      => $this->request->getPost('tipe'),
            'no_seri'                   => $this->request->getPost('no_seri'),
            'daya'                      => $this->request->getPost('daya'),
            'tahun_pembelian'           => $this->request->getPost('tahun_pembelian'),
            'interval_maintenance_hari' => $this->request->getPost('interval_maintenance_hari'),
            'foto'                      => $namaFoto,
            'keterangan'                => $this->request->getPost('keterangan'),
            'kepemilikan'               => $this->request->getPost('kepemilikan'),
            'is_active'                 => 1
        ]);

        // Catat Log
        catat_log('CREATE', 'Menambahkan barang baru: ' . $this->request->getPost('nama_barang'));

        return redirect()->to('/barang')->with('success', 'Barang berhasil ditambahkan!');
    }
}
