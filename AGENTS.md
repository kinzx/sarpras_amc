# Konteks Proyek & Progres Terakhir (sarpras_amc)

Dokumen ini ditujukan sebagai referensi handoff konteks agen (OpenCode, Claude Code, dsb.) agar dapat langsung melanjutkan pekerjaan tanpa pengulangan dari awal.

---

## 1. Lingkungan & Stack Proyek

- **Framework:** CodeIgniter 4 (PHP 8.3 / Laragon di Windows)
- **Database:** MySQL (`db_sarpras_amc`)
- **Template Admin:** Sneat / Bootstrap 5 + Boxicons + jQuery + FilePond
- **Pustaka Tambahan:** 
  - `endroid/qr-code` v6.x (constructor-based: `size: 300, margin: 10`)
  - FilePond (Image Preview, File Size, File Type)
  - `myth/auth` (Autentikasi & Manajemen Role)
- **Aturan URL Proyek:** 
  - Menggunakan `index.php` pada routing tertentu (`site_url()` untuk AJAX/link dinamis).
  - Menggunakan Cloudflare Tunnel (`trycloudflare.com`) untuk testing akses publik, sehingga `app.baseURL` di `.env` harus disesuaikan secara berkala.
- **Branding & Favicon:** Menggunakan `public/AMC-tanpa-nama-pad.png` (ukuran 64x64 & 180x180) di seluruh view.

---

## 2. Fitur & Perubahan yang Baru Diselesaikan

### A. Modul Barang (Inventaris)

1. **Form Tambah Barang (`app/Views/barang/create.php`)**:
   - Layout 2 kolom rapi sesuai mockup.
   - Area drag-and-drop upload foto barang menggunakan **FilePond** (`storeAsFile: true`).
   - **Jadwal Maintenance**: Input dinamis `tanggal_perbaikan_terakhir`, `interval_maintenance_hari`, dan kalkulasi otomatis `jadwal_berikutnya` di JavaScript.
2. **Form Edit Barang (`app/Views/barang/edit.php`)**:
   - Struktur identik dengan form tambah, menggunakan FilePond untuk update foto.
3. **Controller CRUD (`app/Controllers/Barang.php`)**:
   - Validasi, upload foto ke `public/uploads/barang/`, simpan ke `sarpras_barang`, catat log, dan soft delete (`is_active = 0`).
   - `qrcode($kode_aset)`: Menghasilkan PNG QR Code yang mengarah ke `site_url('scan/' . $kode_aset)`.

### B. Modul Guest Scan (QR Code Publik)

1. **Controller (`app/Controllers/Scan.php`)**:
   - Method `detail($kodeAset)` mengambil data barang aktif via `BarangModel::getBarangForGuest()`.
2. **Filter & Keamanan (`app/Config/Filters.php` & `app/Config/Routes.php`)**:
   - Filter `login` dikecualikan untuk endpoint `scan/*`.
   - Route `scan/(:segment)` ditaruh di luar login group.
3. **Tampilan Tamu (`app/Views/scan/detail.php`)**:
   - Mobile friendly. Menampilkan foto, spesifikasi, kepemilikan, dan lokasi ruangan.
   - **TIDAK** menampilkan riwayat pemeliharaan/tabel maintenance untuk menjaga privasi operasional RS.
   - Menggunakan pengecekan null-safe (`?? '-'`).

### C. Standardisasi Upload FilePond di Seluruh Modul
- Seluruh input berkas/gambar telah dimigrasikan ke **FilePond** (`storeAsFile: true`):
  - `create.php` & `edit.php` (Barang), `create.php` (Perbaikan & Maintenance), Modal di `detail.php`, dan `kalibrasi/index.php`.

### D. Penyesuaian Dashboard & Branding
1. **Hero Banner Dinamis (`app/Views/dashboard/main.php`)**:
   - Warna latar mengikuti CSS variable tema Sneat.
   - Penambahan kartu QR Code Cepat ("Scan Portal Guest").
2. **Favicon Terpadu**: Menggunakan `AMC-tanpa-nama-pad.png`.

### E. Modul Manajemen Pengguna & Role (Myth:Auth) - *BARU*
1. **Route Access**:
   - Ditambahkan group route `pengguna` yang dilindungi oleh filter `group:admin` (hanya IT/Admin yang bisa akses).
2. **Controller (`app/Controllers/Pengguna.php`)**:
   - Fungsi `index()`: Menampilkan tabel user beserta role-nya.
   - Fungsi `simpan()`: Membuat user baru (menggunakan `Myth\Auth\Entities\User`), auto-hash password, set `active = 1`, dan masukkan ke grup via `GroupModel->addUserToGroup()`.
   - Fungsi `update($id)`: Update data user (cek jika password diisi, jika tidak biarkan yang lama).
   - Fungsi `hapus($id)`: Soft delete user (`active = 0`).
3. **View (`app/Views/pengguna/`)**:
   - `index.php` (Layout utama).
   - `main.php` (Tabel data user, modal tambah, dan modal edit dengan JavaScript auto-fill).

---

## 3. Status Routing Terkait (`app/Config/Routes.php`)

```php
// Publik (Guest Scan)
$routes->get('scan/(:segment)', 'Scan::detail/$1');

// Authed Group (memerlukan login)
$routes->group('', ['filter' => 'login'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    // ... (rute barang, kategori, ruang, maintenance, dll)
    
    // Khusus Admin/IT
    $routes->group('', ['filter' => 'group:admin'], function ($routes) {
        $routes->get('pengguna', 'Pengguna::index');
        $routes->post('pengguna/simpan', 'Pengguna::simpan');
        $routes->post('pengguna/update/(:num)', 'Pengguna::update/$1');
        $routes->get('pengguna/hapus/(:num)', 'Pengguna::hapus/$1');
    });
});