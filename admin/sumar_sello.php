<?php
include '../includes/db.php';
include '../includes/models.php';
include '../includes/controllers.php';

$controller = new AdminController($pdo);
$controller->sumarSello($_GET['celular'] ?? '');

header("Location: dashboard.php");
