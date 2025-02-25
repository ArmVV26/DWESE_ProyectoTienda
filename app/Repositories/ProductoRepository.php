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
         * Método para crear un producto
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

                // Recojo la conexión y preparo la consulta
                $conexion = $this->conexion->getConexion();

                $sql = "
                    INSERT INTO productos (nombre, descripcion, precio, stock, oferta, imagen, categoria_id)
                    VALUES (:nombre, :descripcion, :precio, :stock, :oferta, :imagen, :categoria_id)
                ";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':precio', $precio);
                $stmt->bindParam(':stock', $stock);
                $stmt->bindParam(':oferta', $oferta);
                $stmt->bindParam(':imagen', $imagen);
                $stmt->bindParam(':categoria_id', $categoria_id);

                $stmt->execute();
                
                return true; 
            } catch (PDOException $e) {
                return false;
            }
        }
    }