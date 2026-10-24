# SIM-SARPRAS RS AMC (Sistem Informasi Manajemen Sarana & Prasarana)

Sistem Informasi Manajemen Sarana dan Prasarana (SARPRAS) untuk **Rumah Sakit AMC**, dibangun menggunakan framework **CodeIgniter 4** dan database **MySQL/MariaDB**. Aplikasi ini dirancang untuk mendata, memantau, serta mengelola siklus pemeliharaan aset medis dan non-medis rumah sakit secara terintegrasi dan efisien.

---

## 📌 Fitur Utama

- **Dashboard Interaktif**: Ringkasan status inventaris, jumlah aset, peringatan jadwal maintenance & kalibrasi.
- **Master Data**:
  - **Data Barang / Aset**: Pencatatan spesifikasi teknis barang (merek, tipe, no seri, daya, kepemilikan, interval maintenance).
  - **Kategori & Sub-Kategori**: Pengelompokan bertingkat (parent-child category) dengan penanda ikon.
  - **Ruangan & Lokasi**: Penempatan barang berdasarkan ruangan dan lantai rumah sakit.
  - **Pengguna & Role**: Manajemen hak akses pengguna (Admin & Teknisi).
- **Manajemen Pemeliharaan & Aset (Database Ready)**:
  - **Kalibrasi Alat**: Jadwal, catatan, dan unggah sertifikat bukti kalibrasi.
  - **Maintenance Rutin**: Inspeksi berkala fisik (bodi, display, tombol, aksesoris) dan kesimpulan kondisi alat.
  - **Perbaikan Kerusakan**: Pencatatan tiket kerusakan, foto sebelum & setelah tindakan, analisis perbaikan, dan histori perbaikan.
  - **Audit Trail & Activity Log**: Pencatatan riwayat aktivitas pengguna ke dalam `log_apps`.

---

## 🛠️ Tech Stack & Kebutuhan Sistem

- **PHP**: `^8.2` (dengan ekstensi `intl`, `mbstring`, `json`, `mysqlnd`, `curl`)
- **Framework**: [CodeIgniter 4](https://codeigniter.com/) (v4.7+)
- **Database**: MySQL / MariaDB
- **Template / UI**: Sneat Bootstrap 5 Admin Dashboard Template & Boxicons
- **Dependency Manager**: Composer

---

## 🚀 Panduan Instalasi & Menjalankan Proyek

### 1. Clone Repositori
```bash
git clone https://github.com/kinzx/sarpras_amc.git
cd sarpras_amc
```

### 2. Instalasi Dependensi
Jalankan Composer untuk mengunduh vendor library:
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin file konfigurasi contoh `env` menjadi `.env` (atau sesuaikan `.env` yang sudah ada):
```bash
cp env .env
```
Sesuaikan konfigurasi database dan base URL pada `.env`:
```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = sarpras_amc
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### 4. Migrasi & Seeding Database
Jalankan migrasi untuk membuat seluruh skema tabel sarpras:
```bash
php spark migrate
```
*(Opsional)* Jalankan seeder untuk data awal kategori:
```bash
php spark db:seed KategoriSeeder
```

### 5. Menjalankan Server Lokal
Jalankan development server CodeIgniter:
```bash
php spark serve
```
Atau jika ingin dapat diakses dari jaringan lokal / IP spesifik:
```bash
php spark serve --host 0.0.0.0 --port 8080
```
Buka browser dan akses aplikasi melalui `http://localhost:8080`.

---

## 📁 Struktur Direktori Singkat

```text
sarpras_amc/
├── app/
│   ├── Config/              # Konfigurasi sistem (Routes, Database, App, dll.)
│   ├── Controllers/         # Controller aplikasi (Dashboard, Kategori, Home, dll.)
│   ├── Database/
│   │   ├── Migrations/      # Skema tabel database (CreateSarprasTables)
│   │   └── Seeds/           # Data awal / seeder
│   ├── Models/              # Model database
│   └── Views/               # Tampilan antarmuka Blade/PHP
│       ├── adds/            # Komponen layout (navbar, sidebar, header, footer)
│       ├── barang/          # Halaman manajemen barang
│       ├── kategori/        # Halaman kategori & sub-kategori
│       ├── ruang/           # Halaman manajemen ruangan
│       └── dashboard/       # Tampilan dashboard
├── public/                  # Document root (index.php, CSS, JS, logo, file statis)
├── writable/                # File cache, logs, dan upload session
└── spark                    # CLI tool CodeIgniter 4
```

---

## 👥 Kontributor

- **RS AMC Development Team** / [kinzx](https://github.com/kinzx)

---

## 📄 Lisensi

Proyek ini berada di bawah lisensi [MIT License](LICENSE).
