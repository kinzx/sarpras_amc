<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\MaintenanceModel;

class Maintenance extends BaseController
{
    protected $maintenanceModel;
    protected $barangModel;

    public function __construct()
    {
        $this->maintenanceModel = new MaintenanceModel();
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $keyword = trim((string) $this->request->getGet("q"));
        $bulan = trim((string) $this->request->getGet("bulan"));

        // Ambil daftar teknisi aktif untuk dropdown edit di modal
        $petugas = $db
            ->table("users u")
            ->select("u.id, u.username, u.email")
            ->join("auth_groups_users agu", "agu.user_id = u.id", "inner")
            ->join("auth_groups g", "g.id = agu.group_id", "inner")
            ->where("u.active", 1)
            ->where("g.name", "teknisi")
            ->groupBy("u.id, u.username, u.email")
            ->orderBy("u.username", "ASC")
            ->get()
            ->getResultArray();

        $data = [
            "title" => "Riwayat Pemeliharaan",
            "keyword" => $keyword,
            "bulan" => $bulan,
            "riwayat" => $this->maintenanceModel->getRiwayat($keyword, $bulan),
            "ringkasan" => $this->maintenanceModel->getRingkasan(),
            "jadwal" => $this->maintenanceModel->getJadwal(),
            "petugas" => $petugas,
        ];

        return view("maintenance/index", $data);
    }

    public function create()
    {
        $db = \Config\Database::connect();
        $barangId = (int) $this->request->getGet("barang_id");

        // Ambil teknisi aktif (kompatibel sql_mode=only_full_group_by)
        $petugas = $db
            ->table("users u")
            ->select("u.id, u.username, u.email, MAX(g.name) as role_name")
            ->join("auth_groups_users agu", "agu.user_id = u.id", "inner")
            ->join("auth_groups g", "g.id = agu.group_id", "inner")
            ->where("u.active", 1)
            ->where("g.name", "teknisi")
            ->groupBy("u.id, u.username, u.email")
            ->orderBy("u.username", "ASC")
            ->get()
            ->getResultArray();

        $kategori = $db
            ->table("sarpras_kategori")
            ->where("is_active", 1)
            ->orderBy("nama_kategori", "ASC")
            ->get()
            ->getResultArray();

        $data = [
            "title" => "Input Pemeliharaan",
            "barang" => $this->barangModel->getBarangWithRelations(),
            "jadwal" => $this->maintenanceModel->getJadwal(),
            "barangId" => $barangId,
            "petugas" => $petugas,
            "kategori" => $kategori,
        ];

        return view("maintenance/create", $data);
    }

    public function simpan()
    {
        $rules = [
            "barang_id" => "required|is_natural_no_zero",
            "user_id" => "required|is_natural_no_zero",
            "tanggal_maintenance" => "required|valid_date[Y-m-d]",
            "kondisi_bodi" => "required",
            "kondisi_display" => "required",
            "kondisi_tombol" => "required",
            "kondisi_aksesoris" => "required",
            "kesimpulan" => "permit_empty",
        ];

        $fileFoto = $this->request->getFile("foto_kondisi");
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $rules["foto_kondisi"] =
                "max_size[foto_kondisi,2048]|is_image[foto_kondisi]|mime_in[foto_kondisi,image/jpg,image/jpeg,image/png,image/webp]";
        }

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with("errors", $this->validator->getErrors());
        }

        $barangId = (int) $this->request->getPost("barang_id");
        $barang = $this->barangModel->find($barangId);

        if (!$barang) {
            return redirect()
                ->back()
                ->withInput()
                ->with("error", "Barang yang dipilih tidak ditemukan.");
        }

        $namaFoto = null;
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . "uploads/maintenance", $namaFoto);
        }

        $tanggal = $this->request->getPost("tanggal_maintenance");
        $userId = (int) $this->request->getPost("user_id");
        $pendampingPost = $this->request->getPost("teknisi_pendamping");
        $pendampingJson = null;
        if (!empty($pendampingPost) && is_array($pendampingPost)) {
            $filtered = array_values(
                array_filter(
                    array_map("intval", $pendampingPost),
                    fn($id) => $id > 0 && $id !== $userId,
                ),
            );
            if (!empty($filtered)) {
                $pendampingJson = json_encode($filtered);
            }
        }

        $this->maintenanceModel->save([
            "barang_id" => $barangId,
            "user_id" => $userId,
            "teknisi_pendamping" => $pendampingJson,
            "tanggal_maintenance" => $tanggal,
            "kondisi_bodi" => $this->request->getPost("kondisi_bodi"),
            "kondisi_display" => $this->request->getPost("kondisi_display"),
            "kondisi_tombol" => $this->request->getPost("kondisi_tombol"),
            "kondisi_aksesoris" => $this->request->getPost("kondisi_aksesoris"),
            "kesimpulan" => $this->request->getPost("kesimpulan"),
            "foto_kondisi" => $namaFoto,
            "is_active" => 1,
        ]);

        $this->barangModel->update($barangId, [
            "tanggal_perbaikan_terakhir" => $tanggal,
        ]);

        catat_log(
            "CREATE",
            "Mencatat pemeliharaan barang: " . $barang["nama_barang"],
        );

        return redirect()
            ->to("/maintenance")
            ->with("success", "Catatan pemeliharaan berhasil disimpan.");
    }

    public function update($id)
    {
        $row = $this->maintenanceModel->find($id);
        if (!$row) {
            return redirect()
                ->to("/maintenance")
                ->with("error", "Catatan pemeliharaan tidak ditemukan.");
        }

        $rules = [
            "user_id" => "required|is_natural_no_zero",
            "tanggal_maintenance" => "required|valid_date[Y-m-d]",
            "kondisi_bodi" => "required",
            "kondisi_display" => "required",
            "kondisi_tombol" => "required",
            "kondisi_aksesoris" => "required",
            "kesimpulan" => "permit_empty",
        ];

        $fileFoto = $this->request->getFile("foto_kondisi");
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $rules["foto_kondisi"] =
                "max_size[foto_kondisi,2048]|is_image[foto_kondisi]|mime_in[foto_kondisi,image/jpg,image/jpeg,image/png,image/webp]";
        }

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with("errors", $this->validator->getErrors());
        }

        $namaFoto = $row["foto_kondisi"];
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFotoBaru = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . "uploads/maintenance", $namaFotoBaru);
            if (
                !empty($namaFoto) &&
                file_exists(FCPATH . "uploads/maintenance/" . $namaFoto)
            ) {
                @unlink(FCPATH . "uploads/maintenance/" . $namaFoto);
            }
            $namaFoto = $namaFotoBaru;
        }

        $tanggal = $this->request->getPost("tanggal_maintenance");
        $userId = (int) $this->request->getPost("user_id");
        $pendampingPost = $this->request->getPost("teknisi_pendamping");
        $pendampingJson = null;
        if (!empty($pendampingPost) && is_array($pendampingPost)) {
            $filtered = array_values(
                array_filter(
                    array_map("intval", $pendampingPost),
                    fn($val) => $val > 0 && $val !== $userId,
                ),
            );
            if (!empty($filtered)) {
                $pendampingJson = json_encode($filtered);
            }
        }

        $this->maintenanceModel->update($id, [
            "user_id" => $userId,
            "teknisi_pendamping" => $pendampingJson,
            "tanggal_maintenance" => $tanggal,
            "kondisi_bodi" => $this->request->getPost("kondisi_bodi"),
            "kondisi_display" => $this->request->getPost("kondisi_display"),
            "kondisi_tombol" => $this->request->getPost("kondisi_tombol"),
            "kondisi_aksesoris" => $this->request->getPost("kondisi_aksesoris"),
            "kesimpulan" => $this->request->getPost("kesimpulan"),
            "foto_kondisi" => $namaFoto,
        ]);

        $barang = $this->barangModel->find($row["barang_id"]);
        catat_log(
            "UPDATE",
            "Memperbarui catatan pemeliharaan: " .
                ($barang["nama_barang"] ?? "#" . $id),
        );

        return redirect()
            ->to("/maintenance")
            ->with("success", "Catatan pemeliharaan berhasil diperbarui.");
    }

    public function hapus($id)
    {
        $row = $this->maintenanceModel->find($id);

        if (!$row) {
            return redirect()
                ->to("/maintenance")
                ->with("error", "Catatan pemeliharaan tidak ditemukan.");
        }

        $this->maintenanceModel->update($id, ["is_active" => 0]);

        $barang = $this->barangModel->find($row["barang_id"]);
        catat_log(
            "DELETE",
            "Menghapus catatan pemeliharaan: " .
                ($barang["nama_barang"] ?? "#" . $id),
        );

        return redirect()
            ->to("/maintenance")
            ->with("success", "Catatan pemeliharaan berhasil dihapus.");
    }
}
