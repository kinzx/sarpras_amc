<style>
    /* Industrial / Utility-first SaaS Design System */
    :root {
        --font-body: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        --font-heading: 'Geist', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        --font-mono: 'JetBrains Mono', SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        --color-accent: #1e40af;
        --color-accent-hover: #1d4ed8;
        --color-accent-active: #172554;
        --border-subtle: #e2e8f0;
        --border-muted: #f1f5f9;
        --slate-900: #0f172a;
        --slate-700: #334155;
        --slate-500: #64748b;
        --slate-400: #94a3b8;
        --slate-100: #f1f5f9;
        --slate-50: #f8fafc;
    }

    body, .layout-wrapper {
        font-family: var(--font-body);
        color: var(--slate-900);
    }

    h1, h2, h3, h4, h5, h6, .card-title {
        font-family: var(--font-heading);
        letter-spacing: -0.02em;
    }

    /* Primary Accent Button Override */
    .btn-primary {
        background-color: var(--color-accent) !important;
        border-color: var(--color-accent) !important;
        border-radius: 4px !important;
        font-weight: 500;
        font-size: 0.875rem;
        box-shadow: none !important;
    }

    .btn-primary:hover {
        background-color: var(--color-accent-hover) !important;
        border-color: var(--color-accent-hover) !important;
    }

    .btn-outline-secondary {
        border-color: var(--border-subtle) !important;
        color: var(--slate-700) !important;
        border-radius: 4px !important;
        background: #ffffff !important;
        font-weight: 500;
        font-size: 0.875rem;
        box-shadow: none !important;
    }

    .btn-outline-secondary:hover {
        background-color: var(--slate-50) !important;
        border-color: var(--slate-400) !important;
        color: var(--slate-900) !important;
    }

    /* Industrial Breadcrumb & Header */
    .breadcrumb-item, .breadcrumb-item a {
        font-size: 0.8rem;
        color: var(--slate-500);
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: var(--slate-700);
        font-weight: 500;
    }

    .page-header-title {
        font-size: 1.45rem;
        font-weight: 700;
        color: var(--slate-900);
        margin-bottom: 0.2rem;
    }

    .page-header-desc {
        font-size: 0.875rem;
        color: var(--slate-500);
        margin-bottom: 0;
    }

    /* Industrial Statistic Cards */
    .stat-card-industrial {
        background: #ffffff;
        border: 1px solid var(--border-subtle);
        border-radius: 6px;
        padding: 1.25rem;
        position: relative;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03);
        transition: border-color 0.15s ease;
    }

    .stat-card-industrial:hover {
        border-color: var(--slate-400);
    }

    .stat-card-industrial .stat-label {
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--slate-500);
        margin-bottom: 0.4rem;
    }

    .stat-card-industrial .stat-number {
        font-family: var(--font-body);
        font-size: 2rem;
        font-weight: 700;
        color: var(--slate-900);
        line-height: 1.1;
        letter-spacing: -0.03em;
        margin-bottom: 0;
    }

    .stat-card-industrial .stat-icon-top {
        position: absolute;
        top: 1.2rem;
        right: 1.2rem;
        font-size: 1.2rem;
        color: var(--slate-400);
    }

    /* Industrial Filter Card */
    .filter-card-industrial {
        background: #ffffff;
        border: 1px solid var(--border-subtle);
        border-radius: 6px;
        padding: 1.25rem;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03);
    }

    .filter-card-industrial .form-label {
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--slate-500);
        margin-bottom: 0.4rem;
    }

    .filter-card-industrial .form-select,
    .filter-card-industrial .form-control {
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        font-size: 0.85rem;
        color: var(--slate-900);
        padding: 0.45rem 0.75rem;
        box-shadow: none;
    }

    .filter-card-industrial .form-select:focus,
    .filter-card-industrial .form-control:focus {
        border-color: var(--color-accent);
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.15);
        outline: none;
    }

    .btn-reset-filter {
        border-radius: 4px !important;
        border: 1px solid var(--border-subtle) !important;
        background: #ffffff !important;
        color: var(--slate-700) !important;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 0.45rem 0.75rem;
        box-shadow: none !important;
    }

    .btn-reset-filter:hover {
        background: #fef2f2 !important;
        border-color: #fecaca !important;
        color: #dc2626 !important;
    }

    /* Industrial Table */
    .table-card-industrial {
        background: #ffffff;
        border: 1px solid var(--border-subtle);
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03);
    }

    .table-card-industrial .card-header-industrial {
        padding: 1rem 1.25rem;
        background: #ffffff;
        border-bottom: 1px solid var(--border-subtle);
    }

    .table-industrial {
        width: 100%;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-industrial thead th {
        background: var(--slate-50);
        color: var(--slate-500);
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-top: none;
        border-bottom: 1px solid var(--border-subtle);
        padding: 10px 16px;
        white-space: nowrap;
    }

    .table-industrial tbody tr {
        background: transparent;
        transition: background-color 0.1s ease;
    }

    .table-industrial tbody tr:hover {
        background-color: var(--slate-50);
    }

    .table-industrial tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-muted);
        color: var(--slate-900);
        font-size: 0.875rem;
    }

    .table-industrial tbody tr:last-child td {
        border-bottom: none;
    }

    /* Monospace Asset Code Box */
    .badge-code-mono {
        font-family: var(--font-mono);
        font-size: 0.75rem;
        font-weight: 500;
        background: var(--slate-50);
        border: 1px solid var(--border-subtle);
        color: var(--slate-700);
        padding: 2px 7px;
        border-radius: 4px;
        display: inline-block;
    }

    /* Status Badge (Technical Box, No Pills) */
    .badge-status-box {
        font-family: var(--font-mono);
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 2px 8px;
        border-radius: 4px;
        display: inline-block;
        line-height: 1.4;
    }

    .badge-status-box.active {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .badge-status-box.inactive {
        background: var(--slate-100);
        color: var(--slate-500);
        border: 1px solid #cbd5e1;
    }

    /* Ghost Action Buttons (Revealed on Row Hover) */
    .action-btn-ghost {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 4px;
        background: transparent;
        border: 1px solid transparent;
        color: var(--slate-500);
        opacity: 0.2;
        transition: all 0.15s ease;
        text-decoration: none;
    }

    .table-industrial tbody tr:hover .action-btn-ghost {
        opacity: 1;
    }

    .action-btn-ghost:hover {
        background: var(--slate-100);
        color: var(--slate-900);
        border-color: var(--border-subtle);
    }

    .action-btn-ghost.btn-ghost-danger:hover {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }

    /* Empty State */
    .empty-state-container {
        padding: 48px 24px;
        text-align: center;
    }

    .empty-state-icon {
        width: 48px;
        height: 48px;
        border-radius: 6px;
        background: var(--slate-100);
        border: 1px solid var(--border-subtle);
        color: var(--slate-400);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 12px;
    }

    .table-footer-industrial {
        padding: 10px 16px;
        background: var(--slate-50);
        border-top: 1px solid var(--border-subtle);
        font-size: 0.8rem;
        color: var(--slate-500);
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= base_url("/") ?>"><i class="bx bx-home-alt me-1"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Inventaris</a></li>
            <li class="breadcrumb-item active" aria-current="page">Daftar Aset</li>
        </ol>
    </nav>

    <!-- HEADER HALAMAN (Tanpa Box/Card Bawaan Template & Tanpa Garis Vertikal) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="page-header-title">Inventaris Aset Sarpras & Alat Medis</h1>
            <p class="page-header-desc">Kelola data aset, pelacakan lokasi, dan status operasional alat rumah sakit.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button class="btn btn-outline-secondary">
                <i class="bx bx-download me-1"></i> Export
            </button>
            <a href="<?= base_url("barang/tambah") ?>" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Tambah Barang
            </a>
        </div>
    </div>

    <!-- STATISTIC CARDS (Gaya Industrial) -->
    <div class="row g-3 mb-4">
        <!-- Total Aset -->
        <div class="col-md-4">
            <div class="stat-card-industrial">
                <i class="bx bx-box stat-icon-top"></i>
                <div class="stat-label">Total Aset</div>
                <div class="stat-number"><?= number_format($totalAset ?? 0) ?></div>
            </div>
        </div>
        <!-- Aset Aktif -->
        <div class="col-md-4">
            <div class="stat-card-industrial">
                <i class="bx bx-check-shield stat-icon-top"></i>
                <div class="stat-label">Aset Aktif</div>
                <div class="stat-number"><?= number_format($asetAktif ?? 0) ?></div>
            </div>
        </div>
        <!-- Rusak / Maintenance -->
        <div class="col-md-4">
            <div class="stat-card-industrial">
                <i class="bx bx-wrench stat-icon-top"></i>
                <div class="stat-label">Rusak / Maintenance</div>
                <div class="stat-number">0</div>
            </div>
        </div>
    </div>

    <!-- FILTER BAR (Container Border Tipis & Radius Kecil) -->
    <div class="filter-card-industrial mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
            <div>
                <h6 class="mb-0 fw-semibold text-dark"><i class="bx bx-filter-alt me-1 text-muted"></i> Filter Inventaris</h6>
                <small class="text-muted">Saring daftar aset berdasarkan kategori dan status operasional.</small>
            </div>
        </div>

        <div class="row g-3 align-items-end">
            <!-- Filter Kategori -->
            <div class="col-lg-3 col-sm-6">
                <label class="form-label">Kategori</label>
                <select class="form-select" id="filterKategori">
                    <option value="" selected>Semua Kategori</option>
                    <?php if (!empty($kategoriList)): ?>
                        <?php foreach ($kategoriList as $k): ?>
                            <option value="<?= esc($k["nama_kategori"]) ?>"><?= esc($k["nama_kategori"]) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Filter Sub-Kategori -->
            <div class="col-lg-3 col-sm-6">
                <label class="form-label">Sub Kategori</label>
                <select class="form-select" id="filterSubKategori">
                    <option value="" selected>Semua Sub</option>
                    <?php if (!empty($subList)): ?>
                        <?php foreach ($subList as $s): ?>
                            <option value="<?= esc($s["nama_sub_kategori"]) ?>"><?= esc($s["nama_sub_kategori"]) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Filter Status -->
            <div class="col-lg-3 col-sm-6">
                <label class="form-label">Status Operasional</label>
                <select class="form-select" id="filterStatus">
                    <option value="" selected>Semua Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Non-Aktif">Non-Aktif</option>
                </select>
            </div>

            <!-- Tombol Reset -->
            <div class="col-lg-3 col-sm-6">
                <button class="btn btn-reset-filter w-100" id="btnResetFilter" title="Reset Semua Filter">
                    <i class="bx bx-refresh me-1"></i> Reset Filter
                </button>
            </div>
        </div>
    </div>

    <!-- TABEL DATA BARANG (Industrial, Padding Lega, Ghost Buttons, Monospace Badge) -->
    <div class="table-card-industrial">
        <div class="card-header-industrial">
            <h6 class="mb-0 fw-semibold text-dark">Daftar Inventaris Terdaftar</h6>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table-industrial">
                <thead>
                    <tr>
                        <th style="width: 50px;">NO.</th>
                        <th style="width: 300px;">ALAT & FOTO</th>
                        <th>KODE ASET</th>
                        <th>MERK & TIPE</th>
                        <th>LOKASI RUANGAN</th>
                        <th>STATUS</th>
                        <th style="width: 110px;" class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($barang)): ?>
                        <tr>
                            <td colspan="7" class="p-0">
                                <div class="empty-state-container">
                                    <div class="empty-state-icon">
                                        <i class="bx bx-box"></i>
                                    </div>
                                    <h6 class="fw-semibold text-dark mb-1">Belum Ada Aset Terdaftar</h6>
                                    <p class="text-muted small mb-3">Tidak ditemukan data inventaris aktif. Silakan tambahkan barang inventaris baru.</p>
                                    <a href="<?= base_url("barang/tambah") ?>" class="btn btn-primary btn-sm">
                                        <i class="bx bx-plus me-1"></i> Tambah Barang
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $no = 1;
                        foreach ($barang as $row): ?>
                            <tr>
                                <td class="text-muted font-monospace" style="font-size: 0.8rem;"><?= sprintf("%02d", $no++) ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 rounded overflow-hidden flex-shrink-0" style="width: 42px; height: 42px; border: 1px solid var(--border-subtle); background: var(--slate-50);">
                                            <?php if (
                                                !empty($row["foto"]) &&
                                                file_exists(
                                                    FCPATH .
                                                        "uploads/barang/" .
                                                        $row["foto"],
                                                )
                                            ): ?>
                                                <img src="<?= base_url(
                                                    "uploads/barang/" .
                                                        $row["foto"],
                                                ) ?>" alt="<?= esc(
                                                    $row["nama_barang"],
                                                ) ?>" class="w-100 h-100 object-fit-cover">
                                            <?php else: ?>
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-secondary">
                                                    <i class="bx bx-image-alt fs-5"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <span class="d-block fw-semibold text-dark" style="font-size: 0.875rem;"><?= esc(
                                                $row["nama_barang"],
                                            ) ?></span>
                                            <span class="text-muted" style="font-size: 0.75rem;">
                                                <?= esc(
                                                    $row["nama_kategori"] ??
                                                        "-",
                                                ) ?>
                                                <?php if (
                                                    !empty(
                                                        $row[
                                                            "nama_sub_kategori"
                                                        ]
                                                    )
                                                ): ?>
                                                    <span class="text-muted">/ <?= esc(
                                                        $row[
                                                            "nama_sub_kategori"
                                                        ],
                                                    ) ?></span>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-code-mono"><?= esc(
                                        $row["kode_aset"],
                                    ) ?></span>
                                </td>
                                <td>
                                    <span class="d-block fw-medium text-dark"><?= esc(
                                        $row["merek"] ?: "-",
                                    ) ?></span>
                                    <span class="text-muted small">Tipe: <?= esc(
                                        $row["tipe"] ?: "-",
                                    ) ?></span>
                                </td>
                                <td>
                                    <span class="text-slate-700">
                                        <i class="bx bx-map-pin text-muted me-1"></i><?= esc(
                                            $row["nama_ruang"] ?? "-",
                                        ) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($row["is_active"] == 1): ?>
                                        <span class="badge-status-box active">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge-status-box inactive">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <a href="<?= base_url(
                                            "barang/detail/" . $row["id"],
                                        ) ?>" class="action-btn-ghost" title="Detail" aria-label="Detail <?= esc(
                                            $row["nama_barang"],
                                        ) ?>">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="<?= base_url(
                                            "barang/edit/" . $row["id"],
                                        ) ?>" class="action-btn-ghost" title="Edit" aria-label="Edit <?= esc(
                                            $row["nama_barang"],
                                        ) ?>">
                                            <i class="bx bx-pencil"></i>
                                        </a>
                                        <a href="<?= base_url(
                                            "barang/hapus/" . $row["id"],
                                        ) ?>" class="action-btn-ghost btn-ghost-danger" title="Hapus" aria-label="Hapus <?= esc(
                                            $row["nama_barang"],
                                        ) ?>" onclick="return confirm('Yakin ingin menghapus barang ini?')">
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

        <!-- Footer Ringkasan -->
        <div class="table-footer-industrial d-flex justify-content-between align-items-center">
            <span>Menampilkan <?= count(
                $barang ?? [],
            ) ?> dari <?= number_format($totalAset ?? 0) ?> entri aset</span>
        </div>
    </div>
</div>
