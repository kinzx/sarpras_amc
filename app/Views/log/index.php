<!doctype html>
<html lang="id" class="layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed" dir="ltr" data-skin="default" data-assets-path="<?= base_url('assets/') ?>" data-template="vertical-menu-template" data-bs-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title ?? 'Log Aktivitas') ?> | RS AMC</title>

  <link rel="icon" type="image/png" sizes="64x64" href="<?= base_url('AMC-tanpa-nama-pad.png') ?>" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('AMC-tanpa-nama-pad.png') ?>" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/iconify-icons.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/boxicons.css') ?>" />
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
      <?= view('adds/sidebar') ?>

      <div class="menu-mobile-toggler d-xl-none rounded-1">
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
          <i class="bx bx-menu icon-base"></i>
          <i class="bx bx-chevron-right icon-base"></i>
        </a>
      </div>

      <div class="layout-page">
        <?= view('adds/navbar') ?>

        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Header Halaman -->
            <div class="card mb-4 border-0 shadow-sm">
              <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                  <h4 class="card-title mb-1 d-flex align-items-center gap-2">
                    <i class="bx bx-history text-primary"></i> Log Aktivitas Sistem
                  </h4>
                  <p class="text-muted mb-0">Catatan riwayat audit aktivitas pengguna pada modul sarana dan prasarana.</p>
                </div>
                <span class="badge bg-label-primary px-3 py-2">
                  <i class="bx bx-shield-quarter me-1"></i> Audit Trail
                </span>
              </div>
            </div>

            <!-- Form Pencarian & Filter Modul -->
            <div class="card mb-4 border-0 shadow-sm">
              <div class="card-body">
                <form action="<?= base_url('log-activity') ?>" method="GET" class="row g-3 align-items-end">
                  <div class="col-md-5">
                    <label class="form-label fw-semibold">Pencarian</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bx bx-search"></i></span>
                      <input type="text" name="q" class="form-control" placeholder="Cari username atau pesan aktivitas…" value="<?= esc($search ?? '') ?>">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label class="form-label fw-semibold">Filter Modul</label>
                    <select name="modul" class="form-select">
                      <option value="">-- Semua Modul --</option>
                      <?php foreach ($modulList as $m): ?>
                        <option value="<?= esc($m) ?>" <?= (string) ($selectedModul ?? '') === (string) $m ? 'selected' : '' ?>>
                          <?= esc(strtoupper($m)) ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                      <i class="bx bx-filter-alt me-1"></i> Terapkan
                    </button>
                    <?php if (!empty($search) || !empty($selectedModul)): ?>
                      <a href="<?= base_url('log-activity') ?>" class="btn btn-outline-secondary" title="Reset Filter" aria-label="Reset Filter">
                        <i class="bx bx-refresh"></i>
                      </a>
                    <?php endif; ?>
                  </div>
                </form>
              </div>
            </div>

            <!-- Tabel Data Log -->
            <div class="card border-0 shadow-sm">
              <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
                <h5 class="card-title mb-0">Daftar Rekaman Aktivitas</h5>
                <small class="text-muted">Menampilkan <?= count($logs ?? []) ?> entri terakhir</small>
              </div>
              <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th style="width: 16%;">Waktu</th>
                      <th style="width: 14%;">User</th>
                      <th style="width: 12%;">Modul</th>
                      <th style="width: 12%;">Aksi</th>
                      <th>Pesan</th>
                    </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                    <?php if (empty($logs)): ?>
                      <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                          <i class="bx bx-info-circle fs-3 d-block mb-2"></i>
                          Belum ada catatan log aktivitas yang sesuai.
                        </td>
                      </tr>
                    <?php else: ?>
                      <?php foreach ($logs as $row): ?>
                        <?php
                          $aksiLower = strtolower($row['aksi'] ?? '');
                          $badgeAksi = match ($aksiLower) {
                            'create', 'tambah' => 'bg-label-success',
                            'update', 'edit', 'ubah' => 'bg-label-warning',
                            'delete', 'hapus' => 'bg-label-danger',
                            default => 'bg-label-info',
                          };

                          $modulLower = strtolower($row['modul'] ?? 'sistem');
                          $badgeModul = match ($modulLower) {
                            'barang'      => 'bg-label-primary',
                            'maintenance' => 'bg-label-info',
                            'perbaikan'   => 'bg-label-danger',
                            'kalibrasi'   => 'bg-label-success',
                            'kategori'    => 'bg-label-secondary',
                            'ruang'       => 'bg-label-dark',
                            'user', 'pengguna' => 'bg-label-warning',
                            default       => 'bg-label-secondary',
                          };
                        ?>
                        <tr>
                          <td>
                            <strong class="d-block text-dark">
                              <?= !empty($row['created_at']) ? date('d M Y', strtotime($row['created_at'])) : '-' ?>
                            </strong>
                            <small class="text-muted font-monospace">
                              <?= !empty($row['created_at']) ? date('H:i:s', strtotime($row['created_at'])) : '-' ?> &bull; <?= esc($row['ipaddress'] ?? '::1') ?>
                            </small>
                          </td>
                          <td>
                            <div class="d-flex align-items-center gap-2">
                              <span class="avatar-initial rounded-circle bg-label-secondary d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                <i class="bx bx-user" style="font-size: 0.9rem;"></i>
                              </span>
                              <span class="fw-semibold text-dark"><?= esc($row['username'] ?: 'Guest') ?></span>
                            </div>
                          </td>
                          <td>
                            <span class="badge <?= $badgeModul ?> text-uppercase">
                              <?= esc($modulLower) ?>
                            </span>
                          </td>
                          <td>
                            <span class="badge <?= $badgeAksi ?>">
                              <?= esc($aksiLower) ?>
                            </span>
                          </td>
                          <td class="text-wrap" style="max-width: 480px;">
                            <?= esc($row['message'] ?? '-') ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <?= view('adds/footer') ?>
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
