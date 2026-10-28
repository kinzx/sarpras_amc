<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_kategori' => 'Elektronik', 'is_active' => 1],
            ['nama_kategori' => 'Non-Elektronik', 'is_active' => 1],
            ['nama_kategori' => 'Alat Medis', 'is_active' => 1],
        ];

        $this->db->table('sarpras_kategori')->insertBatch($data);
    }
}