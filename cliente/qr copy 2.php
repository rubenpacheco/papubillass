<?php
include '../includes/auth.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Código QR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .qr-card {
            max-width: 500px;
            margin: auto;
            margin-top: 60px;
        }
        .qr-img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="bg-light">

    <div class="container">
        <div class="card qr-card shadow text-center p-4">
            <h4 class="mb-3">¡Hola, <?= htmlspecialchars($_SESSION['user']['nombre_completo']) ?>!</h4>
            <p class="text-muted">Este es tu código QR personal</p>

            <img src="../qrcodes/<?= htmlspecialchars($_SESSION['user']['dni']) ?>.png" alt="Mi Código QR" class="qr-img mb-4">

            <a href="sellos.php" class="btn btn-primary">Ver Sellos</a>
        </div>
    </div>

</body>
</html>
