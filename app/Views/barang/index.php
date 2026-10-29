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

   <title>Barang | AMC</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="64x64" href="<?= base_url(
      "AMC-tanpa-nama-pad.png",
  ) ?>" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(
      "AMC-tanpa-nama-pad.png",
  ) ?>" />

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
      <!-- Menu -->

      <?= view("adds/sidebar") ?>

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
        <?= view("adds/navbar") ?>
        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          <?= view("barang/main") ?>
          <!-- / Content -->
          <!-- Footer -->
          <?= view("adds/footer") ?>
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
    $(document).ready(function() {
      // Filter tabel instan via jQuery
      function filterTable() {
        var kategori = $('#filterKategori').val().toLowerCase();
        var subKategori = $('#filterSubKategori').val().toLowerCase();
        var status = $('#filterStatus').val().toLowerCase();

        $('tbody tr').each(function() {
          var rowText = $(this).text().toLowerCase();
          var matchKategori = kategori === '' || rowText.indexOf(kategori) > -1;
          var matchSub = subKategori === '' || rowText.indexOf(subKategori) > -1;
          var matchStatus = status === '' || rowText.indexOf(status) > -1;

          if (matchKategori && matchSub && matchStatus) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      }

      $('#filterKategori, #filterSubKategori, #filterStatus').on('change', filterTable);

      $('#btnResetFilter').on('click', function() {
        $('#filterKategori, #filterSubKategori, #filterStatus').val('');
        filterTable();
      });
    });
  </script>

  <!-- Page JS -->
  <a href="<?= base_url(
      "scan",
  ) ?>" class="btn btn-primary rounded-circle shadow-lg position-fixed d-flex align-items-center justify-content-center"
    style="width: 65px; height: 65px; bottom: 30px; right: 30px; z-index: 9999;">
    <i class="bx bx-qr-scan text-white" style="font-size: 2rem;"></i>
  </a>
</body>

</html>
