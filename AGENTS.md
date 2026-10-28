# Konteks Proyek & Progres Terakhir (sarpras_amc)

Dokumen ini ditujukan sebagai referensi handoff konteks agen (OpenCode, Claude Code, dsb.) agar dapat langsung melanjutkan pekerjaan tanpa pengulangan dari awal.

---

## 1. Lingkungan & Stack Proyek
- **Framework:** CodeIgniter 4 (PHP 8.3 / Laragon di Windows)
- **Database:** MySQL (`db_sarpras_amc`)
- **Template Admin:** Sneat / Bootstrap 5 + Boxicons + jQuery
- **Pustaka Tambahan:** `endroid/qr-code` v6.x (constructor-based: `size: 300, margin: 10`)
- **Aturan URL Proyek:** Menggunakan `index.php` pada routing tertentu (`site_url()` untuk AJAX/link dinamis)

---

## 2. Fitur & Perubahan yang Baru Diselesaikan

### A. Modul Barang (Inventaris)
1. **Form Tambah Barang (`app/Views/barang/create.php`)**:
   - Layout 2 kolom rapi sesuai mockup:
     - Kiri: Kode barang (`kode_aset`), Kategori, Sub Kategori (AJAX dinamis), Merek, No. Seri, Daya (Watt), Kepemilikan (Radio RS/KSO/PT).
     - Kanan: Nama Barang, Ruangan (dropdown), Lantai (otomatis terisi dari `data-lantai`), Tipe, Tahun Pembelian, Kondisi (`Baik`, `Cukup`, `Rusak Ringan`, `Rusak Berat`), Status (`Aktif`/`Nonaktif`).
   - Area drag-and-drop upload foto barang (JPG, PNG, WEBP maks 2MB, required).
   - **Jadwal Maintenance**:
     - `tanggal_perbaikan_terakhir`: Tanggal masuk/servis terakhir (default: `today`).
     - `interval_maintenance_hari`: Input dinamis per unit barang (default: 90 hari).
     - `jadwal_berikutnya`: Terhitung otomatis di JavaScript (`tanggal_acuan + interval_hari`).
2. **Form Edit Barang (`app/Views/barang/edit.php`)**:
   - Struktur dan field identik dengan form tambah barang.
   - Menampilkan data tersimpan dan mengelola penggantian foto secara opsional (foto lama otomatis terhapus saat ada upload baru).
3. **Controller CRUD (`app/Controllers/Barang.php`)**:
   - `create()` & `simpan()`: Validasi, penomoran kode aset otomatis jika kosong, upload foto ke `public/uploads/barang/`, simpan ke `sarpras_barang`, dan catat log.
   - `edit($id)` & `update($id)`: Menyiapkan data terkait, update record, serta catat log.
   - `hapus($id)`: Soft delete (`is_active = 0`) dan catat log.
   - `qrcode($kode_aset)`: Menghasilkan gambar PNG QR Code menggunakan API Endroid QR Code v6 dengan target link ke halaman scan publik `site_url('scan/' . $kode_aset)`.

### B. Modul Guest Scan (QR Code Publik)
1. **Controller (`app/Controllers/Scan.php`)**:
   - Method `detail($kodeAset)` mengambil data barang aktif via `BarangModel::getBarangForGuest()`.
2. **Filter & Keamanan (`app/Config/Filters.php` & `app/Config/Routes.php`)**:
   - Filter `login` dikecualikan untuk endpoint `scan/*` (`'login' => ['except' => ['scan/*']]`).
   - Route `scan/(:segment)` ditaruh di luar login group sehingga tamu/guest bisa mengakses tanpa akun.
3. **Tampilan Tamu (`app/Views/scan/detail.php`)**:
   - Tampilan ramah perangkat seluler (mobile friendly).
   - Menampilkan foto, spesifikasi fisik, kepemilikan, dan lokasi ruangan.
   - **PENTING:** Sengaja **TIDAK** menampilkan riwayat pemeliharaan/tabel maintenance untuk menjaga privasi operasional RS.
   - Menggunakan pengecekan null-safe (`?? '-'`) agar aman untuk data lama.

---

## 3. Status Routing Terkait (`app/Config/Routes.php`)
```php
// Publik (Guest Scan)
$routes->get('scan/(:segment)', 'Scan::detail/$1');

// Authed Group (memerlukan login)
$routes->group('', ['filter' => 'login'], function ($routes) {
    $routes->get('barang', 'Barang::index');
    $routes->get('barang/tambah', 'Barang::create');
    $routes->post('barang/simpan', 'Barang::simpan');
    $routes->get('barang/edit/(:num)', 'Barang::edit/$1');
    $routes->post('barang/update/(:num)', 'Barang::update/$1');
    $routes->get('barang/hapus/(:num)', 'Barang::hapus/$1');
    $routes->get('barang/getSubKategori/(:num)', 'Barang::getSubKategori/$1');
    $routes->post('barang/getSubKategori', 'Barang::getSubKategori');
    $routes->get('barang/detail/(:num)', 'Barang::detail/$1');
    $routes->get('barang/qrcode/(:segment)', 'Barang::qrcode/$1');
    $routes->get('barang/barcode/(:segment)', 'Barang::barcode/$1');
    // ...
});
```

---

## 4. File-File Kunci
- `app/Controllers/Barang.php` (CRUD barang + generator QR Code)
- `app/Controllers/Scan.php` (controller publik halaman scan guest)
- `app/Models/BarangModel.php` (query data barang + getBarangForGuest)
- `app/Views/barang/create.php` (form tambah barang 2 kolom)
- `app/Views/barang/edit.php` (form edit barang 2 kolom)
- `app/Views/barang/detail.php` (halaman detail internal + QR Code)
- `app/Views/scan/detail.php` (halaman detail khusus guest/tamu)
- `app/Config/Routes.php` (konfigurasi seluruh route)
- `app/Config/Filters.php` (pengecualian route publik scan)

---

## 5. Rencana Langkah Selanjutnya (Next Tasks)
1. **Modul Pemeliharaan (Maintenance)**:
   - Buat Controller `Maintenance.php` dan tabel/model untuk mengelola pencatatan servis.
   - Tampilkan filter daftar barang jatuh tempo (kuning/merah) berdasarkan formula:
     `jadwal_berikutnya = tanggal_perbaikan_terakhir + interval_maintenance_hari`.
   - Form input pemeliharaan yang otomatis memperbarui `tanggal_perbaikan_terakhir` di `sarpras_barang` ke tanggal servis terbaru.
2. **Modul Perbaikan & Kalibrasi**:
   - Mengikuti skema menu pada sidebar (`Perbaikan` dan `Kalibrasi`).
