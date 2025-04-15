<?php
include '../includes/db.php';
$dni = $_GET['dni'] ?? '';
$stmt = $pdo->prepare("SELECT id FROM usuarioss WHERE dni = ?");
$stmt->execute([$dni]);
$user = $stmt->fetch();
if ($user) {
    $pdo->prepare("INSERT INTO sellos (usuario_id) VALUES (?)")->execute([$user['id']]);
}
header("Location: dashboard.php");
