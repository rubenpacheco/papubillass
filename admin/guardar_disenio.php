<?php
include '../includes/auth.php';
include '../includes/db.php';
include '../includes/models.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $disenio = $_POST['disenio'] ?? null;
    $usuario_id = $_SESSION['user']['id'];
    echo $disenio;
    echo  $usuario_id;

    if ($disenio) {
        $qrConfig = new QrConfig($pdo);
        $qrConfig->setDisenio($disenio);

        header(header: "Location: ../admin/dashboard.php");
        exit;
    } else {
        echo "Debes seleccionar un diseño.";
    }
}
