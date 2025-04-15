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
        .sellos-card {
            max-width: 500px;
            margin: 60px auto;
        }
    </style>
</head>
<body class="bg-light">

    <div class="container">
        <div class="card sellos-card shadow p-4 text-center">
            <h4 class="mb-3">Hola, <?= htmlspecialchars($_SESSION['user']['nombre_completo']) ?> 👋</h4>
            <h5 class="mb-3 text-primary">Tus Sellos</h5>

            <p class="fs-5">Tienes <strong><?= $total ?></strong> sello<?= $total == 1 ? '' : 's' ?>.</p>

            <?php if ($total >= $meta): ?>
                <div class="alert alert-success">🎉 ¡Felicidades! Has ganado un premio.</div>
            <?php else: ?>
                <div class="alert alert-info">🕐 Te faltan <strong><?= $meta - $total ?></strong> sello<?= ($meta - $total) == 1 ? '' : 's' ?> para tu próximo premio.</div>
            <?php endif; ?>

            <!-- Barra de progreso (opcional pero bonito) -->
            <div class="progress my-3">
                <div class="progress-bar <?= $total >= $meta ? 'bg-success' : 'bg-info' ?>" 
                    role="progressbar" 
                    style="width: <?= min(100, ($total / $meta) * 100) ?>%;" 
                    aria-valuenow="<?= $total ?>" 
                    aria-valuemin="0" 
                    aria-valuemax="<?= $meta ?>">
                    <?= min(100, ($total / $meta) * 100) ?>%
                </div>
            </div>

            <a href="qr.php" class="btn btn-outline-primary mt-3">← Volver a mi QR</a>
        </div>
    </div>

</body>
</html>
