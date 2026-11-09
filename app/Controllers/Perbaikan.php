<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\PerbaikanModel;

class Perbaikan extends BaseController
{
    protected $perbaikanModel;
    protected $barangModel;
    protected $db;

    public function __construct()
    {
        $this->perbaikanModel = new PerbaikanModel();
        $this->barangModel = new BarangModel();
        $this->db = \Config\Database::connect();
    }

    /**
     * Tugas 3: Menampilkan Riwayat Laporan (Index)
     * JOIN 4 tabel: sarpras_perbaikan, sarpras_barang, sarpras_pegawai, sarpras_teknisi
     */
    public function index()
    {
        $keyword = trim((string) $this->request->getGet('q'));
        $bulan   = trim((string) $this->request->getGet('bulan'));
        $status  = trim((string) $this->request->getGet('status'));

        // Query Builder JOIN tabel terkait
        $builder = $this->db->table('sarpras_perbaikan p')
            ->select('
                p.*, 
                b.nama_barang, b.kode_aset, b.merek,
                COALESCE(pg.nama_pegawai, pt.nama_teknisi, u_pelapor.username, u.username, "-") AS nama_pelapor,
                CASE 
                    WHEN pg.id IS NOT NULL THEN \'Pegawai\'
                    WHEN pt.id IS NOT NULL THEN \'Teknisi\'
                    WHEN u_pelapor.id IS NOT NULL THEN \'User\'
                    WHEN u.id IS NOT NULL THEN \'User\'
                    ELSE \'-\'
                END AS tipe_pelapor,
                COALESCE(tk.nama_teknisi, tk_u.username, "-") AS nama_teknisi
            ', false)
            ->join('sarpras_barang b', 'b.id = p.barang_id', 'left')
            ->join('sarpras_pegawai pg', 'pg.id = p.pegawai_id', 'left')
            ->join('sarpras_teknisi pt', 'pt.id = p.pelapor_teknisi_id', 'left')
            ->join('users u_pelapor', 'u_pelapor.id = p.pelapor_id', 'left')
            ->join('users u', 'u.id = p.user_id', 'left')
            ->join('sarpras_teknisi tk', 'tk.id = p.teknisi_utama_id', 'left')
            ->join('users tk_u', 'tk_u.id = p.teknisi_utama_id', 'left')
            ->where('p.is_active', 1);

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('b.nama_barang', $keyword)
                ->orLike('b.kode_aset', $keyword)
                ->orLike('pg.nama_pegawai', $keyword)
                ->orLike('pt.nama_teknisi', $keyword)
                ->orLike('u_pelapor.username', $keyword)
                ->orLike('u.username', $keyword)
                ->orLike('tk.nama_teknisi', $keyword)
                ->orLike('p.laporan_kerusakan', $keyword)
                ->groupEnd();
        }

        if (!empty($bulan)) {
            $builder->where("DATE_FORMAT(COALESCE(p.tanggal_perbaikan, p.created_at), '%Y-%m') =", $bulan);
        }

        if (!empty($status)) {
            $builder->where('p.status', $status);
        }

        $riwayat = $builder->orderBy('p.id', 'DESC')->get()->getResultArray();

        // Ambil data teknisi aktif untuk dropdown di modal tindak lanjut
        $teknisi = $this->db->table('sarpras_teknisi')
            ->where('is_active', 1)
            ->orderBy('nama_teknisi', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'title'     => 'Daftar Laporan Perbaikan',
            'keyword'   => $keyword,
            'bulan'     => $bulan,
            'status'    => $status,
            'riwayat'   => $riwayat,
            'teknisi'   => $teknisi,
            'ringkasan' => $this->perbaikanModel->getRingkasan(),
        ];

        return view('perbaikan/index', $data);
    }

    /**
     * Tugas 2: Form Pelaporan Awal (Create)
     * Memanggil data pegawai & teknisi aktif (is_active = 1)
     */
    public function create()
    {
        $barangId = (int) $this->request->getGet('barang_id');

        // 1. Ambil data Pegawai aktif
        $pegawai = [];
        if ($this->db->tableExists('sarpras_pegawai')) {
            $pegawai = $this->db->table('sarpras_pegawai')
                ->where('is_active', 1)
                ->orderBy('nama_pegawai', 'ASC')
                ->get()
                ->getResultArray();
        }

        // 2. Ambil data Teknisi aktif
        $teknisi = [];
        if ($this->db->tableExists('sarpras_teknisi')) {
            $teknisi = $this->db->table('sarpras_teknisi')
                ->where('is_active', 1)
                ->orderBy('nama_teknisi', 'ASC')
                ->get()
                ->getResultArray();
        }

        // 3. Ambil data Pengguna sistem (tabel users)
        $users = [];
        if ($this->db->tableExists('users')) {
            $users = $this->db->table('users u')
                ->select('u.id, u.username, u.email, COALESCE(MAX(g.name), "user") AS role_name')
                ->join('auth_groups_users agu', 'agu.user_id = u.id', 'left')
                ->join('auth_groups g', 'g.id = agu.group_id', 'left')
                ->where('u.active', 1)
                ->groupBy('u.id, u.username, u.email')
                ->orderBy('u.username', 'ASC')
                ->get()
                ->getResultArray();
        }

        $barang = $this->barangModel->getBarangWithRelations();

        // Gabungkan 3 sumber pelapor ke dalam satu array flat terstandarisasi Select2
        $list_pelapor = [];
        if (!empty($pegawai)) {
            foreach ($pegawai as $p) {
                $nip = !empty($p['nip']) ? ' (NIP: ' . $p['nip'] . ')' : '';
                $list_pelapor[] = [
                    'id'   => 'pegawai-' . $p['id'],
                    'text' => '[Pegawai] ' . $p['nama_pegawai'] . $nip,
                ];
            }
        }
        if (!empty($teknisi)) {
            foreach ($teknisi as $t) {
                $list_pelapor[] = [
                    'id'   => 'teknisi-' . $t['id'],
                    'text' => '[Teknisi] ' . $t['nama_teknisi'],
                ];
            }
        }
        if (!empty($users)) {
            foreach ($users as $u) {
                $role = !empty($u['role_name']) ? ' (' . ucfirst($u['role_name']) . ')' : '';
                $list_pelapor[] = [
                    'id'   => 'user-' . $u['id'],
                    'text' => '[Akun] ' . $u['username'] . $role,
                ];
            }
        }

        $kategori = $this->db->table('sarpras_kategori')
            ->where('is_active', 1)
            ->orderBy('nama_kategori', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'title'            => 'Form Pelaporan Perbaikan',
            'barang'           => $barang,
            'selectedBarangId' => $barangId,
            'list_pelapor'     => $list_pelapor,
            'pegawai'          => $pegawai,
            'teknisi'          => $teknisi,
            'users'            => $users,
            'kategori'         => $kategori,
        ];

        return view('perbaikan/create', $data);
    }

    /**
     * Tugas 2: Simpan Data Laporan Awal
     * Status awal: 'menunggu', menyimpan pegawai_id dan teknisi_utama_id
     */
    public function simpan()
    {
        $rules = [
            'barang_id'         => 'required|is_natural_no_zero',
            'laporan_kerusakan' => 'required|min_length[3]',
        ];

        // Validasi pelapor (bisa pegawai atau teknisi)
        if (!$this->request->getPost('pelapor_raw') && !$this->request->getPost('pegawai_id')) {
            $rules['pelapor_raw'] = 'required';
        }

        $fileFoto = $this->request->getFile('foto_sebelum');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $rules['foto_sebelum'] = 'max_size[foto_sebelum,2048]|is_image[foto_sebelum]|mime_in[foto_sebelum,image/jpg,image/jpeg,image/png,image/webp]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $barangId         = (int) $this->request->getPost('barang_id');
        $pelaporRaw       = trim((string) ($this->request->getPost('pelapor_raw') ?: $this->request->getPost('pegawai_id')));
        $teknisiUtamaId   = $this->request->getPost('teknisi_utama_id') ? (int) $this->request->getPost('teknisi_utama_id') : null;
        $tglPerbaikan     = $this->request->getPost('tanggal_perbaikan') ?: date('Y-m-d');
        $laporanKerusakan = $this->request->getPost('laporan_kerusakan');

        $pegawaiId        = null;
        $pelaporTeknisiId = null;
        $pelaporUserId    = null;

        if (!empty($pelaporRaw)) {
            $delimiter = strpos($pelaporRaw, '-') !== false ? '-' : (strpos($pelaporRaw, ':') !== false ? ':' : null);
            if ($delimiter !== null) {
                list($tipe, $valId) = explode($delimiter, $pelaporRaw, 2);
                $tipe = strtolower(trim($tipe));
                if ($tipe === 'teknisi') {
                    $pelaporTeknisiId = (int) $valId;
                } elseif ($tipe === 'user') {
                    $pelaporUserId = (int) $valId;
                } else {
                    $pegawaiId = (int) $valId;
                }
            } else {
                $pegawaiId = (int) $pelaporRaw;
            }
        }

        $currentUserId = function_exists('user_id') && user_id() ? user_id() : 1;

        $namaFoto = null;
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move(FCPATH . 'uploads/perbaikan', $namaFoto);
        }

        $dataPerbaikan = [
            'barang_id'          => $barangId,
            'pegawai_id'         => $pegawaiId,
            'pelapor_teknisi_id' => $pelaporTeknisiId,
            'pelapor_id'         => $pelaporUserId,
            'teknisi_utama_id'   => $teknisiUtamaId,
            'user_id'            => $pelaporUserId ?: $currentUserId,
            'tanggal_perbaikan'  => $tglPerbaikan,
            'laporan_kerusakan'  => $laporanKerusakan,
            'foto_sebelum'       => $namaFoto,
            'status'             => 'menunggu',
            'is_active'          => 1,
            'created_at'         => date('Y-m-d H:i:s'),
            'updated_at'         => date('Y-m-d H:i:s'),
        ];

        $this->db->table('sarpras_perbaikan')->insert($dataPerbaikan);
        $perbaikanId = $this->db->insertID();

        // Catat log otomatis pertama ke sarpras_perbaikan_log
        $currentUserId = function_exists('user_id') && user_id() ? user_id() : null;
        $this->db->table('sarpras_perbaikan_log')->insert([
            'perbaikan_id' => $perbaikanId,
            'user_id'      => $currentUserId,
            'status_lama'  => null,
            'status_baru'  => 'menunggu',
            'keterangan'   => 'Laporan perbaikan dibuat (Menunggu Penanganan)',
            'created_at'   => date('Y-m-d H:i:s'),
        ]);

        $barang = $this->barangModel->find($barangId);
        $namaBarang = $barang ? $barang['nama_barang'] . ' (' . $barang['kode_aset'] . ')' : '#' . $barangId;
        if (function_exists('catat_log')) {
            catat_log('CREATE', 'Membuat tiket laporan perbaikan barang: ' . $namaBarang);
        }

        return redirect()->to('/perbaikan')->with('success', 'Laporan perbaikan berhasil dibuat dengan status menunggu!');
    }

    /**
     * Tugas 4: AJAX Ambil Log Penanganan
     * JOIN sarpras_perbaikan_log dengan tabel users
     */
    public function getLog($id)
    {
        $id = (int) $id;
        $logs = $this->db
            ->table('sarpras_perbaikan_log l')
            ->select('l.*, u.username AS nama_petugas')
            ->join('users u', 'u.id = l.user_id', 'left')
            ->where('l.perbaikan_id', $id)
            ->orderBy('l.id', 'ASC')
            ->get()
            ->getResultArray();

        $formatted = array_map(function ($item) {
            $ts = strtotime($item['created_at']);
            return [
                'nama_petugas' => $item['nama_petugas'] ?? 'Sistem / Helpdesk',
                'tanggal'      => date('d-m-Y', $ts),
                'jam'          => date('H:i', $ts),
                'penanganan'   => $item['keterangan'] ?? '-',
                'status'       => $item['status_baru'] ?? '-',
            ];
        }, $logs);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $formatted,
        ]);
    }

    /**
     * Update Status & Catat Log Tindak Lanjut dari Modal
     */
    public function tindakLanjut()
    {
        $rules = [
            'perbaikan_id'         => 'required|is_natural_no_zero',
            'status'               => 'required|in_list[diproses,selesai,ditolak]',
            'tanggal_penanganan'   => 'required|valid_date[Y-m-d]',
            'jam_penanganan'       => 'required',
            'deskripsi_penanganan' => 'required|min_length[3]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id             = (int) $this->request->getPost('perbaikan_id');
        $statusBaru     = $this->request->getPost('status');
        $teknisiUtamaId = $this->request->getPost('teknisi_utama_id') ? (int) $this->request->getPost('teknisi_utama_id') : null;
        $tgl            = $this->request->getPost('tanggal_penanganan');
        $jam            = $this->request->getPost('jam_penanganan');
        $deskripsi      = $this->request->getPost('deskripsi_penanganan');
        $userId         = function_exists('user_id') && user_id() ? user_id() : null;

        $current = $this->db->table('sarpras_perbaikan')->where('id', $id)->get()->getRowArray();
        if (!$current) {
            return redirect()->to('/perbaikan')->with('error', 'Data laporan perbaikan tidak ditemukan.');
        }

        $statusLama = $current['status'] ?? 'menunggu';

        // 1. Update status, teknisi, dan data penanganan di tabel sarpras_perbaikan
        $updatePerbaikan = [
            'status'               => $statusBaru,
            'tanggal_penanganan'   => $tgl,
            'jam_penanganan'       => $jam,
            'deskripsi_penanganan' => $deskripsi,
            'updated_at'           => date('Y-m-d H:i:s'),
        ];
        if ($teknisiUtamaId) {
            $updatePerbaikan['teknisi_utama_id'] = $teknisiUtamaId;
        }
        $this->db->table('sarpras_perbaikan')->where('id', $id)->update($updatePerbaikan);

        // 2. Simpan rekaman ke sarpras_perbaikan_log
        $formattedTime = strlen($jam) === 5 ? $jam . ':00' : $jam;
        $this->db->table('sarpras_perbaikan_log')->insert([
            'perbaikan_id' => $id,
            'user_id'      => $userId,
            'status_lama'  => $statusLama,
            'status_baru'  => $statusBaru,
            'keterangan'   => $deskripsi,
            'created_at'   => $tgl . ' ' . $formattedTime,
        ]);

        if (function_exists('catat_log')) {
            catat_log('UPDATE', "Menindaklanjuti perbaikan #$id menjadi status $statusBaru");
        }

        return redirect()->to('/perbaikan')->with('success', 'Tindak lanjut penanganan berhasil disimpan!');
    }

    /**
     * Soft delete laporan perbaikan
     */
    public function hapus($id)
    {
        $id = (int) $id;
        $item = $this->db->table('sarpras_perbaikan')->where('id', $id)->get()->getRowArray();
        if ($item) {
            $this->db->table('sarpras_perbaikan')->where('id', $id)->update(['is_active' => 0]);
            if (function_exists('catat_log')) {
                catat_log('DELETE', "Menonaktifkan catatan perbaikan #$id");
            }
            return redirect()->to('/perbaikan')->with('success', 'Catatan perbaikan berhasil dihapus.');
        }

        return redirect()->to('/perbaikan')->with('error', 'Data tidak ditemukan.');
    }
}
