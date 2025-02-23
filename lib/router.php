<?php
    // Defino el namespace
    namespace lib;

    // Defino la clase Router
    class Router {
        // Atributos
        private static $rutas = [];

        /**
         * Método para agregar una ruta a la lista de rutas
         */
        public static function add(string $metodo, string $accion, Callable $controller):void{

            // Elimino los espacios en blanco
            $accion = trim($accion, '/');

            // Agrego la ruta a la lista
            self::$rutas[$metodo][$accion] = $controller;
        }

        /**
         * Este método se encarga de obtener el sufijo de la URL que permitirá seleccionar
         * la ruta y mostrar el resultado de ejecutar la función pasada al método add para esa ruta
         * usando call_user_func()
         */
        public static function dispatch():void {
            // Obtengo el método de la petición
            $metodo = $_SERVER['REQUEST_METHOD']; 
            
            $BASE_PATH = '/xampp-web/DWESE_ProyectoTienda';

            $accion = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

            // Obtengo la acción de la petición
            $accion = preg_replace('/^' . preg_quote($BASE_PATH, '/') . '/', '', $accion);
            $accion = trim($accion, '/');

            // Verifico si la acción tiene un parámetro
            $param = null;
            preg_match('/[0-9]+$/', $accion, $match);
        
            // Si la acción tiene un parámetro lo guardo y lo elimino de la acción
            if(!empty($match)){
                
                // Guardo el parámetro en la variable $param y elimino el parámetro de la acción
                $param = $match[0];
                $accion=preg_replace('/'.$match[0].'/',':id',$accion);
            }

            // Si existe, ejecuta la función correspondiente a la ruta
            $callback = self::$rutas[$metodo][$accion] ?? null;
            if ($callback) {
                echo call_user_func($callback, $param);
            // Si no existe, muestra un error 
            } else {
                echo "La ruta <strong>$accion</strong> no se encontró.";
            }
        }
    }