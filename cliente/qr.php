
<?php
include '../includes/auth.php';
include '../includes/db.php';



$stmtqr = $pdo->prepare("SELECT disenio FROM qrconfig ORDER BY id DESC LIMIT 1");
$stmtqr->execute();
$disenio = $stmtqr->fetchColumn(); // ✅ Esto ya es el valor de 'sellos'

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mi Código QR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Centrado total de la página */
        body,
        html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }

        .qr-card {
            max-width: 500px;
            margin: auto;
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


<body>

    <div class="container">
        <div class="card qr-card shadow text-center p-4">
            <h4 class="mb-3">¡Hola, <?= htmlspecialchars($_SESSION['user']['nombre_completo']) ?>!</h4>
            <p class="text-muted">Este es tu código QR personal</p>

            <img src="../qrcodes/<?= htmlspecialchars($_SESSION['user']['celular']) ?>.png" alt="Mi Código QR"
                class="qr-img mb-4">

                <a href="<?= $disenio ?>.php" class="btn btn-primary d-block mb-3">Ver Sellos</a>
                <a href="../logout.php" class="btn btn-secondary d-block">Cerrar sesión</a>
        </div>


    </div>

</body>

</html>