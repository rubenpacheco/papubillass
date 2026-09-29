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

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .card-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
                <a href="configd.php" class="btn btn-success">📷 Diseño Sellos</a>
            </div>

            <div class="table-responsive">
                <table id="clientesTable" class="table table-bordered table-hover align-middle text-center">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Celular</th>
                            <th>Sellos</th>
                            <th>Acciones</th> <!-- Nueva columna -->
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
                                <td><?= htmlspecialchars($cli['dni'] ?? '') ?></td>
                                <td><?= htmlspecialchars($cli['celular']) ?></td>
                                <td><span class="badge bg-info fs-6"><?= $sellos ?></span></td>
                                <td>
                                    <a href="editar_cliente.php?id=<?= $cli['id'] ?>" class="btn btn-sm btn-warning">✏️
                                        Editar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- jQuery y DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Inicialización con idioma español -->
    <script>
        // $(document).ready(function () {
        //     $('#clientesTable').DataTable({
        //         language: {
        //             url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        //         }
        //     });
        // });

        $(document).ready(function () {
            $('#clientesTable').DataTable({
                language: {
                    decimal: "",
                    emptyTable: "No hay datos disponibles en la tabla",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    lengthMenu: "Mostrar _MENU_ registros",
                    loadingRecords: "Cargando...",
                    processing: "Procesando...",
                    search: "Buscar:",
                    zeroRecords: "No se encontraron resultados",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    },
                    aria: {
                        sortAscending: ": activar para ordenar ascendente",
                        sortDescending: ": activar para ordenar descendente"
                    }
                }
            });
        });

    </script>

</body>

</html>