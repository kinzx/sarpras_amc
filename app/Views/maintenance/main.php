<div class="container-xxl flex-grow-1 container-p-y">

    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><i class="bx bx-home-alt me-1"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('maintenance') ?>">Pemeliharaan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Riwayat Maintenance</li>
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
                    <span class="text-primary me-2">|</span> Pemeliharaan Aset
                </h4>
                <p class="text-muted mb-0">Pantau jadwal pemeliharaan dan catat hasil pemeriksaan berkala aset rumah sakit.</p>
            </div>
            <a href="<?= base_url('maintenance/create') ?>" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Input Pemeliharaan
            </a>
        </div>
    </div>

    <!-- STATISTIC CARDS -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">TOTAL CATATAN</p>
                        <h3 class="mb-0 fw-bolder"><?= number_format($ringkasan['total'] ?? 0) ?></h3>
                    </div>
                    <div class="bg-label-primary rounded p-3">
                        <i class="bx bx-clipboard fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">BULAN INI</p>
                        <h3 class="mb-0 fw-bolder"><?= number_format($ringkasan['bulan_ini'] ?? 0) ?></h3>
                    </div>
                    <div class="bg-label-success rounded p-3">
                        <i class="bx bx-calendar-check fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">JATUH TEMPO</p>
                        <h3 class="mb-0 fw-bolder"><?= number_format($ringkasan['akan_datang'] ?? 0) ?></h3>
                    </div>
                    <div class="bg-label-warning rounded p-3">
                        <i class="bx bx-time-five fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">TERLAMBAT</p>
                        <h3 class="mb-0 fw-bolder"><?= number_format($ringkasan['terlambat'] ?? 0) ?></h3>
                    </div>
                    <div class="bg-label-danger rounded p-3">
                        <i class="bx bx-error-circle fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    $jadwalPerhatian = array_values(array_filter($jadwal ?? [], function ($j) {
        return (int) $j['sisa_hari'] <= 30;
    }));
    $jadwalPerhatian = array_slice($jadwalPerhatian, 0, 6);
    ?>

    <!-- JADWAL TERDEKAT -->
    <div class="card mb-4">
        <div class="card-header border-bottom mb-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Jadwal Pemeliharaan Terdekat</h5>
            <small class="text-muted">Barang yang jatuh tempo dalam 30 hari atau sudah terlambat</small>
        </div>
        <div class="card-body">
            <?php if (empty($jadwalPerhatian)): ?>
                <div class="text-center text-muted py-4">
                    <i class="bx bx-calendar-check d-block mb-2" style="font-size: 2rem;"></i>
                    Tidak ada barang yang mendekati jadwal pemeliharaan.
                </div>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($jadwalPerhatian as $j): ?>
                        <?php
                        $sisa = (int) $j['sisa_hari'];
                        if ($sisa < 0) {
                            $labelStatus = 'Terlambat ' . abs($sisa) . ' hari';
                            $classStatus = 'bg-label-danger';
                            $classBorder = 'border-danger';
                        } elseif ($sisa === 0) {
                            $labelStatus = 'Jatuh tempo hari ini';
                            $classStatus = 'bg-label-warning';
                            $classBorder = 'border-warning';
                        } else {
                            $labelStatus = 'Jatuh tempo ' . $sisa . ' hari lagi';
                            $classStatus = 'bg-label-warning';
                            $classBorder = 'border-warning';
                        }
                        ?>
                        <div class="col-md-6 col-xl-4">
                            <div class="border <?= $classBorder ?> rounded p-3 h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge <?= $classStatus ?>"><?= esc($labelStatus) ?></span>
                                        <small class="text-muted"><?= date('d M Y', strtotime($j['jadwal_berikutnya'])) ?></small>
                                    </div>
                                    <h6 class="mb-1 text-truncate" title="<?= esc($j['nama_barang']) ?>"><?= esc($j['nama_barang']) ?></h6>
                                    <small class="text-muted d-block"><?= esc($j['kode_aset']) ?> &bull; <?= esc($j['nama_ruang'] ?? '-') ?></small>
                                    <small class="text-muted d-block">Interval <?= (int) $j['interval_maintenance_hari'] ?> hari &bull; terakhir <?= $j['tanggal_perbaikan_terakhir'] ? date('d M Y', strtotime($j['tanggal_perbaikan_terakhir'])) : 'belum ada' ?></small>
                                </div>
                                <a href="<?= base_url('maintenance/create?barang_id=' . $j['id']) ?>" class="btn btn-sm btn-outline-primary mt-3 align-self-start">
                                    <i class="bx bx-plus me-1"></i> Catat Pemeliharaan
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- FILTER -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="<?= base_url('maintenance') ?>" method="GET" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label text-muted small fw-bold text-uppercase">Cari</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" name="q" value="<?= esc($keyword) ?>" placeholder="Cari nama barang, kode aset, atau petugas...">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="form-label text-muted small fw-bold text-uppercase">Bulan</label>
                    <input type="month" class="form-control" name="bulan" value="<?= esc($bulan) ?>">
                </div>
                <div class="col-md-3 col-sm-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="bx bx-filter-alt me-1"></i> Terapkan
                    </button>
                    <a href="<?= base_url('maintenance') ?>" class="btn btn-label-danger" title="Reset filter">
                        <i class="bx bx-refresh"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- TABEL RIWAYAT -->
    <div class="card">
        <div class="card-header border-bottom mb-3">
            <h5 class="mb-0">Riwayat Maintenance</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="4%">NO.</th>
                        <th>TANGGAL</th>
                        <th width="24%">BARANG</th>
                        <th>KONDISI</th>
                        <th>KESIMPULAN</th>
                        <th>PETUGAS</th>
                        <th class="text-center">FOTO</th>
                        <th width="8%" class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php if (empty($riwayat)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                
                                Belum ada catatan pemeliharaan<?= ($keyword !== '' || $bulan !== '') ? ' yang sesuai filter' : '' ?>.
                                Silakan klik <strong>+ Input Pemeliharaan</strong>.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($riwayat as $row): ?>
                            <tr>
                                <td><?= sprintf('%02d', $no++) ?></td>
                                <td>
                                    <strong class="d-block"><?= date('d M Y', strtotime($row['tanggal_maintenance'])) ?></strong>
                                    <small class="text-muted"><?= date('H:i', strtotime($row['created_at'])) ?></small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-md me-3 bg-light rounded overflow-hidden">
                                            <?php if (!empty($row['foto_barang']) && file_exists(FCPATH . 'uploads/barang/' . $row['foto_barang'])): ?>
                                                <img src="<?= base_url('uploads/barang/' . $row['foto_barang']) ?>" alt="<?= esc($row['nama_barang']) ?>" class="w-100 h-100 object-fit-cover rounded">
                                            <?php else: ?>
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-label-primary text-primary fw-bold">
                                                    <i class="bx bx-image-alt fs-4"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-wrap" style="max-width: 220px;">
                                            <strong class="d-block text-dark"><?= esc($row['nama_barang'] ?? 'Barang dihapus') ?></strong>
                                            <small class="text-muted font-monospace"><?= esc($row['kode_aset'] ?? '-') ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small class="d-block"><span class="text-muted">Bodi:</span> <?= esc($row['kondisi_bodi']) ?></small>
                                    <small class="d-block"><span class="text-muted">Display:</span> <?= esc($row['kondisi_display']) ?></small>
                                    <small class="d-block"><span class="text-muted">Tombol:</span> <?= esc($row['kondisi_tombol']) ?></small>
                                    <small class="d-block"><span class="text-muted">Aksesoris:</span> <?= esc($row['kondisi_aksesoris']) ?></small>
                                </td>
                                <td class="text-wrap" style="max-width: 260px;">
                                    <?= esc($row['kesimpulan'] ?: '-') ?>
                                </td>
                                <td><?= esc($row['nama_petugas'] ?? 'Teknisi') ?></td>
                                <td class="text-center">
                                    <?php if (!empty($row['foto_kondisi']) && file_exists(FCPATH . 'uploads/maintenance/' . $row['foto_kondisi'])): ?>
                                        <a href="<?= base_url('uploads/maintenance/' . $row['foto_kondisi']) ?>" target="_blank" rel="noopener" title="Lihat foto kondisi">
                                            <img src="<?= base_url('uploads/maintenance/' . $row['foto_kondisi']) ?>" alt="Foto kondisi" class="rounded border" style="height: 48px; width: 48px; object-fit: cover;">
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('maintenance/hapus/' . $row['id']) ?>" class="btn btn-sm btn-icon btn-outline-danger" title="Hapus catatan" onclick="return confirm('Yakin ingin menghapus catatan pemeliharaan ini?')">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">Menampilkan <?= count($riwayat ?? []) ?> catatan pemeliharaan</small>
        </div>
    </div>
</div>
