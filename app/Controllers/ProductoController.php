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
     * 1. Validar los datos del formulario de producto
     * 2. Crear un producto en la base de datos
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
            // Recojo y limpio los datos
            $nombre = trim($producto['nombre']) ?? '';
            $descripcion = trim($producto['descripcion']) ?? '';
            $precio = (float) $producto['precio'] ?? 0;
            $stock = (int) $producto['stock'] ?? 0;
            $oferta = trim($producto['oferta']) ?? '';
            $imagen = trim($producto['imagen']) ?? '';
            $categoria_id = (int) $producto['categoria_id'] ?? 0;

            // Valido los datos
            if (!$nombre) {
                $this->errores[] = 'El nombre es obligatorio';
            }

            if (!$descripcion) {
                $this->errores[] = 'La descripción es obligatoria';
            }

            if ($precio <= 0) {
                $this->errores[] = 'El precio debe ser mayor que 0';
            }

            if ($stock <= 0) {
                $this->errores[] = 'El stock debe ser mayor que 0';
            }

            if (!$oferta) {
                $this->errores[] = 'La oferta es obligatoria';
            }

            if (!$imagen) {
                $this->errores[] = 'La imagen es obligatoria';
            }

            if ($categoria_id <= 0) {
                $this->errores[] = 'La categoría es obligatoria';
            }

            if (empty($this->errores)) {
                return [
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'precio' => $precio,
                    'stock' => $stock,
                    'oferta' => $oferta,
                    'imagen' => $imagen,
                    'categoria_id' => $categoria_id
                ];
            } else {
                return $this->errores;
            }
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
                                'mensaje' => 'Error al crear el producto: El producto ya existe',
                                'tipo' => 'fallo'
                            ];
                        }
                    } else {
                        $_SESSION['registro'] = [
                            'mensaje' => 'Error al crear el producto:',
                            'tipo' => 'fallo'
                        ];
                        $_SESSION['errores'] = $this->errores;
                    }
                } else {
                    $_SESSION['registro'] = [
                        'mensaje' => 'Error al crear el producto: Datos incorrectos',
                        'tipo' => 'fallo'
                    ];
                }
            }   

            render('../Views/admin/crearProducto', [
                'titulo' => 'Crear Producto',
                'categorias' => $this->categoriaService->mostrarCategorias()
            ]);
            exit();
        }

        /**
         * Método para mostrar los productos
         * 
         * @return void
         */
        public function mostrarProductos() {
            render('../Views/admin/mostrarProductos', [
                'titulo' => 'Mostrar Productos',
                'productos' => $this->productoService->obtenerProductosTodos()
            ]);
            exit();
        }

        /**
         * Método para eliminar un producto
         * 
         * @param int $id El id del producto
         * @return void
         */
        public function eliminarProducto($id) {
            if (isset($id)) {
                $eliminarProd = $this->productoService->eliminarProducto($id);
                
                if ($eliminarProd) {
                    $_SESSION['eliminar'] = [
                        'mensaje' => 'Producto eliminado correctamente',
                        'tipo' => 'exito'
                    ];
                } else {
                    $_SESSION['eliminar'] = [
                        'mensaje' => 'Error al eliminar el producto: El producto no existe',
                        'tipo' => 'fallo'
                    ];
                }
            } else {
                $_SESSION['eliminar'] = [
                    'mensaje' => 'Error al eliminar el producto: Datos incorrectos',
                    'tipo' => 'fallo'
                ];
            }

            $this->mostrarProductos();
        }

        /**
         * Método para validar los datos del formulario de actualización de un producto
         * 
         * @param array $producto Los datos del formulario
         * @return bool True si los datos son válidos, false en caso contrario
         */
        public function validarActualizarProducto($producto) {
            $precio = (float) $producto['precio'] ?? 0;
            $stock = (int) $producto['stock'] ?? 0;
            $categoria_id = (int) $producto['categoria_id'] ?? 0;

            $error = false;

            if (isset($precio) && !empty($precio)) {
                if ($precio <= 0) {
                    $error = true;
                }
            }

            if (isset($stock) && !empty($stock)) {
                if ($stock <= 0) {
                    $error = true;
                }
            }

            if (isset($categoria_id) && !empty($categoria_id)) {
                if ($categoria_id <= 0) {
                    $error = true;
                }
            }

            return !$error;
        }

        /**
         * Método para actualizar/editar un producto
         * 
         * @param int $id El id del producto
         * @return void
         */
        public function actualizarProducto($id) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if ($_POST['data']) {
                    $datos = $_POST['data'];
                    $validar = $this->validarActualizarProducto($datos);

                    if ($validar) {
                        $resultado = $this->productoService->actualizarProducto($datos);

                        if ($resultado) {
                            $_SESSION['editar'] = [
                                'mensaje' => 'Producto actualizado correctamente',
                                'tipo' => 'exito'
                            ];
                        } else {
                            $_SESSION['editar'] = [
                                'mensaje' => 'Error al actualizar el producto: El producto no existe',
                                'tipo' => 'fallo'
                            ];
                        }
                    } else {
                        $_SESSION['editar'] = [
                            'mensaje' => 'Error al actualizar el producto:',
                            'tipo' => 'fallo'
                        ];
                        $_SESSION['errores'] = $this->errores;
                    }
                } else {
                    $_SESSION['editar'] = [
                        'mensaje' => 'Error al actualizar el producto: Datos incorrectos',
                        'tipo' => 'fallo'
                    ];
                }
            }

            if (isset($id)) {
                $producto = $this->productoService->obtenerPorId($id);

                if ($producto) {
                    render('../Views/admin/actualizarProducto', [
                        'titulo' => 'Actualizar Producto',
                        'categorias' => $this->categoriaService->mostrarCategorias(),
                        'producto' => $producto
                    ]);
                    exit();
                } else {
                    $_SESSION['editar'] = [
                        'mensaje' => 'Error al actualizar el producto: El producto no existe',
                        'tipo' => 'fallo'
                    ];
                }
            } else {
                $_SESSION['editar'] = [
                    'mensaje' => 'Error al actualizar el producto: Datos incorrectos',
                    'tipo' => 'fallo'
                ];
            }
        }
    }