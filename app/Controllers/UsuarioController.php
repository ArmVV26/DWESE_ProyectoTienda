<?php
    // Defino el namespace
    namespace App\Controllers;

    // Importo las clases necesarias
    use Models\Usuario;
    use Services\UsuarioServices;

    // Defino la clase UsuarioController
    class UsuarioController {
        // Atributos
        private UsuarioServices $usuarioServices;
        private array $errores = [];

        // Constructor
        public function __construct() {
            $this->usuarioServices = new UsuarioServices();
        }

        /**
         * Método para mostrar el formulario de registro de usuarios 
         */
        public function formRegistro() {
            require_once __DIR__ . "/../Views/usuario/formularioRegistro.php";
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
         */
        public function registrar() {
            if ($_SERVER['REQUEST_METHOD'] === "POST") {

                if($_POST['data']) {
                    $validar = $this->validarRegistro($_POST['data']);

                    if (empty($this->errores) && !empty($validar)) {
                        $usuario = Usuario::fromArray($validar);
                        $crearUser = $this->usuarioServices->crearUser($usuario);

                        if ($crearUser) {
                            $_SESSION['registro'] = "Usuario registrado correctamente";

                        } else {
                            $_SESSION['registro'] = "Error al registrar el usuario";
                        }

                    } else {
                        $_SESSION['registro'] = "Error al registrar el usuario";
                        $_SESSION['errores'] = $this->errores;
                    }

                } else {
                    $_SESSION['registro'] = "Error al registrar el usuario";
                }
            }

            header('Location: index.php?controller=Usuario&action=formRegistro');
            exit();
        }
    }