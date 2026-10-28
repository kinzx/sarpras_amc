<?php

namespace App\Models;

use CodeIgniter\Model;

class MaintenanceModel extends Model
{
    protected $table            = 'sarpras_maintenance';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'barang_id',
        'user_id',
        'tanggal_maintenance',
        'kondisi_bodi',
        'kondisi_display',
        'kondisi_tombol',
        'kondisi_aksesoris',
        'kesimpulan',
        'foto_kondisi',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getRiwayat(string $keyword = '', string $bulan = ''): array
    {
        $builder = $this->db->table('sarpras_maintenance m')
            ->select('m.*, b.nama_barang, b.kode_aset, b.foto AS foto_barang, k.nama_kategori, r.nama_ruang, u.username AS nama_petugas')
            ->join('sarpras_barang b', 'b.id = m.barang_id', 'left')
            ->join('sarpras_kategori k', 'k.id = b.kategori_id', 'left')
            ->join('sarpras_ruang r', 'r.id = b.ruang_id', 'left')
            ->join('users u', 'u.id = m.user_id', 'left')
            ->where('m.is_active', 1);

        if ($keyword !== '') {
            $builder->groupStart()
                ->like('b.nama_barang', $keyword)
                ->orLike('b.kode_aset', $keyword)
                ->orLike('u.username', $keyword)
                ->groupEnd();
        }

        if (preg_match('/^\d{4}-\d{2}$/', $bulan) === 1) {
            $builder->where('DATE_FORMAT(m.tanggal_maintenance, "%Y-%m")', $bulan);
        }

        return $builder
            ->orderBy('m.tanggal_maintenance', 'DESC')
            ->orderBy('m.id', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getJadwal(): array
    {
        return $this->db->table('sarpras_barang b')
            ->select('b.id, b.nama_barang, b.kode_aset, b.foto, b.kondisi_barang,
                b.tanggal_perbaikan_terakhir, b.interval_maintenance_hari,
                k.nama_kategori, r.nama_ruang,
                DATE_ADD(COALESCE(b.tanggal_perbaikan_terakhir, DATE(b.created_at), CURDATE()), INTERVAL COALESCE(b.interval_maintenance_hari, 90) DAY) AS jadwal_berikutnya,
                DATEDIFF(DATE_ADD(COALESCE(b.tanggal_perbaikan_terakhir, DATE(b.created_at), CURDATE()), INTERVAL COALESCE(b.interval_maintenance_hari, 90) DAY), CURDATE()) AS sisa_hari')
            ->join('sarpras_kategori k', 'k.id = b.kategori_id', 'left')
            ->join('sarpras_ruang r', 'r.id = b.ruang_id', 'left')
            ->where('b.is_active', 1)
            ->orderBy('sisa_hari', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getRingkasan(): array
    {
        $total = $this->db->table('sarpras_maintenance')->where('is_active', 1)->countAllResults();

        $bulanIni = $this->db->table('sarpras_maintenance')
            ->where('is_active', 1)
            ->where('MONTH(tanggal_maintenance)', (int) date('n'))
            ->where('YEAR(tanggal_maintenance)', (int) date('Y'))
            ->countAllResults();

        $terlambat  = 0;
        $akanDatang = 0;

        foreach ($this->getJadwal() as $row) {
            $sisa = (int) $row['sisa_hari'];
            if ($sisa < 0) {
                $terlambat++;
            } elseif ($sisa <= 30) {
                $akanDatang++;
            }
        }

        return [
            'total'      => $total,
            'bulan_ini'  => $bulanIni,
            'terlambat'  => $terlambat,
            'akan_datang' => $akanDatang,
        ];
    }
}
