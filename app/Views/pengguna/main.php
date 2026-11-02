<div class="container-xxl flex-grow-1 container-p-y">
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>"><i class="bx bx-home-alt me-1"></i> Beranda</a></li>
      <li class="breadcrumb-item">Data Master</li>
      <li class="breadcrumb-item active" aria-current="page">Pengguna & Role</li>
    </ol>
  </nav>

  <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
      <?= esc(session()->getFlashdata('message')) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
      <ul class="mb-0">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
          <li><?= esc($error) ?></li>
        <?php endforeach; ?>
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <div class="card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
      <div>
        <h5 class="card-title mb-0"><i class="bx bx-user-check me-2 text-primary"></i> Manajemen Pengguna & Hak Akses</h5>
        <small class="text-muted">Kelola akun staf, teknisi, dan administrator sarpras</small>
      </div>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
        <i class="bx bx-user-plus me-1"></i> Tambah Pengguna
      </button>
    </div>

    <div class="table-responsive text-nowrap">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th style="width: 50px;">No</th>
            <th>Pengguna</th>
            <th>Email</th>
            <th>Role / Grup</th>
            <th>Status</th>
            <th class="text-center" style="width: 140px;">Aksi</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          <?php if (empty($users)): ?>
            <tr>
              <td colspan="6" class="text-center py-4 text-muted">Belum ada data pengguna.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($users as $i => $u): ?>
              <tr>
                <td><?= $i + 1 ?></td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2 bg-label-primary rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bx bx-user"></i>
                    </div>
                    <strong><?= esc($u['username']) ?></strong>
                  </div>
                </td>
                <td><?= esc($u['email']) ?></td>
                <td>
                  <?php if (($u['role_name'] ?? '') === 'admin'): ?>
                    <span class="badge bg-label-danger"><i class="bx bx-shield-quarter me-1"></i>Administrator</span>
                  <?php elseif (($u['role_name'] ?? '') === 'teknisi'): ?>
                    <span class="badge bg-label-primary"><i class="bx bx-wrench me-1"></i>Teknisi</span>
                  <?php else: ?>
                    <span class="badge bg-label-secondary"><?= esc($u['role_name'] ?? 'Guest/Staff') ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($u['active'] == 1): ?>
                    <span class="badge bg-label-success">Aktif</span>
                  <?php else: ?>
                    <span class="badge bg-label-danger">Nonaktif</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-icon btn-outline-warning btn-edit-user"
                    data-bs-toggle="modal" data-bs-target="#modalEditUser"
                    data-id="<?= $u['id'] ?>"
                    data-username="<?= esc($u['username']) ?>"
                    data-email="<?= esc($u['email']) ?>"
                    data-group="<?= esc($u['group_id']) ?>">
                    <i class="bx bx-edit"></i>
                  </button>
                  <a href="<?= base_url('pengguna/hapus/' . $u['id']) ?>"
                     class="btn btn-sm btn-icon btn-outline-danger"
                     onclick="return confirm('Yakin ingin menonaktifkan pengguna ini?');">
                    <i class="bx bx-user-x"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL TAMBAH USER -->
<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= base_url('pengguna/simpan') ?>" method="POST">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h5 class="modal-title">Tambah Pengguna Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Username <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="username" placeholder="Contoh: teknisi_medis" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email" placeholder="nama@amc.co.id" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" name="password" minlength="6" placeholder="Minimal 6 karakter" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Role / Hak Akses <span class="text-danger">*</span></label>
            <select class="form-select" name="group_id" required>
              <option value="">-- Pilih Role --</option>
              <?php foreach ($groups as $g): ?>
                <option value="<?= $g->id ?>"><?= esc(ucfirst($g->name)) ?> (<?= esc($g->description) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Pengguna</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL EDIT USER -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formEditUser" method="POST">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h5 class="modal-title">Edit Pengguna</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Username <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="username" id="edit_username" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email" id="edit_email" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password Baru (Opsional)</label>
            <input type="password" class="form-control" name="password" minlength="6" placeholder="Kosongkan jika tidak ingin mengganti password">
          </div>
          <div class="mb-3">
            <label class="form-label">Role / Hak Akses <span class="text-danger">*</span></label>
            <select class="form-select" name="group_id" id="edit_group_id" required>
              <option value="">-- Pilih Role --</option>
              <?php foreach ($groups as $g): ?>
                <option value="<?= $g->id ?>"><?= esc(ucfirst($g->name)) ?> (<?= esc($g->description) ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i> Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
