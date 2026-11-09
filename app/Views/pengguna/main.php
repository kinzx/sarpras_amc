<div class="container-xxl flex-grow-1 container-p-y">
  <!-- BREADCRUMB -->
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="<?= base_url(
          "dashboard",
      ) ?>"><i class="bx bx-home-alt me-1"></i> Beranda</a></li>
      <li class="breadcrumb-item">Data Master</li>
      <li class="breadcrumb-item active" aria-current="page">Pengguna & Role</li>
    </ol>
  </nav>

  <!-- HEADER HALAMAN (Industrial: Menyatu tanpa Card Template) -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="page-header-title">Manajemen Pengguna & Hak Akses</h1>
      <p class="page-header-desc">Kelola otorisasi akun staf, teknisi elektromedik, dan administrator sistem sarpras.</p>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
      <i class="bx bx-user-plus me-1"></i> Tambah Pengguna
    </button>
  </div>

  <?php if (session()->getFlashdata("message")): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= esc(session()->getFlashdata("message")) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata("errors")): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <ul class="mb-0">
        <?php foreach (session()->getFlashdata("errors") as $error): ?>
          <li><?= esc($error) ?></li>
        <?php endforeach; ?>
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <!-- TABEL PENGGUNA (Industrial) -->
  <div class="table-card-industrial">
    <div class="card-header-industrial d-flex justify-content-between align-items-center">
      <h6 class="mb-0 fw-semibold text-dark">Daftar Akun Pengguna Terdaftar</h6>
      <span class="text-muted small">Total: <?= count($users ?? []) ?> Akun</span>
    </div>

    <div class="table-responsive text-nowrap">
      <table class="table-industrial">
        <thead>
          <tr>
            <th style="width: 50px;">NO.</th>
            <th>PENGGUNA</th>
            <th>EMAIL</th>
            <th>ROLE / HAK AKSES</th>
            <th>STATUS</th>
            <th class="text-center" style="width: 110px;">AKSI</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($users)): ?>
            <tr>
              <td colspan="6" class="p-0">
                <div class="empty-state-container">
                  <div class="empty-state-icon">
                    <i class="bx bx-user-x"></i>
                  </div>
                  <h6 class="fw-semibold text-dark mb-1">Belum Ada Pengguna</h6>
                  <p class="text-muted small mb-3">Tambahkan akun staf atau teknisi pertama ke dalam sistem.</p>
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                    <i class="bx bx-user-plus me-1"></i> Tambah Pengguna
                  </button>
                </div>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($users as $i => $u): ?>
              <tr>
                <td class="text-muted font-monospace" style="font-size: 0.8rem;"><?= sprintf(
                    "%02d",
                    $i + 1,
                ) ?></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div style="width: 30px; height: 30px; border-radius: 4px; background: var(--slate-100); border: 1px solid var(--border-subtle); display: inline-flex; align-items: center; justify-content: center; font-size: 0.95rem;" class="text-slate-700">
                      <i class="bx bx-user"></i>
                    </div>
                    <span class="fw-semibold text-dark"><?= esc(
                        $u["username"],
                    ) ?></span>
                  </div>
                </td>
                <td class="text-muted"><?= esc($u["email"]) ?></td>
                <td>
                  <?php if (($u["role_name"] ?? "") === "superadmin"): ?>
                    <span class="badge-status-box" style="background: #0f172a; color: #f8fafc; border-color: #0f172a;"><i class="bx bx-crown me-1"></i>Superadmin</span>
                  <?php elseif (($u["role_name"] ?? "") === "admin"): ?>
                    <span class="badge-status-box" style="background: #fef2f2; color: #991b1b; border-color: #fecaca;"><i class="bx bx-shield-quarter me-1"></i>Administrator</span>
                  <?php elseif (
                      ($u["role_name"] ?? "") === "admin_teknisi"
                  ): ?>
                    <span class="badge-status-box" style="background: #f0f9ff; color: #075985; border-color: #bae6fd;"><i class="bx bx-hard-hat me-1"></i>Admin Teknisi</span>
                  <?php elseif (($u["role_name"] ?? "") === "teknisi"): ?>
                    <span class="badge-status-box" style="background: #eff6ff; color: #1e40af; border-color: #bfdbfe;"><i class="bx bx-wrench me-1"></i>Teknisi</span>
                  <?php else: ?>
                    <span class="badge-status-box inactive"><?= esc(
                        $u["role_name"] ?? "Staff",
                    ) ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($u["active"] == 1): ?>
                    <span class="badge-status-box active">Aktif</span>
                  <?php else: ?>
                    <span class="badge-status-box inactive">Nonaktif</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <div class="d-inline-flex gap-1">
                    <button type="button" class="action-btn-ghost btn-ghost-primary btn-edit-user"
                      data-bs-toggle="modal" data-bs-target="#modalEditUser"
                      data-id="<?= $u["id"] ?>"
                      data-username="<?= esc($u["username"]) ?>"
                      data-email="<?= esc($u["email"]) ?>"
                      data-group="<?= esc($u["group_name"] ?? "") ?>"
                      aria-label="Edit akun <?= esc($u["username"]) ?>"
                      title="Edit User">
                      <i class="bx bx-pencil"></i>
                    </button>
                    <a href="<?= base_url("pengguna/hapus/" . $u["id"]) ?>"
                       class="action-btn-ghost btn-ghost-danger"
                       aria-label="Nonaktifkan akun <?= esc($u["username"]) ?>"
                       title="Nonaktifkan User"
                       onclick="return confirm('Yakin ingin menonaktifkan pengguna ini?');">
                      <i class="bx bx-user-x"></i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="table-footer-industrial d-flex justify-content-between align-items-center">
      <span>Menampilkan <?= count($users ?? []) ?> pengguna sistem</span>
    </div>
  </div>
</div>

<!-- MODAL TAMBAH USER -->
<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 6px; border: 1px solid var(--border-subtle);">
      <form action="<?= base_url("pengguna/simpan") ?>" method="POST">
        <?= csrf_field() ?>
        <div class="modal-header" style="border-bottom: 1px solid var(--border-subtle); padding: 14px 20px;">
          <h5 class="modal-title fw-bold text-dark" style="font-size: 1rem;">Tambah Pengguna Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label text-dark fw-medium" style="font-size: 0.8rem;">Username <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="username" placeholder="Contoh: teknisi_medis" required>
          </div>
          <div class="mb-3">
            <label class="form-label text-dark fw-medium" style="font-size: 0.8rem;">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email" placeholder="nama@amc.co.id" required>
          </div>
          <div class="mb-3">
            <label class="form-label text-dark fw-medium" style="font-size: 0.8rem;">Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" name="password" minlength="6" placeholder="Minimal 6 karakter" required>
          </div>
          <div class="mb-3">
            <label class="form-label text-dark fw-medium" style="font-size: 0.8rem;">Role / Hak Akses <span class="text-danger">*</span></label>
            <select class="form-select" name="group_id" required>
              <option value="">-- Pilih Role --</option>
              <?php foreach ($groups as $g): ?>
                <option value="<?= $g->id ?>"><?= esc(
    ucfirst($g->name),
) ?> (<?= esc($g->description) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid var(--border-subtle); padding: 12px 20px;">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Pengguna</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL EDIT USER -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 6px; border: 1px solid var(--border-subtle);">
      <form id="formEditUser" method="POST">
        <?= csrf_field() ?>
        <div class="modal-header" style="border-bottom: 1px solid var(--border-subtle); padding: 14px 20px;">
          <h5 class="modal-title fw-bold text-dark" style="font-size: 1rem;">Edit Pengguna</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label text-dark fw-medium" style="font-size: 0.8rem;">Username <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="username" id="edit_username" required>
          </div>
          <div class="mb-3">
            <label class="form-label text-dark fw-medium" style="font-size: 0.8rem;">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email" id="edit_email" required>
          </div>
          <div class="mb-3">
            <label class="form-label text-dark fw-medium" style="font-size: 0.8rem;">Password Baru (Opsional)</label>
            <input type="password" class="form-control" name="password" minlength="6" placeholder="Kosongkan jika tidak ingin mengganti password">
          </div>
          <div class="mb-3">
            <label class="form-label text-dark fw-medium" style="font-size: 0.8rem;">Role / Hak Akses <span class="text-danger">*</span></label>
            <select class="form-select" name="group_id" id="edit_group_id" required>
              <option value="">-- Pilih Role --</option>
              <?php foreach ($groups as $g): ?>
                <option value="<?= $g->id ?>"><?= esc(
    ucfirst($g->name),
) ?> (<?= esc($g->description) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer" style="border-top: 1px solid var(--border-subtle); padding: 12px 20px;">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
