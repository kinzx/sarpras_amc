<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label Aset - <?= esc($item['kode_aset']) ?></title>
    <!-- html2canvas untuk unduh sebagai gambar PNG -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        body {
            background-color: #0f172a;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .action-bar {
            margin-bottom: 24px;
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-download {
            background-color: #0d9488;
            color: #ffffff;
        }
        .btn-download:hover {
            background-color: #0f766e;
        }

        .btn-print {
            background-color: #2563eb;
            color: #ffffff;
        }
        .btn-print:hover {
            background-color: #1d4ed8;
        }

        .btn-back {
            background-color: #334155;
            color: #f8fafc;
        }
        .btn-back:hover {
            background-color: #475569;
        }

        /* CARD CONTAINER MIRIP GAMBAR REFERENSI */
        .asset-card {
            width: 580px;
            background: #ffffff;
            border-radius: 20px;
            padding: 24px 28px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            color: #1e293b;
        }

        /* HEADER */
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 16px;
            border-bottom: 1.5px solid #e2e8f0;
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo {
            height: 44px;
            width: auto;
            object-fit: contain;
        }

        .badge-pill {
            background: #e0f2fe;
            color: #0369a1;
            font-size: 13px;
            font-weight: 800;
            padding: 6px 14px;
            border-radius: 9999px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* BODY LAYOUT 2 KOLOM */
        .card-body {
            display: flex;
            gap: 20px;
            margin-top: 18px;
            align-items: stretch;
        }

        /* KOLOM KIRI (QR CODE + KODE) */
        .left-col {
            flex: 0 0 170px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .qr-wrapper {
            position: relative;
            padding: 10px;
            background: #ffffff;
            border: 2px dashed #94a3b8;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qr-corner-tl {
            position: absolute;
            top: -2px;
            left: -2px;
            width: 14px;
            height: 14px;
            border-top: 3.5px solid #0f172a;
            border-left: 3.5px solid #0f172a;
        }
        .qr-corner-tr {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 14px;
            height: 14px;
            border-top: 3.5px solid #0f172a;
            border-right: 3.5px solid #0f172a;
        }
        .qr-corner-bl {
            position: absolute;
            bottom: -2px;
            left: -2px;
            width: 14px;
            height: 14px;
            border-bottom: 3.5px solid #0f172a;
            border-left: 3.5px solid #0f172a;
        }
        .qr-corner-br {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 14px;
            height: 14px;
            border-bottom: 3.5px solid #0f172a;
            border-right: 3.5px solid #0f172a;
        }

        .qr-image {
            width: 130px;
            height: 130px;
            display: block;
        }

        .code-pill {
            margin-top: 12px;
            background: #f1f5f9;
            color: #0f172a;
            font-family: "SFMono-Regular", Consolas, "Liberation Mono", Menlo, Courier, monospace;
            font-weight: 700;
            font-size: 13px;
            padding: 5px 12px;
            border-radius: 9999px;
            letter-spacing: 0.5px;
            text-align: center;
            border: 1px solid #cbd5e1;
        }

        /* KOLOM KANAN (METADATA INFO BOX) */
        .right-col {
            flex: 1;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 16px 18px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 12px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 10px;
            font-size: 14px;
        }

        .info-label {
            color: #64748b;
            font-weight: 500;
            white-space: nowrap;
        }

        .info-value {
            color: #0f172a;
            font-weight: 700;
            text-align: right;
            word-break: break-word;
        }

        .value-green {
            color: #15803d;
        }

        /* PRINT STYLES */
        @media print {
            body {
                background: none;
                padding: 0;
            }
            .action-bar {
                display: none;
            }
            .asset-card {
                box-shadow: none;
                border: 1px solid #cbd5e1;
                margin: 0;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <div class="action-bar">
        <a href="<?= base_url('barang/detail/' . $item['id']) ?>" class="btn btn-back">
            &larr; Kembali
        </a>
        <button type="button" onclick="downloadCard()" class="btn btn-download" id="btnDownload">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/></svg>
            Download Gambar (PNG)
        </button>
        <button type="button" onclick="window.print()" class="btn btn-print">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/><path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-4h8z"/></svg>
            Cetak Label
        </button>
    </div>

    <!-- ELEMEN KARTU ASET YANG AKAN DI-DOWNLOAD -->
    <div class="asset-card" id="assetCard">
        <!-- Header -->
        <div class="card-header">
            <div class="brand-section">
                <img src="<?= base_url('Logo-amc.png') ?>" alt="Logo RS AMC" class="brand-logo">
            </div>
            <div class="badge-pill">
                <?= esc($item['nama_kategori'] ?? 'ASET') ?>
            </div>
        </div>

        <!-- Body -->
        <div class="card-body">
            <!-- Kolom Kiri: QR Code + Kode Aset -->
            <div class="left-col">
                <div class="qr-wrapper">
                    <span class="qr-corner-tl"></span>
                    <span class="qr-corner-tr"></span>
                    <span class="qr-corner-bl"></span>
                    <span class="qr-corner-br"></span>
                    <img src="<?= base_url('barang/qrcode/' . $item['kode_aset']) ?>" alt="QR Code" class="qr-image" crossOrigin="anonymous">
                </div>
                <div class="code-pill">
                    <?= esc($item['kode_aset']) ?>
                </div>
            </div>

            <!-- Kolom Kanan: Detail Informasi -->
            <div class="right-col">
                <div class="info-row">
                    <span class="info-label">Nama Barang:</span>
                    <span class="info-value"><?= esc($item['nama_barang']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Lokasi:</span>
                    <span class="info-value"><?= esc($item['nama_ruang'] ?? '-') ?> - Lantai <?= esc($item['lantai'] ?? '1') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kategori / Merek:</span>
                    <span class="info-value"><?= esc($item['nama_kategori'] ?? '-') ?> / <?= esc($item['merek'] ?? '-') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kepemilikan:</span>
                    <span class="info-value value-green"><?= $item['kepemilikan'] === 'milik_rs' || $item['kepemilikan'] === 'RS' ? 'Milik RS' : 'Milik Vendor' ?></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function downloadCard() {
            var btn = document.getElementById('btnDownload');
            var originalText = btn.innerHTML;
            btn.innerHTML = 'Memproses...';
            btn.style.opacity = '0.7';

            var card = document.getElementById('assetCard');

            html2canvas(card, {
                scale: 3, // Resolusi tinggi agar hasil cetak tajam
                useCORS: true,
                backgroundColor: '#ffffff'
            }).then(function(canvas) {
                var link = document.createElement('a');
                link.download = 'Label-Aset-<?= esc($item['kode_aset']) ?>.png';
                link.href = canvas.toDataURL('image/png');
                link.click();

                btn.innerHTML = originalText;
                btn.style.opacity = '1';
            }).catch(function(err) {
                alert('Gagal membuat gambar: ' + err);
                btn.innerHTML = originalText;
                btn.style.opacity = '1';
            });
        }
    </script>
</body>
</html>
