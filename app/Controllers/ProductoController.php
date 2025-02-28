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
     * 3. Mostrar los productos
     * 4. Eliminar un producto
     * 5. Validar los datos del formulario de actualización de un producto
     * 6. Actualizar un producto en la base de datos
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
         * @return array Devuelve los datos del producto saneados o un array con los errores
         */
        private function validarProducto($producto) {
            // Recojo y limpio los datos
            $nombre = trim($producto['nombre']) ?? '';
            $descripcion = trim($producto['descripcion']) ?? '';
            $precio = (float) $producto['precio'] ?? 0;
            $stock = (int) $producto['stock'] ?? 0;
            $oferta = trim($producto['oferta']) ?? '';
            $imagen = trim($_FILES['data']['name']['imagen']) ?? '';
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
            // Compruebo si se ha enviado el formulario de creación de producto por POST y si hay datos
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Valido los datos
                if ($_POST['data']) {
                    $validar = $this->validarProducto($_POST['data']);

                    // Si no hay errores, creo el producto
                    if (empty($this->errores) && !empty($validar)) {
                        $producto = Producto::fromArray($validar);
                        $crearProd = $this->productoService->crearProducto($producto);

                        // Si se ha creado el producto, muestro un mensaje de éxito
                        if ($crearProd) {
                            $_SESSION['registro'] = [
                                'mensaje' => 'Producto creado correctamente',
                                'tipo' => 'exito'
                            ];

                            // Guardo la imagen en la carpeta media/img
                            if (isset($_FILES['data']['tmp_name']['imagen'])) {
                                $archivoTmp = $_FILES['data']['tmp_name']['imagen'];
                                $nombreArchivo = basename($_FILES['data']['name']['imagen']);
                                $ruta = __DIR__ . '/../../public/media/img/' . $nombreArchivo;

                                if (move_uploaded_file($archivoTmp, $ruta)) {
                                    $_SESSION['registro'] = [
                                        'mensaje' => 'Producto creado correctamente: Imagen guardada',
                                        'tipo' => 'exito'
                                    ];
                                } else {
                                    $_SESSION['registro'] = [
                                        'mensaje' => 'Producto creado correctamente: Error al guardar la imagen',
                                        'tipo' => 'fallo'
                                    ];
                                }
                            }
                                
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
            // Compruebo si el id del producto es válido
            if (isset($id)) {
                $eliminarProd = $this->productoService->eliminarProducto($id);
                
                // Si se ha eliminado el producto, muestro un mensaje de éxito
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
            // Compruebo si se ha enviado el formulario de actualización de producto por POST y si hay datos
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Valido los datos
                if ($_POST['data']) {
                    $datos = $_POST['data'];
                    $validar = $this->validarActualizarProducto($datos);

                    // Guardo la imagen antigua para borrarla
                    $imagenAntigua = $this->productoService->obtenerPorId($datos['id'])['imagen'];

                    // Si no hay errores, actualizo el producto
                    if ($validar) {
                        $resultado = $this->productoService->actualizarProducto($datos);

                        if ($resultado) {
                            $_SESSION['editar'] = [
                                'mensaje' => 'Producto actualizado correctamente',
                                'tipo' => 'exito'
                            ];

                            // Guardo la imagen en la carpeta media/img
                            if (isset($_FILES['data']['tmp_name']['imagen']) && !empty($_FILES['data']['tmp_name']['imagen'])) {
                                // Borro la imagen antigua
                                if (file_exists(__DIR__ . '/../../public/media/img/' . $imagenAntigua)) {
                                    unlink(__DIR__ . '/../../public/media/img/' . $imagenAntigua);
                                }
                                
                                $archivoTmp = $_FILES['data']['tmp_name']['imagen'];
                                $nombreArchivo = basename($_FILES['data']['name']['imagen']);
                                $ruta = __DIR__ . '/../../public/media/img/' . $nombreArchivo;

                                if (move_uploaded_file($archivoTmp, $ruta)) {
                                    $_SESSION['editar'] = [
                                        'mensaje' => 'Producto creado correctamente: Imagen guardada',
                                        'tipo' => 'exito'
                                    ];
                                } else {
                                    $_SESSION['editar'] = [
                                        'mensaje' => 'Producto creado correctamente: Error al guardar la imagen',
                                        'tipo' => 'fallo'
                                    ];
                                }
                            }

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

            // Compruebo si el id del producto es válido
            if (isset($id)) {
                $producto = $this->productoService->obtenerPorId($id);

                // Si el producto existe, muestro el formulario de actualización
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