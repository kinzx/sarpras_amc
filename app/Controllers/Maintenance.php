<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\MaintenanceModel;

class Maintenance extends BaseController
{
    protected $maintenanceModel;
    protected $barangModel;

    public function __construct()
    {
        $this->maintenanceModel = new MaintenanceModel();
        $this->barangModel      = new BarangModel();
    }

    public function index()
    {
        $keyword = trim((string) $this->request->getGet('q'));
        $bulan   = trim((string) $this->request->getGet('bulan'));

        $data = [
            'title'     => 'Riwayat Pemeliharaan',
            'keyword'   => $keyword,
            'bulan'     => $bulan,
            'riwayat'   => $this->maintenanceModel->getRiwayat($keyword, $bulan),
            'ringkasan' => $this->maintenanceModel->getRingkasan(),
            'jadwal'    => $this->maintenanceModel->getJadwal(),
        ];

        return view('maintenance/index', $data);
    }

    public function create()
    {
        $data = [
            'title'    => 'Input Pemeliharaan',
            'barang'   => $this->barangModel->getBarangWithRelations(),
            'jadwal'   => $this->maintenanceModel->getJadwal(),
            'barangId' => (int) $this->request->getGet('barang_id'),
        ];

        return view('maintenance/create', $data);
    }

    public function simpan()
    {
        $rules = [
            'barang_id'          => 'required|is_natural_no_zero',
            'tanggal_maintenance' => 'required|valid_date[Y-m-d]',
            'kondisi_bodi'       => 'required',
            'kondisi_display'    => 'required',
            'kondisi_tombol'     => 'required',
            'kondisi_aksesoris'  => 'required',
            'kesimpulan'         => 'permit_empty',
        ];

        $fileFoto = $this->request->getFile('foto_kondisi');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $rules['foto_kondisi'] = 'max_size[foto_kondisi,2048]|is_image[foto_kondisi]|mime_in[foto_kondisi,image/jpg,image/jpeg,image/png,image/webp]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $barangId = (int) $this->request->getPost('barang_id');
        $barang   = $this->barangModel->find($barangId);

        if (!$barang) {
            return redirect()->back()->withInput()->with('error', 'Barang yang dipilih tidak ditemukan.');
        }

        $namaFoto = null;
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . 'uploads/maintenance', $namaFoto);
        }

        $tanggal = $this->request->getPost('tanggal_maintenance');

        $this->maintenanceModel->save([
            'barang_id'          => $barangId,
            'user_id'            => user()->id,
            'tanggal_maintenance' => $tanggal,
            'kondisi_bodi'       => $this->request->getPost('kondisi_bodi'),
            'kondisi_display'    => $this->request->getPost('kondisi_display'),
            'kondisi_tombol'     => $this->request->getPost('kondisi_tombol'),
            'kondisi_aksesoris'  => $this->request->getPost('kondisi_aksesoris'),
            'kesimpulan'         => $this->request->getPost('kesimpulan'),
            'foto_kondisi'       => $namaFoto,
            'is_active'          => 1,
        ]);

        $this->barangModel->update($barangId, [
            'tanggal_perbaikan_terakhir' => $tanggal,
        ]);

        catat_log('CREATE', 'Mencatat pemeliharaan barang: ' . $barang['nama_barang']);

        return redirect()->to('/maintenance')->with('success', 'Catatan pemeliharaan berhasil disimpan.');
    }

    public function hapus($id)
    {
        $row = $this->maintenanceModel->find($id);

        if (!$row) {
            return redirect()->to('/maintenance')->with('error', 'Catatan pemeliharaan tidak ditemukan.');
        }

        $this->maintenanceModel->update($id, ['is_active' => 0]);

        $barang = $this->barangModel->find($row['barang_id']);
        catat_log('DELETE', 'Menghapus catatan pemeliharaan: ' . ($barang['nama_barang'] ?? '#' . $id));

        return redirect()->to('/maintenance')->with('success', 'Catatan pemeliharaan berhasil dihapus.');
    }
}
