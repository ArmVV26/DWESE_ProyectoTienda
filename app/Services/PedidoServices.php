<?php
    // Defino el namespace
    namespace Services;

    // Importo las clases necesarias
    use Services\ProductoServices;
    use Repositories\PedidoRepository;

    /**
     * Clase PedidoServices
     * 1. Guardar un pedido
     * 2. Obtener los pedidos de un usuario
     * 3. Guardar una línea de pedido
     * 4. Calcular el total del pedido
     */
    class PedidoServices {
        // Atributos
        private ProductoServices $productoService;
        private PedidoRepository $pedidoRepository;

        // Constructor
        public function __construct() {
            $this->productoService = new ProductoServices();
            $this->pedidoRepository = new PedidoRepository();
        }

        // Métodos
        /**
         * Método para guardar un pedido
         * 
         * @param Pedido $pedido Los datos del pedido
         * @return bool Devuelve true si se ha guardado el pedido y false en caso contrario
         */
        public function guardarPedido($pedido) {
            return $this->pedidoRepository->guardarPedido($pedido);
        }

        /**
         * Método para obtener los pedidos de un usuario
         * 
         * @param int $usuario_id El id del usuario
         * @return array Devuelve los pedidos del usuario
         */
        public function obtenerPedidosUsuario($usuario_id) {
            return $this->pedidoRepository->obtenerPedidosUsuario($usuario_id);
        }

        /**
         * Método para guardar una línea de pedido
         * 
         * @param int $pedido_id El id del pedido
         * @param array $carrito El carrito de la compra
         * @return void
         */
        public function guardarLineaPedido($pedido_id, $carrito) {
            return $this->pedidoRepository->guardarLineaPedido($pedido_id, $carrito);
        }

        /**
         * Método para calcular el total del pedido
         * 
         * @return float Devuelve el total del pedido
         */
        public function calcularTotalPedido() {
            $total = 0.0;
            if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                foreach ($_SESSION['carrito'] as $id => $cantidad) {
                    // Obtener el producto (esto podría ser una llamada a un servicio)
                    $producto = $this->productoService->obtenerPorId($id);
                    if ($producto) {
                        $total += $producto['precio'] * $cantidad;
                    }
                }
            }
            return $total * 1.21;
        }
    }