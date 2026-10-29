<!doctype html>
<html lang="id" class="layout-navbar-fixed layout-menu-fixed layout-compact layout-menu-collapsed" dir="ltr" data-skin="default" data-assets-path="<?= base_url(
    "assets/",
) ?>" data-template="vertical-menu-template" data-bs-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title><?= $title ?? "Daftar & Input Perbaikan" ?> | RS AMC</title>
  <link rel="icon" type="image/x-icon" href="<?= base_url(
      "assets/img/favicon/favicon.ico",
  ) ?>" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url(
      "assets/vendor/fonts/iconify-icons.css",
  ) ?>" />
  <link rel="stylesheet" href="<?= base_url(
      "assets/vendor/libs/pickr/pickr-themes.css",
  ) ?>" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/filepond@4.32.7/dist/filepond.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/filepond-plugin-image-preview@4.6.12/dist/filepond-plugin-image-preview.min.css" />
  <link rel="stylesheet" href="<?= base_url("assets/vendor/css/core.css") ?>" />
  <link rel="stylesheet" href="<?= base_url("assets/css/demo.css") ?>" />
  <link rel="stylesheet" href="<?= base_url(
      "assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css",
  ) ?>" />
  <script src="<?= base_url("assets/vendor/js/helpers.js") ?>"></script>
  <script src="<?= base_url(
      "assets/vendor/js/template-customizer.js",
  ) ?>"></script>
  <script src="<?= base_url("assets/js/config.js") ?>"></script>
</head>
<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <?= view("adds/sidebar") ?>
      <div class="menu-mobile-toggler d-xl-none rounded-1">
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
          <i class="bx bx-menu icon-base"></i>
          <i class="bx bx-chevron-right icon-base"></i>
        </a>
      </div>
      <div class="layout-page">
        <?= view("adds/navbar") ?>
        <div class="content-wrapper">

          <div class="container-xxl flex-grow-1 container-p-y">
            <!-- BREADCRUMB -->
            <nav aria-label="breadcrumb" class="mb-4">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(
                    "dashboard",
                ) ?>"><i class="bx bx-home-alt me-1"></i> Beranda</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url(
                    "perbaikan",
                ) ?>">Perbaikan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daftar & Input Perbaikan</li>
              </ol>
            </nav>

            <?php if (session()->getFlashdata("errors")): ?>
              <div class="alert alert-danger alert-dismissible" role="alert">
                <ul class="mb-0">
                  <?php foreach (
                      session()->getFlashdata("errors")
                      as $error
                  ): ?>
                    <li><?= esc($error) ?></li>
                  <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>

            <div class="row g-4">
              <!-- KOLOM KIRI: DAFTAR BARANG RUSAK / PERLU SERVIS -->
              <div class="col-lg-5">
                <div class="card h-100">
                  <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <div>
                      <h5 class="card-title mb-0"><i class="bx bx-error-circle text-danger me-2"></i> Daftar Barang Perlu Servis</h5>
                      <small class="text-muted">Aset dengan kondisi Rusak Ringan / Berat</small>
                    </div>
                    <span class="badge bg-label-danger"><?= count(
                        $barangRusak,
                    ) ?> Unit</span>
                  </div>
                  <div class="card-body p-0">
                    <?php if (empty($barangRusak)): ?>
                      <div class="text-center py-5 text-muted">

                        Semua aset saat ini dalam kondisi Baik.
                      </div>
                    <?php else: ?>
                      <div class="list-group list-group-flush" style="max-height: 580px; overflow-y: auto;">
                        <?php foreach ($barangRusak as $b): ?>
                          <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div>
                              <div class="fw-bold mb-1"><?= esc(
                                  $b["nama_barang"],
                              ) ?></div>
                              <small class="text-muted d-block font-monospace"><?= esc(
                                  $b["kode_aset"],
                              ) ?> &bull; <?= esc(
     $b["nama_ruang"] ?? "-",
 ) ?></small>
                              <div class="mt-1">
                                <?php if (
                                    $b["kondisi_barang"] === "Rusak Berat"
                                ): ?>
                                  <span class="badge bg-label-danger">Rusak Berat</span>
                                <?php elseif (
                                    $b["kondisi_barang"] === "Rusak Ringan"
                                ): ?>
                                  <span class="badge bg-label-warning">Rusak Ringan</span>
                                <?php else: ?>
                                  <span class="badge bg-label-info"><?= esc(
                                      $b["kondisi_barang"],
                                  ) ?></span>
                                <?php endif; ?>
                              </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary select-barang-btn"
                              data-id="<?= $b["id"] ?>"
                              data-nama="<?= esc($b["nama_barang"]) ?> (<?= esc(
     $b["kode_aset"],
 ) ?>)">
                              <i class="bx bx-wrench me-1"></i> Servis
                            </button>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <!-- KOLOM KANAN: FORM INPUT PERBAIKAN -->
              <div class="col-lg-7">
                <div class="card">
                  <div class="card-header border-bottom">
                    <h5 class="card-title mb-0"><i class="bx bx-edit-alt me-2"></i> Formulir Catatan Perbaikan</h5>
                  </div>
                  <div class="card-body pt-4">
                    <form action="<?= base_url(
                        "perbaikan/simpan",
                    ) ?>" method="POST" enctype="multipart/form-data">
                      <?= csrf_field() ?>

                      <!-- Pilih Barang -->
                      <div class="mb-3">
                        <label class="form-label">Pilih Barang yang Diperbaiki <span class="text-danger">*</span></label>
                        <select class="form-select" name="barang_id" id="barang_id" required>
                          <option value="">-- Pilih Barang / Aset --</option>
                          <?php foreach ($barang as $row): ?>
                            <option value="<?= $row["id"] ?>" <?= old(
    "barang_id",
    $selectedBarangId,
) == $row["id"]
    ? "selected"
    : "" ?>>
                              <?= esc($row["nama_barang"]) ?> (<?= esc(
     $row["kode_aset"],
 ) ?>) - <?= esc($row["nama_ruang"] ?? "-") ?> [<?= esc(
     $row["kondisi_barang"] ?? "Baik",
 ) ?>]
                            </option>
                          <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Pilih unit barang yang selesai diperbaiki atau sedang ditangani</small>
                      </div>

                      <div class="row g-3">
                        <!-- Tanggal Perbaikan -->
                        <div class="col-md-6 mb-3">
                          <label class="form-label">Tanggal Perbaikan <span class="text-danger">*</span></label>
                          <input type="date" class="form-control" name="tanggal_perbaikan" value="<?= esc(
                              old("tanggal_perbaikan") ?: date("Y-m-d"),
                          ) ?>" required>
                        </div>

                        <!-- Kondisi Setelah Perbaikan -->
                        <div class="col-md-6 mb-3">
                          <label class="form-label">Kondisi Setelah Perbaikan <span class="text-danger">*</span></label>
                          <select class="form-select" name="kondisi_setelah" required>
                            <option value="Baik" <?= old(
                                "kondisi_setelah",
                                "Baik",
                            ) === "Baik"
                                ? "selected"
                                : "" ?>>Baik (Sudah Normal)</option>
                            <option value="Cukup" <?= old("kondisi_setelah") ===
                            "Cukup"
                                ? "selected"
                                : "" ?>>Cukup (Bisa Digunakan)</option>
                            <option value="Rusak Ringan" <?= old(
                                "kondisi_setelah",
                            ) === "Rusak Ringan"
                                ? "selected"
                                : "" ?>>Masih Rusak Ringan (Perlu Tindak Lanjut)</option>
                            <option value="Rusak Berat" <?= old(
                                "kondisi_setelah",
                            ) === "Rusak Berat"
                                ? "selected"
                                : "" ?>>Rusak Berat (Tidak Tertolong)</option>
                          </select>
                          <small class="text-muted">Kondisi barang otomatis ter-update di master data</small>
                        </div>
                      </div>

                      <!-- Laporan Kerusakan -->
                      <div class="mb-3">
                        <label class="form-label">Laporan / Gejala Kerusakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="laporan_kerusakan" rows="2" placeholder="Contoh: AC tidak dingin, mengeluarkan bau hangus, dan ada bunyi berisik..." required><?= esc(
                            old("laporan_kerusakan"),
                        ) ?></textarea>
                      </div>

                      <!-- Analisa Kerusakan -->
                      <div class="mb-3">
                        <label class="form-label">Analisa Kerusakan</label>
                        <textarea class="form-control" name="analisa_kerusakan" rows="2" placeholder="Contoh: Kapasitor kompresor aus dan freon mengalami kebocoran di pipa outdoor..."><?= esc(
                            old("analisa_kerusakan"),
                        ) ?></textarea>
                      </div>

                      <!-- Tindakan yang Dilakukan -->
                      <div class="mb-3">
                        <label class="form-label">Tindakan / Solusi yang Dilakukan</label>
                        <textarea class="form-control" name="tindakan_dilakukan" rows="2" placeholder="Contoh: Penggantian kapasitor 35uF, pengelasan pipa, dan isi ulang freon R32..."><?= esc(
                            old("tindakan_dilakukan"),
                        ) ?></textarea>
                      </div>

                      <!-- Kesimpulan -->
                      <div class="mb-3">
                        <label class="form-label">Kesimpulan / Rekomendasi</label>
                        <input type="text" class="form-control" name="kesimpulan" value="<?= esc(
                            old("kesimpulan"),
                        ) ?>" placeholder="Contoh: Unit siap pakai, perlu pemantauan suhu 3 hari ke depan">
                      </div>

                      <!-- Upload Foto Kerusakan / Bukti -->
                      <div class="mb-4">
                        <label for="foto_sebelum" class="form-label fw-semibold">Foto Bukti / Fisik Kerusakan (Opsional)</label>
                        <div class="rounded-3 border bg-light p-3">
                          <input type="file" class="filepond" id="foto_sebelum" name="foto_sebelum" accept="image/jpeg,image/png,image/webp">
                          <small class="text-muted d-block mt-2">Format JPG/PNG/WEBP maks 2 MB</small>
                        </div>
                      </div>

                      <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url(
                            "perbaikan",
                        ) ?>" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Catatan Perbaikan</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <?= view("adds/footer") ?>
          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
    <div class="drag-target"></div>
  </div>

  <script src="<?= base_url("assets/vendor/libs/jquery/jquery.js") ?>"></script>
  <script src="<?= base_url("assets/vendor/libs/popper/popper.js") ?>"></script>
  <script src="<?= base_url("assets/vendor/js/bootstrap.js") ?>"></script>
  <script src="<?= base_url(
      "assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js",
  ) ?>"></script>
  <script src="<?= base_url("assets/vendor/js/menu.js") ?>"></script>
  <script src="<?= base_url("assets/js/main.js") ?>"></script>

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
  </script>

  <script>
    $(document).ready(function() {
      $('.select-barang-btn').click(function() {
        var id = $(this).data('id');
        $('#barang_id').val(id).trigger('change');
        $('html, body').animate({
          scrollTop: $('#barang_id').offset().top - 100
        }, 300);
      });
    });
  </script>
</body>
</html>
