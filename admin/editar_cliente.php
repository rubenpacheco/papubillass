<?php
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/models.php';
include '../includes/controllers.php';

$id = $_GET['id'] ?? null;
if ($id === null) {
    header('Location: dashboard.php');
    exit;
}

$controller = new AdminController($pdo);
$controller->handleEditar($id);
