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

   <title>Kategori | AMC</title>

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
  <style>
    /* Efek Card saat di-hover */
    .card-hover-effect {
      transition: all 0.3s ease-in-out;
      border: 1px solid transparent;
    }

    .card-hover-effect:hover {
      transform: translateY(-5px);
      /* Card sedikit naik */
      box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
      /* Shadow lebih tebal */
      border-color: rgba(105, 108, 255, 0.2);
      /* Border warna primary tipis */
    }

    /* Efek Tombol Aksi (Sembunyi -> Muncul) */
    .action-buttons {
      opacity: 0;
      transform: translateY(-10px);
      transition: all 0.3s ease-in-out;
    }

    .card-hover-effect:hover .action-buttons {
      opacity: 1;
      transform: translateY(0);
    }

    /* Efek Ikon sedikit membesar saat card di-hover */
    .icon-hover {
      transition: transform 0.3s ease;
    }

    .card-hover-effect:hover .icon-hover {
      transform: scale(1.1);
    }
  </style>
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
          <?= view('kategori/main') ?>

          <!-- MODAL TAMBAH KATEGORI (Contoh, sesuaikan dengan form-mu) -->
          <!-- Modal Tambah Kategori -->
          <div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Tambah Kategori Baru</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Action ke /kategori/simpan -->
                <form action="<?= base_url('kategori/simpan') ?>" method="POST">
                  <?= csrf_field() ?>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label">Nama Kategori</label>
                      <input type="text" class="form-control" name="nama_kategori" placeholder="Contoh: Sarpras Umum" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Pilih Ikon</label>
                      <select class="form-select" name="icon" required>
                        <option value="bx-category">Default (Kategori)</option>
                        <option value="bx-laptop">Elektronik (Laptop)</option>
                        <option value="bx-chair">Non-Elektronik (Kursi)</option>
                        <option value="bx-plus-medical">Alat Medis (Palang Medis)</option>
                        <option value="bx-buildings">Fasilitas (Gedung)</option>
                        <option value="bx-car">Kendaraan (Mobil)</option>
                        <option value="bx-dashboard">Lain nya </option>

                      </select>
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
          <!-- / Content -->
          <!-- Modal Edit Kategori -->
          <div class="modal fade" id="modalEditKategori" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Kategori</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Action akan diisi via JavaScript -->
                <form id="formEditKategori" method="POST">
                  <?= csrf_field() ?>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label">Nama Kategori</label>
                      <input type="text" class="form-control" name="nama_kategori" id="edit_nama_kategori" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Pilih Ikon</label>
                      <select class="form-select" name="icon" id="edit_icon" required>
                        <option value="bx-category">Default (Kategori)</option>
                        <option value="bx-laptop">Elektronik (Laptop)</option>
                        <option value="bx-chair">Non-Elektronik (Kursi)</option>
                        <option value="bx-plus-medical">Alat Medis (Palang Medis)</option>
                        <option value="bx-buildings">Fasilitas (Gedung)</option>
                        <option value="bx-car">Kendaraan (Mobil)</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

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

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/theme.js  -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Menangkap semua tombol edit
      const tombolEdit = document.querySelectorAll('.btn-edit');

      tombolEdit.forEach(btn => {
        btn.addEventListener('click', function() {
          // Ambil data dari atribut tombol
          const id = this.getAttribute('data-id');
          const nama = this.getAttribute('data-nama');
          const icon = this.getAttribute('data-icon');

          // Isi form di dalam modal
          document.getElementById('edit_nama_kategori').value = nama;
          document.getElementById('edit_icon').value = icon;

          // Ubah action form agar mengarah ke URL update dengan ID yang benar
          document.getElementById('formEditKategori').action = "<?= base_url('kategori/update') ?>/" + id;
        });
      });
    });
  </script>
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
</body>

</html>