<!doctype html>

<html
    lang="en"
    class="layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed"
    dir="ltr"
    data-skin="default"
    data-assets-path="../../assets/"
    data-template="vertical-menu-template"
    data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Barang | AMC</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="../../assets/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="../../assets/vendor/libs/pickr/pickr-themes.css" />

    <link rel="stylesheet" href="../../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="../../assets/vendor/js/template-customizer.js"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="../../assets/js/config.js"></script>
</head>

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
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb" class="mb-4">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= base_url('barang') ?>">Inventaris Alat</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tambah Barang</li>
                            </ol>
                        </nav>

                        <div class="card">
                            <div class="card-header border-bottom mb-4">
                                <h5 class="card-title mb-0"><i class="bx bx-plus-circle me-2"></i> Formulir Tambah Barang</h5>
                            </div>

                            <div class="card-body">
                                <!-- ACTION mengarah ke fungsi simpan di Controller -->
                                <form action="<?= base_url('barang/simpan') ?>" method="POST" enctype="multipart/form-data">
                                    <?= csrf_field() ?>

                                    <div class="row">
                                        <!-- Kolom Kiri: Informasi Utama -->
                                        <div class="col-md-6 mb-4">
                                            <h6 class="text-primary mb-3">Informasi Utama</h6>

                                            <div class="mb-3">
                                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                                <select class="form-select" name="kategori_id" id="kategori_id" required>
                                                    <option value="">-- Pilih Kategori --</option>
                                                    <?php foreach ($kategori as $row): ?>
                                                        <option value="<?= $row['id'] ?>"><?= $row['nama_kategori'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Sub Kategori (Opsional)</label>
                                                <select class="form-select" name="sub_kategori_id" id="sub_kategori_id" disabled>
                                                    <option value="">-- Pilih Sub Kategori --</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="nama_barang" placeholder="Contoh: Ventilator Hamilton C1" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Merek</label>
                                                <input type="text" class="form-control" name="merek" placeholder="Contoh: Hamilton Medical">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Tipe</label>
                                                <input type="text" class="form-control" name="tipe" placeholder="Contoh: C1 Intelligent">
                                            </div>
                                        </div>

                                        <!-- Kolom Kanan: Spesifikasi & Lokasi -->
                                        <div class="col-md-6 mb-4">
                                            <h6 class="text-primary mb-3">Spesifikasi & Lokasi</h6>

                                            <div class="mb-3">
                                                <label class="form-label">Lokasi Ruangan <span class="text-danger">*</span></label>
                                                <select class="form-select" name="ruang_id" required>
                                                    <option value="">-- Pilih Ruangan --</option>
                                                    <?php foreach ($ruang as $row): ?>
                                                        <option value="<?= $row['id'] ?>"><?= $row['nama_ruang'] ?> (Lantai <?= $row['lantai'] ?>)</option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Nomor Seri</label>
                                                <input type="text" class="form-control" name="no_seri" placeholder="Contoh: SN-123456789">
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Daya</label>
                                                    <input type="text" class="form-control" name="daya" placeholder="Contoh: 220V / 150W">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Tahun Pembelian</label>
                                                    <input type="number" class="form-control" name="tahun_pembelian" placeholder="Contoh: 2023" min="1990" max="<?= date('Y') ?>">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Interval Maintenance (Hari)</label>
                                                <input type="number" class="form-control" name="interval_maintenance_hari" value="90" placeholder="Default: 90 hari">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Kepemilikan</label>
                                                <select class="form-select" name="kepemilikan">
                                                    <option value="milik_rs">Milik RS</option>
                                                    <option value="milik_vendor">Milik Vendor</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Bagian Bawah: Foto & Keterangan -->
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Foto Barang</label>
                                            <input type="file" class="form-control" name="foto" accept="image/*">
                                            <small class="text-muted">Format: JPG/PNG. Max: 2MB.</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Keterangan Tambahan</label>
                                            <textarea class="form-control" name="keterangan" rows="3" placeholder="Catatan tambahan mengenai kondisi atau posisi barang..."></textarea>
                                        </div>
                                    </div>

                                    <!-- Tombol Aksi -->
                                    <div class="mt-4 text-end">
                                        <a href="<?= base_url('barang') ?>" class="btn btn-outline-secondary me-2">Batal</a>
                                        <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Barang</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->
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

    <script>
        $(document).ready(function() {
            $('#kategori_id').change(function() {
                var kategori_id = $(this).val();
                $('#sub_kategori_id').html('<option value="">Loading...</option>').prop('disabled', true);

                if (kategori_id) {
                    $.ajax({
                        url: "<?= base_url('barang/getSubKategori') ?>",
                        type: "POST",
                        data: {
                            kategori_id: kategori_id
                        },
                        dataType: "JSON",
                        success: function(data) {
                            $('#sub_kategori_id').prop('disabled', false);
                            $('#sub_kategori_id').html('<option value="">-- Pilih Sub Kategori --</option>');
                            $.each(data, function(key, value) {
                                $('#sub_kategori_id').append('<option value="' + value.id + '">' + value.nama_sub_kategori + '</option>');
                            });
                        }
                    });
                } else {
                    $('#sub_kategori_id').prop('disabled', true);
                    $('#sub_kategori_id').html('<option value="">-- Pilih Sub Kategori --</option>');
                }
            });
        });
    </script>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/theme.js  -->

    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>

    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/@algolia/autocomplete-js.js"></script>

    <script src="../../assets/vendor/libs/pickr/pickr.js"></script>

    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../../assets/vendor/libs/hammer/hammer.js"></script>

    <script src="../../assets/vendor/libs/i18n/i18n.js"></script>

    <script src="../../assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->

    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->
    <a href="<?= base_url('scan') ?>" class="btn btn-primary rounded-circle shadow-lg position-fixed d-flex align-items-center justify-content-center"
        style="width: 65px; height: 65px; bottom: 30px; right: 30px; z-index: 9999;">
        <i class="bx bx-qr-scan text-white" style="font-size: 2rem;"></i>
    </a>
</body>

</html>