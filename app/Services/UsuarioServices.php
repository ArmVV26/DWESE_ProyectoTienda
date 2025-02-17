<?php 
    // Defino el namespace
    namespace Services;

    // Importo las clases necesarias
    use Repositories\UsuarioRepository;

    // Defino la clase UsuarioServices
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
         * @param array $datos Los datos del usuario
         * @return bool True si se ha creado correctamente, false en caso contrario
         */
        public function crearUser($usuario) {
            return $this->usuarioRepository->crearUser($usuario);
        }
    }