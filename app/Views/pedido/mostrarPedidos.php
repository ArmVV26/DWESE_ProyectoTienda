    <section class="contenedor-tabla">
        <h1> Pedidos de <?=$_SESSION['inicioSesion']['nombre']?> </h1>

        <?php
            if (!empty($pedidos)) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Direccion</th>
                                <th>Localidad</th>
                                <th>Provincia</th>
                                <th>Coste</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                ";

                foreach ($pedidos as $pedido) {
                    echo "<tr>
                            <td>{$pedido['id']}</td>
                            <td>{$pedido['direccion']}</td>
                            <td>{$pedido['localidad']}</td>
                            <td>{$pedido['provincia']}</td>
                            <td>{$pedido['coste']}</td>
                            <td>{$pedido['estado']}</td>
                            <td>{$pedido['fecha']}</td>
                            <td>{$pedido['hora']}</td>
                          </tr>
                    ";
                }

                echo "</tbody>
                    </table>";

            } else {
                echo "<p>No hay pedidos registrados.</p>";
            }
        ?>
    </section>    