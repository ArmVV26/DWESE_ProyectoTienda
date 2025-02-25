<?php
    // Defino el namespace
    namespace Controllers;

    // Importo las clases necesarias
    use Models\Producto;
    use Models\Categoria;
    use Services\ProductoServices;
    use Services\CategoriaServices;

    // Importo la función para renderizar la vista
    require_once __DIR__ . '/../../config/render.php';

    /**
     * Controlador de Producto
     */
    class ProductoController {
        // Atributos
        private ProductoServices $productoService;
        private CategoriaServices $categoriaService;
        private array $errores = [];

        // Constructor
        public function __construct() {
            $this->productoService = new ProductoServices();
            $this->categoriaService = new CategoriaServices();
        }

        // Métodos
        /**
         * Método para validar los datos del formulario de creación de un producto
         * 
         * @param array $producto Los datos del formulario
         * @return array Devuelve los datos del usuario saneados o un array con los errores
         */
        private function validarProducto($producto) {

        }

        /**
         * Método para crear un producto
         * 
         * @return void
         */
        public function crearProducto() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if ($_POST['data']) {
                    $validar = $this->validarProducto($_POST['data']);

                    if (empty($this->errores) && !empty($validar)) {
                        $producto = Producto::fromArray($validar);
                        $crearProd = $this->productoService->crearProducto($producto);

                        if ($crearProd) {
                            $_SESSION['registro'] = [
                                'mensaje' => 'Producto creado correctamente',
                                'tipo' => 'exito'
                            ];
                        } else {
                            $_SESSION['registro'] = [
                                'mensaje' => 'Error al crear el producto',
                                'tipo' => 'error'
                            ];
                        }
                    } else {
                        $_SESSION['registro'] = [
                            'mensaje' => 'Error al crear el producto',
                            'tipo' => 'error'
                        ];
                        $_SESSION['errores'] = $this->errores;
                    }
                } else {
                    $_SESSION['registro'] = [
                        'mensaje' => 'Error al crear el producto',
                        'tipo' => 'error'
                    ];
                }
            }   

            render('../Views/admin/crearProducto', [
                'titulo' => 'Crear Producto',
                'categorias' => $this->categoriaService->mostrarCategorias()
            ]);
            exit();
        }

    }