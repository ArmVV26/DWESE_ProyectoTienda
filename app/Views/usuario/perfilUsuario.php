    <section class="contenedor-tabla">
        <h1> Perfil Usuario (<?=$_SESSION['inicioSesion']['nombre']?>) </h1>

        <?php
            if (!empty($usuario)) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Email</th>
                                <th>Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{$usuario['id']}</td>
                                <td>{$usuario['nombre']}</td>
                                <td>{$usuario['apellidos']}</td>
                                <td>{$usuario['email']}</td>
                                <td>{$usuario['rol']}</td>
                            </tr>
                        </tbody>
                    </table>
                ";
            } else {
                echo "<p>No hay usuarios registrados</p>";
            }
        ?>
        <a href="<?=URL_BASE?>usuario/actualizarUsuario/<?=$_SESSION['inicioSesion']['id']?>" class="boton-perfil">Editar Perfil</a>

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
                echo "<p>No hay pedidos registrados</p>";
            }
        ?>
        <a href="<?=URL_BASE?>pedido/mostrarPedidos" class="boton-perfil">Mis Pedidos</a>

    </section>    