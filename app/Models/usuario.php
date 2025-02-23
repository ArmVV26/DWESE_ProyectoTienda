<?php
    // Defino el namespace
    namespace Models;

    /**
     * Clase Usuario
     */
    class Usuario {
        // Atributos
        private ?int $id = null;
        private string $nombre;
        private string $apellidos;
        private string $email;
        private string $password;
        private string $rol;

        // Constructor
        public function __construct(string $nombre, string $apellidos, string $email, string $password, string $rol) {
            $this->nombre = $nombre;
            $this->apellidos = $apellidos;
            $this->email = $email;
            $this->password = $password;
            $this->rol = $rol;
        }

        // Getters
        /**
         * Getter del id
         * 
         * @return int|null Devuelve el id del usuario
         */
        public function getId(): ?int {
            return $this->id;
        }

        /**
         * Getter del nombre
         * 
         * @return string Devuelve el nombre del usuario
         */
        public function getNombre(): string {
            return $this->nombre;
        }

        /**
         * Getter de los apellidos
         * 
         * @return string Devuelve los apellidos del usuario
         */
        public function getApellidos(): string {
            return $this->apellidos;
        }

        /**
         * Getter del email
         * 
         * @return string Devuelve el email del usuario
         */
        public function getEmail(): string {
            return $this->email;
        }

        /**
         * Getter de la contraseña
         * 
         * @return string Devuelve la contraseña del usuario
         */
        public function getPassword(): string {
            return $this->password;
        }

        /**
         * Getter del rol
         * 
         * @return string Devuelve el rol del usuario
         */
        public function getRol(): string {
            return $this->rol;
        }

        // Setters
        /**
         * Setter del id
         * 
         * @param int $id El id del usuario
         */
        public function setId(int $id): void {
            $this->id = $id;
        }

        /**
         * Setter del nombre
         * 
         * @param string $nombre El nombre del usuario
         */
        public function setNombre(string $nombre): void {
            $this->nombre = $nombre;
        }

        /**
         * Setter de los apellidos
         * 
         * @param string $apellidos Los apellidos del usuario
         */
        public function setApellidos(string $apellidos): void {
            $this->apellidos = $apellidos;
        }

        /**
         * Setter del email
         * 
         * @param string $email El email del usuario
         */
        public function setEmail(string $email): void {
            $this->email = $email;
        }

        /**
         * Setter de la contraseña
         * 
         * @param string $password La contraseña del usuario
         */
        public function setPassword(string $password): void {
            $this->password = $password;
        }

        /**
         * Setter del rol
         * 
         * @param string $rol El rol del usuario
         */
        public function setRol(string $rol): void {
            $this->rol = $rol;
        }

        /**
         * Método para convertir un array en una instancia Usuario
         * 
         * @param array $usuario El array con los datos del usuario
         * @return Usuario Una instancia de Usuario
         */
        public static function fromArray(array $usuario): self {
            return new self(
                $usuario['nombre'] ?? '',
                $usuario['apellidos'] ?? '',
                $usuario['email'],
                $usuario['password'],
                $usuario['rol'] ?? 'cliente'
            );
        }
    }
