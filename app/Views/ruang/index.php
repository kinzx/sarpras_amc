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

  <title>Ruangan | AMC</title>

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
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      <?= view('adds/sidebar'); ?>

      <div class="layout-page">
        <?= view('adds/navbar'); ?>

        <div class="content-wrapper">

          <!-- BAGIAN INI YANG BERUBAH -->
          <?= view('ruang/main') ?>

          <?= view('adds/footer'); ?>
          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
    <div class="drag-target"></div>
  </div>
  <!-- / Layout wrapper -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/theme.js  -->
  <!-- 1. Panggil JQuery & Bootstrap DULU -->
  <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../../assets/vendor/libs/popper/popper.js"></script>
  <script src="../../assets/vendor/js/bootstrap.js"></script>

  <!-- 2. Baru panggil script kustom milikmu -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const tombolEdit = document.querySelectorAll('.btn-edit');
      tombolEdit.forEach(btn => {
        btn.addEventListener('click', function() {
          const id = this.getAttribute('data-id');
          const nama = this.getAttribute('data-nama');
          const lantai = this.getAttribute('data-lantai');

          document.getElementById('edit_nama_ruang').value = nama;
          document.getElementById('edit_lantai').value = lantai;
          document.getElementById('formEditRuang').action = "<?= base_url('ruang/update') ?>/" + id;
        });
      });
    });
  </script>
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