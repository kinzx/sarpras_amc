<!doctype html>
<html lang="id" class="layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed" dir="ltr" data-skin="default" data-assets-path="../../assets/" data-template="vertical-menu-template" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title><?= esc($title ?? "Edit Barang") ?> | AMC</title>

    <link rel="icon" type="image/png" sizes="64x64" href="<?= base_url(
        "AMC-tanpa-nama-pad.png",
    ) ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(
        "AMC-tanpa-nama-pad.png",
    ) ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/iconify-icons.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- FilePond CSS -->
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
    <style>
        .filepond--root { margin-bottom: 0; font-family: inherit; }
        .filepond--panel-root { background-color: #f8f9fa; border: 2px dashed #d9dee3; border-radius: 0.5rem; }
    </style>

    <script src="../../assets/vendor/js/helpers.js"></script>
    <script src="../../assets/vendor/js/template-customizer.js"></script>
    <script src="../../assets/js/config.js"></script>
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?= view("adds/sidebar") ?>

            <div class="menu-mobile-toggler d-xl-none rounded-1">
                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
                    <i class="bx bx-menu icon-base"></i>
                    <i class="bx bx-chevron-right icon-base"></i>
                </a>
            </div>

            <div class="layout-page">
                <?= view("adds/navbar") ?>

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <nav aria-label="breadcrumb" class="mb-4">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= base_url(
                                    "barang",
                                ) ?>">Inventaris Alat</a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url(
                                    "barang/detail/" . $barang["id"],
                                ) ?>"><?= esc(
    $barang["nama_barang"],
) ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Barang</li>
                            </ol>
                        </nav>

                        <div class="card">
                            <div class="card-header border-bottom mb-4">
                                <h5 class="card-title mb-0"><i class="bx bx-edit me-2"></i> Formulir Edit Barang</h5>
                            </div>

                            <div class="card-body">
                                <?php if (session()->getFlashdata("errors")): ?>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <ul class="mb-0">
                                            <?php foreach (
                                                session()->getFlashdata(
                                                    "errors",
                                                )
                                                as $error
                                            ): ?>
                                                <li><?= esc($error) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>

                                <form action="<?= base_url(
                                    "barang/update/" . $barang["id"],
                                ) ?>" method="POST" enctype="multipart/form-data" id="barangForm">
                                    <?= csrf_field() ?>

                                    <div class="row g-3">
                                        <!-- Kolom Kiri -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Kode barang</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light" value="<?= esc(
                                                        $barang["kode_aset"],
                                                    ) ?>" readonly>
                                                    <span class="input-group-text"><i class="bx bx-barcode"></i></span>
                                                </div>
                                                <small class="text-muted">Kode barcode unik barang (tidak dapat diubah)</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                                <select class="form-select" name="kategori_id" id="kategori_id" required>
                                                    <option value="">-- Pilih Kategori --</option>
                                                    <?php foreach (
                                                        $kategori
                                                        as $row
                                                    ): ?>
                                                        <option value="<?= $row[
                                                            "id"
                                                        ] ?>" <?= old(
    "kategori_id",
    $barang["kategori_id"],
) == $row["id"]
    ? "selected"
    : "" ?>><?= esc($row["nama_kategori"]) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Sub Kategori <small class="text-muted">(Opsional)</small></label>
                                                <select class="form-select" name="sub_kategori_id" id="sub_kategori_id">
                                                    <option value="">-- Tanpa Sub Kategori --</option>
                                                    <?php foreach (
                                                        $subKategori
                                                        as $row
                                                    ): ?>
                                                        <option value="<?= $row[
                                                            "id"
                                                        ] ?>" <?= old(
    "sub_kategori_id",
    $barang["sub_kategori_id"],
) == $row["id"]
    ? "selected"
    : "" ?>><?= esc($row["nama_sub_kategori"]) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <small class="text-muted">Sub kategori barang (bisa dikosongkan jika tidak ada)</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Merek <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="merek" value="<?= esc(
                                                    old(
                                                        "merek",
                                                        $barang["merek"],
                                                    ),
                                                ) ?>" placeholder="Contoh: Daikin" required>
                                                <small class="text-muted">Merek atau brand barang</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">No. Seri <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="no_seri" value="<?= esc(
                                                    old(
                                                        "no_seri",
                                                        $barang["no_seri"],
                                                    ),
                                                ) ?>" placeholder="Masukkan nomor seri barang" required>
                                                <small class="text-muted">Masukkan nomor seri barang</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Daya (Watt) <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="daya" value="<?= esc(
                                                    old(
                                                        "daya",
                                                        $barang["daya"],
                                                    ),
                                                ) ?>" placeholder="Contoh: 1900" required>
                                                <small class="text-muted">Daya listrik yang dibutuhkan</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label d-block">Kepemilikan <span class="text-danger">*</span></label>
                                                <?php $kepemilikan = old(
                                                    "kepemilikan",
                                                    $barang["kepemilikan"] ??
                                                        "RS",
                                                ); ?>
                                                <div class="d-flex align-items-center gap-4 mt-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="kepemilikan" id="kepemilikan_rs" value="RS" <?= $kepemilikan ===
                                                        "RS"
                                                            ? "checked"
                                                            : "" ?> required>
                                                        <label class="form-check-label" for="kepemilikan_rs">RS</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="kepemilikan" id="kepemilikan_kso" value="KSO" <?= $kepemilikan ===
                                                        "KSO"
                                                            ? "checked"
                                                            : "" ?>>
                                                        <label class="form-check-label" for="kepemilikan_kso">KSO</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="kepemilikan" id="kepemilikan_pt" value="PT" <?= $kepemilikan ===
                                                        "PT"
                                                            ? "checked"
                                                            : "" ?>>
                                                        <label class="form-check-label" for="kepemilikan_pt">PT</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Kolom Kanan -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="nama_barang" value="<?= esc(
                                                    old(
                                                        "nama_barang",
                                                        $barang["nama_barang"],
                                                    ),
                                                ) ?>" placeholder="Masukkan nama barang" required>
                                                <small class="text-muted">Masukkan nama barang</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Ruangan <span class="text-danger">*</span></label>
                                                <select class="form-select" name="ruang_id" id="ruang_id" required>
                                                    <option value="">-- Pilih Ruangan --</option>
                                                    <?php foreach (
                                                        $ruang
                                                        as $row
                                                    ): ?>
                                                        <option value="<?= $row[
                                                            "id"
                                                        ] ?>" data-lantai="<?= esc(
    $row["lantai"] ?? "",
) ?>" <?= old("ruang_id", $barang["ruang_id"]) == $row["id"]
    ? "selected"
    : "" ?>><?= esc($row["nama_ruang"]) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <small class="text-muted">Pilih ruangan tempat barang berada</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Lantai <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control bg-light" id="lantai_display" placeholder="Otomatis mengikuti data ruangan" readonly>
                                                <small class="text-muted">Otomatis mengikuti data ruangan</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Tipe <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="tipe" value="<?= esc(
                                                    old(
                                                        "tipe",
                                                        $barang["tipe"],
                                                    ),
                                                ) ?>" placeholder="Contoh: Inverter / Wall Mounted" required>
                                                <small class="text-muted">Tipe atau model barang</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Tahun Pembelian <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="tahun_pembelian" value="<?= esc(
                                                    old(
                                                        "tahun_pembelian",
                                                        $barang[
                                                            "tahun_pembelian"
                                                        ],
                                                    ),
                                                ) ?>" placeholder="<?= date(
    "Y",
) ?>" min="1990" max="<?= date("Y") ?>" required>
                                                <small class="text-muted">Tahun pembelian barang</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                                                <?php $kondisi = old(
                                                    "kondisi_barang",
                                                    $barang["kondisi_barang"] ??
                                                        "Baik",
                                                ); ?>
                                                <select class="form-select" name="kondisi_barang" required>
                                                    <option value="Baik" <?= $kondisi ===
                                                    "Baik"
                                                        ? "selected"
                                                        : "" ?>>Baik</option>
                                                    <option value="Cukup" <?= $kondisi ===
                                                    "Cukup"
                                                        ? "selected"
                                                        : "" ?>>Cukup</option>
                                                    <option value="Rusak Ringan" <?= $kondisi ===
                                                    "Rusak Ringan"
                                                        ? "selected"
                                                        : "" ?>>Rusak Ringan</option>
                                                    <option value="Rusak Berat" <?= $kondisi ===
                                                    "Rusak Berat"
                                                        ? "selected"
                                                        : "" ?>>Rusak Berat</option>
                                                </select>
                                                <small class="text-muted">Default Baik. Diperbarui lewat menu Pemeliharaan</small>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                                <?php $isActive = old(
                                                    "is_active",
                                                    (string) $barang[
                                                        "is_active"
                                                    ],
                                                ); ?>
                                                <select class="form-select" name="is_active" required>
                                                    <option value="1" <?= $isActive ===
                                                    "1"
                                                        ? "selected"
                                                        : "" ?>>Aktif</option>
                                                    <option value="0" <?= $isActive ===
                                                    "0"
                                                        ? "selected"
                                                        : "" ?>>Nonaktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Upload Foto & Keterangan -->
                                    <div class="row g-3 mt-2">
                                        <div class="col-12">
                                            <label class="form-label">Foto Barang</label>
                                            <div class="rounded-3 border bg-light p-3">
                                                <input type="file" class="filepond" id="foto" name="foto" accept="image/jpeg,image/png,image/webp">
                                                <div class="small text-muted mt-2">
                                                    <i class="bx bx-info-circle me-1"></i>JPG, PNG, atau WEBP. Maksimal 2 MB (Kosongkan jika tetap memakai foto lama).
                                                    <?php if (
                                                        !empty($barang["foto"])
                                                    ): ?>
                                                        <div class="mt-1 text-primary">
                                                            <i class="bx bx-image me-1"></i>Foto saat ini: <strong><?= esc(
                                                                $barang["foto"],
                                                            ) ?></strong>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Keterangan Tambahan</label>
                                            <textarea class="form-control" name="keterangan" rows="3" placeholder="Catatan Tambahan mengenai kondisi barang"><?= esc(
                                                old(
                                                    "keterangan",
                                                    $barang["keterangan"],
                                                ),
                                            ) ?></textarea>
                                        </div>
                                    </div>

                                    <!-- Jadwal Maintenance -->
                                    <div class="mt-4 pt-2">
                                        <h5 class="fw-bold mb-3">Jadwal Maintenance</h5>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Tanggal Masuk / Servis Terakhir</label>
                                                <input type="date" class="form-control" name="tanggal_perbaikan_terakhir" id="tanggal_perbaikan_terakhir" value="<?= esc(
                                                    old(
                                                        "tanggal_perbaikan_terakhir",
                                                        $barang[
                                                            "tanggal_perbaikan_terakhir"
                                                        ] ?? date("Y-m-d"),
                                                    ),
                                                ) ?>" required>
                                                <small class="text-muted">Tanggal barang mulai aktif / servis terakhir</small>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Interval Maintenance (Hari)</label>
                                                <input type="number" class="form-control" name="interval_maintenance_hari" id="interval_maintenance_hari" value="<?= esc(
                                                    old(
                                                        "interval_maintenance_hari",
                                                        $barang[
                                                            "interval_maintenance_hari"
                                                        ] ?? "90",
                                                    ),
                                                ) ?>" min="1" max="1825" required>
                                                <small class="text-muted">Bisa disesuaikan per unit barang</small>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Jadwal Ganti Berikutnya</label>
                                                <input type="text" class="form-control bg-light" id="jadwal_berikutnya" placeholder="Terhitung otomatis..." readonly>
                                                <small class="text-muted" id="helper_jadwal">Tanggal acuan + interval hari</small>
                                            </div>
                                        </div>

                                        <div class="alert alert-primary d-flex align-items-center mt-3 mb-0" role="alert">
                                            <i class="bx bx-info-circle me-2 fs-5"></i>
                                            <div class="small">
                                                Setiap barang memiliki tanggal acuan dan interval sendiri. Siklus pemeliharaan berikutnya akan berulang otomatis di menu <strong>Pemeliharaan</strong>.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tombol Aksi -->
                                    <div class="mt-4 text-end">
                                        <a href="<?= base_url(
                                            "barang",
                                        ) ?>" class="btn btn-outline-secondary me-2">Batal</a>
                                        <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Perubahan</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <?= view("adds/footer") ?>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>

    <!-- Core JS -->
    <script src="<?= base_url(
        "assets/vendor/libs/jquery/jquery.js",
    ) ?>"></script>
    <script src="<?= base_url(
        "assets/vendor/libs/popper/popper.js",
    ) ?>"></script>
    <script src="<?= base_url("assets/vendor/js/bootstrap.js") ?>"></script>
    <script src="<?= base_url(
        "assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js",
    ) ?>"></script>
    <script src="<?= base_url("assets/vendor/js/menu.js") ?>"></script>
    <script src="<?= base_url("assets/js/main.js") ?>"></script>

    <script>
        $(document).ready(function() {
            function updateLantai() {
                var selected = $('#ruang_id option:selected');
                var lantai = selected.data('lantai');
                if (lantai !== undefined && lantai !== '') {
                    $('#lantai_display').val('Lantai ' + lantai);
                } else {
                    $('#lantai_display').val('');
                }
            }

            $('#ruang_id').change(updateLantai);
            updateLantai();

            function hitungJadwalBerikutnya() {
                var tgl = $('#tanggal_perbaikan_terakhir').val();
                var interval = parseInt($('#interval_maintenance_hari').val(), 10) || 90;

                if (!tgl) {
                    $('#jadwal_berikutnya').val('');
                    return;
                }

                var d = new Date(tgl);
                if (isNaN(d.getTime())) {
                    $('#jadwal_berikutnya').val('');
                    return;
                }

                d.setDate(d.getDate() + interval);
                var options = { day: '2-digit', month: 'short', year: 'numeric' };
                $('#jadwal_berikutnya').val(d.toLocaleDateString('id-ID', options));
                $('#helper_jadwal').text('Tanggal acuan + ' + interval + ' hari');
            }

            $('#tanggal_perbaikan_terakhir, #interval_maintenance_hari').on('input change', hitungJadwalBerikutnya);
            hitungJadwalBerikutnya();

            $('#kategori_id').change(function() {
                var kategori_id = $(this).val();
                $('#sub_kategori_id').html('<option value="">Loading...</option>').prop('disabled', true);

                if (kategori_id) {
                    $.ajax({
                        url: "<?= site_url(
                            "barang/getSubKategori",
                        ) ?>/" + encodeURIComponent(kategori_id),
                        type: "GET",
                        dataType: "JSON",
                        success: function(data) {
                            $('#sub_kategori_id').prop('disabled', false);
                            $('#sub_kategori_id').html('<option value="">-- Tanpa Sub Kategori (Opsional) --</option>');
                            if (data.length > 0) {
                                $.each(data, function(key, value) {
                                    $('#sub_kategori_id').append('<option value="' + value.id + '">' + value.nama_sub_kategori + '</option>');
                                });
                            } else {
                                $('#sub_kategori_id').html('<option value="">-- Tidak ada sub kategori (Opsional) --</option>');
                            }
                        },
                        error: function(xhr) {
                            var status = xhr.status ? ' (HTTP ' + xhr.status + ')' : '';
                            var isLoginRedirect = xhr.responseURL && xhr.responseURL.indexOf('/login') !== -1;
                            var message = isLoginRedirect
                                ? 'Sesi login berakhir. Silakan login ulang.'
                                : 'Gagal memuat sub kategori' + status;
                            $('#sub_kategori_id').prop('disabled', true).html('<option value="">' + message + '</option>');
                        }
                    });
                } else {
                    $('#sub_kategori_id').prop('disabled', true);
                    $('#sub_kategori_id').html('<option value="">-- Pilih Sub Kategori --</option>');
                }
            });
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

        FilePond.create(document.getElementById('foto'), {
            storeAsFile: true,
            allowMultiple: false,
            acceptedFileTypes: ['image/jpeg', 'image/png', 'image/webp'],
            maxFileSize: '2MB',
            labelIdle: '<span class="filepond--label-action"><i class="bx bx-cloud-upload fs-2 d-block text-primary mb-1"></i>Pilih atau seret foto baru</span>',
            labelFileTypeNotAllowed: 'Format berkas tidak valid',
            fileValidateTypeLabelExpectedTypes: 'Hanya JPG, PNG, atau WEBP',
            labelMaxFileSizeExceeded: 'Ukuran foto terlalu besar',
            labelMaxFileSize: 'Maksimal 2 MB'
        });
    </script>
</body>
</html>
