<?php include '../includes/auth.php'; include '../includes/db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h3>Panel de Administrador</h3>
        <a href="crear_cliente.php" class="btn btn-primary mb-3">Crear Cliente</a>
        <a href="scan_qr.php" class="btn btn-success mb-3">Escanear QR</a>
        <a href="../logout.php" class="btn btn-secondary mb-3">Cerrar sesión</a>
        <table class="table table-bordered">
            <thead><tr><th>Nombre</th><th>DNI</th><th>Celular</th><th>Sellos</th></tr></thead>
            <tbody>
            <?php
            $clientes = $pdo->query("SELECT * FROM usuarioss WHERE rol = 'cliente'")->fetchAll();
            foreach ($clientes as $cli):
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM sellos WHERE usuario_id = ?");
                $stmt->execute([$cli['id']]);
                $sellos = $stmt->fetchColumn();
            ?>
                <tr>
                    <td><?= htmlspecialchars($cli['nombre_completo']) ?></td>
                    <td><?= htmlspecialchars($cli['dni']) ?></td>
                    <td><?= htmlspecialchars($cli['celular']) ?></td>
                    <td><?= $sellos ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>