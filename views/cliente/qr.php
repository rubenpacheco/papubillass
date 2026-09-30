


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mi Código QR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        (function () {
            const cookie = <?= json_encode(in_array($_COOKIE['theme'] ?? '', ['dark', 'light'], true) ? $_COOKIE['theme'] : '') ?>;
            const t = cookie ||
                localStorage.getItem('theme') ||
                (document.cookie.match(/(?:^|;\s*)theme=(dark|light)(?:;|$)/) || [])[1] ||
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-bs-theme', t);
        })();
    </script>
    <style>
        /* Centrado total de la página */
        html {
            background-color: #f8f9fa;
        }

        html[data-bs-theme="dark"] {
            background-color: #212529;
            color-scheme: dark;
        }

        html[data-bs-theme="light"] {
            color-scheme: light;
        }

        body {
            min-height: 100vh;
            min-height: 100dvh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: transparent;
        }

        .qr-card {
            max-width: 500px;
            margin: auto;
        }

        [data-bs-theme="dark"] .qr-card {
            background-color: #2b3035 !important;
            border-color: rgba(255, 255, 255, .06) !important;
            color: #dee2e6;
        }

        [data-bs-theme="dark"] .qr-card .text-muted {
            color: #adb5bd !important;
        }

        .qr-img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f8f9fa;
        }

        [data-bs-theme="dark"] .qr-img {
            border-color: rgba(255, 255, 255, .08);
            background-color: #ffffff;
        }

        .theme-toggle {
            position: fixed;
            top: .75rem;
            right: .75rem;
            border: none;
            background: transparent;
            font-size: 1.15rem;
            line-height: 1;
            padding: .35rem .5rem;
            border-radius: .5rem;
            cursor: pointer;
            z-index: 1000;
        }

        .theme-toggle:hover {
            background: rgba(128, 128, 128, .2);
        }

        .acciones {
            display: flex;
            flex-wrap: nowrap;
            gap: .5rem;
            align-items: stretch;
        }

        .acciones .btn {
            flex: 1 1 0;
            min-width: 0;
            white-space: normal;
            padding: .6rem .5rem;
            font-size: .95rem;
        }

        @media (max-width: 576px) {
            body {
                padding: 1rem;
            }

            .acciones .btn {
                font-size: .85rem;
                padding: .55rem .35rem;
            }
        }
    </style>
</head>


<body>
    <button type="button" class="theme-toggle" id="themeToggle" title="Cambiar modo claro/oscuro" aria-label="Cambiar modo claro/oscuro">🌙</button>

    <div class="container">
        <div class="card qr-card shadow text-center p-4">
            <h4 class="mb-3">¡Hola, <?= htmlspecialchars($usuario['nombre_completo']) ?>!</h4>
            <p class="text-muted">Este es tu código QR personal</p>

            <img src="../qrcodes/<?= htmlspecialchars($usuario['celular']) ?>.png" alt="Mi Código QR"
                class="qr-img mb-4">

                <div class="acciones">
                    <a href="<?= $disenio ?>.php" class="btn btn-primary" style="background: #666308; border-color: #28a745;">Ver Sellos</a>
                    <a href="../logout.php" class="btn btn-secondary">Cerrar sesión</a>
                </div>
        </div>


    </div>

<?php include __DIR__ . '/../../includes/whatsapp.php'; ?>
    <script>
        (function () {
            const btn = document.getElementById('themeToggle');
            const root = document.documentElement;

            function render() {
                btn.textContent = root.getAttribute('data-bs-theme') === 'dark' ? '☀️' : '🌙';
            }

            btn.addEventListener('click', function () {
                const next = root.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                root.setAttribute('data-bs-theme', next);
                try { localStorage.setItem('theme', next); } catch (e) {}
                document.cookie = 'theme=' + next + ';path=/;max-age=31536000;SameSite=Lax';
                render();
            });

            render();
        })();
    </script>
</body>

</html>