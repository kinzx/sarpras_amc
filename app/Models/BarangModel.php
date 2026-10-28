<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'sarpras_barang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'kategori_id',
        'sub_kategori_id',
        'ruang_id',
        'kode_aset',
        'nama_barang',
        'merek',
        'tipe',
        'no_seri',
        'daya',
        'tahun_pembelian',
        'interval_maintenance_hari',
        'foto',
        'keterangan',
        'kepemilikan',
        'kondisi_barang',
        'tanggal_perbaikan_terakhir',
        'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getBarangWithRelations($id = null)
    {
        $builder = $this->select('
                sarpras_barang.*, 
                sarpras_kategori.nama_kategori, 
                sarpras_sub_kategori.nama_sub_kategori, 
                sarpras_ruang.nama_ruang, 
                sarpras_ruang.lantai
            ')
            ->join('sarpras_kategori', 'sarpras_kategori.id = sarpras_barang.kategori_id', 'left')
            ->join('sarpras_sub_kategori', 'sarpras_sub_kategori.id = sarpras_barang.sub_kategori_id', 'left')
            ->join('sarpras_ruang', 'sarpras_ruang.id = sarpras_barang.ruang_id', 'left')
            ->where('sarpras_barang.is_active', 1);

        if ($id !== null) {
            // Mengambil 1 data (untuk halaman Detail)
            return $builder->where('sarpras_barang.id', $id)->first();
        }

        // Mengambil semua data (untuk halaman Tabel Daftar Barang)
        return $builder->orderBy('sarpras_barang.id', 'DESC')->findAll();
    }

    public function getBarangForGuest(string $kodeAset): ?array
    {
        return $this->select('sarpras_barang.*, sarpras_kategori.nama_kategori, sarpras_sub_kategori.nama_sub_kategori, sarpras_ruang.nama_ruang, sarpras_ruang.lantai')
            ->join('sarpras_kategori', 'sarpras_kategori.id = sarpras_barang.kategori_id', 'left')
            ->join('sarpras_sub_kategori', 'sarpras_sub_kategori.id = sarpras_barang.sub_kategori_id', 'left')
            ->join('sarpras_ruang', 'sarpras_ruang.id = sarpras_barang.ruang_id', 'left')
            ->where('sarpras_barang.kode_aset', $kodeAset)
            ->where('sarpras_barang.is_active', 1)
            ->first();
    }
}
