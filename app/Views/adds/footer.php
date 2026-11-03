<footer class="content-footer footer bg-footer-theme">
  <div class="container-xxl">
    <div
      class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
      <div class="mb-2 mb-md-0">
        <div>&copy; All rights reserved. IT RS AMC Muhammadiyah | version 2.10</div>
      </div>
    </div>
  </div>
</footer>

<!-- Floating QR Button Global -->
<button type="button" class="btn btn-primary rounded-circle shadow-lg position-fixed d-flex align-items-center justify-content-center"
  data-bs-toggle="modal" data-bs-target="#modalScanQr"
  title="Scan QR Code Aset"
  aria-label="Scan QR Code Aset"
  style="width: 60px; height: 60px; bottom: 25px; right: 25px; z-index: 1080;">
  <i class="bx bx-qr-scan text-white" style="font-size: 1.8rem;"></i>
</button>

<!-- Modal Scanner QR Code -->
<div class="modal fade" id="modalScanQr" tabindex="-1" aria-labelledby="modalScanQrLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
    <div class="modal-content shadow-lg">
      <div class="modal-header bg-primary text-white px-4 py-3 align-items-center">
        <h5 class="modal-title text-white d-flex align-items-center gap-2 m-0" id="modalScanQrLabel">
          <i class="bx bx-qr-scan fs-4"></i> Scan QR Code Aset
        </h5>
        <button type="button" class="btn-close btn-close-white m-0" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body p-3">
        <!-- Kamera Viewfinder -->
        <div class="position-relative bg-dark rounded overflow-hidden mb-3" style="min-height: 260px;">
          <div id="modal-qr-reader" style="width: 100%;"></div>
        </div>

        <!-- Status Scan -->
        <div id="modal-scan-status" class="alert alert-secondary py-2 px-3 small d-flex align-items-center gap-2 mb-3">
          <i class="bx bx-camera fs-5"></i>
          <span>Membuka kamera...</span>
        </div>

        <!-- Opsi Upload Foto / Jepret Kamera (Cadangan untuk HTTP LAN) -->
        <div class="border rounded p-2 mb-3 bg-light">
          <label class="form-label small fw-bold mb-1 text-muted">
            <i class="bx bx-image-add me-1 text-primary"></i> Unggah / Ambil Foto QR Code
          </label>
          <input type="file" id="modal-qr-file" accept="image/*" capture="environment" class="form-control form-control-sm">
          <small class="text-muted d-block mt-1" style="font-size: 0.72rem;">Gunakan ini bila live streaming diblokir oleh browser di jaringan HTTP biasa.</small>
        </div>

        <!-- Input Manual -->
        <div class="input-group">
          <input type="text" id="modal-manual-code" class="form-control form-control-sm" placeholder="Atau ketik Kode Aset (mis: AMC-...)">
          <button class="btn btn-sm btn-outline-primary" type="button" id="modal-btn-manual">
            <i class="bx bx-search-alt me-1"></i> Buka
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Library html5-qrcode -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
  (function() {
    var modalEl = document.getElementById('modalScanQr');
    if (!modalEl) return;

    var html5QrCode = null;
    var scanStatus = document.getElementById('modal-scan-status');
    var isScanning = false;

    function handleResult(decodedText) {
      if (!decodedText) return;
      var clean = decodedText.trim();

      // Hentikan scanner dulu sebelum redirect
      stopScanner().finally(function() {
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();

        if (clean.startsWith('http://') || clean.startsWith('https://')) {
          window.location.href = clean;
        } else {
          window.location.href = '<?= site_url(
              "scan/",
          ) ?>' + encodeURIComponent(clean);
        }
      });
    }

    function stopScanner() {
      if (html5QrCode && isScanning) {
        return html5QrCode.stop().then(function() {
          isScanning = false;
        }).catch(function(err) {
          isScanning = false;
        });
      }
      return Promise.resolve();
    }

    function startScanner() {
      if (!html5QrCode) {
        html5QrCode = new Html5Qrcode("modal-qr-reader");
      }

      var isSecure = window.isSecureContext;
      if (!isSecure && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
        scanStatus.className = 'alert alert-warning py-2 px-3 small mb-3';
        scanStatus.innerHTML = '<i class="bx bx-info-circle me-1"></i> Mode HTTP terdeteksi. Browser membatasi kamera live. Silakan gunakan <b>foto QR</b> di bawah.';
        return;
      }

      scanStatus.className = 'alert alert-info py-2 px-3 small d-flex align-items-center gap-2 mb-3';
      scanStatus.innerHTML = '<i class="bx bx-loader-alt bx-spin fs-5"></i><span>Mengaktifkan kamera...</span>';

      var config = { fps: 15, qrbox: { width: 220, height: 220 }, aspectRatio: 1.0 };

      // Coba kamera belakang (environment), fallback ke kamera depan (user)
      html5QrCode.start(
        { facingMode: "environment" },
        config,
        function(text) { handleResult(text); },
        function() {}
      ).then(function() {
        isScanning = true;
        scanStatus.className = 'alert alert-success py-2 px-3 small d-flex align-items-center gap-2 mb-3';
        scanStatus.innerHTML = '<i class="bx bx-scan fs-5"></i><span>Kamera aktif. Arahkan ke QR Code.</span>';
      }).catch(function() {
        html5QrCode.start(
          { facingMode: "user" },
          config,
          function(text) { handleResult(text); },
          function() {}
        ).then(function() {
          isScanning = true;
          scanStatus.className = 'alert alert-success py-2 px-3 small d-flex align-items-center gap-2 mb-3';
          scanStatus.innerHTML = '<i class="bx bx-scan fs-5"></i><span>Kamera aktif. Arahkan ke QR Code.</span>';
        }).catch(function(err) {
          scanStatus.className = 'alert alert-danger py-2 px-3 small mb-3';
          scanStatus.innerHTML = '<i class="bx bx-error me-1"></i> Gagal membuka kamera (' + (err.message || err) + ').';
        });
      });
    }

    // Lifecycle modal
    modalEl.addEventListener('shown.bs.modal', function() {
      startScanner();
    });

    modalEl.addEventListener('hidden.bs.modal', function() {
      stopScanner();
    });

    // Handle foto file upload
    var fileInput = document.getElementById('modal-qr-file');
    if (fileInput) {
      fileInput.addEventListener('change', function(e) {
        if (!e.target.files || e.target.files.length === 0) return;
        var file = e.target.files[0];
        if (!html5QrCode) {
          html5QrCode = new Html5Qrcode("modal-qr-reader");
        }
        scanStatus.className = 'alert alert-info py-2 px-3 small mb-3';
        scanStatus.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Membaca QR dari foto...';

        html5QrCode.scanFile(file, true).then(function(decodedText) {
          handleResult(decodedText);
        }).catch(function(err) {
          scanStatus.className = 'alert alert-danger py-2 px-3 small mb-3';
          scanStatus.innerHTML = '<i class="bx bx-error me-1"></i> QR Code tidak terbaca dari foto. Coba foto lebih jelas/tegak lurus.';
        });
      });
    }

    // Handle input manual
    var btnManual = document.getElementById('modal-btn-manual');
    var inputManual = document.getElementById('modal-manual-code');
    function submitManual() {
      var val = (inputManual.value || '').trim();
      if (val) handleResult(val);
    }
    if (btnManual && inputManual) {
      btnManual.addEventListener('click', submitManual);
      inputManual.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
          e.preventDefault();
          submitManual();
        }
      });
    }
  })();
</script>
