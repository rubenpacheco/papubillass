<?php

class AuthController
{
    public function index(): void
    {
        header('Location: login.php');
        exit;
    }

    public function logout(): void
    {
        session_start();
        session_destroy();

        header('Location: login.php');
        exit;
    }
}
