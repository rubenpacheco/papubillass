<?php

class LoginController
{
    private Usuario $usuarios;

    public function __construct(PDO $pdo)
    {
        $this->usuarios = new Usuario($pdo);
    }

    public function show(string $error = ''): void
    {
        require __DIR__ . '/../views/login.php';
    }

    public function attempt(string $celular, string $pass): ?string
    {
        $user = $this->usuarios->findByCelularActivo($celular);

        $passOk = false;
        if ($user) {
            if (str_starts_with($user['password'], '$2y$') || str_starts_with($user['password'], '$argon')) {
                $passOk = password_verify($pass, $user['password']);
            } else {
                $passOk = hash_equals($user['password'], $pass);
            }
        }

        if ($user && $passOk) {
            $_SESSION['user'] = $user;

            if (in_array($user['rol'], ['admin', 'administrador'], true)) {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: cliente/qr.php");
            }
            exit;
        }

        return "Celular o contraseña incorrectos.";
    }
}
