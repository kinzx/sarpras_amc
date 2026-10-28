<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\PerbaikanModel;

class Perbaikan extends BaseController
{
    protected $perbaikanModel;
    protected $barangModel;

    public function __construct()
    {
        $this->perbaikanModel = new PerbaikanModel();
        $this->barangModel    = new BarangModel();
    }

    // Halaman Riwayat Perbaikan (Menu sidebar: perbaikan)
    public function index()
    {
        $keyword = trim((string) $this->request->getGet('q'));
        $bulan   = trim((string) $this->request->getGet('bulan'));

        $data = [
            'title'     => 'Riwayat Perbaikan',
            'keyword'   => $keyword,
            'bulan'     => $bulan,
            'riwayat'   => $this->perbaikanModel->getRiwayat($keyword, $bulan),
            'ringkasan' => $this->perbaikanModel->getRingkasan(),
        ];

        return view('perbaikan/index', $data);
    }

    // Halaman Form / Daftar Perbaikan (Menu sidebar: perbaikan/create)
    public function create()
    {
        $barangId = (int) $this->request->getGet('barang_id');

        $data = [
            'title'              => 'Daftar & Input Perbaikan',
            'barang'             => $this->barangModel->getBarangWithRelations(),
            'barangRusak'        => $this->perbaikanModel->getDaftarBarangRusak(),
            'selectedBarangId'   => $barangId,
        ];

        return view('perbaikan/create', $data);
    }

    // Simpan data perbaikan
    public function simpan()
    {
        $rules = [
            'barang_id'          => 'required|is_natural_no_zero',
            'tanggal_perbaikan'  => 'required|valid_date[Y-m-d]',
            'laporan_kerusakan'  => 'required|min_length[3]',
            'analisa_kerusakan'  => 'permit_empty',
            'tindakan_dilakukan' => 'permit_empty',
            'kondisi_setelah'    => 'permit_empty',
            'kesimpulan'         => 'permit_empty',
        ];

        $fileFoto = $this->request->getFile('foto_sebelum');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $rules['foto_sebelum'] = 'max_size[foto_sebelum,2048]|is_image[foto_sebelum]|mime_in[foto_sebelum,image/jpg,image/jpeg,image/png,image/webp]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $barangId = (int) $this->request->getPost('barang_id');
        $namaFoto = null;

        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . 'uploads/perbaikan', $namaFoto);
        }

        $userId = function_exists('user_id') ? user_id() : (session()->get('logged_in_user')['id'] ?? 1);

        $this->perbaikanModel->save([
            'barang_id'          => $barangId,
            'user_id'            => $userId ?: 1,
            'tanggal_perbaikan'  => $this->request->getPost('tanggal_perbaikan'),
            'laporan_kerusakan'  => $this->request->getPost('laporan_kerusakan'),
            'foto_sebelum'       => $namaFoto,
            'analisa_kerusakan'  => $this->request->getPost('analisa_kerusakan'),
            'tindakan_dilakukan' => $this->request->getPost('tindakan_dilakukan'),
            'kondisi_setelah'    => $this->request->getPost('kondisi_setelah'),
            'kesimpulan'         => $this->request->getPost('kesimpulan'),
            'is_active'          => 1,
        ]);

        // Perbarui kondisi barang jika ada pilihan kondisi setelah perbaikan
        $kondisiSetelah = $this->request->getPost('kondisi_setelah');
        $updateBarang = [
            'tanggal_perbaikan_terakhir' => $this->request->getPost('tanggal_perbaikan')
        ];
        if (!empty($kondisiSetelah) && in_array($kondisiSetelah, ['Baik', 'Cukup', 'Rusak Ringan', 'Rusak Berat'])) {
            $updateBarang['kondisi_barang'] = $kondisiSetelah;
        }
        $this->barangModel->update($barangId, $updateBarang);

        catat_log('CREATE', 'Mencatat perbaikan barang ID: ' . $barangId);

        return redirect()->to('/perbaikan')->with('success', 'Catatan perbaikan berhasil disimpan!');
    }

    public function hapus($id)
    {
        $item = $this->perbaikanModel->find($id);
        if ($item) {
            $this->perbaikanModel->update($id, ['is_active' => 0]);
            catat_log('DELETE', 'Menghapus catatan perbaikan ID: ' . $id);
            return redirect()->to('/perbaikan')->with('success', 'Catatan perbaikan berhasil dihapus.');
        }

        return redirect()->to('/perbaikan')->with('error', 'Data tidak ditemukan.');
    }
}
