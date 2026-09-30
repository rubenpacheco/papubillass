<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Elegir Diseño de Sellos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .preview-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease-in-out;
        }
        .preview-card:hover {
            transform: scale(1.02);
        }
        iframe {
            width: 100%;
            height: 300px;
            border: none;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-4">
        <h3 class="text-center mb-4">Elige un diseño para tu tarjeta de sellos</h3>
        <form method="POST" action="guardar_disenio.php">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php for ($i = 1; $i <= 9; $i++): ?>
                    <div class="col">
                        <div class="preview-card">
                            <iframe src="../cliente/sellosd<?= $i ?>.php"></iframe>
                            <div class="p-3 text-center">
                                <input type="radio" name="disenio" id="d<?= $i ?>" value="sellosd<?= $i ?>" class="form-check-input">
                                <label for="d<?= $i ?>" class="form-check-label ms-2">Elegir Diseño <?= $i ?></label>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-4">Guardar mi diseño</button>
            </div>
        </form>
    </div>
<?php include __DIR__ . '/../../includes/whatsapp.php'; ?>
</body>
</html>
