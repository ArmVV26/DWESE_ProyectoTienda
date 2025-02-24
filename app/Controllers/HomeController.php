<?php
    // Define el namespace
    namespace Controllers;

    // Importo las clases necesarias
    use Services\CategoriaServices;

    // Importo la función para renderizar la vista
    require_once __DIR__ . '/../../config/render.php';

    /**
     * Controlador de Categoría
     * 1. Mostrar las categorías
     */
    class HomeController {
        // Atributos
        private CategoriaServices $categoriaService;

        // Constructor
        public function __construct() {
            $this->categoriaService = new CategoriaServices();
        }

        // Métodos
        /**
         * Método para mostrar las categorías
         */
        public function index() {
            // Llamo al método del servicio
            $categorias = $this->categoriaService->mostrarCategorias();

            // Incluyo la vista
            render('home/index', ['titulo' => 'HiperArmando', 'categorias' => $categorias]);
        }
    }