<div class="container-xxl flex-grow-1 container-p-y">
    
    <!-- 1. WELCOME & SCAN BANNER -->
    <div class="card bg-primary text-white mb-4">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
                <h4 class="text-white mb-1 fw-bold">Selamat Datang di SIMAS AMC</h4>
                <p class="mb-0 text-white opacity-75">Sistem Informasi Manajemen Sarana, Prasarana, dan Pemeliharaan Rumah Sakit AMC Muhammadiyah.</p>
            </div>
            <div class="d-flex gap-2 mt-3 mt-md-0">
                <a href="<?= base_url('scan') ?>" class="btn btn-white text-primary fw-bold shadow-sm">
                    <i class="bx bx-qr-scan fs-5 me-1 align-middle"></i> Scan QR Guest
                </a>
                <a href="<?= base_url('barang/tambah') ?>" class="btn btn-outline-white text-white border-white fw-semibold">
                    <i class="bx bx-plus me-1 align-middle"></i> Tambah Aset
                </a>
            </div>
        </div>
    </div>

    <!-- 2. STATISTIC CARDS NYATA -->
    <div class="row mb-4">
        <!-- Total Aset -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="badge bg-label-primary rounded p-2">
                            <i class="bx bx-box fs-4"></i>
                        </div>
                        <a href="<?= base_url('barang') ?>" class="small text-primary fw-semibold">Lihat Semua &rarr;</a>
                    </div>
                    <h3 class="card-title mb-1 fw-bolder"><?= number_format($totalAset ?? 0) ?></h3>
                    <p class="text-muted mb-0">Total Seluruh Aset</p>
                </div>
            </div>
        </div>
        <!-- Aset Aktif / Baik -->
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="badge bg-label-success rounded p-2">
                            <i class="bx bx-check-shield fs-4"></i>
                        </div>
                        <span class="badge bg-label-success">Normal</span>
                    </div>
                    <h3 class="card-title mb-1 fw-bolder"><?= number_format($asetAktif ?? 0) ?></h3>
                    <p class="text-muted mb-0">Aset Kondisi Baik</p>
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
                        <a href="<?= base_url('maintenance') ?>" class="small text-warning fw-semibold">Jadwal &rarr;</a>
                    </div>
                    <h3 class="card-title mb-1 fw-bolder text-warning"><?= number_format($perluMaintenanceCount ?? 0) ?></h3>
                    <p class="text-muted mb-0">Jatuh Tempo Servis (&le; 14 Hari)</p>
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
                        <a href="<?= base_url('perbaikan/create') ?>" class="small text-danger fw-semibold">Tindak &rarr;</a>
                    </div>
                    <h3 class="card-title mb-1 fw-bolder text-danger"><?= number_format($asetRusakCount ?? 0) ?></h3>
                    <p class="text-muted mb-0">Aset Rusak (Perlu Servis)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. GRAFIK & ALERT JADWAL -->
    <div class="row mb-4">
        <!-- Grafik Kategori -->
        <div class="col-md-7 mb-3">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="mb-0">Distribusi Aset per Kategori</h5>
                    <a href="<?= base_url('kategori') ?>" class="small text-muted">Kelola Kategori</a>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center pt-4">
                    <?php if (empty($chartSeries) || array_sum($chartSeries) === 0): ?>
                        <div class="text-center py-5 text-muted">
                            <i class="bx bx-pie-chart-alt fs-1 d-block mb-2"></i>
                            Belum ada aset yang terdaftar pada kategori.
                        </div>
                    <?php else: ?>
                        <div id="chartKategori" style="width: 100%; min-height: 270px;"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Alert Maintenance Terdekat (Mendekati Hari Maintenance) -->
        <div class="col-md-5 mb-3">
            <div class="card h-100">
                <div class="card-header bg-label-warning d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-warning"><i class="bx bx-calendar-event me-1"></i> Mendekati Jadwal Maintenance</h5>
                    <span class="badge bg-warning text-dark"><?= count($alertJadwal ?? []) ?> Unit</span>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($alertJadwal)): ?>
                        <div class="text-center py-5 text-muted">
                            <i class="bx bx-check-double fs-1 text-success d-block mb-2"></i>
                            Tidak ada jadwal pemeliharaan mendesak dalam 14 hari ke depan.
                        </div>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($alertJadwal as $j): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                    <div>
                                        <h6 class="mb-0 fw-semibold"><?= esc($j['nama_barang']) ?></h6>
                                        <small class="text-muted font-monospace"><?= esc($j['kode_aset']) ?> &bull; <?= esc($j['nama_ruang'] ?? '-') ?></small>
                                        <div class="small mt-1">
                                            <?php if ((int)$j['sisa_hari'] < 0): ?>
                                                <span class="badge bg-label-danger"><i class="bx bx-error me-1"></i>Lewat <?= abs((int)$j['sisa_hari']) ?> hari</span>
                                            <?php elseif ((int)$j['sisa_hari'] === 0): ?>
                                                <span class="badge bg-label-danger"><i class="bx bx-time me-1"></i>Jatuh tempo HARI INI</span>
                                            <?php else: ?>
                                                <span class="badge bg-label-warning"><i class="bx bx-time me-1"></i>Sisa <?= (int)$j['sisa_hari'] ?> hari</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <a href="<?= base_url('maintenance/create?barang_id=' . $j['id']) ?>" class="btn btn-sm btn-outline-primary" title="Input Pemeliharaan">
                                        <i class="bx bx-wrench me-1"></i> Servis
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="card-footer text-center border-top">
                    <a href="<?= base_url('maintenance') ?>" class="text-primary text-decoration-none small fw-bold">Lihat Semua Jadwal Pemeliharaan &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. ALERT BARANG TIBA-TIBA RUSAK (PERLU PERBAIKAN SEGERA) -->
    <div class="card mb-4 border border-danger">
        <div class="card-header bg-label-danger d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 text-danger"><i class="bx bx-error-alt me-1"></i> Barang / Alat Rusak (Perlu Penanganan Cepat)</h5>
                <small class="text-muted">Aset dengan laporan kondisi Rusak Ringan atau Rusak Berat yang belum selesai diperbaiki</small>
            </div>
            <a href="<?= base_url('perbaikan/create') ?>" class="btn btn-sm btn-danger">
                <i class="bx bx-wrench me-1"></i> Tangani di Modul Perbaikan
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Barang & Kode Aset</th>
                        <th>Lokasi Ruangan</th>
                        <th>Kategori / Merek</th>
                        <th>Tingkat Kerusakan</th>
                        <th>Terakhir Diperbarui</th>
                        <th class="text-center" style="width: 120px;">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarAsetRusak)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bx bx-check-circle fs-2 text-success d-block mb-1"></i>
                                Alhamdulillah, tidak ada barang yang dilaporkan rusak saat ini.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($daftarAsetRusak as $rusak): ?>
                            <tr>
                                <td>
                                    <strong><?= esc($rusak['nama_barang']) ?></strong>
                                    <small class="text-muted d-block font-monospace"><?= esc($rusak['kode_aset']) ?></small>
                                </td>
                                <td>
                                    <?= esc($rusak['nama_ruang'] ?? '-') ?>
                                    <small class="text-muted d-block">Lantai <?= esc($rusak['lantai'] ?? '1') ?></small>
                                </td>
                                <td>
                                    <?= esc($rusak['nama_kategori'] ?? '-') ?><br>
                                    <small class="text-muted"><?= esc($rusak['merek'] ?: '-') ?></small>
                                </td>
                                <td>
                                    <?php if ($rusak['kondisi_barang'] === 'Rusak Berat'): ?>
                                        <span class="badge bg-danger">Rusak Berat</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Rusak Ringan</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted"><?= !empty($rusak['updated_at']) ? date('d M Y, H:i', strtotime($rusak['updated_at'])) : '-' ?></small>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('perbaikan/create?barang_id=' . $rusak['id']) ?>" class="btn btn-sm btn-outline-danger">
                                        <i class="bx bx-wrench me-1"></i> Perbaiki
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 4. LOG AKTIVITAS TERBARU (NYATA DARI log_apps) -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center border-bottom">
            <h5 class="mb-0"><i class="bx bx-history me-1"></i> Aktivitas Terakhir Sistem</h5>
            <small class="text-muted">7 Catatan Terakhir</small>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 130px;">Pengguna</th>
                        <th style="width: 80px;">Aksi</th>
                        <th>Keterangan</th>
                        <th style="width: 120px;">Alamat IP</th>
                        <th style="width: 140px;">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Belum ada log aktivitas tercatat.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td>
                                    <span class="fw-semibold text-dark"><i class="bx bx-user me-1"></i><?= esc($log['username'] ?? 'admin') ?></span>
                                </td>
                                <td>
                                    <?php
                                        $aksi = strtoupper($log['aksi'] ?? 'INFO');
                                        $badgeAksi = 'bg-label-primary';
                                        if ($aksi === 'CREATE' || $aksi === 'TAMBAH') $badgeAksi = 'bg-label-success';
                                        elseif ($aksi === 'EDIT' || $aksi === 'UPDATE') $badgeAksi = 'bg-label-warning';
                                        elseif ($aksi === 'DELETE' || $aksi === 'HAPUS') $badgeAksi = 'bg-label-danger';
                                    ?>
                                    <span class="badge <?= $badgeAksi ?>"><?= esc($aksi) ?></span>
                                </td>
                                <td><?= esc($log['message'] ?? '-') ?></td>
                                <td><small class="text-muted font-monospace"><?= esc($log['ipaddress'] ?? '127.0.0.1') ?></small></td>
                                <td><small class="text-muted"><?= !empty($log['created_at']) ? date('d M Y, H:i', strtotime($log['created_at'])) : '-' ?></small></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ApexCharts Script untuk Donut Chart Kategori -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var chartEl = document.querySelector("#chartKategori");
        if (chartEl) {
            var options = {
                chart: {
                    type: 'donut',
                    height: 260
                },
                labels: <?= json_encode($chartLabels ?? []) ?>,
                series: <?= json_encode($chartSeries ?? []) ?>,
                colors: ['#696cff', '#71dd37', '#ffab00', '#ff3e1d', '#03c3ec', '#233446'],
                legend: {
                    position: 'bottom'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total Aset',
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                }
            };

            var chart = new ApexCharts(chartEl, options);
            chart.render();
        }
    });
</script>
