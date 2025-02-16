<?php
    // Defino el namespace
    namespace Lib;

    // Defino la clase Router
    class Router {
        // Atributos
        private $rutas = [];

        // Método para agregar rutas a la lista
        public static function add(string $metodo, string $accion, Callable $controller):void{

            // Elimino los espacios en blanco
            $accion = trim($accion, '/');
            
            // Agrego la ruta a la lista
            self::$rutas[$metodo][$accion] = $controller;
        }

        // Este método se encarga de obtener el sufijo de la URL que permitirá seleccionar
        // la ruta y mostrar el resultado de ejecutar la función pasada al metodo add para esa ruta
        // usando call_user_func()
        public static function dispatch():void {
            // Obtengo el método de la petición
            $metodo = $_SERVER['REQUEST_METHOD']; 
            
            // Obtengo la acción de la petición
            $accion = preg_replace('/clinicarouter/','',$_SERVER['REQUEST_URI']);
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
            
            // Verifico si la acción existe en la lista de rutas y si no existe muestro un error
            $callback = self::$routes[$metodo][$accion];
        
            // Si la acción existe en la lista de rutas ejecuto la función asociada a la acción
            echo call_user_func($callback, $param);
        }
    }