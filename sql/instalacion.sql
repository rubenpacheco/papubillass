SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS usuarioss (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(100) NOT NULL,
    dni VARCHAR(20) NULL DEFAULT NULL,
    celular VARCHAR(20) NOT NULL,
    rol VARCHAR(20) NOT NULL DEFAULT 'cliente',
    password VARCHAR(255) NOT NULL,
    estado VARCHAR(20) NOT NULL DEFAULT 'activo',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_usuarioss_celular (celular),
    KEY idx_usuarioss_dni (dni)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS sellos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    KEY idx_sellos_usuario (usuario_id),
    CONSTRAINT fk_sellos_usuario FOREIGN KEY (usuario_id)
        REFERENCES usuarioss (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS qrconfig (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sellos INT NOT NULL DEFAULT 10,
    disenio VARCHAR(50) NOT NULL DEFAULT 'sellosd1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO qrconfig (sellos, disenio)
SELECT 10, 'sellosd1' WHERE NOT EXISTS (SELECT 1 FROM qrconfig);

-- Admin de prueba: celular 999999999 / contraseña admin123
INSERT INTO usuarioss (nombre_completo, dni, celular, rol, password, estado)
SELECT 'Administrador', NULL, '999999999', 'admin',
       '$2y$10$gVFR.5mCuDgQd6AGDLx26eGWRDEoPT6z0ECDalgoBEx.nnwDNvMye', 'activo'
WHERE NOT EXISTS (SELECT 1 FROM usuarioss WHERE rol = 'admin');
