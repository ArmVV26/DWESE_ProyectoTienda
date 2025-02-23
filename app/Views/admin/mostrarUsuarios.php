    <section class="contenedor-tabla">
        <h1> Tabla con todos los Usuarios </h1>

        <?php
            if (!empty($usuarios)) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                ";

                foreach ($usuarios as $usuario) {
                    echo "<tr>
                            <td>{$usuario['id']}</td>
                            <td>{$usuario['nombre']}</td>
                            <td>{$usuario['apellidos']}</td>
                            <td>{$usuario['email']}</td>
                            <td>{$usuario['rol']}</td>
                            <td>
                    ";

                    if ($_SESSION['inicioSesion']['id'] !== $usuario['id']) {
                        echo "<a href='". URL_BASE ."usuario/eliminar?id=". $usuario['id'] ."'
                                 onclick='return check()'>
                                 Eliminar</a>";

                    } 
                    echo "          <a href=''>Editar</a>
                                </td>
                            </tr>
                        ";
                }

                echo "</tbody>
                    </table>";

            } else {
                echo "<p>No hay usuarios registrados.</p>";
            }
        ?>
    </section>    

    <!-- Funcion para confirmar la eliminación del Usuario -->
    <script>
        function check() {
            return confirm('¿Estás seguro de que quieres eliminar este usuario?');
        }
    </script>