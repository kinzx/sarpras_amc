<div class="container-xxl flex-grow-1 container-p-y">

    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><i class="bx bx-home-alt me-1"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('perbaikan') ?>">Perbaikan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Riwayat Laporan Perbaikan</li>
        </ol>
    </nav>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle me-1"></i> <?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-error me-1"></i> <?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- HEADER HALAMAN (Industrial: Menyatu tanpa Card Template) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="page-header-title">Riwayat & Daftar Laporan Perbaikan</h1>
            <p class="page-header-desc">Pemantauan tiket perbaikan helpdesk medis oleh pegawai dan penanganan teknisi utama.</p>
        </div>
        <a href="<?= base_url('perbaikan/create') ?>" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Buat Laporan Baru
        </a>
    </div>

    <!-- FILTER & SEARCH (Industrial Filter Card) -->
    <div class="filter-card-industrial mb-4">
        <form method="GET" action="<?= base_url('perbaikan') ?>" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label text-dark fw-medium small mb-1">Cari Barang / Aset / Pelapor / Teknisi</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 4px 0 0 4px;"><i class="bx bx-search"></i></span>
                    <input type="text" name="q" class="form-control border-start-0" placeholder="Ketik kata kunci pencarian..." value="<?= esc($keyword ?? '') ?>">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label text-dark fw-medium small mb-1">Filter Periode Bulan</label>
                <input type="month" name="bulan" class="form-control" value="<?= esc($bulan ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label text-dark fw-medium small mb-1">Status Penanganan</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="menunggu" <?= ($status ?? '') === 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                    <option value="diproses" <?= ($status ?? '') === 'diproses' ? 'selected' : '' ?>>Diproses</option>
                    <option value="selesai" <?= ($status ?? '') === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                    <option value="ditolak" <?= ($status ?? '') === 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bx bx-filter-alt me-1"></i> Filter</button>
                <?php if (!empty($keyword) || !empty($bulan) || !empty($status)): ?>
                    <a href="<?= base_url('perbaikan') ?>" class="btn btn-outline-secondary" title="Reset Filter"><i class="bx bx-refresh"></i></a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- TABEL RIWAYAT PERBAIKAN (Industrial) -->
    <div class="table-card-industrial">
        <div class="card-header-industrial d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-semibold text-dark">Daftar Tiket Perbaikan</h6>
            <span class="text-muted small">Total: <?= count($riwayat ?? []) ?> Laporan</span>
        </div>
        <div class="table-responsive">
            <table class="table-industrial w-100">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO.</th>
                        <th style="width: 140px;">TANGGAL</th>
                        <th>BARANG & KODE ASET</th>
                        <th>PELAPOR (PEGAWAI)</th>
                        <th>TEKNISI UTAMA</th>
                        <th style="width: 120px;">STATUS</th>
                        <th class="text-center" style="width: 130px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayat)): ?>
                        <tr>
                            <td colspan="7" class="p-0">
                                <div class="empty-state-container">
                                    <div class="empty-state-icon">
                                        <i class="bx bx-wrench"></i>
                                    </div>
                                    <h6 class="fw-semibold text-dark mb-1">Belum Ada Tiket Perbaikan</h6>
                                    <p class="text-muted small mb-3">Tidak ada riwayat perbaikan yang sesuai dengan filter atau belum ada laporan yang masuk.</p>
                                    <a href="<?= base_url('perbaikan/create') ?>" class="btn btn-primary btn-sm">
                                        <i class="bx bx-plus me-1"></i> Buat Laporan Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $no = 1;
                        foreach ($riwayat as $row): 
                            $statusVal = strtolower((string) ($row['status'] ?? 'menunggu'));
                        ?>
                            <tr>
                                <td class="text-muted font-monospace" style="font-size: 0.8rem;"><?= sprintf("%02d", $no++) ?></td>
                                <td>
                                    <span class="fw-medium text-dark d-block">
                                        <?= !empty($row['tanggal_perbaikan']) ? date('d M Y', strtotime($row['tanggal_perbaikan'])) : date('d M Y', strtotime($row['created_at'])) ?>
                                    </span>
                                    <span class="text-muted font-monospace" style="font-size: 0.72rem;">
                                        <?= date('H:i', strtotime($row['created_at'])) ?> WIB
                                    </span>
                                </td>
                                <td>
                                    <strong class="text-dark d-block"><?= esc($row['nama_barang'] ?? '-') ?></strong>
                                    <span class="badge-code mt-1 d-inline-block"><?= esc($row['kode_aset'] ?? '-') ?></span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="d-inline-flex align-items-center justify-content-center me-2 text-muted" style="width: 24px; height: 24px; background: #f1f5f9; border-radius: 4px; font-size: 0.75rem;">
                                            <i class="bx <?= ($row['tipe_pelapor'] ?? '') === 'Teknisi' ? 'bx-wrench text-primary' : 'bx-user' ?>"></i>
                                        </span>
                                        <div>
                                            <span class="fw-medium text-dark d-block" style="font-size: 0.85rem;"><?= esc($row['nama_pelapor'] ?? '-') ?></span>
                                            <span class="text-muted" style="font-size: 0.7rem;"><?= esc($row['tipe_pelapor'] ?? 'Pelapor') ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="d-inline-flex align-items-center justify-content-center me-2 text-muted" style="width: 24px; height: 24px; background: #f1f5f9; border-radius: 4px; font-size: 0.75rem;">
                                            <i class="bx bx-wrench"></i>
                                        </span>
                                        <span class="text-slate-700"><?= esc($row['nama_teknisi'] ?? '-') ?></span>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($statusVal === 'selesai'): ?>
                                        <span class="badge-status-box active">Selesai</span>
                                    <?php elseif ($statusVal === 'diproses'): ?>
                                        <span class="badge-status-box info">Diproses</span>
                                    <?php elseif ($statusVal === 'menunggu'): ?>
                                        <span class="badge-status-box warning">Menunggu</span>
                                    <?php else: ?>
                                        <span class="badge-status-box danger">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-secondary btn-tindak-lanjut py-1 px-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalTindakLanjut"
                                            data-id="<?= $row['id'] ?>"
                                            data-status="<?= $statusVal ?>"
                                            data-barang="<?= esc($row['nama_barang'] ?? '') ?>"
                                            data-kode="<?= esc($row['kode_aset'] ?? '') ?>"
                                            data-pelapor="<?= esc(($row['nama_pelapor'] ?? '-') . ' (' . ($row['tipe_pelapor'] ?? 'Pelapor') . ')') ?>"
                                            data-teknisi-id="<?= esc($row['teknisi_utama_id'] ?? '') ?>"
                                            data-teknisi="<?= esc($row['nama_teknisi'] ?? '-') ?>"
                                            data-laporan="<?= esc($row['laporan_kerusakan'] ?? '-') ?>"
                                            style="font-size: 0.8rem; border-radius: 4px;">
                                        <i class="bx bx-history me-1"></i> Log / Tindak Lanjut
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="table-footer-industrial d-flex justify-content-between align-items-center">
            <span>Menampilkan <?= count($riwayat ?? []) ?> entri tiket perbaikan</span>
        </div>
    </div>
</div>

<!-- MODAL TINDAK LANJUT & LOG PENANGANAN (Industrial) -->
<div class="modal fade" id="modalTindakLanjut" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 6px; border: 1px solid var(--border-subtle);">
            <div class="modal-header" style="border-bottom: 1px solid var(--border-subtle); padding: 14px 20px;">
                <h5 class="modal-title fw-bold text-dark" id="modalTindakLanjutTitle" style="font-size: 1rem;">
                    <i class="bx bx-wrench me-2 text-slate-700"></i>Form Tindak Lanjut & Log Penanganan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('perbaikan/tindak-lanjut') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="perbaikan_id" id="modal_perbaikan_id">

                <div class="modal-body p-4">
                    <!-- Ringkasan Info Laporan -->
                    <div class="p-3 mb-4" style="background: var(--slate-50); border: 1px solid var(--border-subtle); border-radius: 4px;">
                        <div class="row g-2">
                            <div class="col-sm-6">
                                <span class="text-muted d-block small">Barang / Alat Medis</span>
                                <span class="fw-bold text-dark" id="info_nama_barang">-</span>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted d-block small">Pelapor (Pegawai RS)</span>
                                <span class="fw-semibold text-dark" id="info_pelapor">-</span>
                            </div>
                            <div class="col-12 mt-2 pt-2 border-top">
                                <span class="text-muted d-block small">Gejala / Laporan Kerusakan</span>
                                <span class="text-slate-700 small" id="info_laporan_kerusakan">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Input Form Penanganan -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-medium small mb-1">Petugas / Teknisi yang Menangani <span class="text-danger">*</span></label>
                            <select name="teknisi_utama_id" id="modal_teknisi_utama_id" class="form-select" required>
                                <option value="">-- Pilih Petugas / Teknisi --</option>
                                <?php foreach (($teknisi ?? []) as $t): ?>
                                    <option value="<?= $t['id'] ?>"><?= esc($t['nama_teknisi']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted" style="font-size: 0.75rem;">Petugas/teknisi yang bertugas memeriksa & memperbaiki.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-medium small mb-1">Status Penanganan <span class="text-danger">*</span></label>
                            <select name="status" id="modal_status" class="form-select" required>
                                <option value="diproses">Diproses</option>
                                <option value="selesai">Selesai</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                            <small class="text-muted" style="font-size: 0.75rem;">Update tahapan penanganan tiket ini.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-medium small mb-1">Tanggal Penanganan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_penanganan" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark fw-medium small mb-1">Jam Penanganan <span class="text-danger">*</span></label>
                            <input type="time" name="jam_penanganan" class="form-control" value="<?= date('H:i') ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-dark fw-medium small mb-1">Deskripsi Penanganan / Tindakan Teknisi <span class="text-danger">*</span></label>
                            <textarea name="deskripsi_penanganan" class="form-control" rows="3" placeholder="Tulis rincian tindakan perbaikan atau penanganan yang dilakukan teknisi..." required></textarea>
                        </div>
                    </div>

                    <!-- Tabel Log Permintaan / Penanganan -->
                    <h6 class="fw-bold text-dark border-top pt-3 mb-2 d-flex align-items-center" style="font-size: 0.85rem;">
                        <i class="bx bx-history me-1 text-slate-700"></i> Riwayat Log Penanganan
                    </h6>
                    <div class="table-responsive" style="border: 1px solid var(--border-subtle); border-radius: 4px;">
                        <table class="table-industrial table-sm mb-0 w-100">
                            <thead>
                                <tr>
                                    <th>PETUGAS / OPERATOR</th>
                                    <th>TANGGAL</th>
                                    <th>JAM</th>
                                    <th>PENANGANAN</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody id="tabel_log_body">
                                <tr>
                                    <td colspan="5" class="text-center py-3 text-muted small">Klik tombol untuk memuat data log.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer" style="border-top: 1px solid var(--border-subtle); padding: 12px 20px;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Penanganan</button>
                </div>
            </form>
        </div>
    </div>
</div>
