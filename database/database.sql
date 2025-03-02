-- Creacion de la base de datos.
CREATE DATABASE IF NOT EXISTS hiperarmando;
USE hiperarmando;

-- CREACION DE TABLAS
-- --------------------------------------------------------------------------------
-- Tabla de usuarios
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(20) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Tabla de categorías
DROP TABLE IF EXISTS categorias;
CREATE TABLE categorias (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Tabla de productos
DROP TABLE IF EXISTS productos;
CREATE TABLE productos (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT(255),
    nombre VARCHAR(255) UNIQUE NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT(255) NOT NULL,
    oferta VARCHAR(2),
    fecha DATE,
    imagen VARCHAR(255),
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Tabla de pedidos
DROP TABLE IF EXISTS pedidos;
CREATE TABLE pedidos (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT(255),
    provincia VARCHAR(100) NOT NULL,
    localidad VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    coste DECIMAL(20,2) NOT NULL,
    estado VARCHAR(20) DEFAULT 'pendiente',
    fecha DATE,
    hora TIME,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Tabla de líneas de pedidos
DROP TABLE IF EXISTS lineas_pedidos;
CREATE TABLE lineas_pedidos (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT(255),
    producto_id INT(255),
    unidades INT(255) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- --------------------------------------------------------------------------------

-- INSERCION DE DATOS
-- --------------------------------------------------------------------------------
-- Insertar Usuarios
INSERT INTO usuarios (nombre, apellidos, email, password, rol) VALUES
('Armando', 'Vaquero Vargas', 'ditovaquero@gmail.com', '$2y$10$y6UNhOhqhYwf1qctc6lUN.tDUcF1adqdbjrUJepKLNmdOR3ABqYIK', 'admin'),
('Antonio', 'García García', 'correo@correo.com', '$2y$10$NkZ8Me0N23PwWKefFIEmXuT0G3ljDf7sxm3flbVsi4Y7zeCGB1v02', 'cliente');

-- Insertar Categorías
INSERT INTO categorias (nombre) VALUES
('Camisetas'),
('Pantalones'),
('Zapatillas'),
('Gorras');

-- Insertar Productos
INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen) VALUES
(1, 'Camiseta Nike', 'Camiseta de la marca Nike', 20.00, 10, 'si', '2025-02-01', 'Camiseta-Nike.jpg'),
(1, 'Camiseta Adidas', 'Camiseta de la marca Adidas', 25.00, 15, 'no', '2025-02-01', 'Camiseta-Adidas.jpg'),
(2, 'Pantalón Nike', 'Pantalón de la marca Nike', 40.00, 10, 'si', '2025-02-01', 'Pantalon-Nike.jpg'),
(2, 'Pantalón Adidas', 'Pantalón de la marca Adidas', 45.00, 15, 'no', '2025-02-01', 'Pantalon-Adidas.jpg'),
(3, 'Zapatillas Nike', 'Zapatillas de la marca Nike', 60.00, 10, 'si', '2025-02-01', 'Zapatillas-Nike.jpg'),
(3, 'Zapatillas Adidas', 'Zapatillas de la marca Adidas', 65.00, 10, 'no', '2025-02-01', 'Zapatillas-Adidas.jpg'),
(4, 'Gorra Nike', 'Gorra de la marca Nike', 15.00, 5, 'si', '2025-02-01', 'Gorra-Nike.jpg'),
(4, 'Gorra Adidas', 'Gorra de la marca Adidas', 20.00, 5, 'no', '2025-02-01', 'Gorra-Adidas.jpg');

-- Insertar Pedidos
INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) VALUES
(1, 'Granada', 'Maracena', 'Calle Una, 1', 100.00, 'pendiente', '2025-02-01', '12:00:00'),
(1, 'Granada', 'Peligros', 'Calle Dos, 2', 200.00, 'pendiente', '2025-02-01', '13:00:00'),
(1, 'Granada', 'Pulianas', 'Calle Tres, 3', 300.00, 'pendiente', '2025-02-01', '14:00:00'),
(1, 'Granada', 'Albolote', 'Calle Cuatro, 4', 400.00, 'pendiente', '2025-02-01', '15:00:00');

-- Insertar Líneas de Pedidos
INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) VALUES
(1, 1, 4),
(1, 2, 2),
(2, 3, 1),
(2, 4, 2),
(3, 5, 3),
(3, 6, 1),
(4, 7, 2),
(4, 8, 1);
-- --------------------------------------------------------------------------------
