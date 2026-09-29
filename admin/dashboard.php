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

        .action-buttons {
            gap: 10px;
        }

        .action-buttons a,
        .action-buttons button {
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

            .action-buttons a,
            .action-buttons button {
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
            <?php if (isset($_GET['ok'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ✅ Cambios guardados correctamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['err'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_GET['err']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="action-buttons d-flex mb-4">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUsuario">➕ Usuario</button>
                <a href="scan_qr.php" class="btn btn-success">📷 Escanear QR</a>
                <a href="configd.php" class="btn btn-success">📷 Diseño Sellos</a>
            </div>

            <!-- Modal Registrar Usuario -->
            <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form class="modal-content" method="post" action="crear_cliente.php">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalUsuarioLabel">Registrar Usuario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" name="nombre" placeholder="Nombre Completo" class="form-control mb-3" required>
                            <input type="text" name="dni" placeholder="DNI (opcional)" class="form-control mb-3">
                            <input type="text" name="celular" placeholder="Celular" class="form-control mb-3" required>
                            <div class="input-group mb-3">
                                <input type="password" name="password" id="passNuevo" class="form-control" placeholder="Contraseña" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePass(this)" title="Mostrar u ocultar contraseña">👁</button>
                            </div>
                            <label for="rol" class="form-label">Rol</label>
                            <select name="rol" id="rol" class="form-select mb-2" required>
                                <option value="trabajador">Trabajador</option>
                                <option value="cliente" selected>Cliente</option>
                                <option value="administrador">Administrador</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Editar Usuario -->
            <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form class="modal-content" method="post" id="formEditar">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditarLabel">Editar Usuario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <label class="form-label">Nombre Completo</label>
                            <input type="text" name="nombre_completo" class="form-control mb-3" required>
                            <label class="form-label">DNI (opcional)</label>
                            <input type="text" name="dni" class="form-control mb-3">
                            <label class="form-label">Celular</label>
                            <input type="text" name="celular" class="form-control mb-3" required>
                            <label class="form-label">Rol</label>
                            <select name="rol" class="form-select mb-3" required>
                                <option value="trabajador">Trabajador</option>
                                <option value="cliente">Cliente</option>
                                <option value="administrador">Administrador</option>
                            </select>
                            <label class="form-label">Nueva contraseña</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" placeholder="Déjalo en blanco para no cambiarla">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePass(this)" title="Mostrar u ocultar contraseña">👁</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">💾 Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table id="clientesTable" class="table table-bordered table-hover align-middle text-center">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>DNI</th>
                            <th>Celular</th>
                            <th>Rol</th>
                            <th>Sellos</th>
                            <th>Acciones</th> <!-- Nueva columna -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $clientes = $pdo->query("SELECT * FROM usuarioss ORDER BY id")->fetchAll();
                        foreach ($clientes as $cli):
                            $stmt = $pdo->prepare("SELECT COUNT(*) FROM sellos WHERE usuario_id = ?");
                            $stmt->execute([$cli['id']]);
                            $sellos = $stmt->fetchColumn();
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($cli['nombre_completo']) ?></td>
                                <td><?= htmlspecialchars($cli['dni'] ?? '') ?></td>
                                <td><?= htmlspecialchars($cli['celular']) ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($cli['rol']) ?></span></td>
                                <td><span class="badge bg-info fs-6"><?= $sellos ?></span></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning"
                                        data-id="<?= $cli['id'] ?>"
                                        data-nombre="<?= htmlspecialchars($cli['nombre_completo'], ENT_QUOTES) ?>"
                                        data-dni="<?= htmlspecialchars($cli['dni'] ?? '', ENT_QUOTES) ?>"
                                        data-celular="<?= htmlspecialchars($cli['celular'], ENT_QUOTES) ?>"
                                        data-rol="<?= htmlspecialchars($cli['rol'], ENT_QUOTES) ?>"
                                        onclick="abrirEditar(this)">✏️ Editar</button>
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

    <!-- Bootstrap JS (necesario para el modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePass(btn) {
            const input = btn.parentElement.querySelector('input');
            const ver = input.type === 'password';
            input.type = ver ? 'text' : 'password';
            btn.textContent = ver ? '🙈' : '👁';
        }

        function abrirEditar(btn) {
            const f = document.getElementById('formEditar');
            f.action = 'editar_cliente.php?id=' + btn.dataset.id;
            f.nombre_completo.value = btn.dataset.nombre;
            f.dni.value = btn.dataset.dni;
            f.celular.value = btn.dataset.celular;
            const rol = btn.dataset.rol === 'admin' ? 'administrador' : btn.dataset.rol;
            f.rol.value = rol;
            f.password.value = '';
            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditar')).show();
        }
    </script>
    <?php if (isset($_GET['open'])): ?>
        <script>
            window.addEventListener('load', function () {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('modalUsuario')).show();
            });
        </script>
    <?php endif; ?>

<?php include '../includes/whatsapp.php'; ?>
</body>

</html>