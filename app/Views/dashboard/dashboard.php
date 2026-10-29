<!doctype html>

<html
  lang="en"
  class="layout-navbar-fixed layout-menu-fixed layout-compact"
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

    <title><?= $title ?? "Dashboard | AMC" ?></title>

    <meta name="description" content="Aplikasi Sarana Prasarana AMC" />

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

    <link rel="stylesheet" href="<?= base_url(
        "assets/vendor/fonts/iconify-icons.css",
    ) ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url(
        "assets/vendor/libs/pickr/pickr-themes.css",
    ) ?>" />
    <link rel="stylesheet" href="<?= base_url(
        "assets/vendor/css/core.css",
    ) ?>" />
    <link rel="stylesheet" href="<?= base_url("assets/css/demo.css") ?>" />
    <link rel="stylesheet" href="<?= base_url(
        "assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css",
    ) ?>" />
    <link rel="stylesheet" href="<?= base_url(
        "assets/vendor/libs/apex-charts/apex-charts.css",
    ) ?>" />

    <!-- Helpers -->
    <script src="<?= base_url("assets/vendor/js/helpers.js") ?>"></script>
    <script src="<?= base_url(
        "assets/vendor/js/template-customizer.js",
    ) ?>"></script>
    <script src="<?= base_url("assets/js/config.js") ?>"></script>
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

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <?= view("dashboard/main") ?>

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
    <script src="<?= base_url(
        "assets/vendor/libs/jquery/jquery.js",
    ) ?>"></script>
    <script src="<?= base_url(
        "assets/vendor/libs/popper/popper.js",
    ) ?>"></script>
    <script src="<?= base_url("assets/vendor/js/bootstrap.js") ?>"></script>
    <script src="<?= base_url(
        "assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js",
    ) ?>"></script>
    <script src="<?= base_url("assets/vendor/js/menu.js") ?>"></script>

    <!-- Vendors JS -->
    <script src="<?= base_url(
        "assets/vendor/libs/apex-charts/apexcharts.js",
    ) ?>"></script>

    <!-- Main JS -->
    <script src="<?= base_url("assets/js/main.js") ?>"></script>
  </body>
</html>
