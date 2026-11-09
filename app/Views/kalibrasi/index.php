<!doctype html>
<html lang="id" class="layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed" dir="ltr" data-skin="default" data-assets-path="<?= base_url(
    "assets/",
) ?>" data-template="vertical-menu-template" data-bs-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $title ?? "Kalibrasi Alat" ?> | RS AMC</title>
  <link rel="icon" type="image/png" sizes="64x64" href="<?= base_url(
      "AMC-tanpa-nama-pad.png",
  ) ?>" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(
      "AMC-tanpa-nama-pad.png",
  ) ?>" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url(
      "assets/vendor/fonts/iconify-icons.css",
  ) ?>" />
  <link rel="stylesheet" href="<?= base_url(
      "assets/vendor/libs/pickr/pickr-themes.css",
  ) ?>" />
  <link rel="stylesheet" href="<?= base_url("assets/vendor/css/core.css") ?>" />
  <link rel="stylesheet" href="<?= base_url("assets/css/demo.css") ?>" />
  <link rel="stylesheet" href="<?= base_url("assets/css/industrial.css") ?>" />

  <!-- FilePond CSS -->
  <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
  <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet" />
  
  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    .filepond--root { margin-bottom: 0; font-family: inherit; }
    .filepond--panel-root { background-color: #f8f9fa; border: 2px dashed #d9dee3; border-radius: 0.5rem; }
    
    /* Select2 Bootstrap 5 & Industrial Integration */
    .select2-container--default .select2-selection--single {
      height: 38px;
      border: 1px solid #cbd5e1;
      border-radius: 4px;
      display: flex;
      align-items: center;
      padding-left: 6px;
      font-size: 0.88rem;
      background-color: #fff;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
      color: #0f172a;
      line-height: normal;
      padding-left: 4px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 36px;
      right: 6px;
    }
    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
      border-color: #1e40af;
      box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.15);
      outline: none;
    }
    .select2-dropdown {
      border: 1px solid #cbd5e1;
      border-radius: 4px;
      font-size: 0.88rem;
      box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.08);
      z-index: 1060;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
      background-color: #1e40af;
      color: #ffffff;
    }
  </style>
  <link rel="stylesheet" href="<?= base_url(
      "assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css",
  ) ?>" />
  <script src="<?= base_url("assets/vendor/js/helpers.js") ?>"></script>
  <script src="<?= base_url(
      "assets/vendor/js/template-customizer.js",
  ) ?>"></script>
  <script src="<?= base_url("assets/js/config.js") ?>"></script>
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
            <!-- BREADCRUMB -->
            <nav aria-label="breadcrumb" class="mb-4">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(
                    "dashboard",
                ) ?>"><i class="bx bx-home-alt me-1"></i> Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kalibrasi Alat Medis</li>
              </ol>
            </nav>

            <?php if (session()->getFlashdata("success")): ?>
              <div class="alert alert-success alert-dismissible" role="alert">
                <?= esc(session()->getFlashdata("success")) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

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

            <!-- HEADER HALAMAN (Industrial: Menyatu tanpa Card Template) -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
              <div>
                <h1 class="page-header-title">Kalibrasi Alat Medis</h1>
                <p class="page-header-desc">Sertifikasi kepatuhan, jadwal kalibrasi tahunan, dan standar mutu instrumen medis rumah sakit.</p>
              </div>
              <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKalibrasi">
                <i class="bx bx-plus me-1"></i> Upload Sertifikat Kalibrasi
              </button>
            </div>

            <!-- STATISTIC CARDS (Industrial) -->
            <div class="row g-3 mb-4">
              <div class="col-md-4 col-sm-6">
                <div class="stat-card-industrial">
                  <i class="bx bx-certification stat-icon"></i>
                  <div class="stat-label">TOTAL SERTIFIKASI</div>
                  <div class="stat-value"><?= number_format($ringkasan["total"] ?? 0) ?></div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6">
                <div class="stat-card-industrial">
                  <i class="bx bx-check-shield stat-icon"></i>
                  <div class="stat-label">DIKALIBRASI TAHUN INI</div>
                  <div class="stat-value text-success"><?= number_format($ringkasan["tahun_ini"] ?? 0) ?></div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6">
                <div class="stat-card-industrial">
                  <i class="bx bx-pulse stat-icon"></i>
                  <div class="stat-label">TOTAL ALAT MEDIS</div>
                  <div class="stat-value"><?= number_format($ringkasan["total_alat_medis"] ?? 0) ?></div>
                </div>
              </div>
            </div>

            <!-- FILTER & SEARCH (Industrial) -->
            <div class="filter-card-industrial mb-4">
              <form method="GET" action="<?= base_url("kalibrasi") ?>" class="row g-2 align-items-end">
                <div class="col-md-6">
                  <label class="form-label text-dark fw-medium small mb-1">Cari Alat / No. Seri / Kode Aset</label>
                  <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 4px 0 0 4px;"><i class="bx bx-search"></i></span>
                    <input type="text" name="q" class="form-control border-start-0" placeholder="Contoh: Defibrillator, AMC-20261028-0001, SN12345..." value="<?= esc($keyword ?? "") ?>">
                  </div>
                </div>
                <div class="col-md-3">
                  <label class="form-label text-dark fw-medium small mb-1">Tahun Kalibrasi</label>
                  <input type="number" name="tahun" class="form-control" placeholder="Contoh: <?= date("Y") ?>" min="2020" max="2099" value="<?= esc($tahun ?? "") ?>">
                </div>
                <div class="col-md-3 d-flex gap-2">
                  <button type="submit" class="btn btn-primary flex-grow-1"><i class="bx bx-filter-alt me-1"></i> Filter</button>
                  <?php if (!empty($keyword) || !empty($tahun)): ?>
                    <a href="<?= base_url("kalibrasi") ?>" class="btn btn-outline-secondary" title="Reset filter"><i class="bx bx-refresh"></i></a>
                  <?php endif; ?>
                </div>
              </form>
            </div>

            <!-- TABEL KALIBRASI (Industrial) -->
            <div class="table-card-industrial">
              <div class="card-header-industrial d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold text-dark">Daftar Sertifikat Kalibrasi Alat</h6>
                <span class="text-muted small">Total: <?= count($riwayat ?? []) ?> Sertifikat</span>
              </div>
              <div class="table-responsive text-nowrap">
                <table class="table-industrial">
                  <thead>
                    <tr>
                      <th style="width: 50px;">NO.</th>
                      <th>TANGGAL KALIBRASI</th>
                      <th>ALAT MEDIS & KODE</th>
                      <th>LOKASI RUANGAN</th>
                      <th>NO. SERI / MEREK</th>
                      <th>DOKUMEN</th>
                      <th>CATATAN</th>
                      <th style="width: 70px;" class="text-center">AKSI</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (empty($riwayat)): ?>
                      <tr>
                        <td colspan="8" class="p-0">
                          <div class="empty-state-container">
                            <div class="empty-state-icon">
                              <i class="bx bx-certification"></i>
                            </div>
                            <h6 class="fw-semibold text-dark mb-1">Belum Ada Dokumen Kalibrasi</h6>
                            <p class="text-muted small mb-3">Tidak ditemukan catatan kalibrasi alat medis untuk parameter saat ini.</p>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKalibrasi">
                              <i class="bx bx-plus me-1"></i> Upload Sertifikat Kalibrasi
                            </button>
                          </div>
                        </td>
                      </tr>
                    <?php else: ?>
                      <?php
                      $no = 1;
                      foreach ($riwayat as $row): ?>
                        <tr>
                          <td class="text-muted font-monospace" style="font-size: 0.8rem;"><?= sprintf("%02d", $no++) ?></td>
                          <td>
                            <strong class="d-block text-dark"><?= date("d M Y", strtotime($row["tanggal_kalibrasi"])) ?></strong>
                          </td>
                          <td>
                            <strong class="text-dark d-block"><?= esc($row["nama_barang"]) ?></strong>
                            <span class="badge-code"><?= esc($row["kode_aset"] ?? "-") ?></span>
                          </td>
                          <td>
                            <span class="text-dark fw-medium"><?= esc($row["nama_ruang"] ?? "-") ?></span>
                            <small class="text-muted d-block font-monospace" style="font-size: 0.72rem;">Lantai <?= esc($row["lantai"] ?? "1") ?></small>
                          </td>
                          <td>
                            <div class="text-dark font-monospace small"><?= esc($row["no_seri"] ?: "-") ?></div>
                            <small class="text-muted"><?= esc($row["merek"] ?: "-") ?></small>
                          </td>
                          <td>
                            <?php if (!empty($row["file_sertifikat"])): ?>
                              <a href="<?= base_url("uploads/kalibrasi/" . $row["file_sertifikat"]) ?>" target="_blank" class="btn btn-sm btn-outline-secondary py-1 px-2" style="font-size: 0.78rem; border-radius: 4px;">
                                <i class="bx bx-file me-1"></i> Sertifikat
                              </a>
                            <?php else: ?>
                              <span class="text-muted small">-</span>
                            <?php endif; ?>
                          </td>
                          <td style="max-width: 250px; white-space: normal;">
                            <span class="small text-slate-700" style="line-height: 1.4;"><?= esc($row["catatan"] ?: "-") ?></span>
                          </td>
                          <td class="text-center">
                            <a href="<?= base_url("kalibrasi/hapus/" . $row["id"]) ?>" class="action-btn-ghost btn-ghost-danger" onclick="return confirm('Hapus catatan kalibrasi ini?')" title="Hapus Kalibrasi">
                              <i class="bx bx-trash"></i>
                            </a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
              <div class="table-footer-industrial d-flex justify-content-between align-items-center">
                <span>Menampilkan <?= count($riwayat ?? []) ?> data sertifikasi</span>
              </div>
            </div>
          </div>

          <!-- MODAL TAMBAH KALIBRASI -->
          <div class="modal fade" id="modalTambahKalibrasi" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <form action="<?= base_url(
                    "kalibrasi/simpan",
                ) ?>" method="POST" enctype="multipart/form-data">
                  <?= csrf_field() ?>
                  <div class="modal-header border-bottom">
                    <h5 class="modal-title"><i class="bx bx-check-shield text-primary me-2"></i> Tambah Data Kalibrasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label">Pilih Alat Medis <span class="text-danger">*</span></label>
                      <select class="form-select select2-alat" name="barang_id" id="selectAlatMedis" required style="width: 100%;">
                        <option value="">-- Cari atau Pilih Alat Medis --</option>
                        <?php foreach ($barang as $b): ?>
                          <option value="<?= $b["id"] ?>">
                            <?= esc($b["nama_barang"]) ?> (<?= esc($b["kode_aset"]) ?>)
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Tanggal Pelaksanaan Kalibrasi <span class="text-danger">*</span></label>
                      <input type="date" class="form-control" name="tanggal_kalibrasi" value="<?= date(
                          "Y-m-d",
                      ) ?>" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">File Sertifikat (PDF / JPG / PNG) <span class="text-danger">*</span></label>
                      <div class="rounded-3 border bg-light p-2">
                        <input type="file" class="filepond" id="file_sertifikat" name="file_sertifikat" accept="application/pdf,image/jpeg,image/png" required>
                        <small class="text-muted d-block mt-1">Format PDF, JPG, atau PNG maks 5 MB</small>
                      </div>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Catatan Hasil / No. Sertifikat</label>
                      <textarea class="form-control" name="catatan" rows="3" placeholder="Contoh: No. Sertifikat BPFK: 2026/AMC/091. Dinyatakan LAIK PAKAI hingga Oktober 2027"></textarea>
                    </div>
                  </div>
                  <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Data</button>
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

  <script src="<?= base_url("assets/vendor/libs/jquery/jquery.js") ?>"></script>
  <script src="<?= base_url("assets/vendor/libs/popper/popper.js") ?>"></script>
  <script src="<?= base_url("assets/vendor/js/bootstrap.js") ?>"></script>
  <script src="<?= base_url(
      "assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js",
  ) ?>"></script>
  <script src="<?= base_url("assets/vendor/js/menu.js") ?>"></script>
  <script src="<?= base_url("assets/js/main.js") ?>"></script>

  <!-- Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

    var elSertifikat = document.getElementById('file_sertifikat');
    if (elSertifikat) {
      FilePond.create(elSertifikat, {
        storeAsFile: true,
        allowMultiple: false,
        acceptedFileTypes: ['application/pdf', 'image/jpeg', 'image/png'],
        maxFileSize: '5MB',
        labelIdle: '<span class="filepond--label-action"><i class="bx bx-cloud-upload fs-4 d-block text-primary mb-1"></i>Pilih atau seret berkas sertifikat</span>',
        labelFileTypeNotAllowed: 'Format berkas tidak valid',
        fileValidateTypeLabelExpectedTypes: 'Hanya PDF, JPG, atau PNG',
        labelMaxFileSizeExceeded: 'Ukuran berkas terlalu besar',
        labelMaxFileSize: 'Maksimal 5 MB'
      });
    }

    // Inisialisasi Select2 pada Modal Tambah Kalibrasi
    $(document).ready(function() {
      $('.select2-alat').select2({
        dropdownParent: $('#modalTambahKalibrasi'),
        placeholder: '-- Cari atau Pilih Alat Medis --',
        allowClear: true,
        width: '100%'
      });
    });
  </script>
</body>
</html>
