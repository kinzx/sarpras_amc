<?php

use Config\Database;

if (!function_exists("catat_log")) {
    function catat_log($param1, $param2, $param3 = null)
    {
        $db = Database::connect();

        // Ambil username dari session Myth:Auth. Jika tidak ada, isi 'Guest'
        $username =
            function_exists("user") && user() ? user()->username : "Guest";

        // Ambil IP Address
        $ip = service("request")->getIPAddress();

        // Dukung signature baru (3 argumen: $modul, $aksi, $message)
        // dan backward-compatibility (2 argumen lama: $aksi, $message)
        if ($param3 !== null) {
            $modul = strtolower((string) $param1);
            $aksi = strtolower((string) $param2);
            $message = (string) $param3;
        } else {
            $modul = "sistem";
            $aksi = strtolower((string) $param1);
            $message = (string) $param2;
        }

        $data = [
            "username" => $username,
            "modul" => $modul,
            "aksi" => $aksi,
            "message" => $message,
            "ipaddress" => $ip,
            "created_at" => date("Y-m-d H:i:s"),
        ];

        // Simpan ke tabel log_apps
        $db->table("log_apps")->insert($data);
    }
}

if (!function_exists("get_nama_teknisi_pendamping")) {
    function get_nama_teknisi_pendamping(?string $json): array
    {
        if (empty($json)) {
            return [];
        }
        $ids = json_decode($json, true);
        if (!is_array($ids) || empty($ids)) {
            return [];
        }

        static $userCache = null;
        if ($userCache === null) {
            $db = Database::connect();
            $rows = $db
                ->table("users")
                ->select("id, username")
                ->get()
                ->getResultArray();
            $userCache = array_column($rows, "username", "id");
        }

        $names = [];
        foreach ($ids as $id) {
            if (isset($userCache[$id])) {
                $names[] = $userCache[$id];
            }
        }
        return $names;
    }
}
