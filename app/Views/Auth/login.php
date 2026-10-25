<?= $this->extend('layout_auth') ?>
<?= $this->section('main') ?>

<div class="container">
	<div class="row justify-content-center align-items-center" style="min-height: 100vh;">
		<div class="col-sm-6 col-md-5 col-lg-4">

			<div class="card shadow-sm border-0">
				<div class="card-body p-4">

					<!-- Icon / Logo RS AMC -->
					<div class="text-center mb-4">
						<img src="<?= base_url('Logo-amc.png') ?>"
							alt="Logo RS AMC"
							style="max-width: 150px; height: auto;">
						<p class="text-muted mt-3 mb-1">Sistem Antrean & Layanan Pasien</p>
					</div>

					<?= view('App\Views\Auth\_message_block') ?>

					<form action="<?= url_to('login') ?>" method="post">
						<?= csrf_field() ?>

						<div class="form-group mb-3">
							<label for="login" class="form-label">Email atau Username</label>
							<input type="text" class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
								name="login" placeholder="Masukkan email atau username">
							<div class="invalid-feedback">
								<?= session('errors.login') ?>
							</div>
						</div>

						<div class="form-group mb-3">
							<label for="password" class="form-label">Password</label>
							<input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="Masukkan password">
							<div class="invalid-feedback">
								<?= session('errors.password') ?>
							</div>
						</div>

						<div class="form-check mb-3">
							<label class="form-check-label">
								<input type="checkbox" name="remember" class="form-check-input" <?php if (old('remember')) : ?> checked <?php endif ?>>
								Ingat Saya
							</label>
						</div>

						<button type="submit" class="btn btn-primary w-100">Login</button>
					</form>

					<hr>
					<p class="text-center mb-0">
						<a href="<?= url_to('forgot') ?>">Lupa password?</a>
					</p>

				</div>
			</div>

		</div>
	</div>
</div>

<?= $this->endSection() ?>