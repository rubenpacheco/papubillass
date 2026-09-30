<?php
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/models.php';
include '../includes/controllers.php';

$controller = new AdminController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->createUsuario($_POST);
}

header('Location: dashboard.php');
exit;
