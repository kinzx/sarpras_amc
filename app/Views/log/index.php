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
  <link
    href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/iconify-icons.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/boxicons.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/industrial.css') ?>" />
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
            <!-- Header Halaman (Industrial: Tanpa Card Template) -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
              <div>
                <h1 class="page-header-title">Log Aktivitas Sistem</h1>
                <p class="page-header-desc">Catatan riwayat audit transaksi pengguna pada seluruh modul sarana dan prasarana.</p>
              </div>
              
            </div>

            <!-- Form Pencarian & Filter Modul (Industrial) -->
            <div class="filter-card-industrial mb-4">
              <form action="<?= base_url('log-activity') ?>" method="GET" class="row g-2 align-items-end">
                <div class="col-md-5">
                  <label class="form-label text-dark fw-medium small mb-1">Pencarian</label>
                  <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 4px 0 0 4px;"><i class="bx bx-search"></i></span>
                    <input type="text" name="q" class="form-control border-start-0" placeholder="Cari username atau pesan aktivitas…" value="<?= esc($search ?? '') ?>">
                  </div>
                </div>

                <div class="col-md-4">
                  <label class="form-label text-dark fw-medium small mb-1">Filter Modul</label>
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

            <!-- Tabel Data Log (Industrial) -->
            <div class="table-card-industrial">
              <div class="card-header-industrial d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold text-dark">Daftar Rekaman Audit Aktivitas</h6>
                <span class="text-muted small">Menampilkan <?= count($logs ?? []) ?> entri terakhir</span>
              </div>
              <div class="table-responsive">
                <table class="table-industrial w-100">
                  <thead>
                    <tr>
                      <th style="width: 180px;">WAKTU & IP</th>
                      <th style="width: 160px;">OPERATOR</th>
                      <th style="width: 120px;">MODUL</th>
                      <th style="width: 120px;">AKSI</th>
                      <th>RINCIAN PERUBAHAN</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (empty($logs)): ?>
                      <tr>
                        <td colspan="5" class="p-0">
                          <div class="empty-state-container">
                            <div class="empty-state-icon">
                              <i class="bx bx-history"></i>
                            </div>
                            <h6 class="fw-semibold text-dark mb-1">Belum Ada Catatan Log</h6>
                            <p class="text-muted small mb-0">Tidak ditemukan log aktivitas yang sesuai dengan parameter filter.</p>
                          </div>
                        </td>
                      </tr>
                    <?php else: ?>
                      <?php foreach ($logs as $row): ?>
                        <?php
                          $aksiLower = strtolower($row['aksi'] ?? '');
                          $badgeAksi = match ($aksiLower) {
                            'create', 'tambah' => 'badge-status-box active',
                            'update', 'edit', 'ubah' => 'badge-status-box warning',
                            'delete', 'hapus' => 'badge-status-box danger',
                            default => 'badge-status-box neutral',
                          };

                          $modulLower = strtolower($row['modul'] ?? 'sistem');
                        ?>
                        <tr>
                          <td>
                            <span class="d-block text-dark fw-medium" style="font-size: 0.85rem;">
                              <?= !empty($row['created_at']) ? date('d M Y', strtotime($row['created_at'])) : '-' ?>
                            </span>
                            <span class="text-muted font-monospace" style="font-size: 0.73rem;">
                              <?= !empty($row['created_at']) ? date('H:i:s', strtotime($row['created_at'])) : '-' ?> &bull; <?= esc($row['ipaddress'] ?? '::1') ?>
                            </span>
                          </td>
                          <td>
                            <div class="d-flex align-items-center gap-2">
                              <span class="d-inline-flex align-items-center justify-content-center text-slate-700" style="width: 26px; height: 26px; background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 0.85rem;">
                                <i class="bx bx-user"></i>
                              </span>
                              <span class="fw-medium text-dark" style="font-size: 0.85rem;"><?= esc($row['username'] ?: 'Guest') ?></span>
                            </div>
                          </td>
                          <td>
                            <span class="badge-code text-uppercase">
                              <?= esc($modulLower) ?>
                            </span>
                          </td>
                          <td>
                            <span class="<?= $badgeAksi ?>">
                              <?= esc($aksiLower) ?>
                            </span>
                          </td>
                          <td>
                            <span class="text-slate-700" style="font-size: 0.85rem; line-height: 1.5;"><?= esc($row['message'] ?? '-') ?></span>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
              <div class="table-footer-industrial d-flex justify-content-between align-items-center">
                <span>Total <?= count($logs ?? []) ?> catatan audit aktivitas</span>
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
