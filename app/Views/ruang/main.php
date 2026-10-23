<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- 1. BREADCRUMB -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('/') ?>"><i class="bx bx-home-alt me-1"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Data Master</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ruangan</li>
        </ol>
    </nav>

    <!-- 2. HEADER CARD -->
    <div class="card mb-4">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div class="mb-3 mb-md-0">
                <h4 class="card-title mb-1">
                    <span class="text-primary me-2">|</span> Data Master Ruangan
                </h4>
                <p class="text-muted mb-0">Kelola data ruangan dan lokasi lantai untuk mendukung pengelolaan aset rumah sakit.</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahRuang">
                <i class="bx bx-plus-circle me-1"></i> Tambah Ruangan
            </button>
        </div>
    </div>

    <!-- 3. STATISTIC CARDS -->
    <div class="row mb-4">
        <!-- Total Ruangan -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.8rem;">Total Ruangan</p>
                        <h2 class="mb-0 fw-bolder">30</h2>
                    </div>
                    <div class="bg-label-primary rounded p-3">
                        <i class="bx bx-buildings fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Ruangan Aktif -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.8rem;">Ruangan Aktif</p>
                        <h2 class="mb-0 fw-bolder">24</h2>
                    </div>
                    <div class="bg-label-primary rounded p-3">
                        <i class="bx bx-door-open fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jumlah Lantai -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.8rem;">Jumlah Lantai</p>
                        <h2 class="mb-0 fw-bolder">6</h2>
                    </div>
                    <div class="bg-label-primary rounded p-3">
                        <i class="bx bx-layer fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. FILTER SECTION -->
    <div class="card mb-4">
        <div class="card-body">
            <h6 class="mb-3 text-uppercase text-muted fw-bold" style="font-size: 0.75rem;">Filter</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="Cari nama ruangan...">
                        <span class="input-group-text"><i class="bx bx-chevron-down"></i></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option selected>Semua Lantai</option>
                        <option value="1">Lantai 1</option>
                        <option value="2">Lantai 2</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option selected>Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="tidak_aktif">Non-aktif</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. TABEL DATA RUANGAN -->
    <div class="card">
        <div class="card-header border-bottom mb-3">
            <h5 class="mb-0">Tabel Data Ruangan</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">NO.</th>
                        <th>NAMA RUANGAN</th>
                        <th>LANTAI</th>
                        <th>STATUS</th>
                        <th width="10%" class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <!-- Contoh Baris 1 -->
                    <tr>
                        <td>01</td>
                        <td><strong>Ruang Dokter</strong></td>
                        <td>Lantai 5</td>
                        <td><span class="badge bg-label-success rounded-pill px-3">Aktif</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-icon btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#modalEditRuang">
                                <i class="bx bx-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-icon btn-outline-danger">
                                <i class="bx bx-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Contoh Baris 2 -->
                    <tr>
                        <td>02</td>
                        <td><strong>Ruang Aula</strong></td>
                        <td>Lantai 5</td>
                        <td><span class="badge bg-label-success rounded-pill px-3">Aktif</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-icon btn-outline-primary me-1">
                                <i class="bx bx-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-icon btn-outline-danger">
                                <i class="bx bx-trash"></i>
                            </button>
                        </td>
                    </tr>
                     <!-- Contoh Baris 3 -->
                     <tr>
                        <td>05</td>
                        <td><strong>Ruang Radiologi</strong></td>
                        <td>Lantai 2</td>
                        <td><span class="badge bg-label-warning rounded-pill px-3">Non aktif</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-icon btn-outline-primary me-1">
                                <i class="bx bx-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-icon btn-outline-danger">
                                <i class="bx bx-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="card-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">Menampilkan 1-5 dari 18 entri kategori</small>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled"><a class="page-link" href="#"><i class="bx bx-chevron-left"></i></a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#"><i class="bx bx-chevron-right"></i></a></li>
            </ul>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH RUANGAN (Opsional, ditaruh di sini atau layout utama) -->
<div class="modal fade" id="modalTambahRuang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Ruangan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('ruang/simpan') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Ruangan</label>
                        <input type="text" class="form-control" name="nama_ruang" placeholder="Contoh: Ruang IGD" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lantai</label>
                        <input type="number" class="form-control" name="lantai" placeholder="Contoh: 1" required>
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