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
    <title>Mi Tarjeta de Fidelización</title>
    <?php include '../includes/theme-head.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Reset default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #1c1e22;
            color: #e5e5e5;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .tarjeta {
            width: 350px;
            background: linear-gradient(135deg, #1e1e2f, #4b4b67);
            border-radius: 18px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            padding: 40px;
            text-align: center;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .tarjeta:hover {
            transform: scale(1.05);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }

        .tarjeta-header img {
            width: 120px;
            margin-bottom: 20px;
            border-radius: 50%;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
        }

        .tarjeta-header h3 {
            font-size: 28px;
            font-weight: bold;
            color: #00e0ff;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .badge {
            background: linear-gradient(135deg, #ff008c, #ff8c00);
            color: #fff;
            font-weight: bold;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sellos-wrapper {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .sello {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 3px solid #ffffff;
            background-color: #23262b;
            color: #d1d3d8;
            font-size: 22px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.4s ease, border-color 0.4s ease;
            cursor: pointer;
        }

        .sello.completed {
            background-color: #00e0ff;
            border-color: #00e0ff;
            color: white;
        }

        .sello.pending {
            background-color: #2e2f38;
            border-color: #444;
            color: #666;
        }

        .info {
            margin-top: 30px;
            font-size: 18px;
            color: #aaa;
            font-weight: normal;
            letter-spacing: 0.5px;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
        }

        .btn-back {
            padding: 12px 28px;
            background: #666308;
            color: white;
            font-weight: bold;
            border-radius: 30px;
            text-decoration: none;
            display: inline-block;
            margin-top: 40px;
            transition: background 0.4s ease, transform 0.3s ease;
        }

        .btn-back:hover {
            background: #4f4e06;
            transform: scale(1.05);
        }

        /* Responsive */
        @media (max-width: 600px) {
            .tarjeta {
                width: 80%;
                padding: 30px;
            }

            .sellos-wrapper {
                gap: 10px;
            }

            .sello {
                width: 45px;
                height: 45px;
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="tarjeta">
            <div class="tarjeta-header">
                <img src="../imgs/logo-modo-claro.png" alt="Logo" class="logo-light">
                <img src="../imgs/logo-modo-oscuro.png" alt="Logo" class="logo-dark">
                <h3>Aquí puedes ver tu progreso hacia el premio</h3>
                <div class="badge">
                    <?= $total >= $meta ? "¡Premio!" : "Faltan " . ($meta - $total) . " sellos" ?>
                </div>
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
                <p><?= $total >= $meta ? "¡Felicidades, ganaste un premio!" : "Te faltan " . ($meta - $total) . " sellos para obtener un premio." ?></p>
            </div>

            <a href="qr.php" class="btn-back">← Volver al QR</a>
        </div>
    </div>

<?php include '../includes/whatsapp.php'; ?>
<?php include '../includes/theme-foot.php'; ?>
</body>
</html>
