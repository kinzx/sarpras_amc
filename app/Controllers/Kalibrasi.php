<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\KalibrasiModel;

class Kalibrasi extends BaseController
{
    protected $kalibrasiModel;
    protected $barangModel;

    public function __construct()
    {
        $this->kalibrasiModel = new KalibrasiModel();
        $this->barangModel    = new BarangModel();
    }

    public function index()
    {
        $keyword = trim((string) $this->request->getGet('q'));
        $tahun   = trim((string) $this->request->getGet('tahun'));

        $data = [
            'title'     => 'Kalibrasi Alat Medis',
            'keyword'   => $keyword,
            'tahun'     => $tahun,
            'riwayat'   => $this->kalibrasiModel->getRiwayat($keyword, $tahun),
            'ringkasan' => $this->kalibrasiModel->getRingkasan(),
            'barang'    => $this->barangModel->getBarangWithRelations(),
        ];

        return view('kalibrasi/index', $data);
    }

    public function simpan()
    {
        $rules = [
            'barang_id'         => 'required|is_natural_no_zero',
            'tanggal_kalibrasi' => 'required|valid_date[Y-m-d]',
            'catatan'           => 'permit_empty',
            'file_sertifikat'   => 'uploaded[file_sertifikat]|max_size[file_sertifikat,5120]|ext_in[file_sertifikat,pdf,jpg,jpeg,png]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileSertifikat = $this->request->getFile('file_sertifikat');
        $namaFile = $fileSertifikat->getRandomName();
        $fileSertifikat->move(FCPATH . 'uploads/kalibrasi', $namaFile);

        $barangId = (int) $this->request->getPost('barang_id');

        $this->kalibrasiModel->save([
            'barang_id'         => $barangId,
            'tanggal_kalibrasi' => $this->request->getPost('tanggal_kalibrasi'),
            'file_sertifikat'   => $namaFile,
            'catatan'           => $this->request->getPost('catatan'),
            'is_active'         => 1,
        ]);

        catat_log('CREATE', 'Menambahkan sertifikat kalibrasi untuk barang ID: ' . $barangId);

        return redirect()->to('/kalibrasi')->with('success', 'Data sertifikat kalibrasi berhasil disimpan!');
    }

    public function hapus($id)
    {
        $item = $this->kalibrasiModel->find($id);
        if ($item) {
            $this->kalibrasiModel->update($id, ['is_active' => 0]);
            catat_log('DELETE', 'Menghapus data kalibrasi ID: ' . $id);
            return redirect()->to('/kalibrasi')->with('success', 'Data kalibrasi berhasil dinonaktifkan.');
        }

        return redirect()->to('/kalibrasi')->with('error', 'Data tidak ditemukan.');
    }
}
