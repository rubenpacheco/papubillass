<?php include '../includes/auth.php'; ?>
<img src="../qrcodes/<?php echo $_SESSION['user']['dni']; ?>.png" alt="Mi QR">
<a href="sellos.php">Ver sellos</a>