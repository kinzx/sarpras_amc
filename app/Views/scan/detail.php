<!DOCTYPE html>
<html lang="id" class="light-style layout-wide" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= esc($title ?? "Detail Barang") ?> | RS AMC</title>
    <link rel="icon" type="image/png" sizes="64x64" href="<?= base_url("AMC-tanpa-nama-pad.png") ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url("AMC-tanpa-nama-pad.png") ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet" media="print" onload="this.media='all'" />

    <link rel="stylesheet" href="<?= base_url("assets/vendor/fonts/boxicons.css") ?>" />
    <link rel="stylesheet" href="<?= base_url("assets/vendor/css/core.css") ?>" />
    <link rel="stylesheet" href="<?= base_url("assets/css/industrial.css") ?>" />

    <style>
        body { background-color: #f1f5f9; font-family: var(--font-body); }
        .guest-card {
            max-width: 760px;
            margin: 2rem auto;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.05);
        }
        .guest-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            background: #ffffff;
        }
        .spec-item {
            padding: 0.65rem 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.88rem;
        }
        .spec-item:last-child { border-bottom: none; }
    </style>
</head>
<body>
    <div class="container p-3">
        <div class="guest-card">
            <div class="guest-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h5 class="mb-0 fw-bold text-dark" style="font-family: var(--font-heading);">
                        <i class="bx bx-package text-slate-700 me-1"></i> Informasi Aset Inventaris
                    </h5>
                    <small class="text-muted">Portal Tamu &bull; Akses Publik Aset Rumah Sakit</small>
                </div>
                <span class="badge-code"><?= esc($barang["kode_aset"] ?? "-") ?></span>
            </div>
            <div class="p-4">
                <div class="row g-4">
                    <div class="col-md-5 text-center">
                        <?php if (!empty($barang["foto"]) && file_exists(FCPATH . "uploads/barang/" . $barang["foto"])): ?>
                            <img src="<?= base_url("uploads/barang/" . $barang["foto"]) ?>" alt="<?= esc($barang["nama_barang"]) ?>" class="img-fluid border mb-3" style="max-height: 240px; object-fit: cover; width: 100%; border-radius: 4px; border-color: #cbd5e1 !important;">
                        <?php else: ?>
                            <div class="border d-flex flex-column align-items-center justify-content-center text-muted mb-3" style="height: 200px; background: #f8fafc; border-radius: 4px; border-color: #cbd5e1 !important;">
                                <i class="bx bx-image-alt fs-1"></i>
                                <span class="small mt-1">Tidak ada foto</span>
                            </div>
                        <?php endif; ?>
                        <div class="p-2 border text-center" style="border-radius: 4px; background: #f8fafc; border-color: #e2e8f0 !important;">
                            <span class="text-muted d-block small" style="font-size: 0.72rem;">STATUS OPERASIONAL</span>
                            <span class="badge-status-box <?= !empty($barang["is_active"]) ? 'active' : 'danger' ?> mt-1">
                                <?= !empty($barang["is_active"]) ? "Aktif" : "Nonaktif" ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h4 class="fw-bold text-dark mb-1" style="font-family: var(--font-heading);"><?= esc($barang["nama_barang"] ?? "-") ?></h4>
                        <p class="text-muted small mb-3"><?= esc($barang["nama_kategori"] ?? "-") ?> &bull; <?= esc($barang["nama_sub_kategori"] ?? "-") ?></p>

                        <div class="spec-list">
                            <div class="spec-item d-flex justify-content-between align-items-center">
                                <span class="text-muted">Kode Aset</span>
                                <span class="badge-code"><?= esc($barang["kode_aset"] ?? "-") ?></span>
                            </div>
                            <div class="spec-item d-flex justify-content-between align-items-center">
                                <span class="text-muted">Merek / Tipe</span>
                                <span class="fw-semibold text-dark"><?= esc($barang["merek"] ?? "-") ?> / <?= esc($barang["tipe"] ?? "-") ?></span>
                            </div>
                            <div class="spec-item d-flex justify-content-between align-items-center">
                                <span class="text-muted">Nomor Seri</span>
                                <span class="font-monospace text-dark"><?= esc($barang["no_seri"] ?? "-") ?></span>
                            </div>
                            <div class="spec-item d-flex justify-content-between align-items-center">
                                <span class="text-muted">Lokasi Ruangan</span>
                                <span class="fw-semibold text-dark"><?= esc($barang["nama_ruang"] ?? "-") ?> <small class="text-muted font-monospace">(Lt. <?= esc($barang["lantai"] ?? "-") ?>)</small></span>
                            </div>
                            <div class="spec-item d-flex justify-content-between align-items-center">
                                <span class="text-muted">Kondisi</span>
                                <span class="badge-status-box info"><?= esc($barang["kondisi_barang"] ?? "Baik") ?></span>
                            </div>
                            <div class="spec-item d-flex justify-content-between align-items-center">
                                <span class="text-muted">Kepemilikan</span>
                                <span class="fw-semibold text-dark"><?= esc($barang["kepemilikan"] ?? "RS") ?></span>
                            </div>
                        </div>

                        <?php if (!empty($barang["keterangan"])): ?>
                            <div class="mt-3 p-3 border" style="border-radius: 4px; background: #f8fafc; border-color: #e2e8f0 !important;">
                                <span class="d-block text-muted small fw-semibold mb-1">Catatan Tambahan:</span>
                                <span class="small text-slate-700" style="line-height: 1.4;"><?= nl2br(esc($barang["keterangan"])) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="p-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2" style="background: #f8fafc; border-color: #e2e8f0 !important; border-radius: 0 0 6px 6px;">
                <a href="<?= base_url("scan") ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="bx bx-qr-scan me-1"></i> Scan Barang Lain
                </a>
                <?php if (function_exists("logged_in") && logged_in()): ?>
                    <a href="<?= base_url("barang/detail/" . $barang["id"]) ?>" class="btn btn-sm btn-primary">
                        <i class="bx bx-shield-quarter me-1"></i> Buka Detail Lengkap (Internal)
                    </a>
                <?php else: ?>
                    <span class="text-muted small">RS AMC Muhammadiyah &bull; Sarpras</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
