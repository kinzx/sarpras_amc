<?php

use Config\Database;

if (!function_exists('catat_log')) {
    function catat_log($aksi, $message)
    {
        $db = Database::connect();
        
        // Ambil username dari session Myth:Auth. Jika tidak ada, isi 'Guest'
        $username = function_exists('user') && user() ? user()->username : 'Guest';
        
        // Ambil IP Address
        $ip = service('request')->getIPAddress();

        $data = [
            'username'   => $username,
            'aksi'       => $aksi, // ex: CREATE, UPDATE, DELETE
            'message'    => $message,
            'ipaddress'  => $ip,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Simpan ke tabel log_apps
        $db->table('log_apps')->insert($data);
    }
}