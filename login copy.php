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

        $_SESSION['user'] = $user;
        if ($user['rol'] == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: cliente/qr.php");
        }
        exit;
    
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <form method="post" class="p-4 border rounded bg-white">
        <h4 class="mb-3">Iniciar Sesión</h4>
        <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
        <input type="text" id="dni" name="dni" class="form-control mb-2" placeholder="DNI" required>
        <input type="password" id="password" name="password" class="form-control mb-2" placeholder="Contraseña" required>
        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
    </form>
</body>
</html>