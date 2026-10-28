<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Laporan extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // 1. Ambil data dropdown filter
        $kategoriList = $db->table('sarpras_kategori')->where('is_active', 1)->get()->getResultArray();
        $ruangList    = $db->table('sarpras_ruang')->where('is_active', 1)->get()->getResultArray();

        // 2. Baca parameter filter
        $jenisLaporan = $this->request->getGet('jenis') ?: 'inventaris'; // inventaris, maintenance, perbaikan, kalibrasi
        $kategoriId   = $this->request->getGet('kategori_id');
        $ruangId      = $this->request->getGet('ruang_id');
        $kondisi      = $this->request->getGet('kondisi');
        $tanggalMulai = $this->request->getGet('tanggal_mulai');
        $tanggalSelesai = $this->request->getGet('tanggal_selesai');

        // 3. Cek apakah kolom kondisi_barang ada di tabel
        $hasKondisiCol = $db->fieldExists('kondisi_barang', 'sarpras_barang');

        // Ringkasan Statistik Kartu Atas
        $totalBarang    = $db->table('sarpras_barang')->where('is_active', 1)->countAllResults();
        $totalBaik      = $hasKondisiCol ? $db->table('sarpras_barang')->where('is_active', 1)->where('kondisi_barang', 'Baik')->countAllResults() : $totalBarang;
        $totalRusak     = $hasKondisiCol ? $db->table('sarpras_barang')->where('is_active', 1)->like('kondisi_barang', 'Rusak')->countAllResults() : 0;

        // 4. Query Data sesuai Filter
        $builder = $db->table('sarpras_barang')
            ->select('sarpras_barang.*, sarpras_kategori.nama_kategori, sarpras_sub_kategori.nama_sub_kategori, sarpras_ruang.nama_ruang, sarpras_ruang.lantai')
            ->join('sarpras_kategori', 'sarpras_kategori.id = sarpras_barang.kategori_id', 'left')
            ->join('sarpras_sub_kategori', 'sarpras_sub_kategori.id = sarpras_barang.sub_kategori_id', 'left')
            ->join('sarpras_ruang', 'sarpras_ruang.id = sarpras_barang.ruang_id', 'left')
            ->where('sarpras_barang.is_active', 1);

        if (!empty($kategoriId)) {
            $builder->where('sarpras_barang.kategori_id', $kategoriId);
        }
        if (!empty($ruangId)) {
            $builder->where('sarpras_barang.ruang_id', $ruangId);
        }
        if (!empty($kondisi) && $hasKondisiCol) {
            $builder->where('sarpras_barang.kondisi_barang', $kondisi);
        }

        $laporanData = $builder->orderBy('sarpras_barang.id', 'DESC')->get()->getResultArray();

        $data = [
            'title'            => 'Laporan Sarpras',
            'jenisLaporan'     => $jenisLaporan,
            'kategoriList'     => $kategoriList,
            'ruangList'        => $ruangList,
            'filters'          => [
                'kategori_id'     => $kategoriId,
                'ruang_id'        => $ruangId,
                'kondisi'         => $kondisi,
                'tanggal_mulai'   => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
            ],
            'statistik'        => [
                'total_barang'  => $totalBarang,
                'total_baik'    => $totalBaik,
                'total_rusak'   => $totalRusak,
            ],
            'laporanData'      => $laporanData,
        ];

        return view('laporan/index', $data);
    }
}
