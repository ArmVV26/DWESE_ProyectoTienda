<?php
    // Defino el namespace
    namespace Services;

    // Importo las clases necesarias
    use Repositories\ProductoRepository;

    /**
     * Servicios de Producto
     * 1. Crear/Guardar un producto
     * 2. Eliminar un producto
     * 3. Obtener un producto por su id
     * 4. Actualizar un producto
     * 5. Obtener todos los productos
     * 6. Obtener productos por categoria
     * 7. Decrementar el stock de un producto
     */
    class ProductoServices {
        // Atributos
        private ProductoRepository $productoRepository;

        // Constructor
        public function __construct() {
            $this->productoRepository = new ProductoRepository();
        }

        // Métodos
        /**
         * Método para crear un producto
         * 
         * @param array $producto Los datos del producto
         * @return bool True si se ha creado correctamente, false en caso contrario
         */
        public function crearProducto($producto) {
            return $this->productoRepository->crearProducto($producto);
        }

        /**
         * Método para eliminar un producto
         * 
         * @param int $id El id del producto
         * @return bool True si se ha eliminado correctamente, false en caso contrario
         */
        public function eliminarProducto($id) {
            return $this->productoRepository->eliminarProducto($id);
        }

        /**
         * Método para obtener un producto por su id
         * 
         * @param int $id El id del producto
         * @return array Devuelve un array con los datos del producto
         */
        public function obtenerPorId($id) {
            return $this->productoRepository->obtenerPorId($id);
        }

        /**
         * Método para actualizar un producto
         * 
         * @param array $datos Los datos del producto
         * @return bool True si se ha actualizado correctamente, false en caso contrario
         */
        public function actualizarProducto($datos) {
            return $this->productoRepository->actualizarProducto($datos);
        }

        /**
         * Método para obtener todos los productos
         * 
         * @return array Devuelve un array con todos los productos
         */
        public function obtenerProductosTodos() {
            return $this->productoRepository->obtenerProductosTodos();
        }

        /**
         * Método para obtener un producto por su categoria
         * 
         * @param int $id El id del producto
         * @return array Devuelve un array con todos los productos de la categoria indicada
         */
        public function obtenerProductosCategoria($categoria_id) {
            return $this->productoRepository->obtenerProductosCategoria($categoria_id);
        }

        /**
         * Método para decrementar el stock de un producto cuando se realiza un pedido
         * 
         * @param int $id El id del producto
         * @param int $cantidad La cantidad de productos
         * @return bool True si se ha actualizado correctamente, false en caso contrario
         */
        public function decrementarStock($id, $cantidad) {
            return $this->productoRepository->decrementarStock($id, $cantidad);
        }
    }