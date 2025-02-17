<?php
    // Inicio de la sesión
    session_start();
    
    // Forzamos una sesión de administrador para efectos de prueba.
    // En un entorno real, esto se haría tras un login correcto.
    if (!isset($_SESSION['inicioSesion'])) {
        // Simulamos un objeto (por ejemplo, un stdClass) con la propiedad "rol"
        $_SESSION['inicioSesion'] = (object)[
            'id'   => 1,
            'nombre' => 'Admin',
            'rol'  => 'admin'
        ];
    }

    unset($_SESSION['inicioSesion']);

    // Carga el autoload (Composer necesario PHP-Dotenv)
    require_once __DIR__ . '/../vendor/autoload.php';

    // Instancia que carga las variables desde el archivo .env (se indica la ruta del .env)
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    // Determinar el controlador y la acción por URL, con valores por defecto
    $controller = $_GET['controller'] ?? 'Usuario';
    $action = $_GET['action'] ?? 'formRegistro';

    // Crear el nombre completo de la clase del controlador
    $controllerClass = 'App\\Controllers\\' . $controller . 'Controller';

    // Instanciar y llamar al método correspondiente
    if (class_exists($controllerClass)) {
        $objController = new $controllerClass();
        if (method_exists($objController, $action)) {
            $objController->{$action}();
        } else {
            echo "La acción '$action' no existe en el controlador '$controller'.";
        }
    } else {
        echo "El controlador '$controller' no existe.";
    }