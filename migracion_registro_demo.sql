CREATE TABLE IF NOT EXISTS demo_usos (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    token_hash CHAR(64) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(254) NOT NULL,
    inicio DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    expira DATETIME NOT NULL,
    fin DATETIME DEFAULT NULL,
    estado VARCHAR(20) NOT NULL DEFAULT 'activa',
    sugerencias TEXT DEFAULT NULL,
    sugerencias_fecha DATETIME DEFAULT NULL,
    INDEX demo_email_inicio (email, inicio),
    INDEX demo_inicio (inicio)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
