<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // ponytail: view statis dulu, query DB/log dihubungkan nanti
        $data = [
            'title'     => 'Dashboard SIMAS',
            'totalAset' => 0,
            'asetAktif' => 0,
            'logs'      => []
        ];

        return view('dashboard/dashboard', $data);
    }
}
