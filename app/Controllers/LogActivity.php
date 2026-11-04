<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Database;

class LogActivity extends BaseController
{
    public function index()
    {
        $db = Database::connect();

        $search = trim((string) $this->request->getGet('q'));
        $modul  = trim((string) $this->request->getGet('modul'));

        $builder = $db->table('log_apps');

        if ($search !== '') {
            $builder->groupStart()
                ->like('username', $search)
                ->orLike('message', $search)
                ->groupEnd();
        }

        if ($modul !== '') {
            $builder->where('modul', strtolower($modul));
        }

        // Ambil daftar modul unik untuk filter dropdown
        $modulList = $db->table('log_apps')
            ->select('modul')
            ->where('modul IS NOT NULL')
            ->where('modul !=', '')
            ->groupBy('modul')
            ->orderBy('modul', 'ASC')
            ->get()
            ->getResultArray();

        $logs = $builder
            ->orderBy('id', 'DESC')
            ->limit(100)
            ->get()
            ->getResultArray();

        $data = [
            'title'     => 'Log Aktivitas Sistem',
            'logs'      => $logs,
            'modulList' => array_column($modulList, 'modul'),
            'search'    => $search,
            'selectedModul' => $modul,
        ];

        return view('log/index', $data);
    }
}
