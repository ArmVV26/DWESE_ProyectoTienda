<?php
    // Defino el namespace
    namespace App\Controllers;

    // Importo las clases necesarias
    use Models\Categoria;
    use Services\CategoriaServices;

    // Importo la función para renderizar la vista
    require_once __DIR__ . '/../../config/render.php';

    /**
     * Controlador de Categoría
     * 1. Validar los datos del formulario de categoría
     * 2. Registrar una categoría en la base de datos
     * 3. Actualizar una categoría en la base de datos
     * 4. Eliminar una categoría en la base de datos
     */
    class CategoriaController {
        // Atributos
        private CategoriaServices $categoriaServices;
        private array $errores = [];

        // Constructor
        public function __construct() {
            $this->categoriaServices = new CategoriaServices();
        }
    }