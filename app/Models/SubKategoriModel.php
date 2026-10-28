<?php

namespace App\Models;

use CodeIgniter\Model;

class SubKategoriModel extends Model
{
    protected $table            = 'sarpras_sub_kategori';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'kategori_id',
        'nama_sub_kategori',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
