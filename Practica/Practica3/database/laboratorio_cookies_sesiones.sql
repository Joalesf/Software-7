CREATE DATABASE IF NOT EXISTS laboratorio_cookies_sesiones
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE laboratorio_cookies_sesiones;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    clave_hash VARCHAR(255) NOT NULL,
    nombre_completo VARCHAR(120) NOT NULL,
    correo VARCHAR(120) NOT NULL UNIQUE,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tokens_recordarme (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    token_hash CHAR(64) NOT NULL UNIQUE,
    expira_en DATETIME NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_token_usuario (usuario_id),
    INDEX idx_token_expira (expira_en),
    CONSTRAINT fk_token_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO usuarios (usuario, clave_hash, nombre_completo, correo)
VALUES
    ('ana', '$2y$10$s0IZWxTsYcacbMpzN1mKVeo7Uj0grRM4OkeMxIxQWMPJClGDQGc6y', 'Ana Lopez', 'ana@example.com'),
    ('demo', '$2y$10$e7uwY31LsZUgFnTOej3rb.YHG3OEj03H8uz.TlaNdi1wNpghPTNSa', 'Usuario Demo', 'demo@example.com')
ON DUPLICATE KEY UPDATE
    nombre_completo = VALUES(nombre_completo),
    correo = VALUES(correo);
