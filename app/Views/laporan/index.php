<!doctype html>
<html lang="id" class="layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed" dir="ltr" data-skin="default" data-assets-path="../../assets/" data-template="vertical-menu-template" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title><?= esc($title ?? "Laporan") ?> | AMC</title>

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

    <style>
        @media print {
            .layout-menu, .layout-navbar, .footer, .btn, .breadcrumb, .card-header .row, .filter-box {
                display: none !important;
            }
            .content-wrapper, .container-xxl, .card {
                padding: 0 !important;
                margin: 0 !important;
                box-shadow: none !important;
                border: none !important;
            }
            .print-header {
                display: block !important;
            }
        }
        .print-header { display: none; }
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

                        <!-- Header & Breadcrumb -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="fw-bold mb-1"><i class="bx bx-bar-chart-alt-2 me-2"></i>Pusat Laporan Sarpras</h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="<?= base_url(
                                            "dashboard",
                                        ) ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Laporan</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" onclick="window.print()" class="btn btn-outline-secondary">
                                    <i class="bx bx-printer me-1"></i> Cetak / PDF
                                </button>
                                <button type="button" class="btn btn-success" onclick="alert('Export Excel dapat dihubungkan ke library PhpSpreadsheet')">
                                    <i class="bx bx-file me-1"></i> Export Excel
                                </button>
                            </div>
                        </div>

                        <!-- 1. Ringkasan Kartu Statistik -->
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6 col-lg-4">
                                <div class="card card-border-shadow-primary h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="avatar avatar-md me-3 bg-label-primary rounded p-2">
                                            <i class="bx bx-box fs-3"></i>
                                        </div>
                                        <div>
                                            <span class="text-muted d-block small">Total Aset Aktif</span>
                                            <h4 class="mb-0 fw-bold"><?= number_format(
                                                $statistik["total_barang"] ?? 0,
                                            ) ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="card card-border-shadow-success h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="avatar avatar-md me-3 bg-label-success rounded p-2">
                                            <i class="bx bx-check-circle fs-3"></i>
                                        </div>
                                        <div>
                                            <span class="text-muted d-block small">Kondisi Baik</span>
                                            <h4 class="mb-0 fw-bold"><?= number_format(
                                                $statistik["total_baik"] ?? 0,
                                            ) ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <div class="card card-border-shadow-danger h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="avatar avatar-md me-3 bg-label-danger rounded p-2">
                                            <i class="bx bx-wrench fs-3"></i>
                                        </div>
                                        <div>
                                            <span class="text-muted d-block small">Perlu Perbaikan / Rusak</span>
                                            <h4 class="mb-0 fw-bold"><?= number_format(
                                                $statistik["total_rusak"] ?? 0,
                                            ) ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Kotak Filter Laporan -->
                        <div class="card mb-4 filter-box">
                            <div class="card-header border-bottom py-3">
                                <h6 class="mb-0 fw-semibold"><i class="bx bx-filter-alt me-2"></i>Filter Parameter Laporan</h6>
                            </div>
                            <div class="card-body pt-3">
                                <form method="GET" action="<?= base_url(
                                    "laporan",
                                ) ?>">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label small fw-semibold">Jenis Laporan</label>
                                            <select class="form-select form-select-sm" name="jenis" onchange="this.form.submit()">
                                                <option value="inventaris" <?= $jenisLaporan ===
                                                "inventaris"
                                                    ? "selected"
                                                    : "" ?>>Inventaris Seluruh Barang</option>
                                                <option value="maintenance" <?= $jenisLaporan ===
                                                "maintenance"
                                                    ? "selected"
                                                    : "" ?>>Jadwal Pemeliharaan</option>
                                                <option value="perbaikan" <?= $jenisLaporan ===
                                                "perbaikan"
                                                    ? "selected"
                                                    : "" ?>>Riwayat Perbaikan</option>
                                                <option value="kalibrasi" <?= $jenisLaporan ===
                                                "kalibrasi"
                                                    ? "selected"
                                                    : "" ?>>Status Kalibrasi</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small fw-semibold">Kategori</label>
                                            <select class="form-select form-select-sm" name="kategori_id">
                                                <option value="">Semua Kategori</option>
                                                <?php foreach (
                                                    $kategoriList
                                                    as $kat
                                                ): ?>
                                                    <option value="<?= $kat[
                                                        "id"
                                                    ] ?>" <?= $filters[
    "kategori_id"
] == $kat["id"]
    ? "selected"
    : "" ?>><?= esc($kat["nama_kategori"]) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small fw-semibold">Ruangan</label>
                                            <select class="form-select form-select-sm" name="ruang_id">
                                                <option value="">Semua Ruangan</option>
                                                <?php foreach (
                                                    $ruangList
                                                    as $rng
                                                ): ?>
                                                    <option value="<?= $rng[
                                                        "id"
                                                    ] ?>" <?= $filters[
    "ruang_id"
] == $rng["id"]
    ? "selected"
    : "" ?>><?= esc($rng["nama_ruang"]) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small fw-semibold">Kondisi Barang</label>
                                            <select class="form-select form-select-sm" name="kondisi">
                                                <option value="">Semua Kondisi</option>
                                                <option value="Baik" <?= $filters[
                                                    "kondisi"
                                                ] === "Baik"
                                                    ? "selected"
                                                    : "" ?>>Baik</option>
                                                <option value="Cukup" <?= $filters[
                                                    "kondisi"
                                                ] === "Cukup"
                                                    ? "selected"
                                                    : "" ?>>Cukup</option>
                                                <option value="Rusak Ringan" <?= $filters[
                                                    "kondisi"
                                                ] === "Rusak Ringan"
                                                    ? "selected"
                                                    : "" ?>>Rusak Ringan</option>
                                                <option value="Rusak Berat" <?= $filters[
                                                    "kondisi"
                                                ] === "Rusak Berat"
                                                    ? "selected"
                                                    : "" ?>>Rusak Berat</option>
                                            </select>
                                        </div>
                                        <div class="col-12 text-end">
                                            <a href="<?= base_url(
                                                "laporan",
                                            ) ?>" class="btn btn-sm btn-outline-secondary me-2">Reset</a>
                                            <button type="submit" class="btn btn-sm btn-primary"><i class="bx bx-search me-1"></i>Terapkan Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- 3. Tabel Data Laporan -->
                        <div class="card">
                            <div class="print-header p-4 text-center border-bottom">
                                <h3 class="mb-1 fw-bold">RUMAH SAKIT AMC MUHAMMADIYAH</h3>
                                <p class="text-muted mb-0 small">Laporan Inventarisasi Sarana & Prasarana</p>
                                <small class="text-muted">Dicetak pada: <?= date(
                                    "d M Y, H:i",
                                ) ?></small>
                            </div>

                            <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-semibold">Data Hasil Laporan (<?= count(
                                    $laporanData,
                                ) ?> Item)</h6>
                                <span class="badge bg-label-info text-capitalize"><?= esc(
                                    $jenisLaporan,
                                ) ?></span>
                            </div>

                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px;">No</th>
                                            <th>Kode Aset</th>
                                            <th>Nama Barang</th>
                                            <th>Kategori / Sub</th>
                                            <th>Ruang & Lantai</th>
                                            <th>Kondisi</th>
                                            <th>Terakhir Diservis</th>
                                            <th>Jadwal Berikutnya</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        <?php if (empty($laporanData)): ?>
                                            <tr>
                                                <td colspan="8" class="text-center py-4 text-muted">
                                                    <i class="bx bx-info-circle fs-3 d-block mb-1"></i>
                                                    Tidak ada data yang cocok dengan kriteria filter.
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php
                                            $no = 1;
                                            foreach ($laporanData as $row): ?>
                                                <?php
                                                $tglServis =
                                                    $row[
                                                        "tanggal_perbaikan_terakhir"
                                                    ];
                                                $interval =
                                                    $row[
                                                        "interval_maintenance_hari"
                                                    ] ?:
                                                    90;
                                                $jadwalBerikut = "-";
                                                $statusBadge =
                                                    "bg-label-success";
                                                if (!empty($tglServis)) {
                                                    $nextTime = strtotime(
                                                        $tglServis .
                                                            " + $interval days",
                                                    );
                                                    $jadwalBerikut = date(
                                                        "d M Y",
                                                        $nextTime,
                                                    );
                                                    $diffDays = ceil(
                                                        ($nextTime - time()) /
                                                            86400,
                                                    );
                                                    if ($diffDays < 0) {
                                                        $statusBadge =
                                                            "bg-label-danger";
                                                    } elseif ($diffDays <= 14) {
                                                        $statusBadge =
                                                            "bg-label-warning";
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td>
                                                        <span class="fw-semibold text-primary"><?= esc(
                                                            $row["kode_aset"],
                                                        ) ?></span>
                                                    </td>
                                                    <td>
                                                        <strong><?= esc(
                                                            $row["nama_barang"],
                                                        ) ?></strong>
                                                        <?php if (
                                                            !empty(
                                                                $row["merek"]
                                                            )
                                                        ): ?>
                                                            <small class="text-muted d-block"><?= esc(
                                                                $row["merek"],
                                                            ) ?> <?= esc(
     $row["tipe"] ?? "",
 ) ?></small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <span><?= esc(
                                                            $row[
                                                                "nama_kategori"
                                                            ] ?? "-",
                                                        ) ?></span>
                                                        <small class="text-muted d-block"><?= esc(
                                                            $row[
                                                                "nama_sub_kategori"
                                                            ] ?? "-",
                                                        ) ?></small>
                                                    </td>
                                                    <td>
                                                        <span><?= esc(
                                                            $row[
                                                                "nama_ruang"
                                                            ] ?? "-",
                                                        ) ?></span>
                                                        <small class="text-muted d-block">Lantai <?= esc(
                                                            $row["lantai"] ??
                                                                "-",
                                                        ) ?></small>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-label-info"><?= esc(
                                                            $row[
                                                                "kondisi_barang"
                                                            ] ?? "Baik",
                                                        ) ?></span>
                                                    </td>
                                                    <td>
                                                        <?= !empty(
                                                            $row[
                                                                "tanggal_perbaikan_terakhir"
                                                            ]
                                                        )
                                                            ? date(
                                                                "d M Y",
                                                                strtotime(
                                                                    $row[
                                                                        "tanggal_perbaikan_terakhir"
                                                                    ],
                                                                ),
                                                            )
                                                            : '<span class="text-muted">-</span>' ?>
                                                    </td>
                                                    <td>
                                                        <?php if (
                                                            $jadwalBerikut !==
                                                            "-"
                                                        ): ?>
                                                            <span class="badge <?= $statusBadge ?>"><?= $jadwalBerikut ?></span>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach;
                                            ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
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
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../assets/vendor/js/menu.js"></script>
    <script src="../../assets/js/main.js"></script>
</body>
</html>
