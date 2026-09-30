<?php
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/models.php';

$sellosModel = new Sello($pdo);
$total = $sellosModel->countByUsuario($_SESSION['user']['id']);
// $meta = 5;


$qrConfig = new QrConfig($pdo);
$meta = $qrConfig->getMetaSellos(); // ✅ Esto ya es el valor de 'sellos'
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Aquí progreso hacia el premio</title>
    <?php include '../includes/theme-head.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .tarjeta {
            width: 350px;
            margin: 50px auto;
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            border: 1px solid #eee;
        }

        .tarjeta-header {
            margin-bottom: 30px;
        }

        .tarjeta-header img {
            width: 80px;
            margin-bottom: 15px;
        }

        .tarjeta-header h2 {
            font-size: 24px;
            color: #333;
            font-weight: bold;
        }

        .sellos-wrapper {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .sello {
            width: 55px;
            height: 55px;
            border-radius: 10px;
            border: 2px solid #ddd;
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #999;
            transition: all 0.3s ease;
        }

        .sello.completed {
            background-color: #4CAF50;
            color: white;
            border-color: #4CAF50;
        }

        .sello.pending {
            background-color: #f0f0f0;
            color: #ccc;
        }

        .info {
            margin-bottom: 25px;
            font-size: 18px;
            color: #444;
        }

        .info p {
            margin: 0;
        }

        .btn-back {
            display: inline-block;
            padding: 10px 20px;
            background-color: #666308;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #4f4e06;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .tarjeta {
                width: 80%;
                padding: 25px;
            }

            .sellos-wrapper {
                justify-content: center;
            }

            .sello {
                width: 45px;
                height: 45px;
                font-size: 20px;
            }
        }

        [data-bs-theme="dark"] body {
            background-color: #1c1e22;
        }

        [data-bs-theme="dark"] .tarjeta {
            background-color: #2b3035;
            border-color: #495057;
            color: #dee2e6;
        }

        [data-bs-theme="dark"] .tarjeta-header h2 {
            color: #dee2e6;
        }

        [data-bs-theme="dark"] .sello {
            background-color: #343a40;
            border-color: #495057;
            color: #adb5bd;
        }

        [data-bs-theme="dark"] .sello.pending {
            background-color: #2b3035;
            color: #6c757d;
        }

        [data-bs-theme="dark"] .sello.completed {
            background-color: #4CAF50;
            color: #fff;
            border-color: #4CAF50;
        }

        [data-bs-theme="dark"] .info {
            color: #adb5bd;
        }
    </style>
</head>
<body>

    <div class="tarjeta">
        <div class="tarjeta-header">
            <img src="../imgs/logo-modo-claro.png" alt="Logo" class="logo-light">
            <img src="../imgs/logo-modo-oscuro.png" alt="Logo" class="logo-dark">
            <h2>Mi Tarjeta de Fidelización</h2>
        </div>

        <div class="sellos-wrapper">
            <?php
            for ($i = 1; $i <= $meta; $i++) {
                $class = ($i <= $total) ? 'completed' : 'pending';
                echo "<div class='sello $class'>✔</div>";
            }
            ?>
        </div>

        <div class="info">
            <p>Tienes <?= $total ?> de <?= $meta ?> sellos.</p>
            <p><?= $total >= $meta ? "¡Ganaste un premio!" : "Te faltan " . ($meta - $total) . " sellos para un premio." ?></p>
        </div>

        <a href="qr.php" class="btn-back">← Volver al QR</a>
    </div>

<?php include '../includes/whatsapp.php'; ?>
<?php include '../includes/theme-foot.php'; ?>
</body>
</html>
