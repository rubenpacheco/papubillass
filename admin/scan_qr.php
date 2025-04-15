<?php include '../includes/auth.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Escanear QR</title>
  <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>
    <h3>Escanear QR del Cliente</h3>
    <div id="reader" style="width:300px"></div>
    <script>
    function onScanSuccess(qrCodeMessage) {
        window.location.href = "sumar_sello.php?dni=" + qrCodeMessage;
    }
    new Html5Qrcode("reader").start({ facingMode: "environment" }, { fps: 10, qrbox: 250 }, onScanSuccess);
    </script>
</body>
</html>