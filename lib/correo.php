<?php
    // Defino el namespace
    namespace Lib;

    // Importo las clases necesarias
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Defino la clase Correo
    class Correo {
        // Atributosç
        private PHPMailer $mail;

        // Constructor
        public function __construct() {
            $this->mail = new PHPMailer(true);
        }

        // Métodos
        public function enviarConfirmaciónPedido(array $carrito, $numeroPedido, string $correoCliente, string $nombreCliente, float $total, string $direccionEnvio): bool {
            try {
                // Configuración del servidor
                $this->mail->isSMTP();
                $this->mail->Host = $_ENV['MAIL_HOST'];
                $this->mail->SMTPAuth = true;
                $this->mail->Username = $_ENV['MAIL_USER'];
                $this->mail->Password = $_ENV['MAIL_PASS'];
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $this->mail->Port = $_ENV['MAIL_PORT'];

                // Configuración del correo 
                $this->mail->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
                $this->mail->addAddress($correoCliente, $nombreCliente);

                // Asunto del correo
                $this->mail->isHTML(true);
                $this->mail->Subject = 'Confirmacion de pedido #' . $numeroPedido;

                // Cuerpo del correo
                $this->mail->Body = '
                    <html>
                        <head>
                        <meta charset="UTF-8">
                        <style>
                            /* Estilos básicos para el correo */
                            body {
                                font-family: Verdana, sans-serif;
                                background-color: #fffdfa;
                                margin: 0;
                                padding: 20px;
                            }
                            section {
                                background-color: #363636;
                                border-radius: 2rem;
                                padding: 2rem;
                                max-width: 40rem;
                                margin: auto;
                                box-shadow: 0 0 10px #121212;
                            }
                            h1 {
                                font-size: 2.5rem;
                                color: #E5E5E5;
                                text-shadow: 0 0 4px #cca43b;
                                text-align: center;
                            }
                            h2 {
                                color: #E5E5E5;
                            }
                            p {
                                color: #E5E5E5;
                                line-height: 1.1;
                            }
                            b {
                                color: #f2b417;
                            }
                            table {
                                width: 100%;
                                border-collapse: collapse;
                                border-radius: 2rem;
                                margin-top: 1.5rem;
                                background-color: #E5E5E5;
                            }
                            th {
                                font-size: 1.25rem;
                                color: #f2b417;
                                text-shadow: 1px 1px 1px #121212;
                            }
                            th, td {
                                padding: 10px;
                                border: 5px solid #363636;
                                text-align: center;
                            }
                        </style>
                        </head>
                        <body>
                        <section>
                            <h1>Pedido Confirmado #' . $numeroPedido . '</h1>
                            <h2>Hola '. $nombreCliente .'</h2>
                            <p>Gracias por tu compra. A continuacion, se detallan los productos de tu pedido:</p>
                            <p><b>Direccion:</b> ' . $direccionEnvio . '</p>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody> 
                ';
                foreach ($carrito as $producto) {
                    $this->mail->Body .= '
                        <tr>
                            <td>' . $producto['nombre'] . '</td>
                            <td>' . $producto['cantidad'] . '</td>
                            <td>' . $producto['precio'] . ' euros</td>
                            <td>' . $producto['precio'] * $producto['cantidad'] . ' euros</td>
                        </tr>
                    ';
                }

                $this->mail->Body .= '
                                </tbody>
                            </table>
                            <p><b>Total (Iva Incluido):</b> ' . $total*1.21 . ' euros</p>
                            <p>!Gracias por confiar en nosotros!</p>
                        </section>
                    </body>
                    </html>
                ';

                // Envío del correo
                $this->mail->send();

                return true;
            } catch (Exception $e) {
                $_SESSION['maxerror'] = $this->mail->ErrorInfo;
                return false;
            }
        }
    }