<?php
    // Definio el namespace
    namespace Controllers;

    // Importo la función para renderizar la vista
    require_once __DIR__ . '/../../config/render.php';

    /**
     * Controlador de Error
     */
    class ErrorController {
        // Métodos
        /**
         * Método para mostrar la página de error
         */
        public function error404() {
            render('error/error404', ['titulo' => 'Error 404']);
        }
    }