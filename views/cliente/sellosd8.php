
<?php include __DIR__ . '/../../includes/theme-head.php'; ?>
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
<?php include __DIR__ . '/../../includes/whatsapp.php'; ?>
<?php include __DIR__ . '/../../includes/theme-foot.php'; ?>