<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_kategori' => 'Elektronik', 'parent_id' => null, 'is_active' => 1],
            ['nama_kategori' => 'Non-Elektronik', 'parent_id' => null, 'is_active' => 1],
            ['nama_kategori' => 'Alat Medis', 'parent_id' => null, 'is_active' => 1],
        ];

        $this->db->table('sarpras_kategori')->insertBatch($data);
    }
}