<?php
    // Defino el namespace
    namespace Controllers;

    // Importo las clases necesarias
    use Models\Usuario;
    use Services\UsuarioServices;   

    // Importo la función para renderizar la vista
    require_once __DIR__ . '/../../config/render.php';

    /**
     * Controlador de Usuario
     * 1. Validar los datos del formulario de registro
     * 2. Registrar un usuario en la base de datos
     * 3. Validar los datos del formulario de inicio de sesión
     * 4. Iniciar sesión en la aplicación
     * 5. Cerrar la sesión
     * 6. Mostrar los usuarios
     * 7. Eliminar un usuario
     * 8. Validar los datos del formulario de actualización
     * 9. Actualizar/editar un usuario
     */
    class UsuarioController {
        // Atributos
        private UsuarioServices $usuarioServices;
        private array $errores = [];

        // Constructor
        public function __construct() {
            $this->usuarioServices = new UsuarioServices();
        }
        
        // Métodos
        /**
         * Método para validar los datos del formulario de registro
         * 
         * @param array $usuario Los datos del usuario
         * @return array Devuelve los datos del usuario saneados o un array con los errores
         */
        private function validarRegistro($usuario) {
            // Recojo y limpio los datos
            $nombre = trim($usuario['nombre']) ?? '';
            $apellidos = trim($usuario['apellidos']) ?? '';
            $email = trim($usuario['email']) ?? '';
            $password = trim($usuario['password']) ?? '';

            // Validación para el nombre
            if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/', $nombre)) {
                $this->errores[] = "El nombre solo puede contener letras y sin espacios";
            }
    
            // Validación para los apellidos
            if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $apellidos)) {
                $this->errores[] = "Los apellidos solo pueden contener letras y espacios";
            }
    
            // Validación para el email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->errores[] = "El email no es válido";
            }
    
            // Validación para la contraseña
            if (strpos($password, ' ') !== false || strlen($password) < 5) {
                $this->errores[] = "La contraseña no puede contener espacios y debe tener al menos 5 caracteres";
            }

            if (empty($this->errores)) {
                return [
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'email' => $email,
                    'password' => $password
                ];
            } else {
                return $this->errores;
            }
        }

        /**
         * Método para registrar un usuario en la base de datos
         * Se comprueba que los datos se reciben con POST, 
         * si hay datos, se validan y se crea el usuario.
         * 
         * @return void
         */
        public function registrar() {
            // Verifico si se ha enviado el formulario de registro por POST y si se han recibido los datos
            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                // Valido los datos
                if ($_POST['data']) {
                    $validar = $this->validarRegistro($_POST['data']);

                    // Si no hay errores y los datos son válidos, creo el usuario
                    if (empty($this->errores) && !empty($validar)) {
                        $usuario = Usuario::fromArray($_POST['data']);
                        $crearUser = $this->usuarioServices->crearUser($usuario);

                        // Si se ha creado el usuario, muestro un mensaje de éxito
                        if ($crearUser) {
                            $_SESSION['registro'] = [
                                'mensaje' => "Registro Exitoso",
                                'tipo' => 'exito'
                            ];
                            // Renderizo la vista del formulario de inicio de sesión
                            render('../Views/usuario/registroExitoso', ['titulo' => 'Registro Exitoso']);
                            exit();

                        // Si no se ha creado el usuario, muestro un mensaje de error
                        } else {
                            $_SESSION['registro'] = [
                                'mensaje' => "Error al registrar el usuario.",
                                'tipo' => 'fallo'
                            ];
                        }

                    // Si hay errores, muestro un mensaje de error
                    } else {
                        $_SESSION['registro'] = [
                            'mensaje' => "Error al registrar el usuario:",
                            'tipo' => 'fallo'
                        ];
                        $_SESSION['errores'] = $this->errores;
                    }

                // Si no se han recibido los datos, muestro un mensaje de error
                } else {
                    $_SESSION['registro'] = [
                        'mensaje' => "Error al registrar el usuario.",
                        'tipo' => 'fallo'
                    ];
                }
            }

            // Renderizo la vista del formulario de registro
            render('../Views/usuario/formularioRegistro', ['titulo' => 'Formulario de Registro']);
            exit();
        }


        /**
         * Método para validar los datos del formulario de inicio de sesión
         * 
         * @param array $usuario Los datos del usuario
         * @return array Devuelve los datos del usuario saneados o un array con los errores
         */
        private function validarInicioSesion($usuario) {
            $email = trim($usuario['email']) ?? '';
            $password = trim($usuario['password']) ?? '';

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->errores[] = "El email no es válido";
            }
    
            if (strpos($password, ' ') !== false || strlen($password) < 5) {
                $this->errores[] = "La contraseña no puede contener espacios y debe tener al menos 5 caracteres";
            }

            if (empty($this->errores)) {
                return [
                    'email' => $email,
                    'password' => $password
                ];
            } else {
                return $this->errores;
            }
        }

        /**
         * Método para iniciar sesión en la aplicación
         * Se comprueba que los datos se reciben con POST,
         * si hay datos, se validan y se inicia sesión.
         * 
         * @return void
         */
        public function login() {
            if ($_SERVER['REQUEST_METHOD'] === "POST") {

                if ($_POST['data']) {
                    $validar = $this->validarInicioSesion($_POST['data']);

                    if (empty($this->errores) && !empty($validar)) {
                        $usuario = Usuario::fromArray($validar);
                        $usuarioValido = $this->usuarioServices->iniciarSesion($usuario);

                        if ($usuarioValido) {
                            $_SESSION['inicioSesion'] = $usuarioValido;
                            header('Location: '. URL_BASE);
                            exit();
                        } else {
                            $_SESSION['login'] = [
                                'mensaje' => "Error al iniciar sesión. Opcion 1",
                                'tipo' => 'fallo'
                            ];
                        }
                    } else {
                        $_SESSION['login'] = [
                            'mensaje' => "Error al iniciar sesión:",
                            'tipo' => 'fallo'
                        ];
                        $_SESSION['errores'] = $this->errores;
                    }
                } else {
                    $_SESSION['login'] = [
                        'mensaje' => "Error al iniciar sesión. Opcion 2",
                        'tipo' => 'fallo'
                    ];
                }
            }

            render('../Views/usuario/formularioLogin', ['titulo' => 'Inicio de Sesión']);
            exit();
        }

        /**
         * Método para cerrar la sesión
         * 
         * @return void
         */
        public function cerrarSesion() {
            // Cierro la sesión
            unset($_SESSION['inicioSesion']);
            header('Location: '. URL_BASE);
            exit();
        }

        /**
         * Método para mostrar los usuarios
         * 
         * @return void
         */
        public function mostrarUsuarios() {
            $usuarios = $this->usuarioServices->mostrarUsuarios();
            render('../Views/admin/mostrarUsuarios', ['titulo' => 'Mostrar Usuarios', 'usuarios' => $usuarios]);
            exit();
        }

        /**
         * Método para eliminar un usuario
         * 
         * @return void
         */
        public function eliminarUsuario() {
            // Compruebo si se ha recibido el id del usuario
            if (isset($_GET['id'])) {
                // Recojo el id del usuario y lo elimino
                $id = $_GET['id'];
                $eliminar = $this->usuarioServices->eliminarUsuario($id);

                // Muestro un mensaje de éxito o error al eliminar el usuario
                if ($eliminar) {
                    $_SESSION['eliminar'] = "Usuario eliminado correctamente.";
                } else {
                    $_SESSION['eliminar'] = "Error al eliminar el usuario.";
                }
            } else {
                $_SESSION['eliminar'] = "Error al eliminar el usuario.";
            }

            // Redirijo a la vista de mostrar usuarios
            $this->mostrarUsuarios();
        }

        /**
         * Método para validar los datos del formulario de actualización
         * 
         * @param array $usuario Los datos del usuario
         * @return bool True si los datos son válidos, false en caso contrario
         */
        private function validarActualizar($usuario) {
            $nombre = trim($usuario['nombre']) ?? '';
            $apellidos = trim($usuario['apellidos']) ?? '';
            $email = trim($usuario['email']) ?? '';
            $password = trim($usuario['password']) ?? '';

            $error = false;

            if (isset($nombre) && $nombre !== '') {
                if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/', $nombre)) {
                    $error = true;
                }
            }

            if (isset($apellidos) && $apellidos !== '') {
                if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $apellidos)) {
                    $error = true;
                }
            }

            if (isset($email) && $email !== '') {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = true;
                }
            }

            if (isset($password) && $password !== '') {
                if (strpos($password, ' ') !== false || strlen($password) < 5) {
                    $error = true;
                }
            }

            return !$error;
        }

        /**
         * Método para actualizar/editar un usuario
         * 
         * @return void
         */
        public function actualizarUsuario() {
            if ($_SERVER['REQUEST_METHOD'] === "POST") {

                if (isset($_POST['data'])) {
                    $datos = $_POST['data'];
                    $validar = $this->validarActualizar($datos);

                    if ($validar) {
                        $resultado = $this->usuarioServices->acualizarUsuario($datos);

                        if ($resultado) {
                            $_SESSION['editar'] = [
                                'mensaje' => "Usuario actualizado correctamente.",
                                'tipo' => 'exito'
                            ];

                            // Actualizo los datos de la sesión si el usuario actualizado es el mismo que el que ha iniciado sesión
                            if ($_SESSION['inicioSesion']['id'] === $datos['id']) {
                                unset($_SESSION['inicioSesion']);
                                $_SESSION['inicioSesion'] = [
                                    'id' => $datos['id'],
                                    'nombre' => $datos['nombre'],
                                    'rol' => $datos['rol']
                                ];
                            }
                        } else {
                            $_SESSION['editar'] = [
                                'mensaje' => "Error al actualizar el usuario.",
                                'tipo' => 'fallo'
                            ];
                        }
                    } else {
                        $_SESSION['editar'] = [
                            'mensaje' => "Error al actualizar el usuario.",
                            'tipo' => 'fallo'
                        ];
                    }
                } else {
                    $_SESSION['editar'] = [
                        'mensaje' => "Error al actualizar el usuario.",
                        'tipo' => 'fallo'
                    ];
                }
            }
            
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $usuario = $this->usuarioServices->obtenerPorId($id);

                if($usuario) {
                    render('../Views/usuario/actualizarUsuario', ['titulo' => 'Editar Usuario', 'usuario' => $usuario]);

                } else {
                    $_SESSION['editar'] = [
                        'mensaje' => "Error al editar el usuario.",
                        'tipo' => 'fallo'
                    ];
                }
            } else {
                $_SESSION['editar'] = [
                    'mensaje' => "Error al editar el usuario.",
                    'tipo' => 'fallo'
                ];
            }
        }
    }