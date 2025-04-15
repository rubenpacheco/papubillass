<?php include '../includes/auth.php'; include '../includes/db.php';
$stmt = $pdo->prepare("SELECT COUNT(*) FROM sellos WHERE usuario_id = ?");
$stmt->execute([$_SESSION['user']['id']]);
$total = $stmt->fetchColumn();
// $meta = 5;


$stmtqr = $pdo->prepare("SELECT sellos FROM qrconfig ORDER BY id DESC LIMIT 1");
$stmtqr->execute();
$meta = $stmtqr->fetchColumn(); // ✅ Esto ya es el valor de 'sellos'
?>
<h3>Mis Sellos</h3>
<p>Tienes <?= $total ?> sellos.</p>
<p><?= $total >= $meta ? "¡Ganaste un premio!" : "Te faltan " . ($meta - $total) . " para un premio." ?></p>
<a href="qr.php">Volver al QR</a>