<?php
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/models.php';
include '../includes/controllers.php';

$controller = new ClienteController($pdo);
$controller->showSellos(6);
