    <section class="contenedor">
        <h1>Editar Usuario</h1>

        <!-- Mostrar Usuario -->
        <?php
            if (isset($_SESSION['editar'])) {
                echo "<p class='". $_SESSION['editar']['tipo'] ."'>" . $_SESSION['editar']['mensaje'] . "</p>";
                unset($_SESSION['editar']);
            }

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
                    </table>";

            } else {
                echo "<p>No hay usuario registrado con ese ID.</p>";
            }
        ?>

        <!-- Formulario de Actualización -->
        <form action="<?=URL_BASE ?>usuario/actualizarUsuario?id=<?=$usuario['id']?>" method="POST">
            <input type="hidden" name="data[id]" value="<?=$usuario['id']?>">

            <label for="nombre">Nombre</label>
            <input type="text" name="data[nombre]" id="nombre" placeholder="Nuevo Nombre">

            <label for="apellidos">Apellidos</label>
            <input type="text" name="data[apellidos]" id="apellidos" placeholder="Nuevos Apellidos">

            <label for="email">Email</label>
            <input type="email" name="data[email]" id="email" placeholder="Nuevo Email">

            <label for="password">Contraseña</label>
            <input type="password" name="data[password]" id="password" placeholder="Nueva Contraseña">

            <?php
            if (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']['rol'] === 'admin') {
                    echo "<label for='rol'>Rol</label>
                        <select name='data[rol]' id='rol'>
                            <option value='cliente'>Cliente</option>
                            <option value='admin'>Admin</option>
                        </select>";
                }
            ?>

            <input type="submit" value="Editar">

        </form>

    </section>