<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header Halaman -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="page-header-title">Data Master Ruangan</h1>
            <p class="page-header-desc">Kelola penomoran lokasi, lantai, dan ketersediaan ruangan rumah sakit.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahRuang">
            <i class="bx bx-plus me-1"></i> Tambah Ruangan
        </button>
    </div>

    <!-- Tabel Ruangan -->
    <div class="table-card-industrial">
        <div class="card-header-industrial d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-semibold text-dark">Daftar Ruangan Terdaftar</h6>
            <span class="text-muted small">Total: <?= count($ruang ?? []) ?> Ruangan</span>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table-industrial">
                <thead>
                    <tr>
                        <th style="width: 60px;">NO.</th>
                        <th>NAMA RUANGAN</th>
                        <th>LANTAI</th>
                        <th>STATUS</th>
                        <th style="width: 100px;" class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ruang)): ?>
                        <tr>
                            <td colspan="5" class="p-0">
                                <div class="empty-state-container">
                                    <div class="empty-state-icon">
                                        <i class="bx bx-door-open"></i>
                                    </div>
                                    <h6 class="fw-semibold text-dark mb-1">Belum Ada Data Ruangan</h6>
                                    <p class="text-muted small mb-3">Data master ruangan rumah sakit belum ditambahkan.</p>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahRuang">
                                        <i class="bx bx-plus me-1"></i> Tambah Ruangan Baru
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $no = 1;
                        foreach ($ruang as $row): ?>
                            <tr>
                                <td class="text-muted font-monospace" style="font-size: 0.8rem;"><?= sprintf("%02d", $no++) ?></td>
                                <td>
                                    <span class="fw-semibold text-dark"><?= esc($row["nama_ruang"]) ?></span>
                                </td>
                                <td>
                                    <span class="badge-code-mono">Lantai <?= esc($row["lantai"]) ?></span>
                                </td>
                                <td>
                                    <?php if ($row["is_active"] == 1): ?>
                                        <span class="badge-status-box active">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge-status-box inactive">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row["is_active"] == 1): ?>
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <button type="button" class="action-btn-ghost action-btn-ghost-warning btn-edit"
                                                data-id="<?= $row["id"] ?>"
                                                data-nama="<?= esc($row["nama_ruang"]) ?>"
                                                data-lantai="<?= esc($row["lantai"]) ?>"
                                                data-bs-toggle="modal" data-bs-target="#modalEditRuang"
                                                aria-label="Edit ruangan <?= esc($row["nama_ruang"]) ?>"
                                                title="Edit Ruangan">
                                                <i class="bx bx-pencil"></i>
                                            </button>
                                            <a href="<?= base_url("ruang/hapus/" . $row["id"]) ?>" 
                                                class="action-btn-ghost btn-ghost-danger" 
                                                aria-label="Nonaktifkan ruangan <?= esc($row["nama_ruang"]) ?>" 
                                                title="Nonaktifkan Ruangan" 
                                                onclick="return confirm('Yakin ingin menonaktifkan ruangan ini?')">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="table-footer-industrial d-flex justify-content-between align-items-center">
            <span>Menampilkan <?= count($ruang ?? []) ?> data ruangan</span>
        </div>
    </div>
</div>

<!-- Modal Tambah Ruangan -->
<div class="modal fade" id="modalTambahRuang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold text-dark mb-0">Tambah Ruangan Baru</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url("ruang/simpan") ?>" method="POST" onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Menyimpan...';">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Ruangan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_ruang" placeholder="Contoh: Ruang IGD" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lantai <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="lantai" placeholder="Contoh: 1" required min="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Ruangan -->
<div class="modal fade" id="modalEditRuang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold text-dark mb-0">Edit Data Ruangan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditRuang" method="POST" onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Menyimpan...';">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Ruangan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_ruang" id="edit_nama_ruang" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lantai <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="lantai" id="edit_lantai" required min="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
