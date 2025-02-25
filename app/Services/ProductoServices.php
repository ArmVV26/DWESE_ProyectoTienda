<?php
    // Defino el namespace
    namespace Services;

    // Importo las clases necesarias
    use Repositories\ProductoRepository;

    /**
     * Servicios de Producto
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
    }