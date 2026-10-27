<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb & Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1"><span class="text-primary me-2">|</span> Data Master Ruangan</h4>
            <p class="text-muted mb-0">Kelola data ruangan dan lokasi lantai.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahRuang">
            <i class="bx bx-plus-circle me-1"></i> Tambah Ruangan
        </button>
    </div>

    <!-- Tabel Ruangan -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Ruangan</th>
                        <th>Lantai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ruang)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4">Belum ada data ruangan.</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($ruang as $row): ?>
                            <tr>
                                <!-- Kolom 1: No -->
                                <td><?= $no++ ?></td>

                                <!-- Kolom 2: Nama Ruangan -->
                                <td><strong><?= $row['nama_ruang'] ?></strong></td>

                                <!-- Kolom 3: Lantai -->
                                <td>Lantai <?= $row['lantai'] ?></td>

                                <!-- Kolom 4: Status -->
                                <td>
                                    <?php if ($row['is_active'] == 1): ?>
                                        <span class="badge bg-label-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-label-danger">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Kolom 5: Aksi (Tombol Edit & Hapus) -->
                                <td>
                                    <?php if ($row['is_active'] == 1): ?>
                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-warning me-1 btn-edit"
                                            data-id="<?= $row['id'] ?>"
                                            data-nama="<?= $row['nama_ruang'] ?>"
                                            data-lantai="<?= $row['lantai'] ?>"
                                            data-bs-toggle="modal" data-bs-target="#modalEditRuang">
                                            <i class="bx bx-pencil"></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <a href="<?= base_url('ruang/hapus/' . $row['id']) ?>" class="btn btn-sm btn-icon btn-outline-danger" onclick="return confirm('Yakin ingin menonaktifkan ruangan ini?')">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Ruangan -->
<div class="modal fade" id="modalTambahRuang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Ruangan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('ruang/simpan') ?>" method="POST" onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.innerHTML = 'Menyimpan...';">
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
                <h5 class="modal-title">Edit Ruangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Action akan diisi secara otomatis oleh JavaScript -->
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