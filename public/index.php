<?php
    // Carga el autoload (Composer necesario PHP-Dotenv)
    require_once __DIR__ . '/../vendor/autoload.php';

    // Inicio de la sesión
    session_start();
    
    // Instancia que carga las variables desde el archivo .env (se indica la ruta del .env)
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
    
    // Cargar la configuracion base
    require_once __DIR__ . '/../config/config.php';

    // Cargar las rutas
    require_once __DIR__ . '/../config/rutas.php';