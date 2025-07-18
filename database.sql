CREATE DATABASE IF NOT EXISTS crud_mvc;
USE crud_mvc;

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO productos (nombre, precio, descripcion) VALUES
('Laptop HP', 899.99, 'Laptop HP con procesador Intel i5'),
('Mouse Logitech', 29.99, 'Mouse inalámbrico Logitech'),
('Teclado Mecánico', 89.99, 'Teclado mecánico RGB');