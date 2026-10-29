<!doctype html>
<html lang="id" class="layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed" dir="ltr" data-skin="default" data-assets-path="<?= base_url('assets/') ?>" data-template="vertical-menu-template" data-bs-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title><?= $title ?? 'Kalibrasi Alat' ?> | RS AMC</title>
  <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon/favicon.ico') ?>" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/iconify-icons.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/pickr/pickr-themes.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />
  <script src="<?= base_url('assets/vendor/js/helpers.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/js/template-customizer.js') ?>"></script>
  <script src="<?= base_url('assets/js/config.js') ?>"></script>
</head>
<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <?= view('adds/sidebar'); ?>
      <div class="menu-mobile-toggler d-xl-none rounded-1">
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
          <i class="bx bx-menu icon-base"></i>
          <i class="bx bx-chevron-right icon-base"></i>
        </a>
      </div>
      <div class="layout-page">
        <?= view('adds/navbar'); ?>
        <div class="content-wrapper">

          <div class="container-xxl flex-grow-1 container-p-y">
            <!-- BREADCRUMB -->
            <nav aria-label="breadcrumb" class="mb-4">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><i class="bx bx-home-alt me-1"></i> Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kalibrasi Alat Medis</li>
              </ol>
            </nav>

            <?php if (session()->getFlashdata('success')): ?>
              <div class="alert alert-success alert-dismissible" role="alert">
                <?= esc(session()->getFlashdata('success')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
              <div class="alert alert-danger alert-dismissible" role="alert">
                <ul class="mb-0">
                  <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                  <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

            <!-- HEADER -->
            <div class="card mb-4">
              <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                  <h4 class="card-title mb-1">
                    <span class="text-primary me-2">|</span> Kalibrasi Alat Medis
                  </h4>
                  <p class="text-muted mb-0">Kelola sertifikasi, jadwal kalibrasi tahunan, dan kepatuhan standar mutu alat medis rumah sakit.</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKalibrasi">
                  <i class="bx bx-plus me-1"></i> Upload Sertifikat Kalibrasi
                </button>
              </div>
            </div>

            <!-- STATISTIC CARDS -->
            <div class="row mb-4">
              <div class="col-md-4 col-sm-6 mb-3">
                <div class="card h-100">
                  <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                      <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">TOTAL SERTIFIKASI</p>
                      <h3 class="mb-0 fw-bolder"><?= number_format($ringkasan['total'] ?? 0) ?></h3>
                    </div>
                    <div class="bg-label-primary rounded p-3">
                      <i class="bx bx-certification fs-3"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 mb-3">
                <div class="card h-100">
                  <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                      <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">DIKALIBRASI TAHUN INI</p>
                      <h3 class="mb-0 fw-bolder"><?= number_format($ringkasan['tahun_ini'] ?? 0) ?></h3>
                    </div>
                    <div class="bg-label-success rounded p-3">
                      <i class="bx bx-check-shield fs-3"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-6 mb-3">
                <div class="card h-100">
                  <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                      <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">TOTAL ALAT MEDIS</p>
                      <h3 class="mb-0 fw-bolder"><?= number_format($ringkasan['total_alat_medis'] ?? 0) ?></h3>
                    </div>
                    <div class="bg-label-info rounded p-3">
                      <i class="bx bx-pulse fs-3"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- FILTER & SEARCH -->
            <div class="card mb-4">
              <div class="card-body">
                <form method="GET" action="<?= base_url('kalibrasi') ?>" class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">Cari Nama Alat / No. Seri / Kode Aset</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bx bx-search"></i></span>
                      <input type="text" name="q" class="form-control" placeholder="Contoh: Defibrillator, AMC-20261028-0001, SN12345..." value="<?= esc($keyword ?? '') ?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" class="form-control" placeholder="Contoh: <?= date('Y') ?>" min="2020" max="2099" value="<?= esc($tahun ?? '') ?>">
                  </div>
                  <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="bx bx-filter-alt me-1"></i> Filter</button>
                    <?php if (!empty($keyword) || !empty($tahun)): ?>
                      <a href="<?= base_url('kalibrasi') ?>" class="btn btn-outline-secondary">Reset</a>
                    <?php endif; ?>
                  </div>
                </form>
              </div>
            </div>

            <!-- TABEL KALIBRASI -->
            <div class="card">
              <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Sertifikat Kalibrasi</h5>
                <span class="badge bg-label-info"><?= count($riwayat) ?> Sertifikat</span>
              </div>
              <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                  <thead class="table-light">
                    <tr>
                      <th style="width: 50px;">No</th>
                      <th>Tanggal Kalibrasi</th>
                      <th>Nama Alat & Kode Aset</th>
                      <th>Ruangan</th>
                      <th>No. Seri / Merek</th>
                      <th>Sertifikat</th>
                      <th>Catatan</th>
                      <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                    <?php if (empty($riwayat)): ?>
                      <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                          Belum ada catatan kalibrasi alat.
                        </td>
                      </tr>
                    <?php else: ?>
                      <?php $no = 1; foreach ($riwayat as $row): ?>
                        <tr>
                          <td><?= sprintf('%02d', $no++) ?></td>
                          <td>
                            <span class="fw-semibold"><?= date('d M Y', strtotime($row['tanggal_kalibrasi'])) ?></span>
                          </td>
                          <td>
                            <strong><?= esc($row['nama_barang']) ?></strong>
                            <small class="text-muted d-block font-monospace"><?= esc($row['kode_aset'] ?? '-') ?></small>
                          </td>
                          <td>
                            <?= esc($row['nama_ruang'] ?? '-') ?>
                            <small class="text-muted d-block">Lantai <?= esc($row['lantai'] ?? '1') ?></small>
                          </td>
                          <td>
                            <?= esc($row['no_seri'] ?: '-') ?><br>
                            <small class="text-muted"><?= esc($row['merek'] ?: '-') ?></small>
                          </td>
                          <td>
                            <?php if (!empty($row['file_sertifikat'])): ?>
                              <a href="<?= base_url('uploads/kalibrasi/' . $row['file_sertifikat']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-file me-1"></i> Lihat File
                              </a>
                            <?php else: ?>
                              <span class="text-muted">-</span>
                            <?php endif; ?>
                          </td>
                          <td style="max-width: 250px; white-space: normal;">
                            <small><?= esc($row['catatan'] ?: '-') ?></small>
                          </td>
                          <td class="text-center">
                            <a href="<?= base_url('kalibrasi/hapus/' . $row['id']) ?>" class="btn btn-sm btn-icon btn-outline-danger" onclick="return confirm('Hapus catatan kalibrasi ini?')" title="Hapus">
                              <i class="bx bx-trash"></i>
                            </a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- MODAL TAMBAH KALIBRASI -->
          <div class="modal fade" id="modalTambahKalibrasi" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <form action="<?= base_url('kalibrasi/simpan') ?>" method="POST" enctype="multipart/form-data">
                  <?= csrf_field() ?>
                  <div class="modal-header border-bottom">
                    <h5 class="modal-title"><i class="bx bx-check-shield text-primary me-2"></i> Tambah Data Kalibrasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label">Pilih Alat Medis <span class="text-danger">*</span></label>
                      <select class="form-select" name="barang_id" required>
                        <option value="">-- Pilih Alat --</option>
                        <?php foreach ($barang as $b): ?>
                          <option value="<?= $b['id'] ?>">
                            <?= esc($b['nama_barang']) ?> (<?= esc($b['kode_aset']) ?>) - <?= esc($b['nama_ruang'] ?? '-') ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Tanggal Pelaksanaan Kalibrasi <span class="text-danger">*</span></label>
                      <input type="date" class="form-control" name="tanggal_kalibrasi" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">File Sertifikat (PDF / JPG / PNG) <span class="text-danger">*</span></label>
                      <input type="file" class="form-control" name="file_sertifikat" accept=".pdf,image/jpeg,image/png" required>
                      <small class="text-muted">Maksimal 5 MB</small>
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

          <?= view('adds/footer'); ?>
          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
    <div class="drag-target"></div>
  </div>

  <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/libs/popper/popper.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/js/bootstrap.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/js/menu.js') ?>"></script>
  <script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>
</html>
