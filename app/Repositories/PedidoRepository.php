<?php
    // Defino el namespace
    namespace Repositories;

    // Importo las clases necesarias
    use Lib\Database;
    use Models\Pedido;
    use PDO;
    use PDOException;
    
    /**
     * Clase PedidoRepository
     * 1. Guardar un pedido
     * 2. Obtener los pedidos de un usuario
     * 3. Guardar una línea de pedido
     */
    class PedidoRepository {
        // Atributos
        private Database $database;

        // Constructor
        public function __construct() {
            $this->database = new Database();
        }

        // Métodos
        /**
         * Método para guardar un pedido
         * 
         * @param Pedido $pedido Los datos del pedido
         * @return bool Devuelve true si se ha guardado el pedido y false en caso contrario
         */
        public function guardarPedido($pedido) {
            try {
                // Recojo los datos del pedido
                $usuario_id = $pedido->getUsuarioId();
                $provincia = $pedido->getProvincia();
                $localidad = $pedido->getLocalidad();
                $direccion = $pedido->getDireccion();
                $coste = $pedido->getCoste();
                $estado = $pedido->getEstado();
                $fecha = $pedido->getFecha();
                $hora = $pedido->getHora();

                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora)
                    VALUES (:usuario_id, :provincia, :localidad, :direccion, :coste, :estado, :fecha, :hora)
                ";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':usuario_id', $usuario_id);
                $stmt->bindParam(':provincia', $provincia);
                $stmt->bindParam(':localidad', $localidad);
                $stmt->bindParam(':direccion', $direccion);
                $stmt->bindParam(':coste', $coste);
                $stmt->bindParam(':estado', $estado);
                $stmt->bindParam(':fecha', $fecha);
                $stmt->bindParam(':hora', $hora);

                $stmt->execute();

                // Guardo el id del pedido
                $pedido->setId($this->database->ultimotId());
                
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }

        /**
         * Método para obtener los pedidos de un usuario
         * 
         * @param int $usuario_id El id del usuario
         * @return array Devuelve los pedidos del usuario
         */
        public function obtenerPedidosUsuario($usuario_id) {
            try {
                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                $sql = "
                    SELECT * FROM pedidos
                    WHERE usuario_id = :usuario_id
                    ORDER BY id ASC
                ";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':usuario_id', $usuario_id);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return [];
            }
        }

        /**
         * Método para guardar una línea de pedido
         * 
         * @param int $pedido_id El id del pedido
         * @param array $carrito El carrito de la compra
         * @return void
         */
        public function guardarLineaPedido($pedido_id, $carrito) {
            try {
                // Recojo la conexión y preparo la consulta
                $conexion = $this->database->getConexion();

                foreach ($carrito as $id => $cantidad) {
                    $sql = "
                        INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades)
                        VALUES (:pedido_id, :producto_id, :unidades)
                    ";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bindParam(':pedido_id', $pedido_id);
                    $stmt->bindParam(':producto_id', $id);
                    $stmt->bindParam(':unidades', $cantidad);

                    $stmt->execute();

                }

                $_SESSION['pedido']['mensaje-tres'] = 'El pedido se ha guardado correctamente';
            } catch (PDOException $e) {
                $_SESSION['pedido']['mensaje-tres'] = 'No se ha podido guardar el pedido';
                return [];
            }
        }
    }