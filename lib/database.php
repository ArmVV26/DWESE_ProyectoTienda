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
            $password = $_ENV['DB_PASSWORD'];
            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

            try {
                $this->conexion = new PDO($dsn, $user, $password);
                $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
            }
        }

        // Método para ejecutar una consulta
        public function getConexion(): ?PDO {
            return $this->conexion;
        }
    }