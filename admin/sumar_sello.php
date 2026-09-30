<?php
include '../includes/db.php';
include '../includes/models.php';
$celular = $_GET['celular'] ?? '';
$usuarios = new Usuario($pdo);
$user = $usuarios->findByCelular($celular);
if ($user) {
    $sellos = new Sello($pdo);
    $sellos->add($user['id']);
}
header("Location: dashboard.php");
