<?php
    // Defino el namespace
    namespace App\Controllers;

    // Importo las clases necesarias
    use Lib\Database;

    // Defino la clase UsuarioController
    class UsuarioController {

        // Método para mostrar el formulario de registro
        public function formRegistro() {
            require_once __DIR__ . "/../Views/usuario/formularioRegistro.php";
        }

        // Método para procesar el registro de un usuario
        public function registrar() {
            
            // Verfico que la sesisón esté iniciada
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // Recojo y limpio los datos
            $nombre = trim($_POST['nombre']) ?? '';
            $apellidos = trim($_POST['apellidos']) ?? '';
            $email = trim($_POST['email']) ?? '';
            $password = trim($_POST['password']) ?? '';
            $rol = trim($_POST['rol']) ?? 'cliente';

            $errores = [];

            // Validación para el nombre
            if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/', $nombre)) {
                $errores[] = "El nombre solo puede contener letras y sin espacios";
            }

            // Validación para los apellidos
            if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $apellidos)) {
                $errores[] = "Los apellidos solo pueden contener letras y espacios";
            }

            // Validación para el email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errores[] = "El email no es válido";
            }

            // Validación para la contraseña
            if (strpos($password, ' ') !== false || strlen($password) < 5) {
                $errores[] = "La contraseña no puede contener espacios y debe tener al menos 5 caracteres";
            }

            // Si hay errores, se almacenan los errores en una sesión y se redirige al formulario
            if (!empty($errores)) {
                $_SESSION['errores'] = $errores;
                header('Location: index.php?controller=Usuario&action=formRegistro');
                exit();
            }

            // Si la validación es correcta, se procede a registrar al usuario en la base de datos
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            try {
                $db = new Database();
                $conexion = $db->getConexion();

                $sql = "INSERT INTO usuarios (nombre, apellidos, email, password, rol) 
                        VALUES (:nombre, :apellidos, :email, :password, :rol)";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':apellidos', $apellidos);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashPassword);
                $stmt->bindParam(':rol', $rol);

                $stmt->execute();

                $_SESSION['registro'] = "Usuario registrado correctamente";
                
            } catch (PDOException $e) {
                echo "Error al registrar el usuario: " . $e->getMessage();
            }

            header('Location: index.php?controller=Usuario&action=formRegistro');
            exit();
        }
    }