<?php
helper("auth");

$userAktif = function_exists("user") ? user() : null;
$namaPengguna = $userAktif ? $userAktif->username : "Pengguna";

/* Sapaan & tanggal dalam Bahasa Indonesia (zona waktu rumah sakit) */
$zonaWaktu = new DateTimeZone("Asia/Jakarta");
$sekarang = new DateTime("now", $zonaWaktu);
$jamSekarang = (int) $sekarang->format("G");
if ($jamSekarang < 11) {
    $sapaan = "Selamat pagi";
} elseif ($jamSekarang < 15) {
    $sapaan = "Selamat siang";
} elseif ($jamSekarang < 18) {
    $sapaan = "Selamat sore";
} else {
    $sapaan = "Selamat malam";
}

$namaHari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
$namaBulan = [
    1 => "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
];
$tanggalHariIni =
    $namaHari[(int) $sekarang->format("w")] .
    ", " .
    $sekarang->format("j") .
    " " .
    $namaBulan[(int) $sekarang->format("n")] .
    " " .
    $sekarang->format("Y");

$totalAsetVal = (int) ($totalAset ?? 0);
$asetBaikVal = (int) ($asetAktif ?? 0);
$persenBaik =
    $totalAsetVal > 0 ? (int) round(($asetBaikVal / $totalAsetVal) * 100) : 0;

/* Waktu relatif untuk log aktivitas */
$waktuRelatif = function ($datetime) {
    if (empty($datetime)) {
        return "-";
    }
    $ts = strtotime($datetime);
    if (!$ts) {
        return "-";
    }
    $selisih = time() - $ts;
    if ($selisih < 0) {
        return date("d M Y, H:i", $ts);
    }
    if ($selisih < 60) {
        return "Baru saja";
    }
    if ($selisih < 3600) {
        return floor($selisih / 60) . " menit lalu";
    }
    if ($selisih < 86400) {
        return floor($selisih / 3600) . " jam lalu";
    }
    if ($selisih < 604800) {
        return floor($selisih / 86400) . " hari lalu";
    }
    return date("d M Y, H:i", $ts);
};
?>

<style>
  /* =========================================================
     DASHBOARD — tampilan lebih hidup, aman untuk mode gelap
     ========================================================= */
  .dashboard-home {
    --dash-radius: 0.875rem;
  }

  /* ---------- Hero / welcome banner ---------- */
  .dashboard-hero {
    position: relative;
    overflow: hidden;
    border: 0;
    border-radius: 1.125rem;
    background: linear-gradient(120deg, var(--bs-primary, #696cff) 0%, rgba(var(--bs-primary-rgb, 105, 108, 255), 0.88) 45%, #232733 100%);
    box-shadow: 0 1rem 2.25rem -1rem rgba(var(--bs-primary-rgb, 105, 108, 255), 0.55);
    color: #fff;
  }

  .dashboard-hero::before,
  .dashboard-hero::after {
    content: "";
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.09);
    pointer-events: none;
  }

  .dashboard-hero::before {
    width: 320px;
    height: 320px;
    top: -150px;
    right: -70px;
  }

  .dashboard-hero::after {
    width: 230px;
    height: 230px;
    bottom: -140px;
    left: 28%;
    background: rgba(255, 255, 255, 0.06);
  }

  .dashboard-hero .card-body {
    position: relative;
    z-index: 1;
  }

  .dashboard-hero__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.35rem 0.7rem;
    border: 1px solid rgba(255, 255, 255, 0.35);
    border-radius: 50rem;
    background: rgba(255, 255, 255, 0.12);
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.02em;
  }

  .dashboard-hero__title {
    font-size: clamp(1.35rem, 2.2vw, 1.9rem);
    font-weight: 700;
    letter-spacing: -0.02em;
  }

  .dashboard-hero__desc {
    max-width: 38rem;
    color: rgba(255, 255, 255, 0.82);
  }

  .btn-hero-light {
    background: #fff;
    border-color: #fff;
    color: var(--bs-primary, #696cff);
    font-weight: 600;
  }

  .btn-hero-light:hover,
  .btn-hero-light:focus {
    background: #f2f2ff;
    border-color: #f2f2ff;
    color: var(--bs-primary, #696cff);
    filter: brightness(0.9);
  }

  .btn-hero-ghost {
    border: 1px solid rgba(255, 255, 255, 0.55);
    background: rgba(255, 255, 255, 0.08);
    color: #fff;
    font-weight: 600;
  }

  .btn-hero-ghost:hover,
  .btn-hero-ghost:focus {
    background: rgba(255, 255, 255, 0.18);
    border-color: #fff;
    color: #fff;
  }

  /* Ring kesehatan aset pada hero */
  .hero-health {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.9rem;
  }

  .hero-ring {
    --ring-value: 0;
    position: relative;
    display: grid;
    place-items: center;
    width: 148px;
    height: 148px;
    border-radius: 50%;
    background: conic-gradient(#71dd37 calc(var(--ring-value) * 1%), rgba(255, 255, 255, 0.2) 0);
    box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.18), 0 0.75rem 1.75rem rgba(20, 20, 60, 0.25);
  }

  .hero-ring__inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 116px;
    height: 116px;
    border-radius: 50%;
    background: rgba(18, 21, 35, 0.78);
    backdrop-filter: blur(6px);
    color: #fff;
  }

  .hero-ring__value {
    font-size: 1.75rem;
    font-weight: 700;
    line-height: 1;
  }

  .hero-ring__label {
    margin-top: 0.25rem;
    font-size: 0.68rem;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.78);
  }

  .hero-mini-stats {
    display: flex;
    gap: 1.75rem;
    justify-content: center;
    text-align: center;
  }

  .hero-mini-stats__value {
    display: block;
    font-size: 1.05rem;
    font-weight: 700;
    line-height: 1.2;
  }

  .hero-mini-stats__label {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: rgba(255, 255, 255, 0.7);
  }

  /* ---------- Kartu statistik ---------- */
  .stat-card {
    position: relative;
    overflow: hidden;
    height: 100%;
    border: 1px solid var(--bs-border-color);
    border-radius: var(--dash-radius);
    background-color: var(--bs-paper-bg);
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
  }

  .stat-card::before {
    content: "";
    position: absolute;
    inset-block-start: 0;
    inset-inline: 0;
    height: 3px;
    background: var(--stat-accent, var(--bs-primary));
  }

  .stat-card:hover {
    transform: translateY(-4px);
    border-color: var(--stat-accent, var(--bs-primary));
    box-shadow: 0 0.75rem 1.75rem rgba(34, 48, 62, 0.13);
  }

  .stat-card .card-body {
    position: relative;
    z-index: 1;
  }

  .stat-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 46px;
    height: 46px;
    border-radius: 0.75rem;
    background: var(--stat-soft, var(--bs-primary-bg-subtle));
    color: var(--stat-accent, var(--bs-primary));
    font-size: 1.35rem;
  }

  .stat-value {
    font-size: 1.85rem;
    font-weight: 700;
    line-height: 1.1;
    letter-spacing: -0.02em;
    color: var(--bs-heading-color);
  }

  .stat-label {
    font-size: 0.8125rem;
    color: var(--bs-secondary-color);
  }

  .stat-link {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--stat-accent, var(--bs-primary));
    text-decoration: none;
    white-space: nowrap;
  }

  .stat-link:hover {
    text-decoration: underline;
  }

  /* ---------- Judul kartu ---------- */
  .card-title-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 0.55rem;
    background: var(--bs-primary-bg-subtle);
    color: var(--bs-primary);
    font-size: 1rem;
  }

  .section-heading {
    font-size: 1.05rem;
    font-weight: 700;
    letter-spacing: -0.01em;
  }

  /* ---------- Timeline maintenance ---------- */
  .maintenance-timeline {
    margin: 0;
    padding: 0;
    list-style: none;
  }

  .maintenance-item {
    position: relative;
    padding: 1rem 1.15rem 1rem 2.65rem;
    border-bottom: 1px solid var(--bs-border-color);
    transition: background-color 0.15s ease;
  }

  .maintenance-item:last-child {
    border-bottom: 0;
  }

  .maintenance-item:hover {
    background-color: var(--bs-tertiary-bg);
  }

  .maintenance-item__dot {
    position: absolute;
    inset-inline-start: 1.15rem;
    inset-block-start: 1.5rem;
    width: 0.65rem;
    height: 0.65rem;
    border-radius: 50%;
    background: var(--bs-secondary-color);
    box-shadow: 0 0 0 4px var(--bs-tertiary-bg);
  }

  .maintenance-item.is-urgent .maintenance-item__dot {
    background: var(--bs-warning);
    box-shadow: 0 0 0 4px var(--bs-warning-bg-subtle);
  }

  .maintenance-item.is-overdue .maintenance-item__dot {
    background: var(--bs-danger);
    box-shadow: 0 0 0 4px var(--bs-danger-bg-subtle);
    animation: dash-pulse 1.8s ease-out infinite;
  }

  @keyframes dash-pulse {
    0% { box-shadow: 0 0 0 0 rgba(255, 62, 29, 0.45); }
    70% { box-shadow: 0 0 0 9px rgba(255, 62, 29, 0); }
    100% { box-shadow: 0 0 0 0 rgba(255, 62, 29, 0); }
  }

  @media (prefers-reduced-motion: reduce) {
    .maintenance-item.is-overdue .maintenance-item__dot { animation: none; }
    .stat-card { transition: none; }
  }

  .maintenance-item__title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--bs-heading-color);
  }

  /* ---------- Tabel ---------- */
  .dashboard-table {
    margin: 0;
  }

  .dashboard-table thead th {
    padding: 0.7rem 1.25rem;
    border-bottom: 1px solid var(--bs-border-color);
    background-color: var(--bs-tertiary-bg);
    color: var(--bs-secondary-color);
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    white-space: nowrap;
  }

  .dashboard-table tbody td {
    padding: 0.85rem 1.25rem;
    border-color: var(--bs-border-color);
    vertical-align: middle;
  }

  .dashboard-table tbody tr {
    transition: background-color 0.15s ease;
  }

  .dashboard-table tbody tr:hover {
    background-color: var(--bs-tertiary-bg);
  }

  .dashboard-table tbody tr:last-child td {
    border-bottom: 0;
  }

  .item-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 0.6rem;
    font-size: 1rem;
    flex-shrink: 0;
  }

  /* ---------- Feed aktivitas ---------- */
  .activity-item {
    display: flex;
    gap: 0.85rem;
    padding: 0.95rem 1.25rem;
    border-bottom: 1px solid var(--bs-border-color);
    transition: background-color 0.15s ease;
  }

  .activity-item:last-child {
    border-bottom: 0;
  }

  .activity-item:hover {
    background-color: var(--bs-tertiary-bg);
  }

  .activity-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    flex-shrink: 0;
    font-size: 1.05rem;
  }

  .text-heading {
    color: var(--bs-heading-color) !important;
  }

  .dashboard-home .min-w-0 {
    min-width: 0;
  }

  .empty-state {
    padding: 2.75rem 1.25rem;
    text-align: center;
    color: var(--bs-secondary-color);
  }

  @media (max-width: 575.98px) {
    .hero-mini-stats { gap: 1.25rem; }
    .dashboard-hero .card-body { padding: 1.5rem; }
    .stat-value { font-size: 1.6rem; }
    .hero-ring { width: 120px; height: 120px; }
    .hero-ring__inner { width: 94px; height: 94px; }
    .hero-ring__value { font-size: 1.4rem; }
  }
</style>

<div class="dashboard-home container-xxl flex-grow-1 container-p-y">

    <!-- 1. HERO / WELCOME -->
    <div class="card dashboard-hero mb-4">
        <div class="card-body p-4 p-lg-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <span class="dashboard-hero__eyebrow mb-3">
                        <i class="bx bx-calendar-event"></i> <?= esc(
                            $tanggalHariIni,
                        ) ?>
                    </span>
                    <h3 class="dashboard-hero__title text-white mb-2">
                        <?= esc($sapaan) ?>, <?= esc($namaPengguna) ?>! 👋
                    </h3>
                    <p class="dashboard-hero__desc mb-4">
                        Ini ringkasan kondisi sarana dan prasarana RS AMC Muhammadiyah hari ini.
                        Pantau jadwal pemeliharaan dan aset yang perlu penanganan langsung dari satu tempat.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="<?= base_url(
                            "barang/tambah",
                        ) ?>" class="btn btn-hero-light">
                            <i class="bx bx-plus me-1 align-middle"></i> Tambah Aset
                        </a>
                        <a href="<?= base_url(
                            "maintenance",
                        ) ?>" class="btn btn-hero-ghost">
                            <i class="bx bx-calendar-check me-1 align-middle"></i> Jadwal Pemeliharaan
                        </a>
                        <a href="<?= base_url(
                            "scan",
                        ) ?>" class="btn btn-hero-ghost">
                            <i class="bx bx-qr-scan me-1 align-middle"></i> Buka Scanner
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- 2. KARTU STATISTIK -->
    <div class="row g-3 mb-4">
        <!-- Total Aset -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card" style="--stat-accent:#696cff; --stat-soft:rgba(105,108,255,.14);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="stat-icon"><i class="bx bx-box"></i></span>
                        <a href="<?= base_url(
                            "barang",
                        ) ?>" class="stat-link">Lihat Semua <i class="bx bx-right-arrow-alt align-middle"></i></a>
                    </div>
                    <div class="stat-value"><?= number_format(
                        $totalAsetVal,
                    ) ?></div>
                    <div class="stat-label mt-1">Total Seluruh Aset</div>
                </div>
            </div>
        </div>

        <!-- Aset Baik -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card" style="--stat-accent:#71dd37; --stat-soft:rgba(113,221,55,.15);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="stat-icon"><i class="bx bx-check-shield"></i></span>
                        <span class="badge bg-label-success"><?= $persenBaik ?>%</span>
                    </div>
                    <div class="stat-value"><?= number_format(
                        $asetBaikVal,
                    ) ?></div>
                    <div class="stat-label mt-1">Aset Kondisi Baik</div>
                    <div class="progress mt-3" style="height: 6px;" role="progressbar"
                         aria-valuenow="<?= $persenBaik ?>" aria-valuemin="0" aria-valuemax="100"
                         aria-label="Persentase aset kondisi baik">
                        <div class="progress-bar bg-success" style="width: <?= $persenBaik ?>%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jatuh Tempo Maintenance -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card" style="--stat-accent:#ffab00; --stat-soft:rgba(255,171,0,.16);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="stat-icon"><i class="bx bx-wrench"></i></span>
                        <a href="<?= base_url(
                            "maintenance",
                        ) ?>" class="stat-link">Jadwal <i class="bx bx-right-arrow-alt align-middle"></i></a>
                    </div>
                    <div class="stat-value" style="color: var(--bs-warning-text-emphasis);"><?= number_format(
                        (int) ($perluMaintenanceCount ?? 0),
                    ) ?></div>
                    <div class="stat-label mt-1">Jatuh Tempo Servis (&le; 14 Hari)</div>
                </div>
            </div>
        </div>

        <!-- Aset Rusak -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card" style="--stat-accent:#ff3e1d; --stat-soft:rgba(255,62,29,.14);">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="stat-icon"><i class="bx bx-error-circle"></i></span>
                        <a href="<?= base_url(
                            "perbaikan/create",
                        ) ?>" class="stat-link">Tindak <i class="bx bx-right-arrow-alt align-middle"></i></a>
                    </div>
                    <div class="stat-value" style="color: var(--bs-danger-text-emphasis);"><?= number_format(
                        (int) ($asetRusakCount ?? 0),
                    ) ?></div>
                    <div class="stat-label mt-1">Aset Rusak (Perlu Servis)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. GRAFIK & JADWAL MAINTENANCE -->
    <div class="row g-3 mb-4">
        <!-- Grafik Kategori -->
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <span class="card-title-icon"><i class="bx bx-pie-chart-alt-2"></i></span>
                        <div>
                            <h5 class="section-heading mb-0">Distribusi Aset</h5>
                            <small class="text-muted">Jumlah aset per kategori</small>
                        </div>
                    </div>
                    <a href="<?= base_url(
                        "kategori",
                    ) ?>" class="btn btn-sm btn-outline-primary">Kelola</a>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center pt-4">
                    <?php if (
                        empty($chartSeries) ||
                        array_sum($chartSeries) === 0
                    ): ?>
                        <div class="empty-state">
                            <i class="bx bx-pie-chart-alt fs-1 d-block mb-2"></i>
                            Belum ada aset yang terdaftar pada kategori.
                        </div>
                    <?php else: ?>
                        <div id="chartKategori" style="width: 100%; min-height: 280px;"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Jadwal Maintenance Terdekat -->
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <span class="card-title-icon" style="background: var(--bs-warning-bg-subtle); color: var(--bs-warning-text-emphasis);">
                            <i class="bx bx-calendar-event"></i>
                        </span>
                        <div>
                            <h5 class="section-heading mb-0">Mendekati Jadwal</h5>
                            <small class="text-muted">14 hari ke depan</small>
                        </div>
                    </div>
                    <span class="badge bg-label-warning"><?= count(
                        $alertJadwal ?? [],
                    ) ?> Unit</span>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($alertJadwal)): ?>
                        <div class="empty-state">
                            Tidak ada jadwal pemeliharaan mendesak dalam 14 hari ke depan.
                        </div>
                    <?php else: ?>
                        <ul class="maintenance-timeline">
                            <?php foreach ($alertJadwal as $j):

                                $sisaHari = (int) $j["sisa_hari"];
                                $kelasItem =
                                    $sisaHari < 0
                                        ? "is-overdue"
                                        : ($sisaHari <= 3
                                            ? "is-urgent"
                                            : "");
                                ?>
                                <li class="maintenance-item <?= $kelasItem ?>">
                                    <span class="maintenance-item__dot"></span>
                                    <div class="d-flex justify-content-between align-items-start gap-2">
                                        <div class="min-w-0">
                                            <div class="maintenance-item__title text-truncate"><?= esc(
                                                $j["nama_barang"],
                                            ) ?></div>
                                            <div class="small text-muted font-monospace text-truncate">
                                                <?= esc(
                                                    $j["kode_aset"],
                                                ) ?> &bull; <?= esc(
     $j["nama_ruang"] ?? "-",
 ) ?>
                                            </div>
                                        </div>
                                        <a href="<?= base_url(
                                            "maintenance/create?barang_id=" .
                                                $j["id"],
                                        ) ?>"
                                           class="btn btn-sm btn-icon btn-outline-primary flex-shrink-0"
                                           title="Input Pemeliharaan" aria-label="Input pemeliharaan <?= esc(
                                               $j["nama_barang"],
                                           ) ?>">
                                            <i class="bx bx-wrench"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center gap-2 mt-2">
                                        <?php if ($sisaHari < 0): ?>
                                            <span class="badge bg-label-danger"><i class="bx bx-error me-1"></i>Lewat <?= abs(
                                                $sisaHari,
                                            ) ?> hari</span>
                                        <?php elseif ($sisaHari === 0): ?>
                                            <span class="badge bg-label-danger"><i class="bx bx-time me-1"></i>Jatuh tempo hari ini</span>
                                        <?php else: ?>
                                            <span class="badge bg-label-warning"><i class="bx bx-time me-1"></i>Sisa <?= $sisaHari ?> hari</span>
                                        <?php endif; ?>
                                        <small class="text-muted">
                                            <i class="bx bx-calendar me-1"></i><?= date(
                                                "d M Y",
                                                strtotime(
                                                    $j["jadwal_berikutnya"],
                                                ),
                                            ) ?>
                                        </small>
                                    </div>
                                </li>
                            <?php
                            endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <div class="card-footer text-center border-top bg-transparent">
                    <a href="<?= base_url(
                        "maintenance",
                    ) ?>" class="text-primary text-decoration-none small fw-semibold">
                        Lihat Semua Jadwal Pemeliharaan <i class="bx bx-right-arrow-alt align-middle"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. BARANG RUSAK -->
    <div class="card mb-4 overflow-hidden">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <span class="card-title-icon" style="background: var(--bs-danger-bg-subtle); color: var(--bs-danger-text-emphasis);">
                    <i class="bx bx-error-alt"></i>
                </span>
                <div>
                    <h5 class="section-heading mb-0">Barang / Alat Rusak</h5>
                    <small class="text-muted">Perlu penanganan cepat oleh teknisi</small>
                </div>
            </div>
            <a href="<?= base_url(
                "perbaikan/create",
            ) ?>" class="btn btn-sm btn-danger">
                <i class="bx bx-wrench me-1"></i> Tangani di Modul Perbaikan
            </a>
        </div>
        <div class="table-responsive">
            <table class="table dashboard-table align-middle">
                <thead>
                    <tr>
                        <th>Barang &amp; Kode Aset</th>
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
                            <td colspan="6">
                                <div class="empty-state">
                                    Alhamdulillah, tidak ada barang yang dilaporkan rusak saat ini.
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($daftarAsetRusak as $rusak): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="item-icon bg-label-danger"><i class="bx bx-box"></i></span>
                                        <div class="min-w-0">
                                            <span class="fw-semibold text-heading d-block text-truncate"><?= esc(
                                                $rusak["nama_barang"],
                                            ) ?></span>
                                            <small class="text-muted font-monospace"><?= esc(
                                                $rusak["kode_aset"],
                                            ) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-body"><?= esc(
                                        $rusak["nama_ruang"] ?? "-",
                                    ) ?></span>
                                    <small class="text-muted d-block">Lantai <?= esc(
                                        $rusak["lantai"] ?? "1",
                                    ) ?></small>
                                </td>
                                <td>
                                    <span class="text-body"><?= esc(
                                        $rusak["nama_kategori"] ?? "-",
                                    ) ?></span>
                                    <small class="text-muted d-block"><?= esc(
                                        $rusak["merek"] ?: "-",
                                    ) ?></small>
                                </td>
                                <td>
                                    <?php if (
                                        $rusak["kondisi_barang"] ===
                                        "Rusak Berat"
                                    ): ?>
                                        <span class="badge bg-danger"><i class="bx bx-error me-1"></i>Rusak Berat</span>
                                    <?php else: ?>
                                        <span class="badge bg-label-warning"><i class="bx bx-error-circle me-1"></i>Rusak Ringan</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted" title="<?= esc(
                                        $rusak["updated_at"] ?? "-",
                                    ) ?>">
                                        <?= !empty($rusak["updated_at"])
                                            ? esc(
                                                $waktuRelatif(
                                                    $rusak["updated_at"],
                                                ),
                                            )
                                            : "-" ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url(
                                        "perbaikan/create?barang_id=" .
                                            $rusak["id"],
                                    ) ?>" class="btn btn-sm btn-outline-danger">
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

    <!-- 5. AKTIVITAS TERBARU -->
    <div class="card mb-2 overflow-hidden">
        <div class="card-header d-flex justify-content-between align-items-center border-bottom">
            <div class="d-flex align-items-center gap-2">
                <span class="card-title-icon"><i class="bx bx-history"></i></span>
                <div>
                    <h5 class="section-heading mb-0">Aktivitas Terakhir Sistem</h5>
                    <small class="text-muted">7 catatan terakhir</small>
                </div>
            </div>
            <span class="badge bg-label-primary">Log Aplikasi</span>
        </div>
        <div class="activity-feed">
            <?php if (empty($logs)): ?>
                <div class="empty-state">
                    <i class="bx bx-time-five fs-1 d-block mb-2"></i>
                    Belum ada log aktivitas tercatat.
                </div>
            <?php else: ?>
                <?php foreach ($logs as $log):

                    $aksi = strtoupper($log["aksi"] ?? "INFO");
                    $badgeAksi = "bg-label-primary";
                    $iconAksi = "bx-info-circle";
                    $softAksi = "bg-label-primary";
                    if ($aksi === "CREATE" || $aksi === "TAMBAH") {
                        $badgeAksi = "bg-label-success";
                        $softAksi = "bg-label-success";
                        $iconAksi = "bx-plus-circle";
                    } elseif ($aksi === "EDIT" || $aksi === "UPDATE") {
                        $badgeAksi = "bg-label-warning";
                        $softAksi = "bg-label-warning";
                        $iconAksi = "bx-edit";
                    } elseif ($aksi === "DELETE" || $aksi === "HAPUS") {
                        $badgeAksi = "bg-label-danger";
                        $softAksi = "bg-label-danger";
                        $iconAksi = "bx-trash";
                    }
                    ?>
                    <div class="activity-item">
                        <span class="activity-icon <?= $softAksi ?>"><i class="bx <?= $iconAksi ?>"></i></span>
                        <div class="flex-grow-1 min-w-0">
                            <div class="d-flex justify-content-between align-items-center gap-2">
                                <span class="fw-semibold text-heading text-truncate">
                                    <i class="bx bx-user me-1"></i><?= esc(
                                        $log["username"] ?? "admin",
                                    ) ?>
                                </span>
                                <small class="text-muted text-nowrap" title="<?= esc(
                                    $log["created_at"] ?? "-",
                                ) ?>">
                                    <?= !empty($log["created_at"])
                                        ? esc($waktuRelatif($log["created_at"]))
                                        : "-" ?>
                                </small>
                            </div>
                            <p class="mb-1 small text-body"><?= esc(
                                $log["message"] ?? "-",
                            ) ?></p>
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <span class="badge <?= $badgeAksi ?>"><?= esc(
    $aksi,
) ?></span>
                                <small class="text-muted font-monospace">
                                    <i class="bx bx-globe me-1"></i><?= esc(
                                        $log["ipaddress"] ?? "127.0.0.1",
                                    ) ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</div>

<!-- ApexCharts: Donut Chart Kategori (mengikuti tema terang/gelap) -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var chartEl = document.querySelector("#chartKategori");
        if (!chartEl || typeof ApexCharts === "undefined") {
            return;
        }

        var isDark = function () {
            return document.documentElement.getAttribute("data-bs-theme") === "dark";
        };

        var palette = ["#696cff", "#71dd37", "#ffab00", "#ff3e1d", "#03c3ec", "#8e54e9", "#20c997", "#fd7e14"];

        var buildOptions = function () {
            var dark = isDark();
            return {
                chart: {
                    type: "donut",
                    height: 280,
                    fontFamily: "inherit",
                    background: "transparent",
                    animations: { speed: 500 }
                },
                labels: <?= json_encode(
                    $chartLabels ?? [],
                    JSON_UNESCAPED_UNICODE,
                ) ?>,
                series: <?= json_encode(
                    array_map("intval", $chartSeries ?? []),
                ) ?>,
                colors: palette,
                stroke: {
                    width: 2,
                    colors: [dark ? "#2b2c40" : "#ffffff"]
                },
                legend: {
                    position: "bottom",
                    fontSize: "13px",
                    labels: { colors: dark ? "#b2b2c4" : "#566a7f" },
                    markers: { offsetX: -4 },
                    itemMargin: { horizontal: 8, vertical: 4 }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: "68%",
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: "13px",
                                    color: dark ? "#b2b2c4" : "#566a7f",
                                    offsetY: -4
                                },
                                value: {
                                    show: true,
                                    fontSize: "1.5rem",
                                    fontWeight: 600,
                                    color: dark ? "#d5d5e2" : "#384551",
                                    offsetY: 4
                                },
                                total: {
                                    show: true,
                                    label: "Total Aset",
                                    fontSize: "13px",
                                    color: dark ? "#b2b2c4" : "#566a7f",
                                    formatter: function (w) {
                                        var total = w.globals.seriesTotals.reduce(function (a, b) { return a + b; }, 0);
                                        return total.toLocaleString("id-ID");
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                tooltip: {
                    theme: dark ? "dark" : "light",
                    y: {
                        formatter: function (val) {
                            return val + " aset";
                        }
                    }
                },
                responsive: [{
                    breakpoint: 576,
                    options: {
                        chart: { height: 240 },
                        legend: { position: "bottom", fontSize: "12px" }
                    }
                }]
            };
        };

        var chart = new ApexCharts(chartEl, buildOptions());
        chart.render();

        /* Ikut berubah saat pengguna mengganti tema tanpa reload */
        var lastTheme = isDark();
        new MutationObserver(function () {
            var current = isDark();
            if (current === lastTheme) {
                return;
            }
            lastTheme = current;
            chart.updateOptions(buildOptions(), false, false);
        }).observe(document.documentElement, { attributes: true, attributeFilter: ["data-bs-theme"] });
    });
</script>
