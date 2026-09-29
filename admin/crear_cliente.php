<?php
include '../includes/auth.php';
include '../includes/db.php';

require_once '../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

function volver_dashboard($msg = null)
{
    $params = $msg === null ? ['ok' => 1] : ['err' => $msg, 'open' => 1];
    header('Location: dashboard.php?' . http_build_query($params));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $celular = trim($_POST['celular'] ?? '');
    $password = $_POST['password'] ?? '';
    $rol = $_POST['rol'] ?? 'cliente';

    $roles_permitidos = ['trabajador', 'cliente', 'administrador'];
    if (!in_array($rol, $roles_permitidos, true)) {
        $rol = 'cliente';
    }

    if ($nombre === '' || $celular === '' || $password === '') {
        volver_dashboard('Nombre, celular y contraseña son obligatorios.');
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarioss (nombre_completo, dni, celular, rol, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $dni !== '' ? $dni : null, $celular, $rol, password_hash($password, PASSWORD_BCRYPT)]);

        // Generar código QR con el celular
        $qrFolder = "../qrcodes";
        if (!is_dir($qrFolder)) {
            mkdir($qrFolder, 0777, true);
        }

        $qr = Builder::create()
            ->writer(new PngWriter())
            ->data($celular)
            ->size(300)
            ->margin(10)
            ->build();
        $qr->saveToFile("$qrFolder/$celular.png");

        volver_dashboard();
    } catch (PDOException $e) {
        $codigo = $e->errorInfo[1] ?? null;
        $msg = $codigo === 1062
            ? 'Ese celular ya está registrado.'
            : 'No se pudo guardar el usuario.';
        volver_dashboard($msg);
    }
}

header('Location: dashboard.php');
exit;
