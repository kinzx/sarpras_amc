<?php helper('auth'); ?>
<nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">

  <!-- Toggle Menu untuk Mobile -->
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
      <i class="icon-base bx bx-menu icon-md"></i>
    </a>
  </div>

  <!-- Search -->
  <div class="navbar-nav align-items-center flex-grow-1 me-3">
    <div class="nav-item navbar-search-wrapper mb-0 w-100">
      <form action="<?= base_url('barang') ?>" method="GET" class="d-flex align-items-center">
        <div class="input-group input-group-merge w-100">
          <span class="input-group-text border-0 ps-0" id="topbar-search-icon">
            <i class="bx bx-search fs-4 text-muted"></i>
          </span>
          <input type="text" name="q" class="form-control border-0 shadow-none ps-2" placeholder="Cari nama aset, kode barcode, serial number, atau ruangan..." aria-label="Search..." value="<?= esc($keyword ?? request()->getGet('q') ?? '') ?>" style="background: transparent;">
        </div>
      </form>
    </div>
  </div>
</nav>