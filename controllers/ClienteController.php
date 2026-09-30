<?php

class ClienteController
{
    private Sello $sellos;
    private QrConfig $qrConfig;

    public function __construct(PDO $pdo)
    {
        $this->sellos = new Sello($pdo);
        $this->qrConfig = new QrConfig($pdo);
    }

    public function showQr(): void
    {
        $disenio = $this->qrConfig->getDisenio();
        require __DIR__ . '/../views/cliente/qr.php';
    }

    public function showSellos(int $diseno): void
    {
        if (!in_array($diseno, range(1, 9), true)) {
            http_response_code(404);
            exit('Diseño no encontrado');
        }

        $total = $this->sellos->countByUsuario($_SESSION['user']['id']);
        $meta = $this->qrConfig->getMetaSellos();

        require __DIR__ . '/../views/cliente/sellosd' . $diseno . '.php';
    }
}
