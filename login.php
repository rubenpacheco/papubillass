<?php
session_start();
include 'includes/db.php';
include 'includes/models.php';
include 'includes/controllers.php';

$controller = new LoginController($pdo);
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = $controller->attempt(trim($_POST['celular']), $_POST['password']) ?? '';
}

$controller->show($error);
