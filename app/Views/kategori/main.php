<div class="container-xxl flex-grow-1 container-p-y">

    <!-- 1. BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="<?= base_url("/") ?>"><i class="bx bx-home-alt me-1"></i> Beranda</a>
            </li>
            <?php
            $segment1 = service("request")->getUri()->getSegment(1);
            $segment2 = service("request")->getUri()->getSegment(2);

            if ($segment1 && $segment1 != "dashboard") {
                $title1 = ucfirst(str_replace("-", " ", $segment1));
                echo '<li class="breadcrumb-item">' . $title1 . "</li>";
            }

            if ($segment2 && $segment2 != "index") {
                $title2 = ucfirst(str_replace("-", " ", $segment2));
                if (!is_numeric($segment2)) {
                    echo '<li class="breadcrumb-item active" aria-current="page">' . $title2 . "</li>";
                }
            }
            ?>
        </ol>
    </nav>

    <!-- HEADER HALAMAN (Industrial: Menyatu tanpa Card Template) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="page-header-title">Data Master Kategori Aset Sarpras RS AMC</h1>
            <p class="page-header-desc">Klasifikasi aset medis, elektromedik, dan fasilitas penunjang operasional rumah sakit.</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
            <i class="bx bx-plus me-1"></i> Tambah Kategori
        </button>
    </div>

    <!-- 2. GRID KARTU KATEGORI (Industrial Style) -->
    <div class="row g-3">
        <?php if (empty($kategori)): ?>
            <div class="col-12">
                <div class="card p-5 text-center">
                    <div class="empty-state-icon mx-auto">
                        <i class="bx bx-category"></i>
                    </div>
                    <h6 class="fw-semibold text-dark mb-1">Belum Ada Kategori Aset</h6>
                    <p class="text-muted small mb-3">Silakan tambahkan kategori master pertama untuk mulai mengelompokkan inventaris.</p>
                    <button class="btn btn-primary btn-sm mx-auto" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                        <i class="bx bx-plus me-1"></i> Tambah Kategori
                    </button>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($kategori as $row): ?>
                <div class="col-md-4 col-sm-6">
                    <div class="card h-100 position-relative p-4 text-center card-hover-effect" style="border: 1px solid var(--border-subtle); border-radius: 6px;">
                        
                        <!-- TOMBOL AKSI GHOST (Pojok Kanan Atas) -->
                        <div class="position-absolute top-0 end-0 m-2 d-flex gap-1 action-buttons">
                            <button type="button" class="action-btn-ghost btn-ghost-primary btn-edit"
                                data-id="<?= $row["id"] ?>"
                                data-nama="<?= $row["nama_kategori"] ?>"
                                data-icon="<?= $row["icon"] ?>"
                                data-bs-toggle="modal" data-bs-target="#modalEditKategori"
                                aria-label="Edit kategori <?= esc($row["nama_kategori"]) ?>"
                                title="Edit Kategori">
                                <i class="bx bx-pencil"></i>
                            </button>
                            <button type="button" class="action-btn-ghost btn-ghost-danger btn-hapus"
                                data-id="<?= $row["id"] ?>"
                                data-nama="<?= $row["nama_kategori"] ?>"
                                aria-label="Hapus kategori <?= esc($row["nama_kategori"]) ?>"
                                title="Hapus Kategori">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>

                        <!-- Ikon Kategori -->
                        <div class="d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 64px; height: 64px; border-radius: 6px; background: var(--slate-50); border: 1px solid var(--border-subtle);">
                            <i class="bx <?= $row["icon"] ?? "bx-category" ?> text-slate-700" style="font-size: 2rem;"></i>
                        </div>

                        <!-- Judul -->
                        <h5 class="fw-bold text-dark mb-1"><?= esc($row["nama_kategori"]) ?></h5>
                        <p class="text-muted small mb-3">Klasifikasi Unit & Sub Aset</p>

                        <!-- Tautan ke Sub Kategori -->
                        <div class="mt-auto">
                            <a href="<?= base_url("kategori/sub/" . $row["id"]) ?>" class="btn btn-outline-secondary btn-sm w-100">
                                <i class="bx bx-list-ul me-1"></i> Kelola Sub-Kategori
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>
