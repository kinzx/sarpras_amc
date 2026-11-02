<!doctype html>

<html
    lang="en"
    class="layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed"
    dir="ltr"
    data-skin="default"
    data-assets-path="<?= base_url("assets/") ?>"
    data-template="vertical-menu-template"
    data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= esc($title ?? "Input Pemeliharaan") ?> | RS AMC</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="64x64" href="<?= base_url(
        "AMC-tanpa-nama-pad.png",
    ) ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(
        "AMC-tanpa-nama-pad.png",
    ) ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="<?= base_url(
        "assets/vendor/fonts/iconify-icons.css",
    ) ?>" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="<?= base_url(
        "assets/vendor/libs/pickr/pickr-themes.css",
    ) ?>" />

    <link rel="stylesheet" href="<?= base_url(
        "assets/vendor/css/core.css",
    ) ?>" />
    <link rel="stylesheet" href="<?= base_url("assets/css/demo.css") ?>" />
    <link rel="stylesheet" href="<?= base_url(
        "dist/libs/select2/select2.css",
    ) ?>" />

    <!-- FilePond CSS -->
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <style>
        .filepond--root { margin-bottom: 0; font-family: inherit; }
        .filepond--panel-root { background-color: #f8f9fa; border: 2px dashed #d9dee3; border-radius: 0.5rem; }
    </style>

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="<?= base_url(
        "assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css",
    ) ?>" />

    <!-- endbuild -->

    <!-- Helpers -->
    <script src="<?= base_url("assets/vendor/js/helpers.js") ?>"></script>

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="<?= base_url(
        "assets/vendor/js/template-customizer.js",
    ) ?>"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="<?= base_url("assets/js/config.js") ?>"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <?= view("adds/sidebar") ?>

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
                <?= view("adds/navbar") ?>
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb" class="mb-4">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= base_url(
                                    "maintenance",
                                ) ?>"><i class="bx bx-home-alt me-1"></i> Pemeliharaan</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Input Pemeliharaan</li>
                            </ol>
                        </nav>

                        <?php if (session()->getFlashdata("errors")): ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <ul class="mb-0">
                                    <?php foreach (
                                        session()->getFlashdata("errors")
                                        as $error
                                    ): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata("error")): ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <?= esc(session()->getFlashdata("error")) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php
                        $pilihanKondisi = [
                            "Baik",
                            "Cukup",
                            "Rusak Ringan",
                            "Rusak Berat",
                        ];
                        $jadwalPerhatian = array_slice(
                            array_values(
                                array_filter($jadwal ?? [], function ($j) {
                                    return (int) $j["sisa_hari"] <= 30;
                                }),
                            ),
                            0,
                            5,
                        );
                        ?>

                        <div class="row">
                            <!-- FORM -->
                            <div class="col-lg-8 mb-4">
                                <div class="card h-100">
                                    <div class="card-header border-bottom mb-4">
                                        <h5 class="card-title mb-0"><i class="bx bx-plus-circle me-2"></i> Formulir Pemeliharaan</h5>
                                    </div>

                                    <div class="card-body">
                                        <form action="<?= base_url(
                                            "maintenance/simpan",
                                        ) ?>" method="POST" enctype="multipart/form-data" id="maintenanceForm">
                                            <?= csrf_field() ?>

                                            <!-- Pilih Petugas & Filter Berjenjang -->
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-12">
                                                    <label class="form-label">Petugas / Teknisi yang Mengerjakan <span class="text-danger">*</span></label>
                                                    <select class="form-select select2" name="user_id" id="user_id" required>
                                                        <option value="">-- Pilih Petugas / Teknisi --</option>
                                                        <?php foreach (
                                                            $petugas
                                                            as $p
                                                        ): ?>
                                                            <option value="<?= $p[
                                                                "id"
                                                            ] ?>" <?= (string) old(
    "user_id",
    user_id() ?? "",
) === (string) $p["id"]
    ? "selected"
    : "" ?>>
                                                                <?= esc(
                                                                    $p[
                                                                        "username"
                                                                    ],
                                                                ) ?> (<?= esc(
     ucfirst($p["role_name"]),
 ) ?>) - <?= esc($p["email"]) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <!-- Filter Kategori & Sub-Kategori (Pencarian Berjenjang) -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Filter Kategori Barang</label>
                                                    <select class="form-select select2" id="filter_kategori">
                                                        <option value="">-- Semua Kategori --</option>
                                                        <?php foreach (
                                                            $kategori
                                                            as $k
                                                        ): ?>
                                                            <option value="<?= $k[
                                                                "id"
                                                            ] ?>"><?= esc(
    $k["nama_kategori"],
) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Filter Sub-Kategori</label>
                                                    <select class="form-select select2" id="filter_sub_kategori" disabled>
                                                        <option value="">-- Tanpa Sub-Kategori --</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Pilih Barang <span class="text-danger">*</span></label>
                                                <select class="form-select select2" name="barang_id" id="barang_id" required>
                                                    <option value="">-- Ketik nama atau kode aset untuk mencari --</option>
                                                    <?php foreach (
                                                        $barang
                                                        as $row
                                                    ): ?>
                                                        <option
                                                            value="<?= $row[
                                                                "id"
                                                            ] ?>"
                                                            data-interval="<?= (int) ($row[
                                                                "interval_maintenance_hari"
                                                            ] ?:
                                                            90) ?>"
                                                            data-last="<?= esc(
                                                                $row[
                                                                    "tanggal_perbaikan_terakhir"
                                                                ] ?? "",
                                                            ) ?>"
                                                            data-kategori="<?= esc(
                                                                $row[
                                                                    "kategori_id"
                                                                ] ?? "",
                                                            ) ?>"
                                                            data-sub="<?= esc(
                                                                $row[
                                                                    "sub_kategori_id"
                                                                ] ?? "",
                                                            ) ?>"
                                                            <?= (string) old(
                                                                "barang_id",
                                                                $barangId,
                                                            ) ===
                                                            (string) $row["id"]
                                                                ? "selected"
                                                                : "" ?>>
                                                            <?= esc(
                                                                $row[
                                                                    "nama_barang"
                                                                ],
                                                            ) ?> (<?= esc(
     $row["kode_aset"],
 ) ?>) - <?= esc($row["nama_ruang"] ?? "-") ?> [<?= esc(
     $row["kondisi_barang"] ?? "Baik",
 ) ?>]
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <small class="text-muted">Ketik nama barang, kode aset, atau saring lewat filter kategori di atas</small>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label class="form-label">Tanggal Maintenance <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" name="tanggal_maintenance" id="tanggal_maintenance" value="<?= esc(
                                                        old(
                                                            "tanggal_maintenance",
                                                        ) ?:
                                                        date("Y-m-d"),
                                                    ) ?>" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Interval Barang</label>
                                                    <input type="text" class="form-control bg-light" id="interval_display" value="90 hari" readonly>
                                                    <small class="text-muted">Mengikuti data barang</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Jadwal Berikutnya</label>
                                                    <input type="text" class="form-control bg-light" id="jadwal_berikutnya" value="-" readonly>
                                                    <small class="text-muted" id="helper_jadwal">Tanggal maintenance + interval</small>
                                                </div>
                                            </div>

                                            <hr class="my-4">

                                            <h6 class="fw-bold mb-3">Kondisi Saat Pemeriksaan</h6>
                                            <div class="row g-3">
                                                <?php
                                                $fieldKondisi = [
                                                    "kondisi_bodi" =>
                                                        "Bodi / Casing",
                                                    "kondisi_display" =>
                                                        "Display",
                                                    "kondisi_tombol" =>
                                                        "Tombol / Panel",
                                                    "kondisi_aksesoris" =>
                                                        "Aksesoris",
                                                ];
                                                foreach (
                                                    $fieldKondisi
                                                    as $name => $label
                                                ): ?>
                                                    <div class="col-md-6">
                                                        <label class="form-label"><?= $label ?> <span class="text-danger">*</span></label>
                                                        <select class="form-select" name="<?= $name ?>" required>
                                                            <?php foreach (
                                                                $pilihanKondisi
                                                                as $opsi
                                                            ): ?>
                                                                <option value="<?= $opsi ?>" <?= old(
    $name,
    "Baik",
) === $opsi
    ? "selected"
    : "" ?>><?= $opsi ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                <?php endforeach;
                                                ?>
                                            </div>

                                            <div class="mt-3">
                                                <label class="form-label">Kesimpulan / Catatan Teknisi</label>
                                                <textarea class="form-control" name="kesimpulan" rows="3" placeholder="Tuliskan hasil pemeriksaan, tindakan, atau rekomendasi..."><?= esc(
                                                    old("kesimpulan"),
                                                ) ?></textarea>
                                            </div>

                                            <div class="mt-3">
                                                <label class="form-label">Foto Kondisi (opsional)</label>
                                                <div class="rounded-3 border bg-light p-3">
                                                    <input type="file" class="filepond" id="foto_kondisi" name="foto_kondisi" accept="image/jpeg,image/png,image/webp">
                                                    <div class="small text-muted mt-2">
                                                        <i class="bx bx-info-circle me-1"></i>Format JPG, PNG, atau WEBP. Maksimal 2 MB.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-4 text-end">
                                                <a href="<?= base_url(
                                                    "maintenance",
                                                ) ?>" class="btn btn-outline-secondary me-2">Batal</a>
                                                <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- JADWAL TERDEKAT -->
                            <div class="col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-header border-bottom mb-3">
                                        <h5 class="mb-0">Perlu Pemeliharaan</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if (empty($jadwalPerhatian)): ?>
                                            <div class="text-center text-muted py-4">
                                                <i class="bx bx-calendar-check d-block mb-2" style="font-size: 2rem;"></i>
                                                Tidak ada barang yang mendekati jadwal.
                                            </div>
                                        <?php else: ?>
                                            <div class="d-flex flex-column gap-2">
                                                <?php foreach (
                                                    $jadwalPerhatian
                                                    as $j
                                                ): ?>
                                                    <?php
                                                    $sisa =
                                                        (int) $j["sisa_hari"];
                                                    if ($sisa < 0) {
                                                        $classStatus =
                                                            "bg-label-danger";
                                                        $labelStatus =
                                                            "Terlambat " .
                                                            abs($sisa) .
                                                            " hari";
                                                    } elseif ($sisa === 0) {
                                                        $classStatus =
                                                            "bg-label-warning";
                                                        $labelStatus =
                                                            "Jatuh tempo hari ini";
                                                    } else {
                                                        $classStatus =
                                                            "bg-label-warning";
                                                        $labelStatus =
                                                            $sisa .
                                                            " hari lagi";
                                                    }
                                                    ?>
                                                    <a href="<?= base_url(
                                                        "maintenance/create?barang_id=" .
                                                            $j["id"],
                                                    ) ?>" class="border rounded p-3 text-decoration-none text-reset <?= (string) $barangId ===
(string) $j["id"]
    ? "border-primary"
    : "" ?>">
                                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                                            <strong class="text-truncate me-2" title="<?= esc(
                                                                $j[
                                                                    "nama_barang"
                                                                ],
                                                            ) ?>"><?= esc(
    $j["nama_barang"],
) ?></strong>
                                                            <span class="badge <?= $classStatus ?> flex-shrink-0"><?= esc(
     $labelStatus,
 ) ?></span>
                                                        </div>
                                                        <small class="text-muted d-block font-monospace"><?= esc(
                                                            $j["kode_aset"],
                                                        ) ?></small>
                                                        <small class="text-muted d-block">Jadwal <?= date(
                                                            "d M Y",
                                                            strtotime(
                                                                $j[
                                                                    "jadwal_berikutnya"
                                                                ],
                                                            ),
                                                        ) ?></small>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->
                    <!-- Footer -->
                    <?= view("adds/footer") ?>
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
    <script src="<?= base_url(
        "assets/vendor/libs/jquery/jquery.js",
    ) ?>"></script>
    <script src="<?= base_url(
        "assets/vendor/libs/popper/popper.js",
    ) ?>"></script>
    <script src="<?= base_url("assets/vendor/js/bootstrap.js") ?>"></script>
    <script src="<?= base_url(
        "assets/vendor/libs/@algolia/autocomplete-js.js",
    ) ?>"></script>
    <script src="<?= base_url("assets/vendor/libs/pickr/pickr.js") ?>"></script>
    <script src="<?= base_url(
        "assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js",
    ) ?>"></script>
    <script src="<?= base_url(
        "assets/vendor/libs/hammer/hammer.js",
    ) ?>"></script>
    <script src="<?= base_url("assets/vendor/libs/i18n/i18n.js") ?>"></script>
    <script src="<?= base_url("assets/vendor/js/menu.js") ?>"></script>
    <script src="<?= base_url("assets/js/main.js") ?>"></script>
    <script src="<?= base_url("dist/libs/select2/select2.js") ?>"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Searchable Dropdown (Select2)
            $('.select2').select2({
                width: '100%',
                placeholder: function() {
                    return $(this).data('placeholder') || '-- Pilih --';
                }
            });

            // Logika Dependent Dropdown Kategori -> Sub-Kategori -> Barang
            $('#filter_kategori').on('change', function() {
                var katId = $(this).val();
                var $subSelect = $('#filter_sub_kategori');

                $subSelect.html('<option value="">Memuat...</option>').prop('disabled', true);

                if (katId) {
                    $.ajax({
                        url: "<?= site_url(
                            "barang/getSubKategori",
                        ) ?>/" + encodeURIComponent(katId),
                        type: "GET",
                        dataType: "JSON",
                        success: function(data) {
                            $subSelect.html('<option value="">-- Semua Sub-Kategori --</option>');
                            if (data && data.length > 0) {
                                $.each(data, function(i, item) {
                                    $subSelect.append('<option value="' + item.id + '">' + item.nama_sub_kategori + '</option>');
                                });
                                $subSelect.prop('disabled', false);
                            } else {
                                $subSelect.html('<option value="">-- Tanpa Sub-Kategori --</option>').prop('disabled', true);
                            }
                            $subSelect.trigger('change.select2');
                            muatBarangFilter();
                        },
                        error: function() {
                            $subSelect.html('<option value="">-- Gagal memuat sub --</option>').prop('disabled', true);
                            $subSelect.trigger('change.select2');
                        }
                    });
                } else {
                    $subSelect.html('<option value="">-- Tanpa Sub-Kategori --</option>').prop('disabled', true);
                    $subSelect.trigger('change.select2');
                    muatBarangFilter();
                }
            });

            $('#filter_sub_kategori').on('change', function() {
                muatBarangFilter();
            });

            function muatBarangFilter() {
                var katId = $('#filter_kategori').val();
                var subId = $('#filter_sub_kategori').val();
                var $barangSelect = $('#barang_id');

                $barangSelect.html('<option value="">Memuat daftar barang...</option>');

                $.ajax({
                    url: "<?= site_url("barang/getBarangByKategori") ?>",
                    type: "GET",
                    data: { kategori_id: katId, sub_kategori_id: subId },
                    dataType: "JSON",
                    success: function(res) {
                        $barangSelect.html('<option value="">-- Ketik nama atau kode aset untuk mencari --</option>');
                        if (res && res.length > 0) {
                            $.each(res, function(i, b) {
                                var ruang = b.nama_ruang ? b.nama_ruang : '-';
                                var optText = b.nama_barang + ' (' + b.kode_aset + ') - ' + ruang + ' [' + (b.kondisi_barang || 'Baik') + ']';
                                var opt = $('<option></option>')
                                    .val(b.id)
                                    .text(optText)
                                    .attr('data-interval', b.interval_maintenance_hari || 90);
                                $barangSelect.append(opt);
                            });
                        } else {
                            $barangSelect.html('<option value="">-- Tidak ada barang di kategori ini --</option>');
                        }
                        $barangSelect.trigger('change');
                    }
                });
            }

            function hitungJadwal() {
                var interval = parseInt($('#barang_id option:selected').data('interval'), 10) || 90;
                $('#interval_display').val(interval + ' hari');

                var tgl = $('#tanggal_maintenance').val();
                if (!tgl) {
                    $('#jadwal_berikutnya').val('-');
                    return;
                }

                var d = new Date(tgl);
                if (isNaN(d.getTime())) {
                    $('#jadwal_berikutnya').val('-');
                    return;
                }

                d.setDate(d.getDate() + interval);
                var options = { day: '2-digit', month: 'short', year: 'numeric' };
                $('#jadwal_berikutnya').val(d.toLocaleDateString('id-ID', options));
                $('#helper_jadwal').text('Tanggal maintenance + ' + interval + ' hari');
            }

            $('#barang_id, #tanggal_maintenance').on('change input', hitungJadwal);
            hitungJadwal();
        });
    </script>

    <!-- FilePond JS -->
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script>
        FilePond.registerPlugin(
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize,
            FilePondPluginImagePreview
        );

        FilePond.create(document.getElementById('foto_kondisi'), {
            storeAsFile: true,
            allowMultiple: false,
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/webp'],
            maxFileSize: '2MB',
            labelIdle: '<span class="filepond--label-action"><i class="bx bx-cloud-upload fs-2 d-block text-primary mb-1"></i>Pilih atau seret foto kondisi</span>',
            labelFileTypeNotAllowed: 'Format berkas tidak valid',
            fileValidateTypeLabelExpectedTypes: 'Hanya JPG, PNG, atau WEBP',
            labelMaxFileSizeExceeded: 'Ukuran foto terlalu besar',
            labelMaxFileSize: 'Maksimal 2 MB'
        });
    </script>

    <!-- Page JS -->
    <a href="<?= base_url(
        "scan",
    ) ?>" class="btn btn-primary rounded-circle shadow-lg position-fixed d-flex align-items-center justify-content-center"
        style="width: 65px; height: 65px; bottom: 30px; right: 30px; z-index: 9999;">
        <i class="bx bx-qr-scan text-white" style="font-size: 2rem;"></i>
    </a>
</body>

</html>
