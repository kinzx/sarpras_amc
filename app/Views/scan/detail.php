<!DOCTYPE html>
<html lang="id" class="light-style layout-wide" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title><?= esc($title ?? 'Detail Barang') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fonts/boxicons.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css') ?>" />
    <style>
        body { background-color: #f5f6fa; }
        .guest-card { max-width: 800px; margin: 2rem auto; border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
        .spec-item { padding: 0.75rem 0; border-bottom: 1px solid #edf2f7; }
        .spec-item:last-child { border-bottom: none; }
    </style>
</head>
<body>
    <div class="container p-3">
        <div class="card guest-card">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 text-primary fw-bold"><i class="bx bx-package me-2"></i>Informasi Aset Barang</h5>
                    <small class="text-muted">Mode Tamu (Guest) - Informasi Publik Aset</small>
                </div>
                <span class="badge bg-label-primary"><?= esc($barang['kode_aset']) ?></span>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-5 text-center">
                        <?php if (!empty($barang['foto']) && file_exists(FCPATH . 'uploads/barang/' . $barang['foto'])): ?>
                            <img src="<?= base_url('uploads/barang/' . $barang['foto']) ?>" alt="<?= esc($barang['nama_barang']) ?>" class="img-fluid rounded border mb-3" style="max-height: 260px; object-fit: cover; width: 100%;">
                        <?php else: ?>
                            <div class="rounded border d-flex flex-column align-items-center justify-content-center bg-light text-muted mb-3" style="height: 220px;">
                                <i class="bx bx-image-alt" style="font-size: 3rem;"></i>
                                <span class="small mt-2">Tidak ada foto</span>
                            </div>
                        <?php endif; ?>
                        <div class="p-2 border rounded bg-white text-center">
                            <span class="text-muted d-block small">Status Barang</span>
                            <span class="badge bg-<?= $barang['is_active'] ? 'success' : 'danger' ?> mt-1">
                                <?= $barang['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h4 class="fw-bold mb-1"><?= esc($barang['nama_barang'] ?? '-') ?></h4>
                        <p class="text-muted small mb-3"><?= esc($barang['nama_kategori'] ?? '-') ?> &bull; <?= esc($barang['nama_sub_kategori'] ?? '-') ?></p>

                        <div class="spec-list">
                            <div class="spec-item d-flex justify-content-between">
                                <span class="text-muted">Kode Aset</span>
                                <span class="fw-semibold"><?= esc($barang['kode_aset'] ?? '-') ?></span>
                            </div>
                            <div class="spec-item d-flex justify-content-between">
                                <span class="text-muted">Merek / Tipe</span>
                                <span class="fw-semibold"><?= esc($barang['merek'] ?? '-') ?> / <?= esc($barang['tipe'] ?? '-') ?></span>
                            </div>
                            <div class="spec-item d-flex justify-content-between">
                                <span class="text-muted">Nomor Seri</span>
                                <span class="fw-semibold"><?= esc($barang['no_seri'] ?? '-') ?></span>
                            </div>
                            <div class="spec-item d-flex justify-content-between">
                                <span class="text-muted">Lokasi Ruangan</span>
                                <span class="fw-semibold"><?= esc($barang['nama_ruang'] ?? '-') ?> (Lantai <?= esc($barang['lantai'] ?? '-') ?>)</span>
                            </div>
                            <div class="spec-item d-flex justify-content-between">
                                <span class="text-muted">Kondisi</span>
                                <span class="fw-semibold badge bg-label-info"><?= esc($barang['kondisi_barang'] ?? 'Baik') ?></span>
                            </div>
                            <div class="spec-item d-flex justify-content-between">
                                <span class="text-muted">Kepemilikan</span>
                                <span class="fw-semibold"><?= esc($barang['kepemilikan'] ?? 'RS') ?></span>
                            </div>
                        </div>

                        <?php if (!empty($barang['keterangan'])): ?>
                            <div class="mt-3 p-3 bg-light rounded">
                                <span class="d-block text-muted small fw-semibold">Keterangan:</span>
                                <span class="small"><?= nl2br(esc($barang['keterangan'])) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-top py-3 text-center text-muted small">
                RS AMC Muhammadiyah &bull; Sistem Informasi Sarana & Prasarana
            </div>
        </div>
    </div>
</body>
</html>
