<?php
    // Defino el namespace
    namespace Controllers;

    // Importo las clases necesarias
    use Models\Usuario;
    use Services\UsuarioServices;   
    use Services\PedidoServices;

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
     * 10. Mostrar el perfil de un usuario
     */
    class UsuarioController {
        // Atributos
        private UsuarioServices $usuarioServices;
        private PedidoServices $pedidoServices;
        private array $errores = [];

        // Constructor
        public function __construct() {
            $this->usuarioServices = new UsuarioServices();
            $this->pedidoServices = new PedidoServices();
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
                                'mensaje' => "Error al registrar el usuario: Email ya registrado",
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
                        'mensaje' => "Error al registrar el usuario: Datos no recibidos",
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
            // Recojo y limpio los datos
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
            // Verifico si se ha enviado el formulario de inicio de sesión por POST y si se han recibido los datos
            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                // Valido los datos
                if ($_POST['data']) {
                    $validar = $this->validarInicioSesion($_POST['data']);

                    // Si no hay errores y los datos son válidos, inicio sesión
                    if (empty($this->errores) && !empty($validar)) {
                        $usuario = Usuario::fromArray($validar);
                        $usuarioValido = $this->usuarioServices->iniciarSesion($usuario);

                        // Si el usuario es válido, inicio sesión y redirijo a la página principal
                        if ($usuarioValido) {
                            // Guardo los datos del usuario en la sesión
                            $_SESSION['inicioSesion'] = $usuarioValido;

                            // Si el usuario ha marcado la casilla de recordar, se crea una cookie
                            if (isset($_POST['data']['recordar'])) {
                                setcookie('recordar', $usuarioValido['id'], time() + (7 * 24 * 60 * 60), '/');
                            }

                            header('Location: '. URL_BASE);
                            exit();
                        } else {
                            $_SESSION['login'] = [
                                'mensaje' => "Error al iniciar sesión: Usuario o contraseña incorrectos",
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
                        'mensaje' => "Error al iniciar sesión: Datos no recibidos",
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
            // Vacío el carrito
            unset($_SESSION['carrito']);
            // Borro la cookie
            setcookie('recordar', '', time() - 3600, "/");

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
         * @param int|null $id El id del usuario
         * @return void
         */
        public function eliminarUsuario($id = null) {
            // Compruebo si se ha recibido el id del usuario
            if (isset($id)) {
                // Recojo el id del usuario y lo elimino
                $eliminar = $this->usuarioServices->eliminarUsuario($id);

                // Muestro un mensaje de éxito o error al eliminar el usuario
                if ($eliminar) {
                    $_SESSION['eliminar'] = [
                        'mensaje' => "Usuario eliminado correctamente",
                        'tipo' => 'exito'
                    ];
                } else {
                    $_SESSION['eliminar'] = [
                        'mensaje' => "Error al eliminar el usuario: El usuario no existe",
                        'tipo' => 'fallo'
                    ];
                }
            } else {
                $_SESSION['eliminar'] = [
                    'mensaje' => "Error al eliminar el usuario: Datos incorrectos",
                    'tipo' => 'fallo'
                ];
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
         * @param int|null $id El id del usuario
         * @return void
         */
        public function actualizarUsuario($id = null) {
            // Compruebo si el formulario se ha enviado por POST y si se han recibido los datos
            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                // Valido los datos
                if (isset($_POST['data'])) {
                    $datos = $_POST['data'];
                    $validar = $this->validarActualizar($datos);

                    // Si los datos son válidos, actualizo el usuario
                    if ($validar) {
                        $resultado = $this->usuarioServices->acualizarUsuario($datos);

                        // Muestro un mensaje de éxito o error al actualizar el usuario
                        if ($resultado) {
                            $_SESSION['editar'] = [
                                'mensaje' => "Usuario actualizado correctamente.",
                                'tipo' => 'exito'
                            ];

                            // Actualizo los datos de la sesión si el usuario actualizado es el mismo que el que ha iniciado sesión
                            if ($_SESSION['inicioSesion']['id'] == $datos['id']) {
                                
                                // Actualizo el nombre si se ha modificado el nombre
                                if (!empty($datos['nombre']) && $_SESSION['inicioSesion']['nombre'] !== $datos['nombre']) {
                                    $_SESSION['inicioSesion']['nombre'] = $datos['nombre'];
                                }

                                // Actualizo el email, el rol y la contraseña si se han modificado
                                if ((!empty($datos['email']) && $_SESSION['inicioSesion']['email'] !== $datos['email']) ||
                                    (!empty($datos['rol']) && $_SESSION['inicioSesion']['rol'] !== $datos['rol']) ||
                                    !empty($datos['password']))  {

                                    // Cierro la sesión
                                    unset($_SESSION['inicioSesion']);

                                    $_SESSION['login'] = [
                                        'mensaje' => "Por favor, inicie sesión de nuevo",
                                        'tipo' => 'exito'
                                    ];
                                    header('Location: '. URL_BASE . 'usuario/formularioLogin');
                                    exit();
                                }
                            }
                        } else {
                            $_SESSION['editar'] = [
                                'mensaje' => "Error al actualizar el usuario: El usuario no existe",
                                'tipo' => 'fallo'
                            ];
                        }
                    } else {
                        $_SESSION['editar'] = [
                            'mensaje' => "Error al actualizar el usuario: Datos incorrectos",
                            'tipo' => 'fallo'
                        ];
                    }
                } else {
                    $_SESSION['editar'] = [
                        'mensaje' => "Error al actualizar el usuario: Datos no recibidos",
                        'tipo' => 'fallo'
                    ];
                }
            }
            
            // Compruebo si se ha recibido el id del usuario
            if (isset($id)) {
                $usuario = $this->usuarioServices->obtenerPorId($id);

                // Renderizo la vista de editar usuario
                if($usuario) {
                    render('../Views/usuario/actualizarUsuario', ['titulo' => 'Editar Usuario', 'usuario' => $usuario]);
                    exit();
                } else {
                    $_SESSION['editar'] = [
                        'mensaje' => "Error al editar el usuario: El usuario no existe",
                        'tipo' => 'fallo'
                    ];
                }
            } else {
                $_SESSION['editar'] = [
                    'mensaje' => "Error al editar el usuario: Datos incorrectos",
                    'tipo' => 'fallo'
                ];
            }
        }

        /**
         * Método para mostrar el perfil de un usuario
         * 
         * @return void
         */
        public function perfilUsuario() {
            // Compruebo si la sesion está iniciada y si el usuario es un usuario registrado
            if (isset($_SESSION['inicioSesion'])) {
                $usuario = $this->usuarioServices->obtenerPorId($_SESSION['inicioSesion']['id']);
                $pedidos = $this->pedidoServices->obtenerPedidosUsuario($_SESSION['inicioSesion']['id']);

                render('usuario/perfilUsuario', [
                    'titulo' => 'Perfil Usuario', 
                    'usuario' => $usuario,
                    'pedidos' => $pedidos]
                );
                exit();
            }
        }
    }