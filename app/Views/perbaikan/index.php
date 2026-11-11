<!doctype html>
<html lang="id" class="layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed" dir="ltr" data-skin="default" data-assets-path="<?= base_url('assets/') ?>" data-template="vertical-menu-template" data-bs-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $title ?? 'Daftar Laporan Perbaikan' ?> | RS AMC</title>
  <link rel="icon" type="image/png" sizes="64x64" href="<?= base_url('AMC-tanpa-nama-pad.png') ?>" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('AMC-tanpa-nama-pad.png') ?>" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet" media="print" onload="this.media='all'" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/iconify-icons.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/pickr/pickr-themes.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/industrial.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />
  <script src="<?= base_url('assets/vendor/js/helpers.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/js/template-customizer.js') ?>"></script>
  <script src="<?= base_url('assets/js/config.js') ?>"></script>
</head>
<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <?= view('adds/sidebar') ?>
      <div class="menu-mobile-toggler d-xl-none rounded-1">
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
          <i class="bx bx-menu icon-base"></i>
          <i class="bx bx-chevron-right icon-base"></i>
        </a>
      </div>
      <div class="layout-page">
        <?= view('adds/navbar') ?>
        <div class="content-wrapper">
          <?= view('perbaikan/main') ?>
          <?= view('adds/footer') ?>
          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
    <div class="drag-target"></div>
  </div>

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

  <!-- SCRIPT AJAX MODAL TINDAK LANJUT & LOG PENANGANAN (TUGAS 4) -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputPerbaikanId = document.getElementById('modal_perbaikan_id');
        const selectStatus = document.getElementById('modal_status');
        const selectTeknisi = document.getElementById('modal_teknisi_utama_id');
        const tbodyLog = document.getElementById('tabel_log_body');
        const infoBarang = document.getElementById('info_nama_barang');
        const infoPelapor = document.getElementById('info_pelapor');
        const infoLaporan = document.getElementById('info_laporan_kerusakan');

        document.querySelectorAll('.btn-tindak-lanjut').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const currentStatus = this.getAttribute('data-status');
                const namaBarang = this.getAttribute('data-barang') || '-';
                const kodeAset = this.getAttribute('data-kode') || '-';
                const pelapor = this.getAttribute('data-pelapor') || '-';
                const teknisiId = this.getAttribute('data-teknisi-id') || '';
                const laporan = this.getAttribute('data-laporan') || '-';

                inputPerbaikanId.value = id;
                if (infoBarang) infoBarang.textContent = `${namaBarang} (${kodeAset})`;
                if (infoPelapor) infoPelapor.textContent = pelapor;
                if (infoLaporan) infoLaporan.textContent = `"${laporan}"`;

                if (selectTeknisi) {
                    selectTeknisi.value = teknisiId;
                }

                if (currentStatus && ['diproses', 'selesai', 'ditolak'].includes(currentStatus)) {
                    selectStatus.value = currentStatus;
                } else {
                    selectStatus.value = 'diproses';
                }

                tbodyLog.innerHTML = '<tr><td colspan="5" class="text-center py-3 text-muted"><span class="spinner-border spinner-border-sm me-1"></span>Memuat log penanganan...</td></tr>';

                fetch('<?= site_url("perbaikan/get-log") ?>/' + id)
                    .then(response => {
                        if (!response.ok) throw new Error('Network error');
                        return response.json();
                    })
                    .then(res => {
                        if (res.status === 'success' && res.data && res.data.length > 0) {
                            tbodyLog.innerHTML = res.data.map(item => {
                                let badgeClass = 'badge-status-box';
                                const s = (item.status || '').toLowerCase();
                                if (s === 'selesai') badgeClass += ' active';
                                else if (s === 'diproses') badgeClass += ' info';
                                else if (s === 'menunggu') badgeClass += ' warning';
                                else badgeClass += ' danger';

                                return `
                                    <tr>
                                        <td><strong class="text-dark">${item.nama_petugas}</strong></td>
                                        <td class="font-monospace" style="font-size: 0.78rem;">${item.tanggal}</td>
                                        <td class="font-monospace" style="font-size: 0.78rem;">${item.jam}</td>
                                        <td style="white-space: normal;" class="text-slate-700">${item.penanganan}</td>
                                        <td><span class="${badgeClass}">${item.status.toUpperCase()}</span></td>
                                    </tr>
                                `;
                            }).join('');
                        } else {
                            tbodyLog.innerHTML = '<tr><td colspan="5" class="text-center py-2 text-muted">Belum ada riwayat aktivitas log.</td></tr>';
                        }
                    })
                    .catch(err => {
                        console.error('Error fetching logs:', err);
                        tbodyLog.innerHTML = '<tr><td colspan="5" class="text-center py-2 text-danger">Gagal memuat riwayat log.</td></tr>';
                    });
            });
        });
    });
  </script>
</body>
</html>
