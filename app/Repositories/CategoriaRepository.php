<?php
    // Defino el namespace
    namespace Repositories;

    // Importo las clases necesarias
    use Lib\Database;
    use Models\Categoria;
    use PDO;
    use PDOException;

    /**
     * Repositorio de Categoría
     * 1. Crear una nueva categoría
     * 2. Mostrar las categorías
     * 3. Eliminar una categoría
     */
    class CategoriaRepository {
        // Atributos
        private Database $database;

        // Constructor
        public function __construct() {
            $this->database = new Database();
        }

        // Métodos
        /**
         * Método para crear una categoría
         * 
         * @param Categoria $categoria Los datos de la categoría
         * @return bool True si se ha creado correctamente, false en caso contrario
         */
        public function crearCategoria($categoria) {
            try {
                // Recojo los datos de la categoría
                $nombre = $categoria->getNombre();

                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    INSERT INTO categorias (nombre)
                    VALUES (:nombre)
                ";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':nombre', $nombre);

                $stmt->execute();
                
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        /**
         * Método para mostrar las categorías
         * 
         * @return array Devuelve un array con las categorías
         */
        public function mostrarCategorias() {
            try {
                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    SELECT * 
                    FROM categorias
                ";
                $stmt = $conexion->prepare($sql);

                $stmt->execute();

                // Devuelvo los resultados en forma de array asociativo
                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                echo [];
            }
        }

        /**
         * Método para eliminar una categoría
         * 
         * @param int $id El id de la categoría
         * @return bool True si se ha eliminado correctamente, false en caso contrario
         */
        public function eliminarCategoria($id) {
            try {
                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    DELETE FROM categorias
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
    }
