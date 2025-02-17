<?php
    // Defino el namespace
    namespace Repositories;

    // Importo las clases necesarias
    use Lib\Database;
    use PDO;
    use PDOException;

    // Defino la clase UsuarioRepository
    class UsuarioRepository {
        // Atributos
        private Database $database;

        // Constructor
        public function __construct() {
            $this->database = new Database();
        }

        // Métodos
        /**
         * Método para crear un nuevo usuario
         * 
         * @param array $datos Los datos del usuario
         * @return bool True si se ha creado correctamente, false en caso contrario
         */
        public function crearUser($usuario) {
            try {
                // Recojo los datos del usuario
                $nombre = $usuario->getNombre();
                $apellidos = $usuario->getApellidos();
                $email = $usuario->getEmail();
                $password = $usuario->getPassword();
                $rol = $usuario->getRol();

                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    INSERT INTO usuarios (nombre, apellidos, email, password, rol)
                    VALUES (:nombre, :apellidos, :email, :password, :rol)
                ";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':apellidos', $apellidos);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':rol', $rol);

                $stmt->execute();

                // Tras insertar, recupero el id del último insertado y lo asigno al usuario
                // $usuario->setId($this->database->ultimotId());

                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
    }