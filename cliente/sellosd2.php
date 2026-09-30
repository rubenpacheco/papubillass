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
    <?php include '../includes/theme-head.php'; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e2e6ea);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sellos-card {
            max-width: 500px;
            margin: 60px auto;
            background: #fff;
            border: none;
            border-radius: 15px;
            padding: 2.5rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .sellos-card h4 {
            font-weight: 600;
        }

        .progress {
            height: 25px;
            border-radius: 50px;
            overflow: hidden;
        }

        .progress-bar {
            font-weight: 500;
            font-size: 14px;
        }

        .btn-custom {
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 500;
        }

        .emoji {
            font-size: 1.5rem;
        }

        [data-bs-theme="dark"] body {
            background: linear-gradient(135deg, #1c1e22, #2b3035);
        }

        [data-bs-theme="dark"] .sellos-card {
            background: #2b3035;
            color: #dee2e6;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="sellos-card text-center">
            <h4>Hola, <?= htmlspecialchars($_SESSION['user']['nombre_completo']) ?> 👋</h4>
            <p class="text-muted mb-4">Aquí puedes ver tu progreso hacia el premio</p>

            <div class="emoji mb-2">
                <?= $total >= $meta ? '🎉' : '⭐' ?>
            </div>

            <h5 class="mb-3">Tienes <strong><?= $total ?></strong> sello<?= $total != 1 ? 's' : '' ?>.</h5>

            <?php if ($total >= $meta): ?>
                <div class="alert alert-success rounded-pill fw-semibold">¡Felicidades! Has ganado un premio. 🎁</div>
            <?php else: ?>
                <div class="alert alert-info rounded-pill fw-semibold">
                    Te faltan <strong><?= $meta - $total ?></strong> sello<?= ($meta - $total) != 1 ? 's' : '' ?> para ganar un premio.
                </div>
            <?php endif; ?>

            <!-- Barra de progreso -->
            <div class="progress my-4">
                <div class="progress-bar <?= $total >= $meta ? 'bg-success' : 'bg-primary' ?> progress-bar-striped progress-bar-animated"
                     role="progressbar"
                     style="width: <?= min(100, ($total / $meta) * 100) ?>%;"
                     aria-valuenow="<?= $total ?>"
                     aria-valuemin="0"
                     aria-valuemax="<?= $meta ?>">
                    <?= min(100, ($total / $meta) * 100) ?>%
                </div>
            </div>

            <a href="qr.php" class="btn btn-primary btn-custom mt-3" style="background: #666308; border-color: #28a745;">← Volver a mi QR</a>
        </div>
    </div>

<?php include '../includes/whatsapp.php'; ?>
<?php include '../includes/theme-foot.php'; ?>
</body>
</html>
