-- Creacion de la base de datos.
CREATE DATABASE tienda;
USE tienda;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(20) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Tabla de categorías
CREATE TABLE categorias (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Tabla de productos
CREATE TABLE productos (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT(255),
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio FLOAT(10,2) NOT NULL,
    stock INT(255) NOT NULL,
    oferta VARCHAR(2),
    fecha DATE,
    imagen VARCHAR(255),
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Tabla de pedidos
CREATE TABLE pedidos (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT(255),
    provincia VARCHAR(100) NOT NULL,
    localidad VARCHAR(100) NOT NULL,
    direccion VARCHAR(255) NOT NULL,
    coste FLOAT(20,2) NOT NULL,
    estado VARCHAR(20) DEFAULT 'pendiente',
    fecha DATE,
    hora TIME,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Tabla de líneas de pedidos
CREATE TABLE lineas_pedidos (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT(255),
    producto_id INT(255),
    unidades INT(255) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;