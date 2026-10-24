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
                        <h3 class="mb-0 fw-bolder">1,248</h3>
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
                        <h3 class="mb-0 fw-bolder">1,150</h3>
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
                        <h3 class="mb-0 fw-bolder">28</h3>
                    </div>
                    <div class="bg-label-warning rounded p-3">
                        <i class="bx bx-wrench fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER & SEARCH SECTION (Lokasi Ruangan Dihapus) -->
    <div class="card mb-4">
        <div class="card-body">
            <!-- Baris 1: Search & Tombol Utama -->
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="Cari berdasarkan nama, kode QR, merek, atau ruangan...">
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="<?= base_url('barang/tambah') ?>" class="btn btn-primary me-2">
                        <i class="bx bx-plus me-1"></i> Tambah Barang
                    </a>
                    <button class="btn btn-outline-secondary">
                        <i class="bx bx-download me-1"></i> Export Excel
                    </button>
                </div>
            </div>

            <!-- Baris 2: Dropdown Filter (Kategori & Status) -->
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-muted small fw-bold">KATEGORI</label>
                    <select class="form-select">
                        <option selected>Semua Kategori</option>
                        <option value="1">Elektronik</option>
                        <option value="2">Non-Elektronik</option>
                        <option value="3">Alat Medis</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small fw-bold">STATUS OPERASIONAL</label>
                    <select class="form-select">
                        <option selected>Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="rusak">Rusak</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-label-secondary w-100">
                        <i class="bx bx-filter-alt me-1"></i> Reset Filter
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
                    <!-- Contoh Baris 1 -->
                    <tr>
                        <td>01</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-md me-3 bg-light rounded">
                                    <img src="<?= base_url('assets/img/default-barang.png') ?>" alt="Ventilator" class="w-100 h-100 object-fit-cover rounded">
                                </div>
                                <div>
                                    <strong class="d-block">Ventilator Hamilton C1</strong>
                                    <small class="text-primary"><i class="bx bx-purchase-tag-alt"></i> Alat Medis</small>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-label-secondary fs-6">AMC-MED-2023-0142</span></td>
                        <td>
                            <strong>Hamilton Medical</strong><br>
                            <small class="text-muted">Type: C1 Intelligent</small>
                        </td>
                        <td>
                            <i class="bx bx-map-pin text-danger me-1"></i> ICU Lt. 2 (Bed 04)
                        </td>
                        <td><span class="badge bg-label-success rounded-pill px-3">Aktif</span></td>
                        <td class="text-center">
                            <a href="<?= base_url('barang/detail/1') ?>" class="btn btn-sm btn-icon btn-outline-primary me-1" title="Detail">
                                <i class="bx bx-show"></i>
                            </a>
                            <a href="<?= base_url('barang/edit/1') ?>" class="btn btn-sm btn-icon btn-outline-warning me-1" title="Edit">
                                <i class="bx bx-pencil"></i>
                            </a>
                            <button class="btn btn-sm btn-icon btn-outline-danger" title="Hapus">
                                <i class="bx bx-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="card-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">Menampilkan 1-2 dari 1,248 entri aset</small>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled"><a class="page-link" href="#"><i class="bx bx-chevron-left"></i></a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#"><i class="bx bx-chevron-right"></i></a></li>
            </ul>
        </div>
    </div>
</div>