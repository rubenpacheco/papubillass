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
    <title>Mis Sellos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Arial', sans-serif;
        }

        .card-fidelizacion {
            max-width: 500px;
            margin: 50px auto;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            text-align: center;
            margin-bottom: 1rem;
        }

        .card-header img {
            max-width: 80px;
            margin-bottom: 1rem;
        }

        .card-header h4 {
            font-size: 1.6rem;
            font-weight: bold;
        }

        .sellos-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            justify-items: center;
            margin-top: 2rem;
        }

        .sello {
            width: 50px;
            height: 50px;
            border: 2px solid #007bff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #007bff;
            background-color: #e9ecef;
            transition: background-color 0.3s ease;
        }

        .sello.completed {
            background-color: #28a745;
            color: #fff;
            border-color: #28a745;
        }

        .sello.pending {
            background-color: #e9ecef;
        }

        .btn-back {
            margin-top: 2rem;
            border-radius: 25px;
            font-weight: bold;
        }

        .progress-section {
            margin-top: 1.5rem;
            text-align: center;
        }

        .progress {
            height: 25px;
            border-radius: 12px;
        }

        .progress-bar {
            font-weight: bold;
            font-size: 14px;
        }

        .result-text {
            margin-top: 1rem;
            font-size: 1.1rem;
        }

        @media (max-width: 576px) {
            .sellos-container {
                grid-template-columns: repeat(3, 1fr);
            }

            .sello {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card-fidelizacion">
            <!-- Header -->
            <div class="card-header">
                <img src="../imgs/logo.jpg" alt="Logo" class="img-fluid">
                <h4>Mi progreso hacia el premio</h4>
            </div>

            <!-- Sellos Completados -->
            <div class="sellos-container">
                <?php
                for ($i = 1; $i <= $meta; $i++) {
                    $class = ($i <= $total) ? 'completed' : 'pending';
                    echo "<div class='sello $class'>✔️</div>";
                }
                ?>
            </div>

            <!-- Progreso y Mensaje -->
            <div class="progress-section">
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?= ($total / $meta) * 100 ?>%" aria-valuenow="<?= $total ?>" aria-valuemin="0" aria-valuemax="<?= $meta ?>">
                        <?= $total ?> de <?= $meta ?> sellos
                    </div>
                </div>

                <div class="result-text">
                    <?= $total >= $meta ? "¡Felicidades! Has ganado un premio." : "Te faltan " . ($meta - $total) . " sellos para un premio." ?>
                </div>
            </div>

            <!-- Botón de Regreso -->
            <a href="qr.php" class="btn btn-outline-primary w-100 btn-back">← Volver al QR</a>
        </div>
    </div>

</body>
</html>
