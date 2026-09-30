<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Escanear QR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- html5-qrcode -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }

        .qr-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        #reader {
            width: 100%;
            margin: auto;
        }

        h3 {
            margin-bottom: 20px;
            color: #0d6efd;
        }

        .btn-back {
            margin-top: 20px;
        }

        @media (max-width: 576px) {
            .qr-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="qr-container">
        <h3>📷 Escanea el QR del Cliente</h3>
        <div id="reader"></div>

        <a href="dashboard.php" class="btn btn-secondary btn-back mt-3">🔙 Volver</a>
    </div>

    <script>
        function onScanSuccess(qrCodeMessage) {
            window.location.href = "sumar_sello.php?celular=" + encodeURIComponent(qrCodeMessage);
        }

        function onScanError(errorMessage) {
            // Puedes mostrar el error si quieres: console.log(errorMessage);
        }

        const html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            },
            onScanSuccess,
            onScanError
        );
    </script>

<?php include __DIR__ . '/../../includes/whatsapp.php'; ?>
</body>
</html>
