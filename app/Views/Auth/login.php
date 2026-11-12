<!doctype html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Masuk | Sarpras RS AMC Muhammadiyah</title>
    <link rel="icon" type="image/png" sizes="64x64" href="<?= base_url(
        "AMC-tanpa-nama-pad.png",
    ) ?>"/>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url(
        "AMC-tanpa-nama-pad.png",
    ) ?>"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>

    <!-- Icons & Core CSS -->
    <link rel="stylesheet" href="<?= base_url(
        "assets/vendor/fonts/boxicons.css",
    ) ?>"/>
    <link rel="stylesheet" href="<?= base_url(
        "assets/vendor/css/core.css",
    ) ?>"/>

    <style>
        :root {
            --font-family: 'Public Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --brand-primary: #282460;
            --brand-primary-hover: #1e1b4b;
            --border-color: #e2e8f0;
            --input-border: #d1d5db;
            --text-dark: #0f172a;
            --text-muted: #64748b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: var(--font-family);
            background-color: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            color: var(--text-dark);
        }

        .dc-auth {
            width: 100%;
            max-width: 440px;
        }

        .dc-auth-panel {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-top: 4px solid var(--brand-primary);
            border-radius: 8px;
            padding: 2rem 2rem 2.25rem;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.06);
        }

        .dc-auth-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #edf2f7;
        }

        .dc-auth-kop {
            display: block;
            width: 100%;
            height: auto;
            max-height: 90px;
            object-fit: contain;
        }

        .dc-auth-panel h1 {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 0.5rem;
            text-align: left;
            font-family: var(--font-family);
            letter-spacing: -0.01em;
        }

        .dc-auth-panel .text-muted-dc {
            font-size: 0.875rem;
            color: var(--text-muted);
            text-align: left;
            margin: 0 0 1.5rem;
            line-height: 1.5;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #334155;
            margin-bottom: 0.4rem;
            text-align: left;
        }

        .form-control {
            width: 100%;
            padding: 0.65rem 0.85rem;
            font-size: 0.9375rem;
            font-family: var(--font-family);
            color: var(--text-dark);
            background: #ffffff;
            border: 1px solid var(--input-border);
            border-radius: 6px;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-control:hover:not(:disabled):not(:focus) {
            border-color: #94a3b8;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 3px rgba(40, 36, 96, 0.15);
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group-merge .form-control {
            padding-right: 2.75rem;
        }

        .input-group-text {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            padding: 0.25rem;
            color: #64748b;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
        }

        .input-group-text:hover {
            color: var(--brand-primary);
        }

        .input-group-text i {
            font-size: 1.25rem;
        }

        .btn-masuk {
            background-color: var(--brand-primary);
            border-color: var(--brand-primary);
            color: #ffffff;
            font-family: var(--font-family);
            font-weight: 600;
            font-size: 0.9375rem;
            padding: 0.7rem 1.25rem;
            border-radius: 6px;
            border: 1px solid transparent;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.15s ease, box-shadow 0.15s ease;
            box-shadow: 0 2px 4px rgba(40, 36, 96, 0.18);
        }

        .btn-masuk:hover {
            background-color: var(--brand-primary-hover);
            border-color: var(--brand-primary-hover);
            color: #ffffff;
        }

        .btn-masuk:active {
            background-color: #161338;
            transform: translateY(1px);
        }

        .form-hint {
            font-size: 0.8125rem;
            color: var(--text-muted);
            text-align: left;
            margin: 1.25rem 0 0;
            line-height: 1.55;
        }

        .invalid-feedback {
            font-size: 0.8125rem;
            color: #ef4444;
            margin-top: 0.35rem;
            text-align: left;
        }

        .alert-error {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
            text-align: left;
        }

        @media (max-width: 480px) {
            .dc-auth-panel {
                padding: 1.5rem 1.25rem 1.75rem;
            }
            .dc-auth-panel h1 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <main class="dc-auth">
        <div class="dc-auth-panel">
            <div class="dc-auth-header">
                <img class="dc-auth-kop" src="<?= base_url(
                    "header.png",
                ) ?>" alt="RS AMC Muhammadiyah"/>
            </div>

            <h1>Sarpras AMC</h1>
            <p class="text-muted-dc">Sistem informasi pengelolaan sarana, prasarana, dan aset inventaris RS AMC Muhammadiyah.</p>

            <?php if (session("error")): ?>
                <div class="alert-error">
                    <?= esc(session("error")) ?>
                </div>
            <?php endif; ?>

            <?php if (session("message")): ?>
                <div class="alert-error" style="background-color: #f0fdf4; border-color: #bbf7d0; color: #166534;">
                    <?= esc(session("message")) ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url(
                "login",
            ) ?>" method="post" autocomplete="off" novalidate>
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label" for="login">Username atau email</label>
                    <input id="login" name="login" type="text" value="<?= old(
                        "login",
                    ) ?>" autofocus class="form-control <?= session(
    "errors.login",
)
    ? "is-invalid"
    : "" ?>"/>
                    <?php if (session("errors.login")): ?>
                        <div class="invalid-feedback"><?= esc(
                            session("errors.login"),
                        ) ?></div>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group input-group-merge">
                        <input id="password" name="password" type="password" class="form-control <?= session(
                            "errors.password",
                        )
                            ? "is-invalid"
                            : "" ?>"/>
                        <button type="button" class="input-group-text" id="toggle-password" aria-label="Tampilkan password">
                            <i class="icon-base bx bx-hide"></i>
                        </button>
                    </div>
                    <?php if (session("errors.password")): ?>
                        <div class="invalid-feedback"><?= esc(
                            session("errors.password"),
                        ) ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn-masuk">Masuk</button>
            </form>

            <p class="form-hint">Gunakan akun yang sama dengan sistem informasi RS lainnya. Lupa password atau belum punya akses? Hubungi admin sarpras / IT.</p>
        </div>
    </main>

    <script>
        document.getElementById('toggle-password').addEventListener('click', function() {
            const input = document.getElementById('password');
            const icon = this.querySelector('i');
            const tampil = input.type === 'password';
            input.type = tampil ? 'text' : 'password';
            icon.classList.toggle('bx-hide', !tampil);
            icon.classList.toggle('bx-show', tampil);
        });
    </script>
</body>
</html>
