<?php

namespace App\Models;

use CodeIgniter\Model;

class KalibrasiModel extends Model
{
    protected $table            = 'sarpras_kalibrasi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'barang_id',
        'tanggal_kalibrasi',
        'file_sertifikat',
        'catatan',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getRiwayat(?string $keyword = null, ?string $tahun = null): array
    {
        $builder = $this->db->table($this->table . ' k')
            ->select('k.*, b.nama_barang, b.kode_aset, b.merek, b.tipe, b.no_seri, kat.nama_kategori, r.nama_ruang, r.lantai')
            ->join('sarpras_barang b', 'b.id = k.barang_id', 'left')
            ->join('sarpras_kategori kat', 'kat.id = b.kategori_id', 'left')
            ->join('sarpras_ruang r', 'r.id = b.ruang_id', 'left')
            ->where('k.is_active', 1);

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('b.nama_barang', $keyword)
                ->orLike('b.kode_aset', $keyword)
                ->orLike('b.no_seri', $keyword)
                ->orLike('k.catatan', $keyword)
                ->groupEnd();
        }

        if (!empty($tahun)) {
            $builder->where("YEAR(k.tanggal_kalibrasi) =", $tahun);
        }

        return $builder->orderBy('k.tanggal_kalibrasi', 'DESC')
            ->orderBy('k.id', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getRingkasan(): array
    {
        $total = $this->where('is_active', 1)->countAllResults();

        $tahunIni = date('Y');
        $tahunIniCount = $this->where('is_active', 1)
            ->where("YEAR(tanggal_kalibrasi) =", $tahunIni)
            ->countAllResults();

        // Total alat medis (kategori medis)
        $totalAlatMedis = $this->db->table('sarpras_barang b')
            ->join('sarpras_kategori kat', 'kat.id = b.kategori_id', 'left')
            ->where('b.is_active', 1)
            ->like('kat.nama_kategori', 'medis')
            ->countAllResults();

        return [
            'total'            => $total,
            'tahun_ini'        => $tahunIniCount,
            'total_alat_medis' => $totalAlatMedis,
        ];
    }
}
