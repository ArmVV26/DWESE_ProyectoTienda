<?php
    /**
     * Funcion para renderizar una vista con un layout principal.
     * 
     * @param string $rutaVista La ruta de la vista a renderizar
     * @param array $data Los datos que se pasan a la vista
     * @return void
     */
    function render(string $rutaVista, array $data = []) {
        // Extraer variables para que estén disponibles en la vista
        extract($data);

        // Iniciar output buffering para capturar la salida de la vista
        ob_start();
        include __DIR__ . '/../app/Views/' . $rutaVista . '.php';
        $contenido = ob_get_clean();

        // Incluir el layout principal, que usará la variable $contenido
        include __DIR__ . '/../app/Views/layout/layout.php';
    }