<?php
    // Defino el namespace
    namespace App\Controllers;

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
     */
    class UsuarioController {
        // Atributos
        private UsuarioServices $usuarioServices;
        private array $errores = [];

        // Constructor
        public function __construct() {
            $this->usuarioServices = new UsuarioServices();
        }
        
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
            if ($_SERVER['REQUEST_METHOD'] === "POST") {

                if ($_POST['data']) {
                    $validar = $this->validarRegistro($_POST['data']);

                    if (empty($this->errores) && !empty($validar)) {
                        $usuario = Usuario::fromArray($_POST['data']);
                        $crearUser = $this->usuarioServices->crearUser($usuario);

                        if ($crearUser) {
                            $_SESSION['registro'] = [
                                'mensaje' => "Usuario registrado correctamente.",
                                'tipo' => 'exito'
                            ];

                        } else {
                            $_SESSION['registro'] = [
                                'mensaje' => "Error al registrar el usuario.",
                                'tipo' => 'fallo'
                            ];
                        }

                    } else {
                        $_SESSION['registro'] = [
                            'mensaje' => "Error al registrar el usuario:",
                            'tipo' => 'fallo'
                        ];
                        $_SESSION['errores'] = $this->errores;
                    }

                } else {
                    $_SESSION['registro'] = [
                        'mensaje' => "Error al registrar el usuario.",
                        'tipo' => 'fallo'
                    ];
                }
            }

            render('../Views/usuario/formularioRegistro', ['titulo' => 'Registro de Usuario']);
            exit();
        }


        /**
         * Método para validar los datos del formulario de inicio de sesión
         * 
         * @param array $usuario Los datos del usuario
         * @return array Devuelve los datos del usuario saneados o un array con los errores
         */
        public function validarInicioSesion($usuario) {
            // Recojo y limpio los datos
            $email = trim($usuario['email']) ?? '';
            $password = trim($usuario['password']) ?? '';

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
                                'mensaje' => "Error al iniciar sesión.",
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
                        'mensaje' => "Error al iniciar sesión.",
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

        public function eliminarUsuario() {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $eliminar = $this->usuarioServices->eliminarUsuario($id);

                if ($eliminar) {
                    $_SESSION['eliminar'] = "Usuario eliminado correctamente.";
                } else {
                    $_SESSION['eliminar'] = "Error al eliminar el usuario.";
                }
            } else {
                $_SESSION['eliminar'] = "Error al eliminar el usuario.";
            }

            $this->mostrarUsuarios();
        }
    }