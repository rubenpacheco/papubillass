<?php

class AdminController
{
    private Usuario $usuarios;
    private Sello $sellos;
    private QrConfig $qrConfig;

    public function __construct(PDO $pdo)
    {
        $this->usuarios = new Usuario($pdo);
        $this->sellos = new Sello($pdo);
        $this->qrConfig = new QrConfig($pdo);
    }

    public function showDashboard(): void
    {
        $filas = [];
        foreach ($this->usuarios->findAll() as $cli) {
            $filas[] = [
                'cliente' => $cli,
                'sellos' => $this->sellos->countByUsuario($cli['id']),
            ];
        }

        require __DIR__ . '/../views/admin/dashboard.php';
    }

    public function showConfig(): void
    {
        require __DIR__ . '/../views/admin/configd.php';
    }

    public function showScan(): void
    {
        require __DIR__ . '/../views/admin/scan_qr.php';
    }

    public function createUsuario(array $post): void
    {
        require_once __DIR__ . '/../vendor/autoload.php';

        $nombre = trim($post['nombre'] ?? '');
        $dni = trim($post['dni'] ?? '');
        $celular = trim($post['celular'] ?? '');
        $password = $post['password'] ?? '';
        $rol = $post['rol'] ?? 'cliente';

        $roles_permitidos = ['trabajador', 'cliente', 'administrador'];
        if (!in_array($rol, $roles_permitidos, true)) {
            $rol = 'cliente';
        }

        if ($nombre === '' || $celular === '' || $password === '') {
            $this->volverDashboard('Nombre, celular y contraseña son obligatorios.');
        }

        try {
            $this->usuarios->create($nombre, $dni, $celular, $rol, $password);

            // Generar código QR con el celular
            $qrFolder = __DIR__ . '/../qrcodes';
            if (!is_dir($qrFolder)) {
                mkdir($qrFolder, 0777, true);
            }

            $qr = \Endroid\QrCode\Builder\Builder::create()
                ->writer(new \Endroid\QrCode\Writer\PngWriter())
                ->data($celular)
                ->size(300)
                ->margin(10)
                ->build();
            $qr->saveToFile("$qrFolder/$celular.png");

            $this->volverDashboard();
        } catch (PDOException $e) {
            $codigo = $e->errorInfo[1] ?? null;
            $msg = $codigo === 1062
                ? 'Ese celular ya está registrado.'
                : 'No se pudo guardar el usuario.';
            $this->volverDashboard($msg);
        }
    }

    public function handleEditar($id): void
    {
        $cliente = $this->usuarios->findById($id);

        if (!$cliente) {
            echo "Cliente no encontrado";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre_completo'];
            $dni = trim($_POST['dni'] ?? '');
            $celular = trim($_POST['celular']);
            $password = trim($_POST['password'] ?? '');
            $rol = $_POST['rol'] ?? 'cliente';

            $roles_permitidos = ['trabajador', 'cliente', 'administrador'];
            if (!in_array($rol, $roles_permitidos, true)) {
                $rol = $cliente['rol'];
            }

            try {
                $this->usuarios->update($id, $nombre, $dni, $celular, $rol, $password);

                header("Location: dashboard.php?ok=1");
                exit;
            } catch (PDOException $e) {
                $codigo = $e->errorInfo[1] ?? null;
                $msg = $codigo === 1062 ? 'Ese celular ya está registrado en otro usuario.' : 'No se pudieron guardar los cambios.';
                header('Location: dashboard.php?' . http_build_query(['err' => $msg]));
                exit;
            }
        }

        require __DIR__ . '/../views/admin/editar_cliente.php';
    }

    public function sumarSello(string $celular): void
    {
        $user = $this->usuarios->findByCelular($celular);

        if ($user) {
            $this->sellos->add($user['id']);
        }
    }

    public function guardarDisenio(?string $disenio): void
    {
        $usuario_id = $_SESSION['user']['id'];
        echo $disenio;
        echo $usuario_id;

        if ($disenio) {
            $this->qrConfig->setDisenio($disenio);

            header(header: "Location: ../admin/dashboard.php");
            exit;
        } else {
            echo "Debes seleccionar un diseño.";
        }
    }

    private function volverDashboard(string $msg = null): void
    {
        $params = $msg === null ? ['ok' => 1] : ['err' => $msg, 'open' => 1];
        header('Location: dashboard.php?' . http_build_query($params));
        exit;
    }
}
