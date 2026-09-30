<?php

class QrConfig
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getDisenio()
    {
        $stmt = $this->pdo->prepare("SELECT disenio FROM qrconfig ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getMetaSellos()
    {
        $stmt = $this->pdo->prepare("SELECT sellos FROM qrconfig ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function setDisenio(string $disenio): void
    {
        $update = $this->pdo->prepare("UPDATE qrconfig SET disenio = ? ORDER BY id DESC LIMIT 1");
        $update->execute([$disenio]);
    }
}
