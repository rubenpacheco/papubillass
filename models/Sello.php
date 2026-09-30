<?php

class Sello
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function countByUsuario($usuarioId)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM sellos WHERE usuario_id = ?");
        $stmt->execute([$usuarioId]);
        return $stmt->fetchColumn();
    }

    public function add($usuarioId): void
    {
        $this->pdo->prepare("INSERT INTO sellos (usuario_id) VALUES (?)")->execute([$usuarioId]);
    }
}
