<?php include '../includes/auth.php'; include '../includes/db.php'; include '../includes/models.php';
$sellosModel = new Sello($pdo);
$total = $sellosModel->countByUsuario($_SESSION['user']['id']);
// $meta = 5;


$qrConfig = new QrConfig($pdo);
$meta = $qrConfig->getMetaSellos(); // ✅ Esto ya es el valor de 'sellos'
?>
<?php include '../includes/theme-head.php'; ?>
<style>
    body {
        padding: 1rem;
    }

    [data-bs-theme="dark"] body {
        background-color: #1c1e22;
        color: #dee2e6;
    }
</style>
<h3>Mis Sellos</h3>
<p>Tienes <?= $total ?> sellos.</p>
<p><?= $total >= $meta ? "¡Ganaste un premio!" : "Te faltan " . ($meta - $total) . " para un premio." ?></p>
<a href="qr.php" class="btn btn-primary" style="background: #666308; border-color: #28a745;">Volver al QR</a>
<?php include '../includes/whatsapp.php'; ?>
<?php include '../includes/theme-foot.php'; ?>