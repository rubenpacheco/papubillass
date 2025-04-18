<?php
session_start();
include 'includes/db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['dni'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarioss WHERE dni = ? AND estado = 'activo'");
    $stmt->execute([$dni]);
    $user = $stmt->fetch();

    if ($user && $user['password'] === $pass) {
        $_SESSION['user'] = $user;

        if ($user['rol'] === 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: cliente/qr.php");
        }
        exit;
    } else {
        $error = "DNI o contraseña incorrectos.";
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
    <style>
        body {
            background: #f8f9fa;
        }
        .login-wrapper {
            max-width: 400px;
            width: 100%;
            padding: 2rem;
        }
        .logo {
            max-width: 140px;
            height: auto;
        }
        @media (max-width: 576px) {
            .logo {
                max-width: 100px;
            }
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="login-wrapper bg-white rounded shadow text-center">
        <!-- Logo -->
        <img src="imgs/logo.jpg" alt="Logo" class="logo mb-3">

        <h4 class="mb-4">Iniciar Sesión</h4>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3 text-start">
                <input type="text" name="dni" class="form-control" placeholder="DNI" required>
            </div>
            <div class="mb-3 text-start">
                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
    </div>

    <a href="https://wa.me/51987654321?text=Hola,%20estoy%20interesado%20en%20el%20software" 
    class="whatsapp-float" target="_blank">
        <img src="https://img.icons8.com/color/48/000000/whatsapp--v1.png" alt="WhatsApp">
        <span class="whatsapp-text">Adquiere tu software</span>
    </a>


</body>
</html>
<style>
    .whatsapp-float {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #25d366;
    color: white;
    border-radius: 30px;
    padding: 8px 12px;
    text-decoration: none;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    z-index: 1000;
    transition: transform 0.2s ease;
}
.whatsapp-float:hover {
    transform: scale(1.05);
    text-decoration: none;
    color: white;
}
.whatsapp-float img {
    width: 28px;
    height: 28px;
    margin-right: 8px;
}
.whatsapp-text {
    font-weight: bold;
    font-size: 14px;
}

</style>