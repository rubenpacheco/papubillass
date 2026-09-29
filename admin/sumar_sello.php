<?php
include '../includes/db.php';
$celular = $_GET['celular'] ?? '';
$stmt = $pdo->prepare("SELECT id FROM usuarioss WHERE celular = ?");
$stmt->execute([$celular]);
$user = $stmt->fetch();
if ($user) {
    $pdo->prepare("INSERT INTO sellos (usuario_id) VALUES (?)")->execute([$user['id']]);
}
header("Location: dashboard.php");
