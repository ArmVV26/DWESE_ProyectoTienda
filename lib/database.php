<?php
    // Defino el namespace
    namespace Lib;

    // Importo las clases necesarias
    use PDO;
    use PDOException;

    // Defino la clase Database
    class Database {
        // Atributos
        private ?PDO $conexion = null;
        private ?PDOStatement $resultado = null;

        // Constructor
        public function __construct () {
            $host = $_ENV['DB_HOST'];
            $dbname = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASS'];
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

            try {
                $this->conexion = new PDO($dsn, $user, $pass);
                $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
            }
        }

        /**
         * Método para obtener la conexión 
         * 
         * @return PDO|null Devuelve la conexión o null si no se ha podido establecer
         */
        public function getConexion(): ?PDO {
            return $this->conexion;
        }

        /**
         * Método para obtener el último id insertado
         * 
         * @return int El último id insertado
         */
        public function ultimotId(): int {
            return $this->conexion->lastInsertId();
        }
    }