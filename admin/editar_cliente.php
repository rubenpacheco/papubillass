<?php
include '../includes/auth.php';
include '../includes/db.php';

if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM usuarioss WHERE id = ?");
$stmt->execute([$id]);
$cliente = $stmt->fetch();

if (!$cliente) {
    echo "Cliente no encontrado";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre_completo'];
    $dni = trim($_POST['dni'] ?? '');
    $celular = trim($_POST['celular']);
    $password = trim($_POST['password'] ?? '');
    $rol = $_POST['rol'] ?? 'cliente';

    $roles_permitidos = ['trabajador', 'cliente', 'administrador'];
    if (!in_array($rol, $roles_permitidos, true)) {
        $rol = $cliente['rol'];
    }

    try {
        if ($password !== '') {
            $update = $pdo->prepare("UPDATE usuarioss SET nombre_completo = ?, dni = ?, celular = ?, rol = ?, password = ? WHERE id = ?");
            $update->execute([$nombre, $dni !== '' ? $dni : null, $celular, $rol, password_hash($password, PASSWORD_BCRYPT), $id]);
        } else {
            $update = $pdo->prepare("UPDATE usuarioss SET nombre_completo = ?, dni = ?, celular = ?, rol = ? WHERE id = ?");
            $update->execute([$nombre, $dni !== '' ? $dni : null, $celular, $rol, $id]);
        }

        header("Location: dashboard.php?ok=1");
        exit;
    } catch (PDOException $e) {
        $codigo = $e->errorInfo[1] ?? null;
        $msg = $codigo === 1062 ? 'Ese celular ya está registrado en otro usuario.' : 'No se pudieron guardar los cambios.';
        header('Location: dashboard.php?' . http_build_query(['err' => $msg]));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f4f6f9;
        }

        .edit-container {
            max-width: 500px;
            margin: 50px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .edit-title {
            color: #0d6efd;
            font-weight: 600;
        }

        .form-label {
            font-weight: 500;
        }

        @media (max-width: 576px) {
            .edit-container {
                padding: 20px;
                margin: 20px auto;
            }

            .edit-title {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="edit-container">
            <h3 class="edit-title mb-4 text-center">✏️ Editar Usuario</h3>
            <form method="POST">
                <div class="mb-3">
                    <label for="nombre_completo" class="form-label">Nombre Completo</label>
                    <input type="text" name="nombre_completo" id="nombre_completo" class="form-control" value="<?= htmlspecialchars($cliente['nombre_completo']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="dni" class="form-label">DNI (opcional)</label>
                    <input type="text" name="dni" id="dni" class="form-control" value="<?= htmlspecialchars($cliente['dni'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label for="celular" class="form-label">Celular</label>
                    <input type="text" name="celular" id="celular" class="form-control" value="<?= htmlspecialchars($cliente['celular']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="rol" class="form-label">Rol</label>
                    <?php $rol_actual = $cliente['rol'] === 'admin' ? 'administrador' : $cliente['rol']; ?>
                    <select name="rol" id="rol" class="form-select" required>
                        <option value="trabajador" <?= $rol_actual === 'trabajador' ? 'selected' : '' ?>>Trabajador</option>
                        <option value="cliente" <?= $rol_actual === 'cliente' ? 'selected' : '' ?>>Cliente</option>
                        <option value="administrador" <?= $rol_actual === 'administrador' ? 'selected' : '' ?>>Administrador</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Nueva contraseña</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Déjalo en blanco para no cambiarla">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePass(this)" title="Mostrar u ocultar contraseña">👁</button>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">💾 Guardar Cambios</button>
                    <a href="dashboard.php" class="btn btn-secondary">↩️ Cancelar</a>
                </div>
                
            </form>
        </div>
    </div>

    <script>
        function togglePass(btn) {
            const input = btn.parentElement.querySelector('input');
            const ver = input.type === 'password';
            input.type = ver ? 'text' : 'password';
            btn.textContent = ver ? '🙈' : '👁';
        }
    </script>

</body>
</html>
