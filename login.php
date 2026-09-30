<?php
session_start();
include 'includes/db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $celular = trim($_POST['celular']);
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarioss WHERE celular = ? AND estado = 'activo'");
    $stmt->execute([$celular]);
    $user = $stmt->fetch();

    $passOk = false;
    if ($user) {
        if (str_starts_with($user['password'], '$2y$') || str_starts_with($user['password'], '$argon')) {
            $passOk = password_verify($pass, $user['password']);
        } else {
            $passOk = hash_equals($user['password'], $pass);
        }
    }

    if ($user && $passOk) {
        $_SESSION['user'] = $user;

        if (in_array($user['rol'], ['admin', 'administrador'], true)) {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: cliente/qr.php");
        }
        exit;
    } else {
        $error = "Celular o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
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
        body {
            background: #f8f9fa;
        }
        [data-bs-theme="dark"] body {
            background: #212529;
        }
        .login-wrapper {
            max-width: 400px;
            width: 100%;
            padding: 2rem;
        }
        .login-wrapper.bg-white {
            background-color: #fff !important;
            color: #212529;
        }
        [data-bs-theme="dark"] .login-wrapper.bg-white {
            background-color: #343a40 !important;
            color: #dee2e6;
        }
        .theme-toggle {
            position: absolute;
            top: .75rem;
            right: .75rem;
            border: none;
            background: transparent;
            font-size: 1.15rem;
            line-height: 1;
            padding: .35rem .5rem;
            border-radius: .5rem;
            cursor: pointer;
        }
        .theme-toggle:hover {
            background: rgba(128, 128, 128, .2);
        }
        .logo {
            max-width: 240px;
            height: auto;
        }
        .logo-dark {
            display: none;
        }
        [data-bs-theme="dark"] .logo-light {
            display: none;
        }
        [data-bs-theme="dark"] .logo-dark {
            display: inline-block;
        }
        @media (max-width: 576px) {
            .logo {
                max-width: 180px;
            }
            .login-wrapper {
                width: calc(100% - 2rem);
                max-width: calc(100% - 2rem);
                padding: 1.5rem 1.25rem;
            }
            body {
                padding: 1rem;
            }
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="login-wrapper bg-white rounded shadow text-center position-relative">
        <button type="button" class="theme-toggle" id="themeToggle" title="Cambiar modo claro/oscuro" aria-label="Cambiar modo claro/oscuro">🌙</button>
        <!-- Logo -->
        <img src="imgs/logo-modo-claro.png" alt="Logo" class="logo logo-light mb-3">
        <img src="imgs/logo-modo-oscuro.png" alt="Logo" class="logo logo-dark mb-3">

        <h4 class="mb-4">Iniciar Sesión</h4>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3 text-start">
                <input type="text" name="celular" class="form-control" placeholder="Celular" required>
            </div>
            <div class="mb-3 text-start">
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePass(this)" title="Mostrar u ocultar contraseña">👁</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100" style="background: #666308; border-color: #28a745;">Ingresar</button>
        </form>
    </div>

    <script>
        function togglePass(btn) {
            const input = btn.parentElement.querySelector('input');
            const ver = input.type === 'password';
            input.type = ver ? 'text' : 'password';
            btn.textContent = ver ? '🙈' : '👁';
        }

        const themeBtn = document.getElementById('themeToggle');

        function renderTheme() {
            const dark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
            themeBtn.textContent = dark ? '☀️' : '🌙';
        }

        themeBtn.addEventListener('click', () => {
            const actual = document.documentElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', actual);
            try { localStorage.setItem('theme', actual); } catch (e) {}
            document.cookie = 'theme=' + actual + ';path=/;max-age=31536000;SameSite=Lax';
            renderTheme();
        });

        renderTheme();
    </script>
    
    <?php include 'includes/whatsapp.php'; ?>



</body>
</html>
