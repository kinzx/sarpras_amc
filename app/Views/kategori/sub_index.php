<!doctype html>
<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed" dir="ltr" data-skin="default" data-assets-path="<?= base_url('assets/') ?>" data-template="vertical-menu-template" data-bs-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title><?= $title ?? 'Sub Kategori' ?> | RS AMC</title>
  
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
      
      <!-- MENU SIDEBAR -->
      <?= view('adds/sidebar'); ?>

      <div class="menu-mobile-toggler d-xl-none rounded-1">
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
          <i class="bx bx-menu icon-base"></i>
          <i class="bx bx-chevron-right icon-base"></i>
        </a>
      </div>

      <!-- Layout container -->
      <div class="layout-page">
        
        <!-- NAVBAR -->
        <?= view('adds/navbar'); ?>

        <!-- Content wrapper -->
        <div class="content-wrapper">
          
          <!-- ========================================== -->
          <!-- KONTEN SUB KATEGORI DIMULAI DARI SINI -->
          <!-- ========================================== -->
          <div class="container-xxl flex-grow-1 container-p-y">
              
              <!-- Header Card -->
              <div class="card mb-4">
                  <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                      <div class="mb-3 mb-md-0">
                          <h4 class="card-title mb-1">
                              <span class="text-primary me-2">|</span> Sub Kategori: <?= $kategoriInduk['nama_kategori'] ?>
                          </h4>
                          <p class="text-muted mb-0">Daftar pengelompokan spesifik di bawah <?= $kategoriInduk['nama_kategori'] ?>.</p>
                      </div>
                      <div class="d-flex gap-2">
                          <a href="<?= base_url('kategori') ?>" class="btn btn-outline-secondary">
                              <i class="bx bx-arrow-back me-1"></i> Kembali
                          </a>
                          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahSub">
                              <i class="bx bx-plus-circle me-1"></i> Tambah Sub
                          </button>
                      </div>
                  </div>
              </div>

              <!-- Alert Sukses/Error -->
              <?php if(session()->getFlashdata('success')): ?>
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <?= session()->getFlashdata('success') ?>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              <?php endif; ?>

              <!-- Tabel Sub Kategori -->
              <div class="card">
                  <div class="table-responsive text-nowrap">
                      <table class="table table-hover">
                          <thead>
                              <tr>
                                  <th width="5%">No</th>
                                  <th>Nama Sub Kategori</th>
                                  <th>Status</th>
                                  <th width="15%">Aksi</th>
                              </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">
                              <?php if(empty($subKategori)): ?>
                                  <tr>
                                      <td colspan="4" class="text-center py-4 text-muted">Belum ada sub-kategori.</td>
                                  </tr>
                              <?php else: ?>
                                  <?php $no = 1; foreach($subKategori as $sub): ?>
                                  <tr>
                                      <td><?= $no++ ?></td>
                                      <td><strong><?= $sub['nama_sub_kategori'] ?></strong></td>
                                      <td>
                                          <?php if($sub['is_active'] == 1): ?>
                                              <span class="badge bg-label-success">Aktif</span>
                                          <?php else: ?>
                                              <span class="badge bg-label-danger">Non-Aktif</span>
                                          <?php endif; ?>
                                      </td>
                                      <td>
                                          <a href="<?= base_url('kategori/hapus/'.$sub['id']) ?>" class="btn btn-sm btn-icon btn-danger" onclick="return confirm('Yakin ingin menonaktifkan sub-kategori ini?')">
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
          <!-- ========================================== -->
          <!-- KONTEN SELESAI -->
          <!-- ========================================== -->

          <!-- FOOTER -->
          <?= view('adds/footer'); ?>

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
              <form action="<?= base_url('kategori/simpan-sub') ?>" method="POST">
                  <?= csrf_field() ?>
                  <!-- Kirim ID Induk secara sembunyi -->
                  <input type="hidden" name="kategori_id" value="<?= $kategoriInduk['id'] ?>">
                  
                  <div class="modal-body">
                      <div class="mb-3">
                          <label class="form-label">Nama Sub Kategori</label>
                          <input type="text" class="form-control" name="nama_sub_kategori" placeholder="Contoh: AC, Komputer, Kursi Roda" required>
                      </div>
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
  <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/libs/popper/popper.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/js/bootstrap.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/libs/@algolia/autocomplete-js.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/libs/pickr/pickr.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/libs/hammer/hammer.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/libs/i18n/i18n.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/js/menu.js') ?>"></script>
  <script src="<?= base_url('assets/js/main.js') ?>"></script>

</body>
</html>