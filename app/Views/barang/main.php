<div class="container-xxl flex-grow-1 container-p-y">

    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt me-1"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Inventaris</a></li>
            <li class="breadcrumb-item active" aria-current="page">Daftar Aset</li>
        </ol>
    </nav>

    <!-- HEADER CARD -->
    <div class="card mb-4">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div class="mb-3 mb-md-0">
                <h4 class="card-title mb-1">
                    <span class="text-primary me-2">|</span> Inventaris Aset Sarpras & Alat Medis
                </h4>
                <p class="text-muted mb-0">Kelola data aset, pelacakan lokasi, dan status operasional alat rumah sakit.</p>
            </div>
        </div>
    </div>

    <!-- STATISTIC CARDS (Hanya 3 Card) -->
    <div class="row mb-4">
        <!-- Total Aset -->
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">TOTAL ASET</p>
                        <h3 class="mb-0 fw-bolder"><?= number_format($totalAset ?? 0) ?></h3>
                    </div>
                    <div class="bg-label-primary rounded p-3">
                        <i class="bx bx-box fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Aset Aktif -->
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">ASET AKTIF</p>
                        <h3 class="mb-0 fw-bolder"><?= number_format($asetAktif ?? 0) ?></h3>
                    </div>
                    <div class="bg-label-success rounded p-3">
                        <i class="bx bx-check-shield fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Rusak / Maintenance -->
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">RUSAK / MAINTENANCE</p>
                        <h3 class="mb-0 fw-bolder">0</h3>
                    </div>
                    <div class="bg-label-warning rounded p-3">
                        <i class="bx bx-wrench fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card mb-4">
        <div class="card-body">

            <!-- Baris 1: Search, Tombol Tambah & Export -->
            <div class="row g-3 mb-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" id="searchBarang" placeholder="Cari nama, kode aset, merek, atau ruangan...">
                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end gap-2">
                    <button class="btn btn-outline-secondary">
                        <i class="bx bx-download me-1"></i> Export
                    </button>
                    <a href="<?= base_url('barang/tambah') ?>" class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i> Tambah Barang
                    </a>
                </div>
            </div>

            <!-- Baris 2: Filter Dropdown -->
            <div class="row g-3">
                <!-- Filter Kategori -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label text-muted small fw-bold text-uppercase">Kategori</label>
                    <select class="form-select" id="filterKategori">
                        <option value="" selected>Semua Kategori</option>
                        <?php if (!empty($kategoriList)): ?>
                            <?php foreach ($kategoriList as $k): ?>
                                <option value="<?= esc($k['nama_kategori']) ?>"><?= esc($k['nama_kategori']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Filter Sub-Kategori -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label text-muted small fw-bold text-uppercase">Sub Kategori</label>
                    <select class="form-select" id="filterSubKategori">
                        <option value="" selected>Semua Sub</option>
                        <?php if (!empty($subList)): ?>
                            <?php foreach ($subList as $s): ?>
                                <option value="<?= esc($s['nama_sub_kategori']) ?>"><?= esc($s['nama_sub_kategori']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Filter Status -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label text-muted small fw-bold text-uppercase">Status Operasional</label>
                    <select class="form-select" id="filterStatus">
                        <option value="" selected>Semua Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Non-Aktif">Non-Aktif</option>
                    </select>
                </div>

                <!-- Tombol Reset -->
                <div class="col-md-3 col-sm-6 d-flex align-items-end">
                    <button class="btn btn-label-danger w-100" id="btnResetFilter" title="Reset Semua Filter">
                        <i class="bx bx-refresh me-1"></i> Reset Filter
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- TABEL DATA BARANG -->
    <div class="card">
        <div class="card-header border-bottom mb-3">
            <h5 class="mb-0">Tabel Data Inventaris</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">NO.</th>
                        <th width="25%">ALAT & FOTO</th>
                        <th>KODE ASET</th>
                        <th>MERK & TIPE</th>
                        <th>LOKASI RUANGAN</th>
                        <th>STATUS</th>
                        <th width="10%" class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php if (empty($barang)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                Belum ada data inventaris barang. Silakan klik <strong>+ Tambah Barang</strong>.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($barang as $row): ?>
                            <tr>
                                <td><?= sprintf('%02d', $no++) ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-md me-3 bg-light rounded overflow-hidden">
                                            <?php if (!empty($row['foto']) && file_exists(FCPATH . 'uploads/barang/' . $row['foto'])): ?>
                                                <img src="<?= base_url('uploads/barang/' . $row['foto']) ?>" alt="<?= esc($row['nama_barang']) ?>" class="w-100 h-100 object-fit-cover rounded">
                                            <?php else: ?>
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-label-primary text-primary fw-bold">
                                                    <i class="bx bx-image-alt fs-4"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <strong class="d-block text-dark"><?= esc($row['nama_barang']) ?></strong>
                                            <small class="text-primary">
                                                <i class="bx bx-purchase-tag-alt"></i> <?= esc($row['nama_kategori'] ?? '-') ?>
                                                <?php if (!empty($row['nama_sub_kategori'])): ?>
                                                    <span class="text-muted">/ <?= esc($row['nama_sub_kategori']) ?></span>
                                                <?php endif; ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-label-secondary fs-6 font-monospace"><?= esc($row['kode_aset']) ?></span></td>
                                <td>
                                    <strong><?= esc($row['merek'] ?: '-') ?></strong><br>
                                    <small class="text-muted">Type: <?= esc($row['tipe'] ?: '-') ?></small>
                                </td>
                                <td>
                                    <i class="bx bx-map-pin text-danger me-1"></i> <?= esc($row['nama_ruang'] ?? '-') ?>
                                </td>
                                <td>
                                    <?php if ($row['is_active'] == 1): ?>
                                        <span class="badge bg-label-success rounded-pill px-3">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-label-secondary rounded-pill px-3">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('barang/detail/' . $row['id']) ?>" class="btn btn-sm btn-icon btn-outline-primary me-1" title="Detail">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <a href="<?= base_url('barang/edit/' . $row['id']) ?>" class="btn btn-sm btn-icon btn-outline-warning me-1" title="Edit">
                                        <i class="bx bx-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('barang/hapus/' . $row['id']) ?>" class="btn btn-sm btn-icon btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="card-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">Menampilkan <?= count($barang ?? []) ?> dari <?= number_format($totalAset ?? 0) ?> entri aset</small>
        </div>
    </div>
</div>