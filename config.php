<?php
    // Carga el autoload (Composer necesario PHP-Dotenv)
    require_once __DIR__ . '/vendor/autoload.php';

    // Instancia que carga las variables desde el archivo .env
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // Definicion de las credenciales para conectarse a la base de datos
    define('DB_HOST', $_ENV['DB_HOST']);
    define('DB_NAME', $_ENV['DB_NAME']);
    define('DB_USER', $_ENV['DB_USER']);
    define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
?>
