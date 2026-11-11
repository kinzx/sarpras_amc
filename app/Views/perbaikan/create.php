<!doctype html>
<html lang="id" class="layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed" dir="ltr" data-skin="default" data-assets-path="<?= base_url('assets/') ?>" data-template="vertical-menu-template" data-bs-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $title ?? 'Form Pelaporan Perbaikan' ?> | RS AMC</title>
  <link rel="icon" type="image/png" sizes="64x64" href="<?= base_url('AMC-tanpa-nama-pad.png') ?>" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('AMC-tanpa-nama-pad.png') ?>" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet" media="print" onload="this.media='all'" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/iconify-icons.css') ?>" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/filepond@4.32.7/dist/filepond.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/filepond-plugin-image-preview@4.6.12/dist/filepond-plugin-image-preview.min.css" />
  <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/industrial.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('dist/libs/select2/select2.css') ?>" />
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

          <div class="container-xxl flex-grow-1 container-p-y">
            <!-- BREADCRUMB -->
            <nav aria-label="breadcrumb" class="mb-4">
              <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><i class="bx bx-home-alt me-1"></i> Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('perbaikan') ?>">Perbaikan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Buat Laporan Baru</li>
              </ol>
            </nav>

            <?php if (session()->getFlashdata('errors')): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6 class="alert-heading fw-bold mb-1"><i class="bx bx-error-circle me-1"></i> Terjadi Kesalahan Pengisian:</h6>
                <ul class="mb-0 ps-3">
                  <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                  <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

            <div class="row justify-content-center">
              <div class="col-lg-10 col-xl-8">
                <!-- FORM CARD INDUSTRIAL -->
                <div class="card" style="border: 1px solid var(--border-subtle); border-radius: 6px; box-shadow: 0 1px 3px rgba(15,23,42,0.05);">
                  <div class="card-header border-bottom py-3 px-4 bg-white">
                    <h5 class="card-title mb-0 fw-bold text-dark d-flex align-items-center" style="font-size: 1.05rem;">
                      <i class="bx bx-plus-circle me-2 text-slate-700"></i> Laporan Kerusakan
                    </h5>
                    <small class="text-muted">Pelaporan awal kerusakan inventaris / alat medis rumah sakit.</small>
                  </div>
                  <div class="card-body p-4">
                    <form action="<?= base_url('perbaikan/simpan') ?>" method="POST" enctype="multipart/form-data">
                      <?= csrf_field() ?>

                      <!-- 1. Pilih Pelapor (Pegawai / Teknisi) & Tanggal Laporan -->
                      <div class="row g-3 mb-4">
                        <div class="col-md-7">
                          <label class="form-label text-dark fw-semibold small">Pelapor (Pegawai / Teknisi / Akun) <span class="text-danger">*</span></label>
                          <select class="form-select" name="pelapor_raw" id="select-pelapor" required data-placeholder="-- Cari Nama Pegawai, Teknisi, atau Akun User --">
                            <option value=""></option>
                            <?php if (!empty($list_pelapor)): ?>
                              <?php foreach ($list_pelapor as $pelapor): ?>
                                <option value="<?= esc($pelapor['id']) ?>" <?= (string) old('pelapor_raw') === (string) $pelapor['id'] ? 'selected' : '' ?>>
                                  <?= esc($pelapor['text']) ?>
                                </option>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </select>
                          <small class="text-muted" style="font-size: 0.75rem;">Pegawai, teknisi, atau akun user yang melaporkan kerusakan alat.</small>
                        </div>

                        <div class="col-md-5">
                          <label class="form-label text-dark fw-semibold small">Tanggal Laporan <span class="text-danger">*</span></label>
                          <input type="date" class="form-control" name="tanggal_perbaikan" value="<?= esc(old('tanggal_perbaikan') ?: date('Y-m-d')) ?>" required>
                          <small class="text-muted" style="font-size: 0.75rem;">Tanggal terjadinya atau ditemukannya kerusakan.</small>
                        </div>
                      </div>

                      <!-- 2. Pilih Barang yang Dilaporkan -->
                      <div class="mb-4">
                        <label class="form-label text-dark fw-semibold small">Pilih Barang / Alat Medis Rusak <span class="text-danger">*</span></label>
                        <select class="form-select select2" name="barang_id" id="barang_id" required>
                          <option value="">-- Ketik nama atau kode aset untuk mencari --</option>
                          <?php foreach ($barang as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= (string) old('barang_id', $selectedBarangId) === (string) $row['id'] ? 'selected' : '' ?>>
                              <?= esc($row['nama_barang']) ?> (<?= esc($row['kode_aset']) ?>) - <?= esc($row['nama_ruang'] ?? '-') ?> [<?= esc($row['kondisi_barang'] ?? 'Baik') ?>]
                            </option>
                          <?php endforeach; ?>
                        </select>
                        <small class="text-muted" style="font-size: 0.75rem;">Pilih alat atau ketik kode/nama pada kolom pencarian.</small>
                      </div>

                      <!-- 4. Rincian / Gejala Kerusakan -->
                      <div class="mb-4">
                        <label class="form-label text-dark fw-semibold small">Gejala / Deskripsi Kerusakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="laporan_kerusakan" rows="3" placeholder="Jelaskan secara jelas gejala atau indikasi kerusakan alat yang terjadi..." required><?= esc(old('laporan_kerusakan')) ?></textarea>
                      </div>

                      <!-- 5. Upload Foto Bukti Fisik (FilePond) -->
                      <div class="mb-4">
                        <label for="foto_sebelum" class="form-label text-dark fw-semibold small">Foto Bukti Fisik Kerusakan (Opsional)</label>
                        <div class="rounded-3 border bg-light p-3">
                          <input type="file" class="filepond" id="foto_sebelum" name="foto_sebelum" accept="image/jpeg,image/png,image/webp">
                          <small class="text-muted d-block mt-2">Format: JPG, PNG, atau WEBP (Maksimal 2 MB)</small>
                        </div>
                      </div>

                      <!-- Tombol Aksi -->
                      <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="<?= base_url('perbaikan') ?>" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary" id="btnSubmitPerbaikan">
                          <i class="bx bx-paper-plane me-1"></i> Kirim Laporan Perbaikan
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

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
  <script src="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/js/menu.js') ?>"></script>
  <script src="<?= base_url('assets/js/main.js') ?>"></script>
  <script src="<?= base_url('dist/libs/select2/select2.js') ?>"></script>

  <script src="https://cdn.jsdelivr.net/npm/filepond@4.32.7/dist/filepond.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/filepond-plugin-file-validate-type@1.2.9/dist/filepond-plugin-file-validate-type.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/filepond-plugin-file-validate-size@2.2.8/dist/filepond-plugin-file-validate-size.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/filepond-plugin-image-preview@4.6.12/dist/filepond-plugin-image-preview.min.js"></script>

  <script>
    if (window.FilePond) {
      FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginFileValidateSize,
        FilePondPluginImagePreview
      );

      FilePond.create(document.querySelector('#foto_sebelum'), {
        name: 'foto_sebelum',
        allowMultiple: false,
        required: false,
        storeAsFile: true,
        maxFileSize: '2MB',
        acceptedFileTypes: ['image/jpeg', 'image/png', 'image/webp'],
        imagePreviewHeight: 160,
        labelIdle: 'Seret dan lepaskan foto bukti atau <span class="filepond--label-action">Pilih file</span>',
        labelFileTypeNotAllowed: 'Format file tidak didukung',
        labelMaxFileSizeExceeded: 'Ukuran file terlalu besar',
        labelMaxFileSize: 'Ukuran maksimal adalah {filesize}'
      });
    }

    $(document).ready(function() {
      // Inisialisasi Select2 untuk Pelapor (id="select-pelapor")
      $('#select-pelapor').select2({
        width: '100%',
        placeholder: '-- Cari Nama Pegawai, Teknisi, atau Akun User --',
        allowClear: true
      });

      // Inisialisasi Select2 untuk Pilih Barang / Alat
      $('#barang_id').select2({
        width: '100%',
        placeholder: '-- Ketik nama atau kode aset untuk mencari --',
        allowClear: true
      });

      // Cegah double submit form perbaikan
      $('form[action*="perbaikan/simpan"]').on('submit', function(e) {
        var $btn = $('#btnSubmitPerbaikan');
        if ($btn.prop('disabled')) {
          e.preventDefault();
          return false;
        }
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Mengirim Laporan...');
      });
    });
  </script>
</body>
</html>
