<?php
include '../includes/auth.php';
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $disenio = $_POST['disenio'] ?? null;
    $usuario_id = $_SESSION['user']['id'];
    echo $disenio;
    echo  $usuario_id;

    if ($disenio) {
 
             $update = $pdo->prepare("UPDATE qrconfig SET disenio = ? ORDER BY id DESC LIMIT 1");
            $update->execute([$disenio]);
        

        header(header: "Location: ../admin/dashboard.php");
        exit;
    } else {
        echo "Debes seleccionar un diseño.";
    }
}
