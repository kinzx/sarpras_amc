<!doctype html>

<html
    lang="en"
    class="layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed"
    dir="ltr"
    data-skin="default"
    data-assets-path="<?= base_url('assets/') ?>"
    data-template="vertical-menu-template"
    data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= $title ?? 'Detail Barang' ?> | RS AMC</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon/favicon.ico') ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/iconify-icons.css') ?>" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/pickr/pickr-themes.css') ?>" />

    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />

    <!-- endbuild -->

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="<?= base_url('assets/vendor/js/helpers.js') ?>"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="<?= base_url('assets/vendor/js/template-customizer.js') ?>"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="<?= base_url('assets/js/config.js') ?>"></script>
    <style>
        .bg-label-secondary {
            background-color: #f5f5f9;
            color: #697a8d;
        }

        .bg-label-success {
            background-color: #e8fadf;
            color: #71dd37;
        }

        .bg-label-warning {
            background-color: #fff2d6;
            color: #ffab00;
        }

        .bg-label-danger {
            background-color: #ffe0db;
            color: #ff3e1d;
        }
    </style>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <?= view('adds/sidebar'); ?>

            <div class="menu-mobile-toggler d-xl-none rounded-1">
                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
                    <i class="bx bx-menu icon-base"></i>
                    <i class="bx bx-chevron-right icon-base"></i>
                </a>
            </div>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?= view('adds/navbar'); ?>

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y mt-4">

                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="mb-1">Detail Barang</h4>
                                <p class="text-muted mb-0">Informasi barang, jadwal, dan riwayat maintenance</p>
                            </div>
                            <div>
                                <a href="<?= base_url('barang') ?>" class="btn btn-outline-secondary me-2">Kembali</a>
                                <a href="#" class="btn btn-warning me-2"><i class="bx bx-pencil me-1"></i> Ubah</a>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalMaintenance"><i class="bx bx-plus me-1"></i> Input Maintenance</button>
                            </div>
                        </div>

                        <div class="row">
                            <!-- KOLOM KIRI (Profil & Data) -->
                            <div class="col-md-4 mb-4">

                                <!-- Card Profil Barang -->
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                        <!-- Foto Barang -->
                                        <div class="mb-3">
                                            <?php if ($item['foto']): ?>
                                                <img src="<?= base_url('uploads/barang/' . $item['foto']) ?>" alt="Foto Barang" class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-light rounded d-flex justify-content-center align-items-center" style="height: 200px;">
                                                    <i class="bx bx-image text-muted" style="font-size: 5rem;"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-end mt-4">
                                            <div class="text-start">
                                                <h3 class="mb-1"><?= $item['nama_barang'] ?></h3>
                                                <p class="text-muted mb-2"><?= $item['kode_aset'] ?></p>
                                                <?php if ($item['is_active'] == 1): ?>
                                                    <span class="badge bg-label-success px-3">Aktif</span>
                                                <?php else: ?>
                                                    <span class="badge bg-label-danger px-3">Non-Aktif</span>
                                                <?php endif; ?>
                                            </div>
                                            <!-- QR Code / Barcode -->
                                            <!-- KODE BARU (QR Code Kotak) -->
                                            <div class="text-end">
                                                <img src="<?= base_url('barang/qrcode/' . $item['kode_aset']) ?>" alt="QR Code" class="img-fluid rounded border p-1 bg-white" style="width: 90px; height: 90px; object-fit: contain;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Data Barang -->
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h5 class="mb-0">Data barang</h5>
                                    </div>
                                    <div class="card-body mt-3">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <td class="text-muted">Kategori</td>
                                                <td class="text-end fw-bold"><?= $item['nama_kategori'] ?> <?= $item['nama_sub_kategori'] ? ' > ' . $item['nama_sub_kategori'] : '' ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Merek</td>
                                                <td class="text-end"><?= $item['merek'] ?? '-' ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Kepemilikan</td>
                                                <td class="text-end fw-bold"><?= $item['kepemilikan'] == 'milik_rs' ? 'Milik RS' : 'Milik Vendor' ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Lokasi ruangan</td>
                                                <td class="text-end"><?= $item['nama_ruang'] ?>, Lantai <?= $item['lantai'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Status ruangan</td>
                                                <td class="text-end"><span class="badge bg-label-secondary">Aktif</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Dibuat</td>
                                                <td class="text-end"><?= date('d M Y, H:i', strtotime($item['created_at'])) ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- KOLOM KANAN (Maintenance) -->
                            <div class="col-md-8 mb-4">

                                <!-- Card Jadwal Maintenance -->
                                <div class="card mb-4">
                                    <div class="card-header border-bottom mb-3">
                                        <h5 class="mb-0">Jadwal maintenance</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row bg-light rounded p-3">
                                            <div class="col-md-3 border-end">
                                                <small class="text-muted d-block mb-1">Interval (dari kategori)</small>
                                                <h6 class="mb-0 fw-bold"><?= $item['interval_maintenance_hari'] ?> hari</h6>
                                            </div>
                                            <div class="col-md-3 border-end px-3">
                                                <small class="text-muted d-block mb-1">Tanggal maintenance</small>
                                                <h6 class="mb-0 fw-bold"><?= isset($maintenance[0]) ? date('d M Y', strtotime($maintenance[0]['tanggal_maintenance'])) : '-' ?></h6>
                                            </div>
                                            <div class="col-md-3 border-end px-3">
                                                <small class="text-muted d-block mb-1">Berikutnya</small>
                                                <h6 class="mb-0 fw-bold"><?= isset($maintenance[0]) ? date('d M Y', strtotime($maintenance[0]['tanggal_maintenance'] . ' + ' . $item['interval_maintenance_hari'] . ' days')) : '-' ?></h6>
                                            </div>
                                            <div class="col-md-3 px-3 text-end">
                                                <small class="text-muted d-block mb-1">Status</small>
                                                <span class="badge bg-label-primary">Terjadwal</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Riwayat Maintenance -->
                                <div class="card">
                                    <div class="card-header border-bottom mb-3">
                                        <h5 class="mb-0">Riwayat maintenance</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if (empty($maintenance)): ?>
                                            <div class="text-center text-muted py-4">Belum ada riwayat maintenance.</div>
                                        <?php else: ?>
                                            <div class="timeline">
                                                <?php foreach ($maintenance as $m): ?>
                                                    <div class="d-flex mb-4">
                                                        <!-- Titik Timeline -->
                                                        <div class="me-3">
                                                            <div class="rounded-circle bg-primary" style="width: 12px; height: 12px; margin-top: 5px;"></div>
                                                        </div>
                                                        <!-- Konten Riwayat -->
                                                        <div class="flex-grow-1 border-bottom pb-3">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <h6 class="mb-0 fw-bold"><?= date('d F Y', strtotime($m['tanggal_maintenance'])) ?></h6>
                                                                <span class="badge bg-label-success">Selesai</span>
                                                            </div>
                                                            <p class="mb-1 text-dark"><?= $m['kesimpulan'] ?: 'Maintenance rutin dilakukan.' ?></p>
                                                            <small class="text-muted d-block">
                                                                Interval <?= $item['interval_maintenance_hari'] ?> hari &bull; berikutnya <?= date('d M Y', strtotime($m['tanggal_maintenance'] . ' + ' . $item['interval_maintenance_hari'] . ' days')) ?> &bull; petugas <?= $m['nama_petugas'] ?? 'Teknisi' ?>
                                                            </small>

                                                            <!-- Foto Kondisi (Jika ada) -->
                                                            <?php if ($m['foto_kondisi']): ?>
                                                                <div class="mt-2">
                                                                    <img src="<?= base_url('uploads/maintenance/' . $m['foto_kondisi']) ?>" class="rounded border" style="height: 60px;">
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- / Content -->
                    <!-- Modal Edit Kategori -->
                    <div class="modal fade" id="modalEditKategori" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Kategori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <!-- Action akan diisi via JavaScript -->
                                <form id="formEditKategori" method="POST">
                                    <?= csrf_field() ?>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Kategori</label>
                                            <input type="text" class="form-control" name="nama_kategori" id="edit_nama_kategori" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pilih Ikon</label>
                                            <select class="form-select" name="icon" id="edit_icon" required>
                                                <option value="bx-category">Default (Kategori)</option>
                                                <option value="bx-laptop">Elektronik (Laptop)</option>
                                                <option value="bx-chair">Non-Elektronik (Kursi)</option>
                                                <option value="bx-plus-medical">Alat Medis (Palang Medis)</option>
                                                <option value="bx-buildings">Fasilitas (Gedung)</option>
                                                <option value="bx-car">Kendaraan (Mobil)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <?= view('adds/footer'); ?>

                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/theme.js  -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Menangkap semua tombol edit
            const tombolEdit = document.querySelectorAll('.btn-edit');

            tombolEdit.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Ambil data dari atribut tombol
                    const id = this.getAttribute('data-id');
                    const nama = this.getAttribute('data-nama');
                    const icon = this.getAttribute('data-icon');

                    // Isi form di dalam modal
                    document.getElementById('edit_nama_kategori').value = nama;
                    document.getElementById('edit_icon').value = icon;

                    // Ubah action form agar mengarah ke URL update dengan ID yang benar
                    document.getElementById('formEditKategori').action = "<?= base_url('kategori/update') ?>/" + id;
                });
            });
        });
    </script>
    <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/popper/popper.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/js/bootstrap.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/@algolia/autocomplete-js.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/pickr/pickr.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/hammer/hammer.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/i18n/i18n.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/js/menu.js') ?>"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="<?= base_url('assets/js/main.js') ?>"></script>

    <!-- Page JS -->
</body>

</html>