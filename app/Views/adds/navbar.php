<?php helper('auth'); ?>
<nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">

  <!-- Toggle Menu untuk Mobile -->
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
      <i class="icon-base bx bx-menu icon-md"></i>
    </a>
  </div>

  <!-- Search -->
  <div class="navbar-nav align-items-center">
    <div class="nav-item navbar-search-wrapper mb-0">
      <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
        <!-- Cukup gunakan ikon dan teks statis, hapus id="autocomplete" agar tidak ditimpa JS template -->
        <span class="d-inline-block text-body-secondary fw-normal">
          <i class="bx bx-search align-middle me-1"></i> Cari aset, serial number, atau ruangan...
        </span>
      </a>
    </div>
  </div>
</nav>