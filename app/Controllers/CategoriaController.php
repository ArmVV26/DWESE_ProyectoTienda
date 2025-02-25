<?php
    // Defino el namespace
    namespace Controllers;

    // Importo las clases necesarias
    use Models\Categoria;
    use Services\CategoriaServices;

    // Importo la función para renderizar la vista
    require_once __DIR__ . '/../../config/render.php';

    /**
     * Controlador de Categoría
     * 1. Validar los datos del formulario de categoría
     * 2. Crear una categoría en la base de datos
     * 3. Mostrar las categorías
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

        // Métodos
        /**
         * Método para validar los datos del formulario de categoría
         * 
         * @param array $categoria Los datos de la categoría
         * @return bool True si los datos son válidos, false en caso contrario
         */
        private function validarCategoria($categoria) {
            // Limpio los datos
            $nombre = trim($categoria['nombre']);

            // Validación para el nombre    
            if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/', $nombre)) {
                $this->errores[] = "El nombre solo puede contener letras y sin espacios";
            }

            if (empty($this->errores)) {
                return $nombre;
            } else {
                return $this->errores;
            }
        }

        /**
         * Método para crear una categoría
         * 
         * @return void
         */
        public function crearCategoria() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if ($_POST['data']) {
                    $validar = $this->validarCategoria($_POST['data']);
                    
                    if (empty($this->errores) && !empty($validar)) {
                        $categoria = new Categoria($validar);
                        $crearCategoria = $this->categoriaServices->crearCategoria($categoria);

                        if ($crearCategoria) {
                            $_SESSION['registro'] = [
                                'mensaje' => 'Categoría creada correctamente',
                                'tipo' => 'exito'
                            ];
                        } else {
                            $_SESSION['registro'] = [
                                'mensaje' => 'Error al crear la categoría: La categoría ya existe',
                                'tipo' => 'fallo'
                            ];
                        }
                    } else {
                        $_SESSION['registro'] = [
                            'mensaje' => 'Error al crear la categoría:',
                            'tipo' => 'fallo'
                        ];
                        $_SESSION['errores'] = $this->errores;
                    }
                } else {
                    $_SESSION['registro'] = [
                        'mensaje' => 'Error al crear la categoría: Datos vacíos',
                        'tipo' => 'fallo'
                    ];
                }
            }

            render('../Views/admin/crearCategoria', ['titulo' => 'Crear Categoría']);
            exit();
        }

        /**
         * Método para mostrar las categorías
         * 
         * @return void
         */
        public function mostrarCategorias() {
            $categorias = $this->categoriaServices->mostrarCategorias();
            render('../Views/admin/mostrarCategorias', ['titulo' => 'Mostrar Categorías', 'categorias' => $categorias]);
            exit();
        }

        /**
         * Método para eliminar una categoría en la base de datos
         * 
         * @param int|null $id El id de la categoría
         * @return void
         */
        public function eliminarCategoria($id = null) {
            if (isset($id)) {
                $eliminarCategoria = $this->categoriaServices->eliminarCategoria($id);

                if ($eliminarCategoria) {
                    $_SESSION['eliminar'] = [
                        'mensaje' => 'La categoría se ha eliminado correctamente',
                        'tipo' => 'exito'
                    ];
                } else {
                    $_SESSION['eliminar'] = [
                        'mensaje' => 'Error al eliminar la categoría: La categoría no existe',
                        'tipo' => 'fallo'
                    ];
                }
            } else {
                $_SESSION['eliminar'] = [
                    'mensaje' => 'Error al eliminar la categoría: Datos incorrectos',
                    'tipo' => 'fallo'
                ];
            }

            $this->mostrarCategorias();
        }
    }