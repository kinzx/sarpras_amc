<div class="container-xxl flex-grow-1 container-p-y">

    <!-- 1. BREADCRUMB & HEADER CARD -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('/') ?>"><i class="bx bx-home-alt me-1"></i> Beranda</a>
            </li>
            <?php
            // Mengambil URL segment (contoh URL: localhost/dashboard/kategori/edit)
            $segment1 = service('request')->getUri()->getSegment(1);
            $segment2 = service('request')->getUri()->getSegment(2);

            if ($segment1 && $segment1 != 'dashboard') {
                // Jika segmen 1 adalah 'kategori', buat huruf depannya kapital
                $title1 = ucfirst(str_replace('-', ' ', $segment1));
                echo '<li class="breadcrumb-item">' . $title1 . '</li>';
            }

            if ($segment2 && $segment2 != 'index') {
                $title2 = ucfirst(str_replace('-', ' ', $segment2));
                // Jika segmen 2 adalah ID (angka), jangan ditampilkan
                if (!is_numeric($segment2)) {
                    echo '<li class="breadcrumb-item active" aria-current="page">' . $title2 . '</li>';
                }
            }
            ?>
        </ol>
    </nav>

    <div class="card mb-4">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div class="mb-3 mb-md-0">
                <h4 class="card-title mb-1">
                    <span class="text-primary me-2">|</span> Data Master Kategori Aset Sarpras RS AMC
                </h4>
                <p class="text-muted mb-0">Daftar pengelompokan klasifikasi aset medis, elektromedik, dan fasilitas penunjang operasional pelayanan rumah sakit.</p>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                <i class="bx bx-plus-circle me-1"></i> Tambah Kategori
            </button>
        </div>
    </div>
    <!-- 2. GRID KARTU KATEGORI -->
    <div class="row g-4">
        <?php if (empty($kategori)): ?>
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada data kategori. Silakan tambah kategori baru.</p>
            </div>
        <?php else: ?>
            <?php foreach ($kategori as $row): ?>
                <div class="col-md-4">
                    <div class="card h-100 text-center pt-4">
                        <div class="card-body position-relative d-flex flex-column align-items-center justify-content-center py-5">

                            <!-- TOMBOL AKSI (Edit & Hapus) -->
                            <div class="position-absolute top-0 end-0 m-3 d-flex gap-1">
                                <!-- Tombol Edit (Memicu Modal) -->
                                <button type="button" class="btn btn-sm btn-icon btn-primary rounded-circle btn-edit"
                                    data-id="<?= $row['id'] ?>"
                                    data-nama="<?= $row['nama_kategori'] ?>"
                                    data-icon="<?= $row['icon'] ?>"
                                    data-bs-toggle="modal" data-bs-target="#modalEditKategori">
                                    <i class="bx bx-pencil"></i>
                                </button>
                                <!-- Tombol Hapus -->
                                <a href="<?= base_url('kategori/hapus/' . $row['id']) ?>"
                                    class="btn btn-sm btn-icon btn-danger rounded-circle"
                                    onclick="return confirm('Yakin ingin menonaktifkan kategori ini?')">
                                    <i class="bx bx-trash"></i>
                                </a>
                            </div>

                            <!-- Ikon & Judul -->
                            <i class="bx <?= $row['icon'] ?? 'bx-category' ?> text-secondary mb-4" style="font-size: 5rem;"></i>
                            <h4 class="card-title mb-0 fw-bold text-dark"><?= $row['nama_kategori'] ?></h4>

                            <!-- Tautan ke Sub Kategori -->
                            <a href="<?= base_url('kategori/sub/' . $row['id']) ?>" class="btn btn-sm btn-outline-primary mt-3">
                                Lihat Sub-Kategori
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>