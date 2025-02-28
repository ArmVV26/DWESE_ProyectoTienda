<?php
    // Defino el namespace
    namespace Services;

    // Importo las clases necesarias
    use Repositories\CategoriaRepository;

    /**
     * Servicios de Categoría
     * 1. Crear/Guardar una categoría
     * 2. Mostrar las categorías
     * 3. Eliminar una categoría
     */
    class CategoriaServices {
        // Atributos
        private CategoriaRepository $categoriaRepository;

        // Constructor
        public function __construct() {
            $this->categoriaRepository = new CategoriaRepository();
        }

        // Métodos
        /**
         * Método para mostrar las categorías
         * 
         * @param array $categoria Los datos de la categoría
         * @return bool True si se ha creado correctamente, false en caso contrario 
         */
        public function crearCategoria($categoria) {
            return $this->categoriaRepository->crearCategoria($categoria);
        }

        /**
         * Método para mostrar las categorías
         * 
         * @return array Devuelve un array con las categorías
         */
        public function mostrarCategorias() {
            return $this->categoriaRepository->mostrarCategorias();
        }

        /**
         * Método para eliminar una categoría
         * 
         * @param int $id El id de la categoría
         * @return bool True si se ha eliminado correctamente, false en caso contrario
         */
        public function eliminarCategoria($id) {
            return $this->categoriaRepository->eliminarCategoria($id);
        }
    }