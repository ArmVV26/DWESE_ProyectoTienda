<?php
    // Defino el namespace
    namespace Repositories;

    // Importo las clases necesarias
    use Lib\Database;
    use Models\Producto;
    use PDO;
    use PDOException;

    /**
     * Repositorio de Producto
     * 1. Crear un producto
     * 2. Eliminar un producto
     * 3. Obtener un producto por su id
     * 4. Actualizar un producto
     * 5. Obtener todos los productos
     * 6. Obtener productos por su categoria
     * 7. Decrementar el stock de un producto
     */
    class ProductoRepository {
        // Atributos
        private Database $database;

        // Constructor
        public function __construct() {
            $this->database = new Database();
        }

        // Métodos
        /**
         * Método para crear/guardar un producto
         * 
         * @param Producto $producto El producto a crear
         * @return bool True si se ha creado correctamente, false en caso contrario
         */
        public function crearProducto(Producto $producto) {
            try {
                // Recojo los datos del producto
                $nombre = $producto->getNombre();
                $descripcion = $producto->getDescripcion();
                $precio = $producto->getPrecio();
                $stock = $producto->getStock();
                $oferta = $producto->getOferta();
                $imagen = $producto->getImagen();
                $categoria_id = $producto->getCategoriaId();
                $fecha = date('Y-m-d');

                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    INSERT INTO productos (nombre, descripcion, precio, stock, oferta, imagen, categoria_id, fecha)
                    VALUES (:nombre, :descripcion, :precio, :stock, :oferta, :imagen, :categoria_id, :fecha)
                ";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':precio', $precio);
                $stmt->bindParam(':stock', $stock);
                $stmt->bindParam(':oferta', $oferta);
                $stmt->bindParam(':imagen', $imagen);
                $stmt->bindParam(':categoria_id', $categoria_id);
                $stmt->bindParam(':fecha', $fecha);

                $stmt->execute();
                
                return true; 
            } catch (PDOException $e) {
                return false;
            }
        }

        /**
         * Método para eliminar un producto
         * 
         * @param int $id El id del producto
         * @return bool True si se ha eliminado correctamente, false en caso contrario
         */
        public function eliminarProducto($id) {
            try {
                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    DELETE FROM productos
                    WHERE id = :id
                ";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':id', $id);

                $stmt->execute();

                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        /**
         * Método para obtener un producto por su id
         * 
         * @param int $id El id del producto
         * @return array Devuelve un array con los datos del producto
         */
        public function obtenerPorId($id) {
            try {
                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    SELECT * 
                    FROM productos 
                    WHERE id = :id
                ";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return [];
            }
        }

        /**
         * Método para actualizar un producto
         * 
         * @param array $datos Los datos del producto
         * @return bool True si se ha actualizado correctamente, false en caso contrario
         */
        public function actualizarProducto($datos) {
            try {
                // Recojo los datos del producto
                $producto = $this->obtenerPorId($datos['id']);

                $id = $producto['id'];
                $nombre = empty($datos['nombre']) ? $producto['nombre'] : $datos['nombre'];
                $descripcion = empty($datos['descripcion']) ? $producto['descripcion'] : $datos['descripcion'];
                $precio = empty($datos['precio']) ? $producto['precio'] : $datos['precio'];
                $stock = empty($datos['stock']) ? $producto['stock'] : $datos['stock'];
                $oferta = empty($datos['oferta']) ? $producto['oferta'] : $datos['oferta'];
                $imagen = empty($_FILES['data']['name']['imagen']) ? $producto['imagen'] : $_FILES['data']['name']['imagen'];
                $categoria_id = empty($datos['categoria_id']) ? $producto['categoria_id'] : $datos['categoria_id'];
                $fecha = date('Y-m-d');

                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    UPDATE productos 
                    SET nombre = :nombre, descripcion = :descripcion, precio = :precio, stock = :stock, oferta = :oferta, imagen = :imagen, categoria_id = :categoria_id, fecha = :fecha
                    WHERE id = :id  
                ";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':precio', $precio);
                $stmt->bindParam(':stock', $stock);
                $stmt->bindParam(':oferta', $oferta);
                $stmt->bindParam(':imagen', $imagen);
                $stmt->bindParam(':categoria_id', $categoria_id);
                $stmt->bindParam(':fecha', $fecha);

                $stmt->execute();

                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        /**
         * Método para obtener todos los productos
         * 
         * @return array Devuelve un array con todos los productos
         */
        public function obtenerProductosTodos() {
            try {
                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    SELECT * 
                    FROM productos
                    ORDER BY id ASC
                ";
                $stmt = $conexion->prepare($sql);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return [];
            }
        }

        /**
         * Método para obtener productos por su categoria
         * 
         * @param int $id El id del producto
         * @return array Devuelve un array con todos los productos de la categoria indicada
         */
        public function obtenerProductosCategoria($categoria_id) {
            try {
                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    SELECT * 
                    FROM productos 
                    WHERE categoria_id = :categoria_id
                    ORDER BY id ASC
                ";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':categoria_id', $categoria_id);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return [];
            }
        }

        /**
         * Método para decrementar el stock de un producto cuando se realiza un pedido
         * 
         * @param int $id El id del producto
         * @param int $cantidad La cantidad de productos a decrementar
         * @return bool True si se ha actualizado correctamente, false en caso contrario
         */
        public function decrementarStock($id, $cantidad) {
            try {
                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    UPDATE productos 
                    SET stock = stock - :cantidad
                    WHERE id = :id AND stock >= :cantidad
                ";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':cantidad', $cantidad);

                $stmt->execute();

                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
    }