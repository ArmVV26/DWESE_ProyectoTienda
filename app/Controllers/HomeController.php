<?php
    // Define el namespace
    namespace Controllers;

    // Importo las clases necesarias
    use Services\CategoriaServices;
    use Services\ProductoServices;

    // Importo la función para renderizar la vista
    require_once __DIR__ . '/../../config/render.php';

    /**
     * Controlador de Categoría
     * 1. Mostrar las categorías
     */
    class HomeController {
        // Atributos
        private CategoriaServices $categoriaService;
        private ProductoServices $productoService;

        // Constructor
        public function __construct() {
            $this->categoriaService = new CategoriaServices();
            $this->productoService = new ProductoServices();
        }

        // Métodos
        /**
         * Método para mostrar el index de la página
         * 
         * @param int|null $id El id de la categoría
         * @return void
         */
        public function index($id = null) {
            // Llamo al método del servicio para mostrar las categorías
            $categorias = $this->categoriaService->mostrarCategorias();

            // Si el id no es nulo, muestro los productos de la categoría
            if (isset($id)) {
                $productos = $this->productoService->obtenerProductosCategoria($id);
            } else {
                $productos = $this->productoService->obtenerProductosTodos();
            }

            // Incluyo la vista
            render('home/index', [
                'titulo' => 'HiperArmando',
                'categorias' => $categorias,
                'productos' => $productos
            ]);
        }
    }