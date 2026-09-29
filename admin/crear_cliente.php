<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../includes/auth.php';
include '../includes/db.php';

require_once '../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $dni = trim($_POST['dni'] ?? '');
    $celular = trim($_POST['celular']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    try {
        // Insertar nuevo cliente
        $stmt = $pdo->prepare("INSERT INTO usuarioss (nombre_completo, dni, celular, rol, password) VALUES (?, ?, ?, 'cliente', ?)");
        $stmt->execute([$nombre, $dni !== '' ? $dni : null, $celular, $password]);

        // Crear carpeta de códigos QR si no existe
        $qrFolder = "../qrcodes";
        if (!is_dir($qrFolder)) {
            mkdir($qrFolder, 0777, true);
        }

        // Generar código QR
        $qr = Builder::create()
            ->writer(new PngWriter())
            ->data($celular)
            ->size(300) // tamaño en píxeles
            ->margin(10)
            ->build();

        // Guardar archivo PNG
        $filename = "$qrFolder/$celular.png";
        $qr->saveToFile($filename);

        // Redirigir al dashboard
        header("Location: dashboard.php");
        exit;

    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-wrapper {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        .form-wrapper h4 {
            font-weight: bold;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

    <div class="form-wrapper">
        <h4 class="text-center">Nuevo Cliente</h4>
        <form method="post">
            <input type="text" name="nombre" placeholder="Nombre Completo" class="form-control mb-3" required>
            <input type="text" name="dni" placeholder="DNI (opcional)" class="form-control mb-3">
            <input type="text" name="celular" placeholder="Celular" class="form-control mb-3" required>
            <input type="password" name="password" placeholder="Contraseña" class="form-control mb-4" required>
            <button type="submit" class="btn btn-primary w-100">Crear Cliente</button>
        </form>
    </div>

</body>
</html>
