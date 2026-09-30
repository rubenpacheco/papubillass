<?php
include '../includes/auth.php';
include '../includes/db.php';

$stmt = $pdo->prepare("SELECT COUNT(*) FROM sellos WHERE usuario_id = ?");
$stmt->execute([$_SESSION['user']['id']]);
$total = $stmt->fetchColumn();
// $meta = 5;


$stmtqr = $pdo->prepare("SELECT sellos FROM qrconfig ORDER BY id DESC LIMIT 1");
$stmtqr->execute();
$meta = $stmtqr->fetchColumn(); // ✅ Esto ya es el valor de 'sellos'
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Tarjeta de Fidelización</title>
    <?php include '../includes/theme-head.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0;
            font-family: 'Arial', sans-serif;
        }

        .card-container {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .tarjeta {
            width: 350px;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }

        .tarjeta-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .tarjeta-header img {
            width: 100px;
            margin-bottom: 15px;
        }

        .tarjeta-header h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .sellos-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 20px;
        }

        .sello {
            width: 60px;
            height: 60px;
            background-color: #e0e0e0;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            color: #555;
            border: 2px solid #ddd;
            transition: background-color 0.3s, color 0.3s;
        }

        .sello.completed {
            background-color: #4CAF50;
            color: white;
            border-color: #4CAF50;
        }

        .sello.pending {
            background-color: #f7f7f7;
            color: #ccc;
        }

        .info {
            text-align: center;
            font-size: 18px;
            margin-bottom: 15px;
            color: #333;
        }

        .btn-back {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #666308;
            color: white;
            font-weight: bold;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn-back:hover {
            background-color: #4f4e06;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .tarjeta {
                width: 90%;
                padding: 20px;
            }

            .sellos-wrapper {
                flex-direction: column;
                align-items: center;
            }

            .sello {
                width: 50px;
                height: 50px;
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

        [data-bs-theme="dark"] .tarjeta-header h3 {
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

    <div class="card-container">
        <div class="tarjeta">
            <!-- Header de la tarjeta -->
            <div class="tarjeta-header">
                <img src="../imgs/logo-modo-claro.png" alt="Logo" class="logo-light">
                <img src="../imgs/logo-modo-oscuro.png" alt="Logo" class="logo-dark">
                <h3>Mi progreso hacia el premio</h3>
            </div>

            <!-- Sellos -->
            <div class="sellos-wrapper">
                <?php
                for ($i = 1; $i <= $meta; $i++) {
                    $class = ($i <= $total) ? 'completed' : 'pending';
                    echo "<div class='sello $class'>✔</div>";
                }
                ?>
            </div>

            <!-- Información de progreso -->
            <div class="info">
                <p>Tienes <?= $total ?> de <?= $meta ?> sellos.</p>
                <p><?= $total >= $meta ? "¡Ganaste un premio!" : "Te faltan " . ($meta - $total) . " sellos para un premio." ?></p>
            </div>

            <!-- Botón de Volver -->
            <a href="qr.php" class="btn-back">← Volver al QR</a>
        </div>
    </div>

<?php include '../includes/whatsapp.php'; ?>
<?php include '../includes/theme-foot.php'; ?>
</body>
</html>
