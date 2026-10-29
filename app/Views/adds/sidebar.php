<?php helper("auth"); ?>
<style>
  /* 1. Membuat Sidebar menjadi Flexbox (Atas-Bawah) */
  .layout-menu {
    display: flex;
    flex-direction: column;
    height: 100vh;
    /* Memenuhi tinggi layar */
  }

  /* 2. Area Logo (Tetap di atas) */
  .sidebar-logo-area {
    flex-shrink: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #e7e7e8;
  }

  /* 3. Area Menu (Bisa di-scroll) */
  .sidebar-menu-scroll {
    flex-grow: 1;
    overflow-y: auto;
    overflow-x: hidden;
  }

  /* Menghilangkan scrollbar bawaan browser agar lebih rapi */
  .sidebar-menu-scroll::-webkit-scrollbar {
    width: 5px;
  }

  .sidebar-menu-scroll::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
  }

  /* 4. Area Bawah: Logout & Profil (Terkunci di bawah) */
  .sidebar-bottom-area {
    flex-shrink: 0;
    background-color: #fff;
    border-top: 1px solid #e7e7e8;
    padding: 10px;
  }

  .sidebar-user-profile {
    padding: 10px 10px 0 10px;
  }

  .sidebar-user-role {
    color: #a1acb8 !important;
    font-size: 11px;
    font-weight: 500;
  }

  .sidebar-user-name {
    color: #566a7f !important;
    font-weight: 600;
    font-size: 14px;
  }

  /* ========================================================= */
  /* ATURAN KHUSUS SAAT SIDEBAR DILIPAT (COLLAPSED)            */
  /* ========================================================= */
  .layout-menu-collapsed:not(.layout-menu-hover) .layout-menu .app-brand-text,
  .layout-menu-collapsed:not(.layout-menu-hover) .layout-menu .sidebar-user-name,
  .layout-menu-collapsed:not(.layout-menu-hover) .layout-menu .sidebar-user-role {
    display: none !important;
  }

  /* Menyembunyikan teks tombol logout, hanya menyisakan ikon */
  .layout-menu-collapsed:not(.layout-menu-hover) .layout-menu .logout-text {
    display: none !important;
  }

  /* Menyesuaikan tombol logout agar pas di tengah */
  .layout-menu-collapsed:not(.layout-menu-hover) .layout-menu .sidebar-logout-btn {
    padding: 0.25rem 0.5rem;
    justify-content: center !important;
  }

  /* Menyesuaikan posisi avatar profil agar di tengah */
  .layout-menu-collapsed:not(.layout-menu-hover) .layout-menu .sidebar-user-profile {
    padding: 5px 0 0 0;
    display: flex;
    justify-content: center;
  }

  .layout-menu-collapsed:not(.layout-menu-hover) .layout-menu .sidebar-user-profile a {
    margin: 0 auto;
    justify-content: center !important;
  }

  .layout-menu-collapsed:not(.layout-menu-hover) .layout-menu .sidebar-user-profile .avatar {
    margin-right: 0 !important;
  }

  .layout-menu-collapsed:not(.layout-menu-hover) .app-brand-img {
    max-height: 32px !important;
    max-width: 32px !important;
    object-fit: contain;
  }

  .app-brand-img-collapsed {
    display: none;
  }

  .layout-menu-collapsed:not(.layout-menu-hover) .app-brand-img-collapsed {
    display: block !important;
    max-height: 34px;
    width: auto;
  }
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-white">

  <div class="sidebar-logo-area app-brand demo justify-content-center">
    <a href="<?= base_url("/") ?>" class="app-brand-link">
      <span class="app-brand-logo demo">
        <!-- 1. Logo Penuh (Tampil saat sidebar terbuka) -->
        <img src="<?= base_url(
            "Logo-amc.png",
        ) ?>" alt="Logo RS AMC" class="app-brand-img" style="max-height: 38px; width: auto; max-width: 165px; object-fit: contain;">

        <!-- 2. Logo Ikon (Tampil saat sidebar tertutup) -->
        <img src="<?= base_url(
            "logo-amc-icon.png",
        ) ?>" alt="Logo RS AMC" class="app-brand-img-collapsed">
      </span>
    </a>
  </div>

  <!-- BAGIAN 2: MENU UTAMA (Bisa Scroll) -->
  <div class="sidebar-menu-scroll">
    <ul class="menu-inner py-1">

      <!-- 1. Dashboard -->
      <li class="menu-item <?= url_is("/") || url_is("dashboard")
          ? "active"
          : "" ?>">
        <a href="<?= base_url("dashboard") ?>" class="menu-link">
          <i class="menu-icon icon-base bx bx-home-smile"></i>
          <div data-i18n="Dashboard">Dashboard</div>
        </a>
      </li>

      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Data Master & Manajemen</span>
      </li>

      <!-- 2. Data Master (Hanya Admin) -->

        <li class="menu-item <?= url_is("kategori*") ||
        url_is("ruang*") ||
        url_is("pengguna*") ||
        url_is("sub-kategori*")
            ? "active open"
            : "" ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base bx bx-layer"></i>
            <div data-i18n="Data Master">Data Master</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?= url_is("barang*") ? "active" : "" ?>">
              <a href="<?= base_url("barang") ?>" class="menu-link">
                <div data-i18n="Barang">Barang</div>
              </a>
            </li>
            <li class="menu-item <?= url_is("kategori*") ? "active" : "" ?>">
              <a href="<?= base_url("kategori") ?>" class="menu-link">
                <div data-i18n="Kategori">Kategori</div>
              </a>
            </li>

            <li class="menu-item <?= url_is("ruang*") ? "active" : "" ?>">
              <a href="<?= base_url("ruang") ?>" class="menu-link">
                <div data-i18n="Ruangan">Ruangan</div>
              </a>
            </li>
          </ul>
        </li>

      <!-- 3. Pemeliharaan -->
      <li class="menu-item <?= url_is("maintenance*") ? "active open" : "" ?>">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon icon-base bx bx-wrench"></i>
          <div data-i18n="Pemeliharaan">Pemeliharaan</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item <?= url_is("maintenance/create")
              ? "active"
              : "" ?>">
            <a href="<?= base_url("maintenance/create") ?>" class="menu-link">
              <div data-i18n="Input Maintenance">Daftar Maintenance</div>
            </a>
          </li>
          <li class="menu-item <?= url_is("maintenance") ? "active" : "" ?>">
            <a href="<?= base_url("maintenance") ?>" class="menu-link">
              <div data-i18n="Riwayat Maintenance">Riwayat Maintenance</div>
            </a>
          </li>

        </ul>
      </li>

      <!-- 5. Perbaikan -->
      <li class="menu-item <?= url_is("perbaikan*") ? "active open" : "" ?>">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon icon-base bx bx-cog"></i>
          <div data-i18n="Perbaikan">Perbaikan</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item <?= url_is("perbaikan/create")
              ? "active"
              : "" ?>">
            <a href="<?= base_url("perbaikan/create") ?>" class="menu-link">
              <div data-i18n="Daftar Perbaikan">Daftar Perbaikan</div>
            </a>
          </li>
          <li class="menu-item <?= url_is("perbaikan") ? "active" : "" ?>">
            <a href="<?= base_url("perbaikan") ?>" class="menu-link">
              <div data-i18n="Riwayat Perbaikan">Riwayat Perbaikan</div>
            </a>
          </li>
        </ul>
      </li>

      <!-- 6. Kalibrasi -->
      <li class="menu-item <?= url_is("kalibrasi*") ? "active" : "" ?>">
        <a href="<?= base_url("kalibrasi") ?>" class="menu-link">
          <i class="menu-icon icon-base bx bx-check-shield"></i>
          <div data-i18n="Kalibrasi">Kalibrasi</div>
        </a>
      </li>

      <!-- 7. Laporan -->
      <li class="menu-item <?= url_is("laporan*") ? "active" : "" ?>">
        <a href="<?= base_url("laporan") ?>" class="menu-link">
          <i class="menu-icon icon-base bx bx-bar-chart-alt-2"></i>
          <div data-i18n="Laporan">Laporan</div>
        </a>
      </li>
    </ul>
  </div>

  <!-- BAGIAN 3: LOGOUT & PROFIL (Terpaku di bawah) -->
  <div class="sidebar-bottom-area">

    <!-- Tombol Logout -->
    <div class="pb-2">
      <a href="<?= base_url(
          "logout",
      ) ?>" class="btn btn-sm btn-outline-danger w-100 d-flex align-items-center justify-content-center sidebar-logout-btn" title="Keluar">
        <i class="icon-base bx bx-power-off"></i>
        <span class="logout-text ms-1">Keluar</span>
      </a>
    </div>

    <!-- Profil User -->
    <div class="sidebar-user-profile">
      <div class="dropdown dropup">
        <a href="javascript:void(0);" class="d-flex align-items-center text-decoration-none dropdown-toggle hide-arrow w-100" data-bs-toggle="dropdown">
          <div class="avatar avatar-online me-3">
            <span class="avatar-initial rounded-circle bg-label-primary">
              <i class="icon-base bx bx-user"></i>
            </span>
          </div>
          <div class="d-flex flex-column text-start overflow-hidden">
            <span class="sidebar-user-name text-truncate"><?= user()
                ? user()->username
                : "Guest" ?></span>
            <small class="sidebar-user-role">
              <?php
              $user = user();
              if ($user) {
                  $roles = $user->getRoles();
                  echo in_array("admin", $roles) ? "IT / Admin" : "Teknisi";
              } else {
                  echo "Guest";
              }
              ?>
            </small>
          </div>
        </a>
      </div>
    </div>
  </div>

</aside>
