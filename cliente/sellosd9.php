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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            background-color: #fff;
            color: #e5e5e5;
            overflow-x: hidden;
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
            background: linear-gradient(135deg, rgba(0, 98, 255, 0.9), rgba(0, 55, 105, 0.9));
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: transform 0.4s ease, box-shadow 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .tarjeta:hover {
            transform: translateY(-10px);
            box-shadow: 0 35px 65px rgba(0, 0, 0, 0.7);
        }

        .tarjeta-header img {
            width: 120px;
            margin-bottom: 25px;
            border-radius: 50%;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.4);
            transition: transform 0.3s ease;
        }

        .tarjeta-header h3 {
            font-size: 32px;
            font-weight: 700;
            color: #00d0ff;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .badge {
            background: rgba(0, 206, 255, 0.8);
            color: #fff;
            font-weight: 600;
            padding: 8px 25px;
            border-radius: 40px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 10px rgba(0, 206, 255, 0.6);
            transition: all 0.3s ease;
        }

        .badge:hover {
            background: #00b0ff;
            box-shadow: 0 4px 20px rgba(0, 206, 255, 0.9);
        }

        .sellos-wrapper {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .sello {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #23262b;
            color: #fff;
            font-size: 22px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .sello.completed {
            background: #00e0ff;
            color: white;
            border: 3px solid #00e0ff;
            transform: scale(1.1);
        }

        .sello.pending {
            background-color: #1d2026;
            border: 3px solid #444;
            color: #7a7a7a;
        }

        .info {
            margin-top: 30px;
            font-size: 18px;
            color: #e5e5e5;
            font-weight: normal;
            letter-spacing: 0.5px;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .btn-back {
            padding: 12px 30px;
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
            transform: scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .tarjeta {
                width: 85%;
                padding: 25px;
            }

            .sellos-wrapper {
                gap: 10px;
            }

            .sello {
                width: 50px;
                height: 50px;
                font-size: 18px;
            }
        }

        [data-bs-theme="dark"] body {
            background-color: #1c1e22;
        }

        [data-bs-theme="light"] body {
            background-color: #f8f9fa;
            color: #212529;
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
