<?php
include '../includes/auth.php';
include '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - Clientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .card-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .admin-header {
            margin-bottom: 30px;
        }
        .action-buttons a {
            margin-right: 10px;
        }
        .table thead {
            background-color: #0d6efd;
            color: white;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        @media (max-width: 576px) {
            .action-buttons {
                flex-direction: column;
            }
            .action-buttons a {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body class="p-4">
    <div class="container">
        <div class="admin-header d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Panel de Administración</h3>
            <a href="../logout.php" class="btn btn-outline-danger">Cerrar sesión</a>
        </div>

        <div class="card-container">
            <div class="action-buttons d-flex mb-4">
                <a href="crear_cliente.php" class="btn btn-primary">➕ Crear Cliente</a>
                <a href="scan_qr.php" class="btn btn-success">📷 Escanear QR</a>
            </div>

            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar por nombre, DNI o celular" onkeyup="filterTable()">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Celular</th>
                            <th>Sellos</th>
                        </tr>
                    </thead>
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
                            <td><span class="badge bg-info fs-6"><?= $sellos ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.querySelector('.table tbody');
            const rows = table.getElementsByTagName('tr');

            Array.from(rows).forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        }
    </script>
</body>
</html>
