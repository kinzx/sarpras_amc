<?php

namespace App\Models;

use CodeIgniter\Model;

class PerbaikanModel extends Model
{
    protected $table = "sarpras_perbaikan";
    protected $primaryKey = "id";
    protected $useAutoIncrement = true;
    protected $returnType = "array";
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        "barang_id",
        "pelapor_id",
        "teknisi_id",
        "pegawai_id",
        "pelapor_teknisi_id",
        "teknisi_utama_id",
        "status",
        "tanggal_penanganan",
        "jam_penanganan",
        "deskripsi_penanganan",
        "user_id",
        "teknisi_pendamping",
        "tanggal_perbaikan",
        "laporan_kerusakan",
        "foto_sebelum",
        "tindakan_dilakukan",
        "kondisi_setelah",
        "is_active",
    ];

    protected $useTimestamps = true;
    protected $dateFormat = "datetime";
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";

    public function getRiwayat(
        ?string $keyword = null,
        ?string $bulan = null,
        ?string $status = null,
    ): array {
        $builder = $this->db
            ->table($this->table . " p")
            ->select(
                "p.*, b.nama_barang, b.kode_aset, b.merek, b.foto AS foto_barang, k.nama_kategori, r.nama_ruang, r.lantai, up.username AS nama_pelapor, ut.username AS nama_teknisi, COALESCE(ut.username, u.username) AS nama_petugas",
            )
            ->join("sarpras_barang b", "b.id = p.barang_id", "left")
            ->join("sarpras_kategori k", "k.id = b.kategori_id", "left")
            ->join("sarpras_ruang r", "r.id = b.ruang_id", "left")
            ->join("users up", "up.id = p.pelapor_id", "left")
            ->join("users ut", "ut.id = p.teknisi_id", "left")
            ->join("users u", "u.id = p.user_id", "left")
            ->where("p.is_active", 1);

        if (!empty($keyword)) {
            $builder
                ->groupStart()
                ->like("b.nama_barang", $keyword)
                ->orLike("b.kode_aset", $keyword)
                ->orLike("p.laporan_kerusakan", $keyword)
                ->orLike("p.tindakan_dilakukan", $keyword)
                ->orLike("up.username", $keyword)
                ->orLike("ut.username", $keyword)
                ->groupEnd();
        }

        if (!empty($bulan)) {
            $builder->where(
                "DATE_FORMAT(COALESCE(p.tanggal_perbaikan, p.created_at), '%Y-%m') =",
                $bulan,
            );
        }

        if (!empty($status)) {
            $builder->where("p.status", $status);
        }

        return $builder
            ->orderBy("p.id", "DESC")
            ->get()
            ->getResultArray();
    }

    public function getDaftarBarangRusak(): array
    {
        return $this->db
            ->table("sarpras_barang b")
            ->select(
                "b.id, b.nama_barang, b.kode_aset, b.merek, b.kondisi_barang, b.foto, k.nama_kategori, r.nama_ruang, r.lantai",
            )
            ->join("sarpras_kategori k", "k.id = b.kategori_id", "left")
            ->join("sarpras_ruang r", "r.id = b.ruang_id", "left")
            ->where("b.is_active", 1)
            ->whereIn("b.kondisi_barang", [
                "Rusak Ringan",
                "Rusak Berat",
                "Cukup",
            ])
            ->orderBy("b.kondisi_barang", "DESC")
            ->orderBy("b.id", "DESC")
            ->get()
            ->getResultArray();
    }

    public function getRingkasan(): array
    {
        $totalPerbaikan = $this->where("is_active", 1)->countAllResults();

        $bulanIni = date("Y-m");
        $bulanIniCount = $this->where("is_active", 1)
            ->where("DATE_FORMAT(COALESCE(tanggal_perbaikan, created_at), '%Y-%m') =", $bulanIni)
            ->countAllResults();

        $perluPerbaikan = $this->db
            ->table("sarpras_barang")
            ->where("is_active", 1)
            ->whereIn("kondisi_barang", ["Rusak Ringan", "Rusak Berat"])
            ->countAllResults();

        return [
            "total" => $totalPerbaikan,
            "bulan_ini" => $bulanIniCount,
            "perlu_perbaikan" => $perluPerbaikan,
        ];
    }
}
