<div class="container-xxl flex-grow-1 container-p-y">

    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= base_url(
                "dashboard",
            ) ?>"><i class="bx bx-home-alt me-1"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url(
                "maintenance",
            ) ?>">Pemeliharaan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Riwayat Maintenance</li>
        </ol>
    </nav>

    <?php if (session()->getFlashdata("success")): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata("success")) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata("error")): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata("error")) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- HEADER HALAMAN (Industrial: Menyatu tanpa Card Template) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="page-header-title">Pemeliharaan & Kalibrasi Berkala</h1>
            <p class="page-header-desc">Pemantauan siklus pemeliharaan preventif dan pencatatan riwayat fisik aset sarpras rumah sakit.</p>
        </div>
        <a href="<?= base_url("maintenance/create") ?>" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Input Pemeliharaan
        </a>
    </div>

    <!-- STATISTIC CARDS (Industrial Utility Style) -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card-industrial">
                <i class="bx bx-clipboard stat-icon"></i>
                <div class="stat-label">TOTAL PEMELIHARAAN</div>
                <div class="stat-value"><?= number_format(
                    $ringkasan["total"] ?? 0,
                ) ?></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card-industrial">
                <i class="bx bx-calendar-check stat-icon"></i>
                <div class="stat-label">BULAN INI</div>
                <div class="stat-value text-success"><?= number_format(
                    $ringkasan["bulan_ini"] ?? 0,
                ) ?></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card-industrial">
                <i class="bx bx-time-five stat-icon"></i>
                <div class="stat-label">JADWAL TERDEKAT</div>
                <div class="stat-value text-warning"><?= number_format(
                    $ringkasan["akan_datang"] ?? 0,
                ) ?></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card-industrial">
                <i class="bx bx-error-circle stat-icon"></i>
                <div class="stat-label">TERLAMBAT</div>
                <div class="stat-value text-danger"><?= number_format(
                    $ringkasan["terlambat"] ?? 0,
                ) ?></div>
            </div>
        </div>
    </div>

    <?php
    $jadwalPerhatian = array_values(
        array_filter($jadwal ?? [], function ($j) {
            return (int) $j["sisa_hari"] <= 30;
        }),
    );
    $jadwalPerhatian = array_slice($jadwalPerhatian, 0, 6);
    ?>

    <!-- JADWAL TERDEKAT (Industrial Card) -->
    <div class="table-card-industrial mb-4">
        <div class="card-header-industrial d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-0 fw-semibold text-dark">Jadwal Pemeliharaan Terdekat</h6>
                <span class="text-muted small">Barang yang jatuh tempo dalam 30 hari atau telah lewat tanggal</span>
            </div>
            <span class="badge-code"><?= count(
                $jadwalPerhatian,
            ) ?> Prioritas</span>
        </div>
        <div class="p-3">
            <?php if (empty($jadwalPerhatian)): ?>
                <div class="empty-state-container py-4">
                    <div class="empty-state-icon">
                        <i class="bx bx-calendar-check"></i>
                    </div>
                    <h6 class="fw-semibold text-dark mb-1">Semua Pemeliharaan Terkendali</h6>
                    <p class="text-muted small mb-0">Tidak ada jadwal pemeliharaan alat atau sarpras yang mendekati jatuh tempo.</p>
                </div>
            <?php else: ?>
                <div class="row g-3">
                    <?php foreach ($jadwalPerhatian as $j): ?>
                        <?php
                        $sisa = (int) $j["sisa_hari"];
                        if ($sisa < 0) {
                            $labelStatus = "Terlambat " . abs($sisa) . " hari";
                            $statusStyle =
                                "background: #fef2f2; color: #991b1b; border-color: #fecaca;";
                        } elseif ($sisa === 0) {
                            $labelStatus = "Jatuh tempo hari ini";
                            $statusStyle =
                                "background: #fffbeb; color: #b45309; border-color: #fde68a;";
                        } else {
                            $labelStatus =
                                "Jatuh tempo " . $sisa . " hari lagi";
                            $statusStyle =
                                "background: #fffbeb; color: #b45309; border-color: #fde68a;";
                        }
                        ?>
                        <div class="col-md-6 col-xl-4">
                            <div class="p-3 h-100 d-flex flex-column justify-content-between" style="border: 1px solid var(--border-subtle); border-radius: 4px; background: var(--slate-50);">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge-status-box" style="<?= $statusStyle ?>"><?= esc(
    $labelStatus,
) ?></span>
                                        <span class="text-muted font-monospace" style="font-size: 0.75rem;"><?= date(
                                            "d M Y",
                                            strtotime($j["jadwal_berikutnya"]),
                                        ) ?></span>
                                    </div>
                                    <h6 class="mb-1 text-truncate fw-semibold text-dark" title="<?= esc(
                                        $j["nama_barang"],
                                    ) ?>"><?= esc($j["nama_barang"]) ?></h6>
                                    <div class="d-flex align-items-center gap-1 mb-1">
                                        <span class="badge-code"><?= esc(
                                            $j["kode_aset"],
                                        ) ?></span>
                                        <span class="text-muted small">&bull; <?= esc(
                                            $j["nama_ruang"] ?? "-",
                                        ) ?></span>
                                    </div>
                                    <span class="text-muted small d-block" style="font-size: 0.75rem;">
                                        Interval: <?= (int) $j[
                                            "interval_maintenance_hari"
                                        ] ?> hari &bull; Terakhir: <?= $j[
     "tanggal_perbaikan_terakhir"
 ]
     ? date("d M Y", strtotime($j["tanggal_perbaikan_terakhir"]))
     : "Belum ada" ?>
                                    </span>
                                </div>
                                <div class="mt-3 pt-2" style="border-top: 1px solid var(--border-subtle);">
                                    <a href="<?= base_url(
                                        "maintenance/create?barang_id=" .
                                            $j["id"],
                                    ) ?>" class="btn btn-outline-secondary btn-sm w-100">
                                        <i class="bx bx-plus me-1"></i> Catat Pemeliharaan
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- FILTER BAR (Industrial) -->
    <div class="filter-card-industrial mb-4">
        <form action="<?= base_url(
            "maintenance",
        ) ?>" method="GET" class="row g-2 align-items-end">
            <div class="col-md-6">
                <label class="form-label text-dark fw-medium small mb-1">Cari Catatan</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 4px 0 0 4px;"><i class="bx bx-search"></i></span>
                    <input type="text" class="form-control border-start-0" name="q" value="<?= esc(
                        $keyword,
                    ) ?>" placeholder="Nama barang, kode aset, atau petugas...">
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <label class="form-label text-dark fw-medium small mb-1">Periode Bulan</label>
                <input type="month" class="form-control" name="bulan" value="<?= esc(
                    $bulan,
                ) ?>">
            </div>
            <div class="col-md-3 col-sm-6 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="bx bx-filter-alt me-1"></i> Filter
                </button>
                <a href="<?= base_url(
                    "maintenance",
                ) ?>" class="btn btn-outline-secondary" title="Reset filter">
                    <i class="bx bx-refresh"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- TABEL RIWAYAT (Industrial) -->
    <div class="table-card-industrial">
        <div class="card-header-industrial d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-semibold text-dark">Riwayat Log Pemeliharaan</h6>
            <span class="text-muted small">Total: <?= count(
                $riwayat ?? [],
            ) ?> Catatan</span>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table-industrial">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO.</th>
                        <th>TANGGAL & WAKTU</th>
                        <th style="min-width: 220px;">BARANG & KODE</th>
                        <th>KONDISI FISIK</th>
                        <th>KESIMPULAN TINDAKAN</th>
                        <th>PETUGAS</th>
                        <th class="text-center" style="width: 70px;">FOTO</th>
                        <th style="width: 80px;" class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($riwayat)): ?>
                        <tr>
                            <td colspan="8" class="p-0">
                                <div class="empty-state-container">
                                    <div class="empty-state-icon">
                                        <i class="bx bx-clipboard"></i>
                                    </div>
                                    <h6 class="fw-semibold text-dark mb-1">Belum Ada Catatan Pemeliharaan</h6>
                                    <p class="text-muted small mb-3">Belum ada catatan pemeliharaan yang tercatat sesuai kriteria pencarian Anda.</p>
                                    <a href="<?= base_url(
                                        "maintenance/create",
                                    ) ?>" class="btn btn-primary btn-sm">
                                        <i class="bx bx-plus me-1"></i> Input Pemeliharaan
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $no = 1;
                        foreach ($riwayat as $row): ?>
                            <tr>
                                <td class="text-muted font-monospace" style="font-size: 0.8rem;"><?= sprintf(
                                    "%02d",
                                    $no++,
                                ) ?></td>
                                <td>
                                    <strong class="d-block text-dark"><?= date(
                                        "d M Y",
                                        strtotime($row["tanggal_maintenance"]),
                                    ) ?></strong>
                                    <span class="text-muted font-monospace" style="font-size: 0.75rem;"><?= date(
                                        "H:i",
                                        strtotime($row["created_at"]),
                                    ) ?> WIB</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 40px; height: 40px; border-radius: 4px; border: 1px solid var(--border-subtle); overflow: hidden; background: var(--slate-100); flex-shrink: 0;" class="d-flex align-items-center justify-content-center">
                                            <?php if (
                                                !empty($row["foto_barang"]) &&
                                                file_exists(
                                                    FCPATH .
                                                        "uploads/barang/" .
                                                        $row["foto_barang"],
                                                )
                                            ): ?>
                                                <img src="<?= base_url(
                                                    "uploads/barang/" .
                                                        $row["foto_barang"],
                                                ) ?>" alt="<?= esc(
    $row["nama_barang"],
) ?>" class="w-100 h-100 object-fit-cover">
                                            <?php else: ?>
                                                <i class="bx bx-image text-muted" style="font-size: 1.2rem;"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <strong class="d-block text-dark" style="font-size: 0.85rem;"><?= esc(
                                                $row["nama_barang"] ??
                                                    "Aset Dihapus",
                                            ) ?></strong>
                                            <span class="badge-code"><?= esc(
                                                $row["kode_aset"] ?? "-",
                                            ) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small" style="font-size: 0.78rem; line-height: 1.4;">
                                        <div><span class="text-muted">Bodi:</span> <span class="fw-medium text-dark"><?= esc(
                                            $row["kondisi_bodi"],
                                        ) ?></span></div>
                                        <div><span class="text-muted">Display:</span> <span class="fw-medium text-dark"><?= esc(
                                            $row["kondisi_display"],
                                        ) ?></span></div>
                                        <div><span class="text-muted">Tombol:</span> <span class="fw-medium text-dark"><?= esc(
                                            $row["kondisi_tombol"],
                                        ) ?></span></div>
                                        <div><span class="text-muted">Aksesoris:</span> <span class="fw-medium text-dark"><?= esc(
                                            $row["kondisi_aksesoris"],
                                        ) ?></span></div>
                                    </div>
                                </td>
                                <td style="max-width: 260px; white-space: normal;">
                                    <div class="small text-slate-700" style="line-height: 1.4;">
                                        <?= esc($row["kesimpulan"] ?: "-") ?>
                                    </div>
                                </td>
                                <td>
                                    <strong class="d-block text-dark" style="font-size: 0.85rem;"><?= esc(
                                        $row["nama_petugas"] ?? "Teknisi",
                                    ) ?></strong>
                                    <?php
                                    $pendamping = get_nama_teknisi_pendamping(
                                        $row["teknisi_pendamping"] ?? null,
                                    );
                                    if (!empty($pendamping)): ?>
                                        <span class="text-muted small d-block font-monospace" style="font-size: 0.72rem;">
                                            <i class="bx bx-group me-1"></i><?= esc(
                                                implode(", ", $pendamping),
                                            ) ?>
                                        </span>
                                    <?php endif;
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php if (
                                        !empty($row["foto_kondisi"]) &&
                                        file_exists(
                                            FCPATH .
                                                "uploads/maintenance/" .
                                                $row["foto_kondisi"],
                                        )
                                    ): ?>
                                        <a href="<?= base_url(
                                            "uploads/maintenance/" .
                                                $row["foto_kondisi"],
                                        ) ?>" target="_blank" rel="noopener" title="Lihat Foto Fisik">
                                            <img src="<?= base_url(
                                                "uploads/maintenance/" .
                                                    $row["foto_kondisi"],
                                            ) ?>" alt="Kondisi" class="border" style="height: 38px; width: 38px; object-fit: cover; border-radius: 4px;">
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button"
                                            class="action-btn-ghost btn-ghost-primary btn-edit-maintenance border-0 bg-transparent p-0"
                                            title="Ubah catatan"
                                            data-id="<?= $row["id"] ?>"
                                            data-nama-barang="<?= esc(
                                                $row["nama_barang"] ?? "",
                                            ) ?>"
                                            data-kode-aset="<?= esc(
                                                $row["kode_aset"] ?? "",
                                            ) ?>"
                                            data-tanggal="<?= esc(
                                                $row["tanggal_maintenance"],
                                            ) ?>"
                                            data-user-id="<?= esc(
                                                $row["user_id"],
                                            ) ?>"
                                            data-pendamping='<?= esc(
                                                json_encode(
                                                    json_decode(
                                                        $row[
                                                            "teknisi_pendamping"
                                                        ] ?? "[]",
                                                    ),
                                                ),
                                                "attr",
                                            ) ?>'
                                            data-bodi="<?= esc(
                                                $row["kondisi_bodi"],
                                            ) ?>"
                                            data-display="<?= esc(
                                                $row["kondisi_display"],
                                            ) ?>"
                                            data-tombol="<?= esc(
                                                $row["kondisi_tombol"],
                                            ) ?>"
                                            data-aksesoris="<?= esc(
                                                $row["kondisi_aksesoris"],
                                            ) ?>"
                                            data-kesimpulan="<?= esc(
                                                $row["kesimpulan"] ?? "",
                                            ) ?>">
                                            <i class="bx bx-pencil"></i>
                                        </button>
                                        <a href="<?= base_url(
                                            "maintenance/hapus/" . $row["id"],
                                        ) ?>" class="action-btn-ghost btn-ghost-danger" title="Hapus catatan" aria-label="Hapus catatan pemeliharaan <?= esc(
    $row["nama_barang"],
) ?>" onclick="return confirm('Yakin ingin menghapus catatan pemeliharaan ini?')">
                                            <i class="bx bx-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;
                        ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="table-footer-industrial d-flex justify-content-between align-items-center">
            <span>Menampilkan <?= count(
                $riwayat ?? [],
            ) ?> catatan pemeliharaan</span>
        </div>
    </div>
</div>

<!-- Modal Edit Catatan Pemeliharaan -->
<div class="modal fade" id="modalEditMaintenance" tabindex="-1" aria-labelledby="modalEditMaintenanceLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white d-flex align-items-center gap-2" id="modalEditMaintenanceLabel">
                    <i class="bx bx-pencil fs-4"></i> Edit Catatan Pemeliharaan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formEditMaintenance" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <!-- Info Barang (Readonly) -->
                    <div class="alert alert-secondary py-2 px-3 mb-3 d-flex align-items-center justify-content-between">
                        <div>
                            <small class="text-muted d-block">Barang / Aset</small>
                            <strong id="edit_info_barang" class="text-dark">-</strong>
                        </div>
                        <span id="edit_info_kode" class="badge bg-secondary font-monospace">-</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Maintenance <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_maintenance" id="edit_tanggal" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Teknisi Utama <span class="text-danger">*</span></label>
                            <select name="user_id" id="edit_user_id" class="form-select" required>
                                <option value="">-- Pilih Teknisi --</option>
                                <?php foreach ($petugas ?? [] as $p): ?>
                                    <option value="<?= $p["id"] ?>"><?= esc(
    $p["username"],
) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Teknisi Pendamping (Opsional)</label>
                            <div class="border rounded p-2 bg-light d-flex flex-wrap gap-3" id="edit_pendamping_container">
                                <?php foreach ($petugas ?? [] as $p): ?>
                                    <div class="form-check m-0">
                                        <input class="form-check-input edit-pendamping-check" type="checkbox" name="teknisi_pendamping[]" value="<?= $p[
                                            "id"
                                        ] ?>" id="edit_pendamping_<?= $p[
    "id"
] ?>">
                                        <label class="form-check-label small" for="edit_pendamping_<?= $p[
                                            "id"
                                        ] ?>">
                                            <?= esc($p["username"]) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <small class="text-muted" style="font-size: 0.72rem;">Centang teknisi lain yang turut mendampingi proses maintenance.</small>
                        </div>

                        <!-- Pemeriksaan Fisik -->
                        <div class="col-12">
                            <h6 class="fw-bold mb-2 text-primary border-bottom pb-1">
                                <i class="bx bx-check-shield me-1"></i> Pemeriksaan Kondisi Fisik
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Kondisi Bodi / Casing <span class="text-danger">*</span></label>
                            <select name="kondisi_bodi" id="edit_kondisi_bodi" class="form-select form-select-sm" required>
                                <option value="Bersih & Utuh">Bersih & Utuh</option>
                                <option value="Baret Halus">Baret Halus</option>
                                <option value="Retak Ringan">Retak Ringan</option>
                                <option value="Pecah / Rusak">Pecah / Rusak</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Kondisi Layar / Display <span class="text-danger">*</span></label>
                            <select name="kondisi_display" id="edit_kondisi_display" class="form-select form-select-sm" required>
                                <option value="Normal & Jelas">Normal & Jelas</option>
                                <option value="Redup">Redup</option>
                                <option value="Baret / Tergores">Baret / Tergores</option>
                                <option value="Garis / Mati Sebagian">Garis / Mati Sebagian</option>
                                <option value="Tidak Ada Display">Tidak Ada Display (N/A)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Kondisi Tombol / Saklar <span class="text-danger">*</span></label>
                            <select name="kondisi_tombol" id="edit_kondisi_tombol" class="form-select form-select-sm" required>
                                <option value="Responsif">Responsif</option>
                                <option value="Keras / Macet">Keras / Macet</option>
                                <option value="Longgar">Longgar</option>
                                <option value="Rusak / Hilang">Rusak / Hilang</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Kondisi Aksesoris / Kabel <span class="text-danger">*</span></label>
                            <select name="kondisi_aksesoris" id="edit_kondisi_aksesoris" class="form-select form-select-sm" required>
                                <option value="Lengkap & Baik">Lengkap & Baik</option>
                                <option value="Kabel Terkelupas">Kabel Terkelupas</option>
                                <option value="Tidak Lengkap">Tidak Lengkap</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Kesimpulan / Catatan Tambahan</label>
                            <textarea name="kesimpulan" id="edit_kesimpulan" class="form-control" rows="3" placeholder="Catatan kondisi saat pemeliharaan..."></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Ganti Foto Fisik (Opsional)</label>
                            <input type="file" name="foto_kondisi" class="form-control" accept="image/*">
                            <small class="text-muted" style="font-size: 0.72rem;">Format: JPG, JPEG, PNG, WEBP (maks 2MB). Biarkan kosong jika tidak ingin mengubah foto.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var modalEl = document.getElementById('modalEditMaintenance');
    if (!modalEl) return;
    var modal = new bootstrap.Modal(modalEl);

    document.querySelectorAll('.btn-edit-maintenance').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var namaBarang = this.getAttribute('data-nama-barang');
            var kodeAset = this.getAttribute('data-kode-aset');
            var tanggal = this.getAttribute('data-tanggal');
            var userId = this.getAttribute('data-user-id');
            var pendampingRaw = this.getAttribute('data-pendamping');
            var bodi = this.getAttribute('data-bodi');
            var display = this.getAttribute('data-display');
            var tombol = this.getAttribute('data-tombol');
            var aksesoris = this.getAttribute('data-aksesoris');
            var kesimpulan = this.getAttribute('data-kesimpulan');

            document.getElementById('formEditMaintenance').action = '<?= site_url(
                "maintenance/update/",
            ) ?>' + id;
            document.getElementById('edit_info_barang').textContent = namaBarang || '-';
            document.getElementById('edit_info_kode').textContent = kodeAset || '-';
            document.getElementById('edit_tanggal').value = tanggal ? tanggal.substring(0, 10) : '';
            document.getElementById('edit_user_id').value = userId || '';
            document.getElementById('edit_kondisi_bodi').value = bodi || 'Bersih & Utuh';
            document.getElementById('edit_kondisi_display').value = display || 'Normal & Jelas';
            document.getElementById('edit_kondisi_tombol').value = tombol || 'Responsif';
            document.getElementById('edit_kondisi_aksesoris').value = aksesoris || 'Lengkap & Baik';
            document.getElementById('edit_kesimpulan').value = kesimpulan || '';

            // Reset checklist pendamping
            document.querySelectorAll('.edit-pendamping-check').forEach(function(chk) {
                chk.checked = false;
            });

            if (pendampingRaw) {
                try {
                    var pendampingArr = JSON.parse(pendampingRaw);
                    if (Array.isArray(pendampingArr)) {
                        pendampingArr.forEach(function(pid) {
                            var chk = document.getElementById('edit_pendamping_' + pid);
                            if (chk) chk.checked = true;
                        });
                    }
                } catch (e) {}
            }

            modal.show();
        });
    });
});
</script>
