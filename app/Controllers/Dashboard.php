<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\MaintenanceModel;
use App\Models\PerbaikanModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $barangModel = new BarangModel();
        $maintenanceModel = new MaintenanceModel();
        $perbaikanModel = new PerbaikanModel();

        // 1. Data Statistik Utama
        $totalAset = $db->table('sarpras_barang')->where('is_active', 1)->countAllResults();
        $asetAktif = $db->table('sarpras_barang')->where('is_active', 1)->where('kondisi_barang', 'Baik')->countAllResults();
        
        // Jadwal maintenance terdekat (jatuh tempo atau sisa <= 7 hari)
        $semuaJadwal = $maintenanceModel->getJadwal();
        $perluMaintenanceCount = 0;
        $alertJadwal = [];
        foreach ($semuaJadwal as $j) {
            $sisa = (int)$j['sisa_hari'];
            if ($sisa <= 14) {
                $perluMaintenanceCount++;
                if (count($alertJadwal) < 5) {
                    $alertJadwal[] = $j;
                }
            }
        }

        // Aset rusak berat / ringan (Barang yang tiba-tiba rusak / butuh servis)
        $daftarAsetRusak = $db->table('sarpras_barang b')
            ->select('b.id, b.nama_barang, b.kode_aset, b.merek, b.kondisi_barang, b.updated_at, r.nama_ruang, r.lantai, k.nama_kategori')
            ->join('sarpras_ruang r', 'r.id = b.ruang_id', 'left')
            ->join('sarpras_kategori k', 'k.id = b.kategori_id', 'left')
            ->where('b.is_active', 1)
            ->whereIn('b.kondisi_barang', ['Rusak Ringan', 'Rusak Berat'])
            ->orderBy('b.updated_at', 'DESC')
            ->limit(6)
            ->get()
            ->getResultArray();

        $asetRusakCount = $db->table('sarpras_barang')
            ->where('is_active', 1)
            ->whereIn('kondisi_barang', ['Rusak Ringan', 'Rusak Berat'])
            ->countAllResults();

        // 2. Data Grafik Kategori
        $kategoriStat = $db->table('sarpras_kategori k')
            ->select('k.nama_kategori, COUNT(b.id) as total')
            ->join('sarpras_barang b', 'b.kategori_id = k.id AND b.is_active = 1', 'left')
            ->where('k.is_active', 1)
            ->groupBy('k.id, k.nama_kategori')
            ->orderBy('total', 'DESC')
            ->get()
            ->getResultArray();

        $chartLabels = [];
        $chartSeries = [];
        foreach ($kategoriStat as $row) {
            $chartLabels[] = $row['nama_kategori'];
            $chartSeries[] = (int) $row['total'];
        }

        // 3. Log Aktivitas Terbaru
        $logs = $db->table('log_apps')
            ->orderBy('id', 'DESC')
            ->limit(7)
            ->get()
            ->getResultArray();

        $data = [
            'title'                 => 'Dashboard Sarpras | RS AMC',
            'totalAset'             => $totalAset,
            'asetAktif'             => $asetAktif,
            'perluMaintenanceCount' => $perluMaintenanceCount,
            'asetRusakCount'        => $asetRusakCount,
            'alertJadwal'           => $alertJadwal,
            'daftarAsetRusak'       => $daftarAsetRusak,
            'chartLabels'           => $chartLabels,
            'chartSeries'           => $chartSeries,
            'logs'                  => $logs,
        ];

        return view('dashboard/dashboard', $data);
    }
}
