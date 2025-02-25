<?php
    // Defino el namespace
    namespace Models;

    /**
     * Clase Producto
     */
    class Producto {
        // Atributos
        private ?int $id = null;
        private string $nombre;
        private string $descripcion;
        private float $precio;
        private int $stock;
        private string $oferta;
        private string $imagen;
        private int $categoria_id;

        // Constructor
        public function __construct(string $nombre, string $descripcion, float $precio, int $stock, string $oferta, string $imagen, int $categoria_id) {
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->precio = $precio;
            $this->stock = $stock;
            $this->oferta = $oferta;
            $this->imagen = $imagen;
            $this->categoria_id = $categoria_id;
        }

        // Getters
        /**
         * Getter del id
         * 
         * @return int|null Devuelve el id del producto
         */
        public function getId(): ?int {
            return $this->id;
        }

        /**
         * Getter del nombre
         * 
         * @return string Devuelve el nombre del producto
         */
        public function getNombre(): string {
            return $this->nombre;
        }

        /**
         * Getter de la descripción
         * 
         * @return string Devuelve la descripción del producto
         */
        public function getDescripcion(): string {
            return $this->descripcion;
        }

        /**
         * Getter del precio
         * 
         * @return float Devuelve el precio del producto
         */
        public function getPrecio(): float {
            return $this->precio;
        }

        /**
         * Getter del stock
         * 
         * @return int Devuelve el stock del producto
         */
        public function getStock(): int {
            return $this->stock;
        }

        /**
         * Getter de la oferta
         * 
         * @return string Devuelve la oferta del producto
         */
        public function getOferta(): string {
            return $this->oferta;
        }
        
        /**
         * Getter de la imagen
         * 
         * @return string Devuelve la imagen del producto
         */
        public function getImagen(): string {
            return $this->imagen;
        }

        /**
         * Getter de la categoría
         * 
         * @return int Devuelve la categoría del producto
         */
        public function getCategoriaId(): int {
            return $this->categoria_id;
        }

        // Setters
        /**
         * Setter del id
         * 
         * @param int $id El id del producto
         */
        public function setId(int $id): void {
            $this->id = $id;
        }

        /**
         * Setter del nombre
         * 
         * @param string $nombre El nombre del producto
         */
        public function setNombre(string $nombre): void {
            $this->nombre = $nombre;
        }

        /**
         * Setter de la descripción
         * 
         * @param string $descripcion La descripción del producto
         */
        public function setDescripcion(string $descripcion): void {
            $this->descripcion = $descripcion;
        }

        /**
         * Setter del precio
         * 
         * @param float $precio El precio del producto
         */
        public function setPrecio(float $precio): void {
            $this->precio = $precio;
        }

        /**
         * Setter del stock
         * 
         * @param int $stock El stock del producto
         */
        public function setStock(int $stock): void {
            $this->stock = $stock;
        }

        /**
         * Setter de la oferta
         * 
         * @param string $oferta La oferta del producto
         */
        public function setOferta(string $oferta): void {
            $this->oferta = $oferta;
        }

        /**
         * Setter de la imagen
         * 
         * @param string $imagen La imagen del producto
         */
        public function setImagen(string $imagen): void {
            $this->imagen = $imagen;
        }

        /**
         * Setter de la categoría
         * 
         * @param int $categoria_id La categoría del producto
         */
        public function setCategoriaId(int $categoria_id): void {
            $this->categoria_id = $categoria_id;
        }

        // Método
        /**
         * Método para convertir un array en un objeto Producto
         * 
         * @param array $producto El array con los datos del producto
         * @return Producto Una instancia de Producto
         */
        public static function fromArray(array $producto): Producto {
            $nuevoProducto = new Producto(
                $producto['nombre'],
                $producto['descripcion'],
                $producto['precio'],
                $producto['stock'],
                $producto['oferta'],
                $producto['imagen'],
                $producto['categoria_id']
            );
            
            return $nuevoProducto;
        }
    }