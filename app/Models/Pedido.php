<?php
    // Defino el namespace
    namespace Models;

    /**
     * Clase Pedido
     */
    class Pedido {
        // Atributos
        private ?int $id = null;
        private int $usuario_id;
        private string $provincia;
        private string $localidad;
        private string $direccion;
        private float $coste;
        private string $estado;
        private string $fecha;
        private string $hora;

        // Constructor
        public function __construct(int $usuario_id, string $provincia, string $localidad, string $direccion, float $coste, string $estado, string $fecha, string $hora) {
            $this->usuario_id = $usuario_id;
            $this->provincia = $provincia;
            $this->localidad = $localidad;
            $this->direccion = $direccion;
            $this->coste = $coste;
            $this->estado = $estado;
            $this->fecha = $fecha;
            $this->hora = $hora;
        }

        // Getters
        /**
         * Getter del id
         * 
         * @return int|null Devuelve el id del pedido
         */
        public function getId(): ?int {
            return $this->id;
        }
        
        /**
         * Getter del id del usuario
         * 
         * @return int Devuelve el id del usuario
         */
        public function getUsuarioId(): int {
            return $this->usuario_id;
        }

        /**
         * Getter de la provincia
         * 
         * @return string Devuelve la provincia del pedido
         */
        public function getProvincia(): string {
            return $this->provincia;
        }

        /**
         * Getter de la localidad
         * 
         * @return string Devuelve la localidad del pedido
         */
        public function getLocalidad(): string {
            return $this->localidad;
        }

        /**
         * Getter de la dirección
         * 
         * @return string Devuelve la dirección del pedido
         */
        public function getDireccion(): string {
            return $this->direccion;
        }

        /**
         * Getter del coste
         * 
         * @return float Devuelve el coste del pedido
         */
        public function getCoste(): float {
            return $this->coste;
        }

        /**
         * Getter del estado
         * 
         * @return string Devuelve el estado del pedido
         */
        public function getEstado(): string {
            return $this->estado;
        }

        /**
         * Getter de la fecha
         * 
         * @return string Devuelve la fecha del pedido
         */
        public function getFecha(): string {
            return $this->fecha;
        }

        /**
         * Getter de la hora
         * 
         * @return string Devuelve la hora del pedido
         */
        public function getHora(): string {
            return $this->hora;
        }

        // Setters
        /**
         * Setter del id
         * 
         * @param int $id El id del pedido
         */
        public function setId(int $id): void {
            $this->id = $id;
        }

        /**
         * Setter del id del usuario
         * 
         * @param int $usuario_id El id del usuario
         */
        public function setUsuarioId(int $usuario_id): void {
            $this->usuario_id = $usuario_id;
        }

        /**
         * Setter de la provincia
         * 
         * @param string $provincia La provincia del pedido
         */
        public function setProvincia(string $provincia): void {
            $this->provincia = $provincia;
        }

        /**
         * Setter de la localidad
         * 
         * @param string $localidad La localidad del pedido
         */
        public function setLocalidad(string $localidad): void {
            $this->localidad = $localidad;
        }

        /**
         * Setter de la dirección
         * 
         * @param string $direccion La dirección del pedido
         */
        public function setDireccion(string $direccion): void {
            $this->direccion = $direccion;
        }

        /**
         * Setter del coste
         * 
         * @param float $coste El coste del pedido
         */
        public function setCoste(float $coste): void {
            $this->coste = $coste;
        }

        /**
         * Setter del estado
         * 
         * @param string $estado El estado del pedido
         */
        public function setEstado(string $estado): void {
            $this->estado = $estado;
        }

        /**
         * Setter de la fecha
         * 
         * @param string $fecha La fecha del pedido
         */
        public function setFecha(string $fecha): void {
            $this->fecha = $fecha;
        }

        /**
         * Setter de la hora
         * 
         * @param string $hora La hora del pedido
         */
        public function setHora(string $hora): void {
            $this->hora = $hora;
        }
    }