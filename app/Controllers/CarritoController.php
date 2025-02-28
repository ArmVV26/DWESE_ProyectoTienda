<?php
    // Defino el namespace
    namespace Controllers;

    // Importo las clases necesarias
    use Services\ProductoServices;

    // Importo la función para renderizar la vista
    require_once __DIR__ . '/../../config/render.php';

    /**
     * Controlador de Carrito
     * 1. Agregar un producto en el carrito
     * 2. Mostrar el carrito
     * 3. Restar un producto del carrito
     * 4. Eliminar un producto del carrito
     * 5. Vaciar el carrito
     */
    class CarritoController {
        // Atributos
        private ProductoServices $productoServices;

        // Constructor
        public function __construct() {
            $this->productoServices = new ProductoServices();
        }

        // Métodos
        /**
         * Método para agregar un producto en el carrito
         * 
         * @param int|null $id El id del producto
         * @return void
         */
        public function agregarProducto($id = null) {
            // Compruebo si el id es válido
            if (isset($id)) {
                
                // Compruebo el carrito existe y si no lo creo
                if (!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = [];
                } 

                // Obtengo el producto y compruebo si existe
                $producto = $this->productoServices->obtenerPorId($id);
                if ($producto) {

                    // Compruebo si esta añadido el producto en el carrito
                    if (isset($_SESSION['carrito'][$id])) {
                        
                        // Compruebo si la cantidad añadida es menor que el stock
                        if ($_SESSION['carrito'][$id] < $producto['stock']) {
                            $_SESSION['carrito'][$id]++;
                        } 

                    // Si no esta añadido el producto lo añado
                    } else {
                        $_SESSION['carrito'][$id] = 1;
                    }
                } 

                // Guardo el carrito en una cookie si el usuario esta logueado
                if (isset($_SESSION['inicioSesion'])) {
                    setcookie('carrito', json_encode($_SESSION['carrito']), time() + (3 * 24 * 60 * 60), '/');
                }
                
                // Redirijo a la página del carrito o a la principal
                if (isset($_SESSION['origen']) && !empty($_SESSION['origen']) && $_SESSION['origen'] === 'carrito')   {
                    header('Location: ' . URL_BASE . 'carrito/mostrarCarrito');
                    unset($_SESSION['origen']);

                } else {
                    header('Location: ' . URL_BASE);
                }
                exit();
            }
        }

        /**
         * Método para mostrar el carrito
         * 
         * @return void
         */
        public function mostrarCarrito() {
            $productoCarrito = [];

            // Compruebo si el carrito existe y no esta vacío
            if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {

                // Recorro el carrito y obtengo los productos
                foreach ($_SESSION['carrito'] as $id => $cantidad) {

                    $producto = $this->productoServices->obtenerPorId($id);

                    if ($producto) {
                        $productoCarrito[] = [
                            'cantidad' => $cantidad,
                            'producto' => $producto
                        ];
                    }
                }
            }

            // Renderizo la vista
            render('carrito/mostrarCarrito', [
                'titulo' => 'Carrito',
                'productoCarrito' => $productoCarrito
            ]);
            exit();
        }

        /**
         * Método para restar/eliminar un producto del carrito
         * 
         * @param int $id El id del producto
         * @return void
         */
        public function restarProducto($id = null) {
            // Compruebo si el id es válido
            if (isset($id)) {
                // Resto la cantidad del producto
                if (isset($_SESSION['carrito'][$id])) {
                    if ($_SESSION['carrito'][$id] > 1) {
                        $_SESSION['carrito'][$id]--;
                    } else {
                        unset($_SESSION['carrito'][$id]);
                    }
                }

                // Guardo el carrito en una cookie si el usuario esta logueado
                if (isset($_SESSION['inicioSesion'])) {
                    setcookie('carrito', json_encode($_SESSION['carrito']), time() + (3 * 24 * 60 * 60), '/');
                }

                header('Location: ' . URL_BASE . 'carrito/mostrarCarrito');
            }
        }

        /**
         * Método para eliminar un producto del carrito
         * 
         * @param int $id El id del producto
         * @return void
         */
        public function eliminarProducto($id = null) {
            // Compruebo si el id es válido
            if (isset($id)) {
                unset($_SESSION['carrito'][$id]);

                // Guardo el carrito en una cookie si el usuario esta logueado
                if (isset($_SESSION['inicioSesion'])) {
                    setcookie('carrito', json_encode($_SESSION['carrito']), time() + (3 * 24 * 60 * 60), '/');
                }

                header('Location: ' . URL_BASE . 'carrito/mostrarCarrito');
            }
        }

        /**
         * Método para vaciar el carrito
         * 
         * @return void
         */
        public function vaciarCarrito() {
            unset($_SESSION['carrito']);

            // Guardo el carrito en una cookie si el usuario esta logueado
            if (isset($_SESSION['inicioSesion'])) {
                setcookie('carrito', json_encode($_SESSION['carrito']), time() + (3 * 24 * 60 * 60), '/');
            }

            header('Location: ' . URL_BASE . 'carrito/mostrarCarrito');
        }
    }