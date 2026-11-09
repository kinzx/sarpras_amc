<!doctype html>
<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed" dir="ltr" data-skin="default" data-assets-path="<?= base_url(
    "assets/",
) ?>" data-template="vertical-menu-template" data-bs-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $title ?? "Sub Kategori" ?> | RS AMC</title>

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

      <!-- MENU SIDEBAR -->
      <?= view("adds/sidebar") ?>

      <div class="menu-mobile-toggler d-xl-none rounded-1">
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
          <i class="bx bx-menu icon-base"></i>
          <i class="bx bx-chevron-right icon-base"></i>
        </a>
      </div>

      <!-- Layout container -->
      <div class="layout-page">

        <!-- NAVBAR -->
        <?= view("adds/navbar") ?>

        <!-- Content wrapper -->
        <div class="content-wrapper">

          <!-- ========================================== -->
          <!-- KONTEN SUB KATEGORI DIMULAI DARI SINI -->
          <!-- ========================================== -->
          <div class="container-xxl flex-grow-1 container-p-y">

              <!-- Header Halaman (Industrial Clean) -->
              <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                  <div>
                      <h1 class="page-header-title">Sub Kategori: <?= esc($kategoriInduk["nama_kategori"]) ?></h1>
                      <p class="page-header-desc">Daftar pengelompokan spesifik di bawah kategori <?= esc($kategoriInduk["nama_kategori"]) ?>.</p>
                  </div>
                  <div class="d-flex gap-2">
                      <a href="<?= base_url("kategori") ?>" class="btn btn-outline-secondary">
                          <i class="bx bx-arrow-back me-1"></i> Kembali
                      </a>
                      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahSub">
                          <i class="bx bx-plus me-1"></i> Tambah Sub
                      </button>
                  </div>
              </div>

              <!-- Alert Sukses/Error -->
              <?php if (session()->getFlashdata("success")): ?>
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <?= session()->getFlashdata("success") ?>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              <?php endif; ?>

              <?php if (session()->getFlashdata("errors")): ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Sub-kategori belum tersimpan:</strong>
                      <ul class="mb-0 mt-2">
                          <?php foreach (session()->getFlashdata("errors") as $error): ?>
                              <li><?= esc($error) ?></li>
                          <?php endforeach; ?>
                      </ul>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              <?php endif; ?>

              <!-- Tabel Sub Kategori (Industrial) -->
              <div class="table-card-industrial">
                  <div class="card-header-industrial d-flex justify-content-between align-items-center">
                      <h6 class="mb-0 fw-semibold text-dark">Daftar Sub-Kategori Terdaftar</h6>
                      <span class="text-muted small">Total: <?= count($subKategori ?? []) ?></span>
                  </div>
                  <div class="table-responsive text-nowrap">
                      <table class="table-industrial">
                          <thead>
                              <tr>
                                  <th style="width: 60px;">NO.</th>
                                  <th>NAMA SUB KATEGORI</th>
                                  <th>STATUS</th>
                                  <th style="width: 100px;" class="text-center">AKSI</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php if (empty($subKategori)): ?>
                                  <tr>
                                      <td colspan="4" class="p-0">
                                          <div class="empty-state-container">
                                              <div class="empty-state-icon">
                                                  <i class="bx bx-git-branch"></i>
                                              </div>
                                              <h6 class="fw-semibold text-dark mb-1">Belum Ada Sub-Kategori</h6>
                                              <p class="text-muted small mb-3">Silakan tambahkan sub-kategori untuk mengelompokkan aset lebih detail.</p>
                                              <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSub">
                                                  <i class="bx bx-plus me-1"></i> Tambah Sub Sekarang
                                              </button>
                                          </div>
                                      </td>
                                  </tr>
                              <?php else: ?>
                                  <?php
                                  $no = 1;
                                  foreach ($subKategori as $sub): ?>
                                  <tr>
                                      <td class="text-muted font-monospace" style="font-size: 0.8rem;"><?= sprintf("%02d", $no++) ?></td>
                                      <td><strong class="text-dark"><?= esc($sub["nama_sub_kategori"]) ?></strong></td>
                                      <td>
                                          <?php if ($sub["is_active"] == 1): ?>
                                              <span class="badge-status-box active">Aktif</span>
                                          <?php else: ?>
                                              <span class="badge-status-box inactive">Non-Aktif</span>
                                          <?php endif; ?>
                                      </td>
                                      <td class="text-center">
                                          <a href="<?= base_url("kategori/hapus/" . $sub["id"]) ?>" class="action-btn-ghost btn-ghost-danger" onclick="return confirm('Yakin ingin menonaktifkan sub-kategori ini?')" title="Hapus Sub-Kategori">
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
                      <span>Menampilkan <?= count($subKategori ?? []) ?> sub-kategori</span>
                  </div>
              </div>
          </div>
          <!-- ========================================== -->
          <!-- KONTEN SELESAI -->
          <!-- ========================================== -->

          <!-- FOOTER -->
          <?= view("adds/footer") ?>

          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <div class="layout-overlay layout-menu-toggle"></div>
    <div class="drag-target"></div>
  </div>

  <!-- Modal Tambah Sub Kategori -->
  <div class="modal fade" id="modalTambahSub" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Tambah Sub Kategori</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="<?= base_url(
                  "kategori/simpan-sub",
              ) ?>" method="POST">
                  <?= csrf_field() ?>
                  <!-- Kirim ID Induk secara sembunyi -->
                  <input type="hidden" name="kategori_id" value="<?= $kategoriInduk[
                      "id"
                  ] ?>">

                  <div class="modal-body">
                  <label class="form-label">Nama Sub Kategori</label>
                  <p class="text-muted small">Isi satu nama per baris. Baris kosong akan diabaikan.</p>
                  <div id="subKategoriInputs">
                      <div class="input-group mb-2 sub-kategori-row">
                          <input type="text" class="form-control" name="nama_sub_kategori[]" placeholder="Contoh: AC" minlength="3" maxlength="100" style="min-height: 56px;">
                          <button type="button" class="btn btn-outline-danger btn-hapus-baris" aria-label="Hapus baris" style="min-width: 56px;">&times;</button>
                      </div>
                  </div>
                  <button type="button" class="btn btn-outline-primary" id="btnTambahBaris" style="min-height: 56px;">
                      <i class="bx bx-plus me-1"></i>Tambah baris
                  </button>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
              </form>
          </div>
      </div>
  </div>

  <!-- Core JS -->
  <script src="<?= base_url("assets/vendor/libs/jquery/jquery.js") ?>"></script>
  <script src="<?= base_url("assets/vendor/libs/popper/popper.js") ?>"></script>
  <script src="<?= base_url("assets/vendor/js/bootstrap.js") ?>"></script>
  <script src="<?= base_url(
      "assets/vendor/libs/@algolia/autocomplete-js.js",
  ) ?>"></script>
  <script src="<?= base_url("assets/vendor/libs/pickr/pickr.js") ?>"></script>
  <script src="<?= base_url(
      "assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js",
  ) ?>"></script>
  <script src="<?= base_url("assets/vendor/libs/hammer/hammer.js") ?>"></script>
  <script src="<?= base_url("assets/vendor/libs/i18n/i18n.js") ?>"></script>
  <script src="<?= base_url("assets/vendor/js/menu.js") ?>"></script>
  <script src="<?= base_url("assets/js/main.js") ?>"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const container = document.getElementById('subKategoriInputs');

      document.getElementById('btnTambahBaris').addEventListener('click', function () {
        const row = document.createElement('div');
        row.className = 'input-group mb-2 sub-kategori-row';
        row.innerHTML = '<input type="text" class="form-control" name="nama_sub_kategori[]" placeholder="Nama sub-kategori" minlength="3" maxlength="100" style="min-height: 56px;">' +
          '<button type="button" class="btn btn-outline-danger btn-hapus-baris" aria-label="Hapus baris" style="min-width: 56px;">&times;</button>';
        container.appendChild(row);
        row.querySelector('input').focus();
      });

      container.addEventListener('click', function (event) {
        const removeButton = event.target.closest('.btn-hapus-baris');
        if (removeButton && container.querySelectorAll('.sub-kategori-row').length > 1) {
          removeButton.closest('.sub-kategori-row').remove();
        }
      });
    });
  </script>

</body>
</html>
