<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
{
    $db = \Config\Database::connect();
    
    // 1. Hitung Total Aset
    $totalAset = $db->table('sarpras_barang')->where('is_active', 1)->countAllResults();
    
    // 2. Hitung Aset Aktif
    $asetAktif = $db->table('sarpras_barang')->where('is_active', 1)->where('kondisi', 'baik')->countAllResults(); // sesuaikan
    
    // 3. Ambil 5 Log Terbaru
    $logs = $db->table('log_apps')->orderBy('created_at', 'DESC')->limit(5)->get()->getResultArray();

    $data = [
        'title' => 'Dashboard SIMAS',
        'totalAset' => $totalAset,
        'asetAktif' => $asetAktif,
        'logs' => $logs
    ];

    // Panggil view utama, yang di dalamnya memanggil 'dashboard/main'
    return view('dashboard/index', $data);
}
}