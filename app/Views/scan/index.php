<!DOCTYPE html>
<html lang="id" class="light-style layout-wide" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= esc($title ?? "Scan QR Code") ?> | RS AMC</title>

    <link rel="icon" type="image/png" sizes="64x64" href="<?= base_url(
        "AMC-tanpa-nama-pad.png",
    ) ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(
        "AMC-tanpa-nama-pad.png",
    ) ?>" />

    <link rel="stylesheet" href="<?= base_url(
        "assets/vendor/fonts/boxicons.css",
    ) ?>" />
    <link rel="stylesheet" href="<?= base_url(
        "assets/vendor/css/core.css",
    ) ?>" />

    <!-- html5-qrcode scanner library -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <style>
        body {
            background-color: #0f172a;
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .scanner-card {
            max-width: 540px;
            margin: auto;
            border-radius: 1.25rem;
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }
        #reader {
            width: 100%;
            border-radius: 0.75rem;
            overflow: hidden;
            background: #000;
        }
        #reader video {
            object-fit: cover !important;
            border-radius: 0.75rem;
        }
        .scan-laser {
            position: relative;
        }
        .scan-laser::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 5%;
            width: 90%;
            height: 2px;
            background: #696cff;
            box-shadow: 0 0 10px #696cff, 0 0 20px #696cff;
            opacity: 0.8;
            pointer-events: none;
            animation: scanning 2s infinite ease-in-out alternate;
        }
        @keyframes scanning {
            0% { top: 15%; }
            100% { top: 85%; }
        }
    </style>
</head>
<body class="p-3">

    <div class="scanner-card w-100 p-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <img src="<?= base_url(
                    "AMC-tanpa-nama-pad.png",
                ) ?>" alt="Logo" style="width: 38px; height: 38px; object-fit: contain;">
                <div>
                    <h5 class="mb-0 text-white fw-bold">Scan QR Code Aset</h5>
                    <small class="text-white-50">Arahkan kamera ke label aset RS AMC</small>
                </div>
            </div>
            <a href="<?= base_url(
                "dashboard",
            ) ?>" class="btn btn-sm btn-outline-light rounded-pill">
                <i class="bx bx-arrow-back me-1"></i> Dashboard
            </a>
        </div>

        <!-- Kamera Viewfinder -->
        <div class="position-relative scan-laser mb-3">
            <div id="reader"></div>
        </div>

        <!-- Status & Manual Input -->
        <div id="scan-status" class="alert alert-info py-2 px-3 small d-flex align-items-center gap-2 mb-3">
            <i class="bx bx-camera fs-5"></i>
            <span>Menyiapkan kamera...</span>
        </div>

        <!-- Opsi Jepret Foto Langsung (Bisa bekerja di HTTP biasa) -->
        <div class="card bg-dark border-secondary p-3 mb-3 text-center">
            <label class="form-label text-white small fw-bold mb-2">
                <i class="bx bx-camera me-1 text-primary"></i> Ambil Foto QR Code dari Kamera / Galeri
            </label>
            <input type="file" id="qr-input-file" accept="image/*" capture="environment" class="form-control form-control-sm bg-secondary text-white border-0">
            <small class="text-white-50 mt-1 d-block" style="font-size: 0.72rem;">Berfungsi langsung di jaringan HTTP / HP tanpa perlu HTTPS</small>
        </div>

        <div class="input-group">
            <input type="text" id="manual-code" class="form-control bg-dark text-white border-secondary" placeholder="Atau ketik manual Kode Aset (mis: AMC-B001)">
            <button class="btn btn-primary" type="button" id="btn-manual">
                <i class="bx bx-search-alt me-1"></i> Buka
            </button>
        </div>
    </div>

    <script>
        function prosesHasilScan(decodedText) {
            var statusEl = document.getElementById('scan-status');
            statusEl.className = 'alert alert-success py-2 px-3 small d-flex align-items-center gap-2 mb-3';
            statusEl.innerHTML = '<i class="bx bx-check-circle fs-5"></i><span>Berhasil terdeteksi! Mengalihkan ke detail aset...</span>';

            // Jika hasil scan berupa URL lengkap (e.g. http://domain/scan/AMC-001)
            var target = decodedText.trim();
            if (target.startsWith('http://') || target.startsWith('https://')) {
                window.location.href = target;
            } else {
                // Jika hanya kode aset mentah
                window.location.href = '<?= site_url(
                    "scan/",
                ) ?>' + encodeURIComponent(target);
            }
        }

        var html5QrcodeScanner = new Html5Qrcode("reader");
        var config = {
            fps: 15,
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0
        };

        function startScanner() {
            var statusEl = document.getElementById('scan-status');

            // Cek protokol HTTPS / Localhost
            var isSecure = window.isSecureContext;
            if (!isSecure && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
                statusEl.className = 'alert alert-warning py-2 px-3 small d-flex flex-column gap-1 mb-3';
                statusEl.innerHTML = '<strong><i class="bx bx-info-circle me-1"></i> Mode HTTP LAN Terdeteksi</strong>' +
                    '<span>Live streaming video dibatasi oleh browser di HTTP. Gunakan <b>tombol jepret foto kamera</b> di bawah untuk scan, atau buka via <code>localhost</code> / Cloudflare HTTPS untuk live streaming.</span>';
                return;
            }

            // Langsung panggil kamera environment (belakang) tanpa getCameras dulu agar prompt izin langsung muncul
            html5QrcodeScanner.start(
                { facingMode: "environment" },
                config,
                function(decodedText, decodedResult) {
                    html5QrcodeScanner.stop().then(function() {
                        prosesHasilScan(decodedText);
                    }).catch(function() {
                        prosesHasilScan(decodedText);
                    });
                },
                function(errorMessage) {
                    // Frame scan biasa
                }
            ).then(function() {
                statusEl.className = 'alert alert-secondary py-2 px-3 small d-flex align-items-center gap-2 mb-3 text-white';
                statusEl.innerHTML = '<i class="bx bx-scan fs-5 text-primary"></i><span>Kamera aktif. Arahkan ke QR Code.</span>';
            }).catch(function(err) {
                // Fallback jika facingMode environment ditolak laptop/webcam depan
                html5QrcodeScanner.start(
                    { facingMode: "user" },
                    config,
                    function(decodedText, decodedResult) {
                        html5QrcodeScanner.stop().then(function() {
                            prosesHasilScan(decodedText);
                        }).catch(function() {
                            prosesHasilScan(decodedText);
                        });
                    },
                    function(errorMessage) {}
                ).then(function() {
                    statusEl.className = 'alert alert-secondary py-2 px-3 small d-flex align-items-center gap-2 mb-3 text-white';
                    statusEl.innerHTML = '<i class="bx bx-scan fs-5 text-primary"></i><span>Kamera aktif (Webcam). Arahkan ke QR Code.</span>';
                }).catch(function(errFallback) {
                    statusEl.className = 'alert alert-danger py-2 px-3 small d-flex flex-column gap-1 mb-3';
                    statusEl.innerHTML = '<strong><i class="bx bx-error me-1"></i> Izin kamera belum diberikan</strong>' +
                        '<span>Klik ikon gembok/setelan di address bar browser, ubah <b>Kamera</b> ke <b>Izinkan (Allow)</b> lalu refresh.</span>' +
                        '<button type="button" class="btn btn-sm btn-light mt-2" onclick="startScanner()"><i class="bx bx-refresh me-1"></i> Coba Minta Izin Lagi</button>';
                });
            });
        }

        // Scan dari upload foto / jepretan kamera langsung
        document.getElementById('qr-input-file').addEventListener('change', function(e) {
            if (e.target.files.length === 0) return;
            var file = e.target.files[0];
            var statusEl = document.getElementById('scan-status');
            statusEl.className = 'alert alert-info py-2 px-3 small d-flex align-items-center gap-2 mb-3';
            statusEl.innerHTML = '<i class="bx bx-loader-alt bx-spin fs-5"></i><span>Membaca QR Code dari foto...</span>';

            html5QrcodeScanner.scanFile(file, true)
                .then(function(decodedText) {
                    prosesHasilScan(decodedText);
                })
                .catch(function(err) {
                    statusEl.className = 'alert alert-danger py-2 px-3 small d-flex align-items-center gap-2 mb-3';
                    statusEl.innerHTML = '<i class="bx bx-error fs-5"></i><span>QR Code tidak terbaca dari foto. Pastikan gambar jelas dan coba lagi.</span>';
                });
        });

        // Langsung trigger saat halaman dibuka
        window.addEventListener('DOMContentLoaded', startScanner);

        // Handler input manual
        document.getElementById('btn-manual').addEventListener('click', function() {
            var val = document.getElementById('manual-code').value.trim();
            if (val) {
                prosesHasilScan(val);
            }
        });

        document.getElementById('manual-code').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                var val = this.value.trim();
                if (val) {
                    prosesHasilScan(val);
                }
            }
        });
    </script>
</body>
</html>
