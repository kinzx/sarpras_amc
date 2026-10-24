<style>
  /* Menjaga icon logo RS AMC tepat di tengah dan sejajar dengan menu saat sidebar collapse */
  .layout-menu-collapsed:not(.layout-menu-hover) .layout-menu .app-brand,
  .menu-collapsed:not(:hover) .app-brand {
    padding-inline: 0 !important;
    justify-content: center !important;
  }

  .layout-menu-collapsed:not(.layout-menu-hover) .layout-menu .app-brand-link,
  .menu-collapsed:not(:hover) .app-brand-link {
    margin-inline: auto !important;
    justify-content: center !important;
    width: 100% !important;
    text-align: center !important;
  }

  .layout-menu-collapsed:not(.layout-menu-hover) .layout-menu .app-brand-logo,
  .menu-collapsed:not(:hover) .app-brand-logo {
    margin-inline: auto !important;
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    width: 100% !important;
  }

  .layout-menu-collapsed:not(.layout-menu-hover) .layout-menu .app-brand-img-collapsed,
  .menu-collapsed:not(:hover) .app-brand-img-collapsed {
    margin: 0 auto !important;
    display: block !important;
  }
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu">
  <div class="app-brand demo">
    <a href="<?= base_url('/') ?>" class="app-brand-link">
      <span class="app-brand-logo demo">
        <!-- Logo Penuh (Tampil saat Sidebar Terbuka) -->
        <img src="<?= base_url('Logo-amc.png') ?>"
          alt="Logo RS AMC"
          class="app-brand-img"
          style="max-height: 38px; width: auto; max-width: 165px; object-fit: contain;">

        <!-- Logo Icon / Lambang (Tampil saat Sidebar Ditutup / Collapse) -->
        <img src="<?= base_url('logo-amc-icon.png') ?>"
          alt="Logo RS AMC"
          class="app-brand-img-collapsed"
          style="max-height: 34px; width: auto; object-fit: contain;">
      </span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="icon-base bx bx-chevron-left"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item <?= url_is('/') ? 'active' : '' ?>">
      <a href="<?= base_url('/') ?>" class="menu-link">
        <i class="menu-icon icon-base bx bx-home-smile"></i>
        <div data-i18n="Dashboard">Dashboard</div>
      </a>
    </li>

    <!-- Master Data -->
    <li class="menu-item <?= (url_is('barang*') || url_is('kategori*') || url_is('ruang*') || url_is('master-data*')) ? 'active open' : '' ?>">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon icon-base bx bx-layer"></i>
        <div data-i18n="Master Data">Master Data</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item <?= url_is('barang') ? 'active' : '' ?>">
          <a href="<?= base_url('barang') ?>" class="menu-link">
            <div data-i18n="Barang">Barang</div>
          </a>
        </li>
        <li class="menu-item <?= url_is('kategori') ? 'active' : '' ?>">
          <a href="<?= base_url('kategori') ?>" class="menu-link">
            <div data-i18n="Kategori">Kategori</div>
          </a>
        </li>
        <li class="menu-item <?= url_is('ruang') ? 'active' : '' ?>">
          <a href="<?= base_url('ruang') ?>" class="menu-link">
            <div data-i18n="Ruang">Ruangan</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="<?= base_url('pengguna') ?>" class="menu-link">
            <div data-i18n="Pengguna & Role">Pengguna & Role</div>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</aside>