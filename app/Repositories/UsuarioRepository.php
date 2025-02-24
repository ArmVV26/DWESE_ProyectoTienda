<?php
    // Defino el namespace
    namespace Repositories;

    // Importo las clases necesarias
    use Lib\Database;
    use Models\Usuario;
    use PDO;
    use PDOException;

    /**
     * Repositorio de Usuario
     * 1. Crear un nuevo usuario
     * 2. Iniciar sesión
     * 3. Mostrar los usuarios
     * 4. Eliminar un usuario
     * 5. Obtener un usuario por su id
     * 6. Actualizar un usuario
     */
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
         * @param array $usuario Los datos del usuario
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

                // Encripto la contraseña
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);

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
                $stmt->bindParam(':password', $hashPassword);
                $stmt->bindParam(':rol', $rol);

                $stmt->execute();

                // Tras insertar, recupero el id del último insertado y lo asigno al usuario
                $usuario->setId($this->database->ultimotId());

                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        /**
         * Método para iniciar sesión
         * 
         * @param array $usuario Los datos del usuario
         * @return array $usuario Si el email y la contraseña son correctas
         */
        public function iniciarSesion($usuario) {
            try {
                // Recojo los datos del usuario
                $email = $usuario->getEmail();
                $password = $usuario->getPassword();

                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    SELECT * 
                    FROM usuarios
                    WHERE email = :email
                ";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':email', $email);

                $stmt->execute();

                // Si el usuario existe, compruebo la contraseña
                if ($stmt->rowCount() !== 0) {
                    $data = $stmt->fetch(PDO::FETCH_ASSOC);
                    $passwordHash = $data['password'];  

                    // Si la contraseña es correcta, devuelvo el usuario
                    if (password_verify($password, $passwordHash)) {
                        return [
                            'id' => $data['id'],
                            'nombre' => $data['nombre'],
                            'rol' => $data['rol']
                        ];
                    } else {
                        return null;
                    }
                } else {
                    return null;
                }

            } catch (PDOException $e) {
                return null;
            }
        }

        /**
         * Método para mostrar los usuarios
         * 
         * @return array Devuelve un array con los usuarios
         */
        public function mostrarUsuarios() {
            try {
                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    SELECT * 
                    FROM usuarios
                ";
                $stmt = $conexion->prepare($sql);

                $stmt->execute();

                // Devuelvo los usuarios en un array
                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                return [];
            }
        }

        /**
         * Método para eliminar un usuario
         * 
         * @param int $id El id del usuario
         * @return bool True si se ha eliminado correctamente, false en caso contrario
         */
        public function eliminarUsuario($id) {
            try {
                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    DELETE FROM usuarios
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
         * Método para obtener un usuario por su id
         * 
         * @param int $id El id del usuario
         * @return array Devuelve un array con los datos del usuario
         */
        public function obtenerPorId($id) {
            try {
                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    SELECT * 
                    FROM usuarios
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
         * Método para acualizar un usuario
         * 
         * @param array $datos Los datos del usuario
         * @return bool True si se ha actualizado correctamente, false en caso contrario
         */
        public function acualizarUsuario($datos) {
            try {
                // Recojo los datos del usuario
                $usuario = $this->obtenerPorId($datos['id']);
                
                $id = $usuario['id'];
                $nombre = empty($datos['nombre']) ? $usuario['nombre'] : $datos['nombre'];
                $apellidos = empty($datos['apellidos']) ? $usuario['apellidos'] : $datos['apellidos'];
                $email = empty($datos['email']) ? $usuario['email'] : $datos['email'];
                $rol = empty($datos['rol']) ? $usuario['rol'] : $datos['rol'];

                if (empty($data['password'])) {
                    $password = $usuario['password'];
                } else {
                    $password = password_hash($datos['password'], PASSWORD_DEFAULT);
                }

                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();
                
                $sql = "
                    UPDATE usuarios
                    SET nombre = :nombre, apellidos = :apellidos, email = :email, password = :password, rol = :rol
                    WHERE id = :id
                ";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':apellidos', $apellidos);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':rol', $rol);
                $stmt->bindParam(':id', $id);

                $stmt->execute();

                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
    }