<?php 
    // Defino el namespace
    namespace Services;

    // Importo las clases necesarias
    use Repositories\UsuarioRepository;

    /**
     * Servicios de Usuario
     * 1. Crear un nuevo usuario
     * 2. Iniciar sesión
     */
    class UsuarioServices {
        // Atributos
        private UsuarioRepository $usuarioRepository;

        // Constructor
        public function __construct() {
            $this->usuarioRepository = new UsuarioRepository();
        }

        // Métodos
        /**
         * Método para crear un nuevo usuario
         * 
         * @param array $usuario Los datos del usuario
         * @return bool True si se ha creado correctamente, false en caso contrario
         */
        public function crearUser($usuario) {
            return $this->usuarioRepository->crearUser($usuario);
        }

        /**
         * Método para iniciar sesión
         * 
         * @param string $usuario Los datos del usuario
         * @return bool True si se ha iniciado sesión correctamente, false en caso contrario
         */
        public function iniciarSesion($usuario) {
            return $this->usuarioRepository->iniciarSesion($usuario);
        }

        /**
         * Método para mostrar los usuarios
         * 
         * @return array Devuelve un array con los usuarios
         */
        public function mostrarUsuarios() {
            return $this->usuarioRepository->mostrarUsuarios();
        }

        /**
         * Método para eliminar un usuario
         * 
         * @param int $id El id del usuario
         * @return bool True si se ha eliminado correctamente, false en caso contrario
         */
        public function eliminarUsuario($id) {
            return $this->usuarioRepository->eliminarUsuario($id);
        }
    }