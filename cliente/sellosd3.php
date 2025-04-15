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
            background: linear-gradient(120deg, #fdfbfb, #ebedee);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card-sellos {
            max-width: 380px;
            margin: 80px auto;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            background: white;
            text-align: center;
            transition: all 0.3s ease-in-out;
        }

        .card-sellos:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
        }

        .stamp-count {
            font-size: 3rem;
            font-weight: bold;
            color: #0d6efd;
        }

        .meta-info {
            font-size: 1rem;
            margin-top: 1rem;
        }

        .reward-msg {
            border-radius: 50px;
            padding: 0.6rem 1rem;
            margin-top: 1rem;
            font-weight: 500;
        }

        .emoji-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .btn-back {
            border-radius: 50px;
            margin-top: 1.5rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card-sellos">

            <div class="emoji-icon"><?= $total >= $meta ? '🏆' : '🎯' ?></div>

            <h5 class="mb-2">Hola, <?= htmlspecialchars($_SESSION['user']['nombre_completo']) ?></h5>
            <p class="text-muted small">Tu progreso de sellos</p>

            <div class="stamp-count"><?= $total ?></div>
            <div class="meta-info">Sellos acumulados</div>

            <?php if ($total >= $meta): ?>
                <div class="alert alert-success reward-msg">¡Felicidades! Has ganado un premio. 🎁</div>
            <?php else: ?>
                <div class="alert alert-info reward-msg">
                    Te faltan <strong><?= $meta - $total ?></strong> sello<?= ($meta - $total) != 1 ? 's' : '' ?> para tu premio.
                </div>
            <?php endif; ?>

            <a href="qr.php" class="btn btn-outline-primary w-100 btn-back">← Volver a mi QR</a>
        </div>
    </div>

</body>
</html>
