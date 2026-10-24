<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- 1. WELCOME & SCAN BANNER -->
    <div class="card bg-primary text-white mb-4">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
             
                <p class="mb-0 text-white opacity-75">Berikut adalah ringkasan inventaris Sarpras RS AMC hari ini.</p>
            </div>
            <a href="<?= base_url('scan') ?>" class="btn btn-white text-primary fw-bold mt-3 mt-md-0 shadow-sm">
                <i class="bx bx-qr-scan fs-5 me-1 align-middle"></i> Scan QR Alat
            </a>
        </div>
    </div>

    <!-- 2. STATISTIC CARDS -->
    <div class="row mb-4">
        <!-- Total Aset -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="badge bg-label-primary rounded p-2">
                            <i class="bx bx-box fs-4"></i>
                        </div>
                        <small class="text-success fw-bold"><i class="bx bx-up-arrow-alt"></i> +12%</small>
                    </div>
                    <h3 class="card-title mb-1 fw-bolder">1,248</h3>
                    <p class="text-muted mb-0">Total Aset</p>
                </div>
            </div>
        </div>
        <!-- Aset Aktif -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="badge bg-label-success rounded p-2">
                            <i class="bx bx-check-shield fs-4"></i>
                        </div>
                    </div>
                    <h3 class="card-title mb-1 fw-bolder">1,150</h3>
                    <p class="text-muted mb-0">Aset Aktif</p>
                </div>
            </div>
        </div>
        <!-- Perlu Maintenance -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="badge bg-label-warning rounded p-2">
                            <i class="bx bx-wrench fs-4"></i>
                        </div>
                    </div>
                    <h3 class="card-title mb-1 fw-bolder">28</h3>
                    <p class="text-muted mb-0">Jadwal Maintenance</p>
                </div>
            </div>
        </div>
        <!-- Alat Rusak -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="badge bg-label-danger rounded p-2">
                            <i class="bx bx-error-circle fs-4"></i>
                        </div>
                    </div>
                    <h3 class="card-title mb-1 fw-bolder">5</h3>
                    <p class="text-muted mb-0">Alat Rusak Berat</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. GRAFIK & ALERT -->
    <div class="row mb-4">
        <!-- Grafik Kategori -->
        <div class="col-md-7 mb-3">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Distribusi Aset per Kategori</h5>
                    <i class="bx bx-dots-vertical-rounded"></i>
                </div>
                <div class="card-body">
                    <!-- Placeholder Grafik (Gunakan Chart.js nanti) -->
                    <div style="height: 250px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                        <span class="text-muted">[ Grafik Donat (Donut Chart) di sini ]</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Alert Kalibrasi/Maintenance -->
        <div class="col-md-5 mb-3">
            <div class="card h-100">
                <div class="card-header bg-label-warning">
                    <h5 class="mb-0 text-warning"><i class="bx bx-bell me-1"></i> Perlu Perhatian</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <!-- Item 1 -->
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div>
                                <h6 class="mb-0">Ventilator Hamilton C1</h6>
                                <small class="text-danger">Kalibrasi jatuh tempo besok</small>
                            </div>
                            <a href="#" class="btn btn-sm btn-icon btn-outline-primary"><i class="bx bx-right-arrow-alt"></i></a>
                        </li>
                        <!-- Item 2 -->
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div>
                                <h6 class="mb-0">AC Ruang Server</h6>
                                <small class="text-warning">Maintenance 3 hari lagi</small>
                            </div>
                            <a href="#" class="btn btn-sm btn-icon btn-outline-primary"><i class="bx bx-right-arrow-alt"></i></a>
                        </li>
                        <!-- Item 3 -->
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div>
                                <h6 class="mb-0">Patient Monitor Mindray</h6>
                                <small class="text-danger">Sering mati mendadak (Rusak)</small>
                            </div>
                            <a href="#" class="btn btn-sm btn-icon btn-outline-primary"><i class="bx bx-right-arrow-alt"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="<?= base_url('maintenance') ?>" class="text-primary text-decoration-none small fw-bold">Lihat Semua Jadwal</a>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. LOG AKTIVITAS TERBARU -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Aktivitas Terakhir Sistem</h5>
            <a href="<?= base_url('log') ?>" class="btn btn-sm btn-outline-secondary">Lihat Semua Log</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Aksi</th>
                        <th>Keterangan</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><i class="bx bx-user-circle me-2"></i> admin</td>
                        <td><span class="badge bg-label-success">TAMBAH</span></td>
                        <td>Menambahkan barang baru: Ventilator Hamilton C1</td>
                        <td>10 menit yang lalu</td>
                    </tr>
                    <tr>
                        <td><i class="bx bx-user-circle me-2"></i> teknisi1</td>
                        <td><span class="badge bg-label-warning">EDIT</span></td>
                        <td>Mengubah status AC Ruang Server menjadi Maintenance</td>
                        <td>1 jam yang lalu</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>