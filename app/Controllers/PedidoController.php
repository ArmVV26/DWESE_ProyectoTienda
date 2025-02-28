<?php
    // Define el namespace
    namespace Controllers;

    // Importo las clases necesarias
    use Models\Pedido;
    use Services\PedidoServices;
    use Services\ProductoServices;
    use Lib\Correo;

    // Importo la función para renderizar la vista
    require_once __DIR__ . '/../../config/render.php';

    /**
     * Controlador de Pedido
     * 1. Valida el pedido
     * 2. Procesa el formulario del pedido y lo guarda en la base de datos
     * 3. Muestra los pedidos de un usuario
     */
    class PedidoController {
        // Atributos
        private PedidoServices $pedidoServices;
        private ProductoServices $productoService;
        private array $errores = [];

        // Constructor
        public function __construct() {
            $this->pedidoServices = new PedidoServices();
            $this->productoService = new ProductoServices();
        }

        // Métodos
        /**
         * Método para validar el pedido
         * 
         * @param array $pedido Los datos del formulario
         * @return array Devuelve los datos del pedido saneados o un array con los errores
         */
        public function validarPedido($pedido) {
            // Recojo y limpio los datos
            $direccion = trim($pedido['direccion']);
            $localidad = trim($pedido['localidad']);
            $provincia = trim($pedido['provincia']);

            // Validar los datos
            if (!$direccion) {
                $this->errores[] = 'La dirección es obligatoria';
            }

            if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $localidad)) {
                $this->errores[] = 'La localidad solo puede contener letras y espacios';
            }

            if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $provincia)) {
                $this->errores[] = 'La provincia solo puede contener letras y espacios';
            }

            if (empty($this->errores)) {
                return [
                    'direccion' => $direccion,
                    'localidad' => $localidad,
                    'provincia' => $provincia
                ];
            } else {
                return $this->errores;
            }
        }

        /**
         * Método para procesar el formualrio del pedido y guardarlo en la base de datos. 
         * Funciones:
         * 1. Comprueba si el usuarioa ha iniciado sesión y si no lo redirige al formulario de login.
         * 2. Guarda el pedido en la base de datos.
         * 3. Guarda las líneas del pedido en la base de datos.
         * 4. Actualiza el stock del producto con el id $id, restándole la cantidad $cantidad.
         * 5. Recoje los datos necesarios para mandar el correo.
         * 6. Envía el correo.
         * 
         * @return void
         */
        public function formularioPedido() {
            // Verifico si se ha enviado el formulario de pedido por POST y si se han recibido los datos
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Valido los datos
                if ($_POST['data']) {
                    $validar = $this->validarPedido($_POST['data']);

                    // Si no hay errores, guardo el pedido
                    if (empty($this->errores) && !empty($validar)) {
                        $usuario_id = $_SESSION['inicioSesion']['id'];
                        $provincia = $validar['provincia'];
                        $localidad = $validar['localidad'];
                        $direccion = $validar['direccion'];
                        $coste = $this->pedidoServices->calcularTotalPedido();
                        $estado = 'pendiente';
                        $fecha = date('Y-m-d');
                        $hora = date('H:i:s');

                        // Creo el objeto Pedido
                        $pedido = new Pedido($usuario_id, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora);

                        // Guarda el pedido
                        $guardar = $this->pedidoServices->guardarPedido($pedido);

                        // Guarda las líneas del pedido
                        $this->pedidoServices->guardarLineaPedido($pedido->getId(), $_SESSION['carrito']);

                        if ($guardar) {
                            // Actualiza el stock del producto con el id $id, restándole la cantidad $cantidad
                            foreach ($_SESSION['carrito'] as $id => $cantidad) {
                                $this->productoService->decrementarStock($id, $cantidad);
                            }

                            // Recojo los datos necesarios para mandar el correo
                            $productos = [];
                            $total = 0;
                            foreach ($_SESSION['carrito'] as $id => $cantidad) {
                                $producto = $this->productoService->obtenerPorId($id);
                                $productos[] = [
                                    'nombre' => $producto['nombre'],
                                    'precio' => $producto['precio'],
                                    'cantidad' => $cantidad
                                ];

                                $total += $producto['precio'] * $cantidad;
                            }
                            $numeroPedido = $pedido->getId();
                            $correoCliente = $_SESSION['inicioSesion']['email'];
                            $nombreCliente = $_SESSION['inicioSesion']['nombre'];
                            $direccionEnvio = $pedido->getDireccion() . ', ' . $pedido->getLocalidad() . ', ' . $pedido->getProvincia();

                            // Envía el correo
                            $correo = new Correo();
                            $exitoCorreo = $correo->enviarConfirmaciónPedido($productos, $numeroPedido, $correoCliente, $nombreCliente, $total, $direccionEnvio);

                            // Si se ha enviado el correo
                            if ($exitoCorreo) {
                                $_SESSION['pedido'] = [
                                    'mensaje' => 'Pedido realizado correctamente',
                                    'mensaje-dos' => 'Se ha enviado un correo con los detalles del pedido',
                                    'tipo' => 'exito'
                                ];

                                // Limpia el carrito
                                unset($_SESSION['carrito']);
                                
                                // Borra la cookie
                                setcookie("carrito", "", time() - 3600, "/");

                                render('pedido/pedidoExitoso', ['titulo' => 'Pedido Confirmado']);
                                exit();
                            } else {
                                $_SESSION['pedido'] = [
                                    'mensaje' => 'Pedido realizado correctamente',
                                    'mensaje-dos' => 'No se ha podido enviar el correo',
                                    'tipo' => 'exito'
                                ];

                                // Limpia el carrito
                                unset($_SESSION['carrito']);

                                render('pedido/pedidoExitoso', ['titulo' => 'Pedido Confirmado']);
                                exit();
                            }

                        } else {
                            $_SESSION['pedido'] = [
                                'mensaje' => 'Error al realizar el pedido: No se ha podido guardar el pedido',
                                'tipo' => 'error'
                            ];
                        }
                    } else {
                        $_SESSION['pedido'] = [
                            'mensaje' => 'Error al realizar el pedido:',
                            'tipo' => 'error'
                        ];
                        $_SESSION['errores'] = $this->errores;
                    }
                } else {
                    $_SESSION['pedido'] = [
                        'mensaje' => 'Error al realizar el pedido: No se han enviado los datos',
                        'tipo' => 'error'
                    ];
                }
            }

            // Comprueba si el usuario ha iniciado sesión y si no lo redirige al formulario de login
            if (!isset($_SESSION['inicioSesion'])) {
                $_SESSION['login'] = [
                    'mensaje' => 'Debes iniciar sesión para confirmar el pedido',
                    'tipo' => 'exito'
                ];
                header('Location: ' . URL_BASE . 'usuario/formularioLogin');
                exit();
            } else {
                render('pedido/formularioPedido', ['titulo' => 'Formulario Pedido']);
                exit();
            }
        }

        /**
         * Método para mostrar los pedidos de un usuario
         * 
         * @return void
         */
        public function obtenerPedidosUsuario() {
            if (isset($_SESSION['inicioSesion'])) {
                $pedidos = $this->pedidoServices->obtenerPedidosUsuario($_SESSION['inicioSesion']['id']);
                render('pedido/mostrarPedidos', ['titulo' => 'Mis Pedidos', 'pedidos' => $pedidos]);
            } 
        }

    }