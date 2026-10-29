<div class="container-xxl flex-grow-1 container-p-y">

    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><i class="bx bx-home-alt me-1"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('perbaikan') ?>">Perbaikan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Riwayat Perbaikan</li>
        </ol>
    </nav>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- HEADER CARD -->
    <div class="card mb-4">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h4 class="card-title mb-1">
                    <span class="text-primary me-2">|</span> Riwayat Perbaikan Aset
                </h4>
                <p class="text-muted mb-0">Catatan riwayat tindakan servis, perbaikan kerusakan, dan kondisi akhir aset rumah sakit.</p>
            </div>
            <a href="<?= base_url('perbaikan/create') ?>" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Input Perbaikan
            </a>
        </div>
    </div>

    <!-- STATISTIC CARDS -->
    <div class="row mb-4">
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">TOTAL PERBAIKAN</p>
                        <h3 class="mb-0 fw-bolder"><?= number_format($ringkasan['total'] ?? 0) ?></h3>
                    </div>
                    <div class="bg-label-primary rounded p-3">
                        <i class="bx bx-wrench fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">PERBAIKAN BULAN INI</p>
                        <h3 class="mb-0 fw-bolder"><?= number_format($ringkasan['bulan_ini'] ?? 0) ?></h3>
                    </div>
                    <div class="bg-label-success rounded p-3">
                        <i class="bx bx-calendar-check fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">ASET PERLU PERBAIKAN</p>
                        <h3 class="mb-0 fw-bolder text-danger"><?= number_format($ringkasan['perlu_perbaikan'] ?? 0) ?></h3>
                    </div>
                    <div class="bg-label-danger rounded p-3">
                        <i class="bx bx-error-alt fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER & SEARCH -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="<?= base_url('perbaikan') ?>" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Cari Nama Barang / Kode Aset / Kerusakan</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" name="q" class="form-control" placeholder="Contoh: AC, AMC-20261028-0001, pipa bocor..." value="<?= esc($keyword ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Filter Bulan</label>
                    <input type="month" name="bulan" class="form-control" value="<?= esc($bulan ?? '') ?>">
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="bx bx-filter-alt me-1"></i> Filter</button>
                    <?php if (!empty($keyword) || !empty($bulan)): ?>
                        <a href="<?= base_url('perbaikan') ?>" class="btn btn-outline-secondary">Reset</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- TABEL RIWAYAT PERBAIKAN -->
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Riwayat Perbaikan</h5>
            <span class="badge bg-label-info"><?= count($riwayat) ?> Data Ditemukan</span>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Tanggal</th>
                        <th>Barang & Kode Aset</th>
                        <th>Ruangan</th>
                        <th>Laporan Kerusakan</th>
                        <th>Tindakan Dilakukan</th>
                        <th>Kondisi Akhir</th>
                        <th>Petugas</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php if (empty($riwayat)): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bx bx-info-circle fs-1 d-block mb-2 text-secondary"></i>
                                Belum ada riwayat perbaikan yang tercatat.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($riwayat as $row): ?>
                            <tr>
                                <td><?= sprintf('%02d', $no++) ?></td>
                                <td>
                                    <span class="fw-semibold"><?= date('d M Y', strtotime($row['tanggal_perbaikan'])) ?></span>
                                </td>
                                <td>
                                    <strong><?= esc($row['nama_barang']) ?></strong>
                                    <small class="text-muted d-block font-monospace"><?= esc($row['kode_aset'] ?? '-') ?></small>
                                </td>
                                <td>
                                    <?= esc($row['nama_ruang'] ?? '-') ?>
                                    <small class="text-muted d-block">Lantai <?= esc($row['lantai'] ?? '1') ?></small>
                                </td>
                                <td style="max-width: 250px; white-space: normal;">
                                    <div class="text-truncate-2 small"><?= esc($row['laporan_kerusakan']) ?></div>
                                </td>
                                <td style="max-width: 250px; white-space: normal;">
                                    <div class="text-truncate-2 small"><?= esc($row['tindakan_dilakukan'] ?: '-') ?></div>
                                </td>
                                <td>
                                    <?php
                                        $kondisi = $row['kondisi_setelah'] ?? 'Baik';
                                        $badgeClass = 'bg-label-success';
                                        if ($kondisi === 'Cukup') $badgeClass = 'bg-label-info';
                                        elseif ($kondisi === 'Rusak Ringan') $badgeClass = 'bg-label-warning';
                                        elseif ($kondisi === 'Rusak Berat') $badgeClass = 'bg-label-danger';
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= esc($kondisi) ?></span>
                                </td>
                                <td>
                                    <span class="small text-muted"><i class="bx bx-user me-1"></i><?= esc($row['nama_petugas'] ?? 'Petugas') ?></span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-icon btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $row['id'] ?>" title="Lihat Detail">
                                        <i class="bx bx-show"></i>
                                    </button>
                                    <a href="<?= base_url('perbaikan/hapus/' . $row['id']) ?>" class="btn btn-sm btn-icon btn-outline-danger" onclick="return confirm('Hapus catatan perbaikan ini?')" title="Hapus">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- MODAL DETAIL PERBAIKAN -->
                            <div class="modal fade" id="modalDetail<?= $row['id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-bottom">
                                            <h5 class="modal-title">Detail Catatan Perbaikan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="bg-label-primary p-2 rounded me-3">
                                                    <i class="bx bx-wrench fs-2"></i>
                                                </div>
                                                <div>
                                                    <h5 class="mb-0"><?= esc($row['nama_barang']) ?></h5>
                                                    <small class="text-muted font-monospace"><?= esc($row['kode_aset']) ?> &bull; <?= esc($row['nama_ruang'] ?? '-') ?></small>
                                                </div>
                                            </div>

                                            <div class="list-group list-group-flush mb-3">
                                                <div class="list-group-item px-0">
                                                    <strong class="d-block text-muted small">Tanggal Perbaikan</strong>
                                                    <span><?= date('d F Y', strtotime($row['tanggal_perbaikan'])) ?></span>
                                                </div>
                                                <div class="list-group-item px-0">
                                                    <strong class="d-block text-muted small">Laporan Kerusakan</strong>
                                                    <span><?= nl2br(esc($row['laporan_kerusakan'])) ?></span>
                                                </div>
                                                <div class="list-group-item px-0">
                                                    <strong class="d-block text-muted small">Analisa Kerusakan</strong>
                                                    <span><?= nl2br(esc($row['analisa_kerusakan'] ?: '-')) ?></span>
                                                </div>
                                                <div class="list-group-item px-0">
                                                    <strong class="d-block text-muted small">Tindakan yang Dilakukan</strong>
                                                    <span><?= nl2br(esc($row['tindakan_dilakukan'] ?: '-')) ?></span>
                                                </div>
                                                <div class="list-group-item px-0">
                                                    <strong class="d-block text-muted small">Kondisi Setelah Perbaikan</strong>
                                                    <span class="badge <?= $badgeClass ?>"><?= esc($row['kondisi_setelah'] ?? 'Baik') ?></span>
                                                </div>
                                                <div class="list-group-item px-0">
                                                    <strong class="d-block text-muted small">Kesimpulan / Rekomendasi</strong>
                                                    <span><?= nl2br(esc($row['kesimpulan'] ?: '-')) ?></span>
                                                </div>
                                                <?php if (!empty($row['foto_sebelum'])): ?>
                                                    <div class="list-group-item px-0">
                                                        <strong class="d-block text-muted small mb-1">Foto Kerusakan / Bukti</strong>
                                                        <img src="<?= base_url('uploads/perbaikan/' . $row['foto_sebelum']) ?>" alt="Foto Kerusakan" class="img-fluid rounded border" style="max-height: 200px;">
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
