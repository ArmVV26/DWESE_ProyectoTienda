<?php
    // Defino el namespace
    namespace Models;

    /**
     * Clase Categoria
     */
    class Categoria {
        // Atributos
        private ?int $id = null;
        private string $nombre;

        // Constructor
        public function __construct(string $nombre) {
            $this->nombre = $nombre;
        }

        // Getters
        /**
         * Getter del id
         * 
         * @return int|null Devuelve el id de la categoría
         */
        public function getId(): ?int {
            return $this->id;
        }

        /**
         * Getter del nombre
         * 
         * @return string Devuelve el nombre de la categoría
         */
        public function getNombre(): string {
            return $this->nombre;
        }

        // Setters
        /**
         * Setter del id
         * 
         * @param int $id El id de la categoría
         */
        public function setId(int $id): void {
            $this->id = $id;
        }

        /**
         * Setter del nombre
         * 
         * @param string $nombre El nombre de la categoría
         */
        public function setNombre(string $nombre): void {
            $this->nombre = $nombre;
        }
    }