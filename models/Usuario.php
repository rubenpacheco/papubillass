<?php

class Usuario
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByCelularActivo(string $celular): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarioss WHERE celular = ? AND estado = 'activo'");
        $stmt->execute([$celular]);
        $user = $stmt->fetch();
        return $user === false ? null : $user;
    }

    public function findByCelular(string $celular): ?array
    {
        $stmt = $this->pdo->prepare("SELECT id FROM usuarioss WHERE celular = ?");
        $stmt->execute([$celular]);
        $user = $stmt->fetch();
        return $user === false ? null : $user;
    }

    public function findById($id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarioss WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        return $user === false ? null : $user;
    }

    public function findAll(): array
    {
        return $this->pdo->query("SELECT * FROM usuarioss ORDER BY id")->fetchAll();
    }

    public function create(string $nombre, string $dni, string $celular, string $rol, string $password): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO usuarioss (nombre_completo, dni, celular, rol, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $dni !== '' ? $dni : null, $celular, $rol, password_hash($password, PASSWORD_BCRYPT)]);
    }

    public function update($id, string $nombre, string $dni, string $celular, string $rol, string $password = ''): void
    {
        if ($password !== '') {
            $update = $this->pdo->prepare("UPDATE usuarioss SET nombre_completo = ?, dni = ?, celular = ?, rol = ?, password = ? WHERE id = ?");
            $update->execute([$nombre, $dni !== '' ? $dni : null, $celular, $rol, password_hash($password, PASSWORD_BCRYPT), $id]);
        } else {
            $update = $this->pdo->prepare("UPDATE usuarioss SET nombre_completo = ?, dni = ?, celular = ?, rol = ? WHERE id = ?");
            $update->execute([$nombre, $dni !== '' ? $dni : null, $celular, $rol, $id]);
        }
    }
}
