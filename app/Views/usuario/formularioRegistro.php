    <section class="contenedor">
        <h1>Formulario de Registro</h1>

        <!-- Mostrar mensaje de exito si existe -->
        <?php
            if (isset($_SESSION['registro'])) {
                echo "<p class='". $_SESSION['registro']['tipo'] ."'>" . $_SESSION['registro']['mensaje'] . "</p>";
                unset($_SESSION['registro']);
            }   
        ?>

        <!-- Mostrar errores de validación -->
        <?php
            if (isset($_SESSION['errores'])) {
                echo "<ul class='error'>";
                foreach ($_SESSION['errores'] as $error) {
                    echo "<li>" . $error . "</li>";
                }
                echo "</ul>";
                unset($_SESSION['errores']);
            }
        ?>

        <!-- Formulario de Registro -->
        <form action="<?=URL_BASE ?>usuario/formularioRegistro" method="POST">
            <label for="nombre">Nombre</label>
            <input type="text" name="data[nombre]" id="nombre" required>

            <label for="apellidos">Apellidos</label>
            <input type="text" name="data[apellidos]" id="apellidos" required>

            <label for="email">Email</label>
            <input type="email" name="data[email]" id="email" required>

            <label for="password">Contraseña</label>
            <input type="password" name="data[password]" id="password" required>

            <!-- Muestro un menú de selección del rol, si hay una sesion iniciada de un usuario admin  -->
            <?php
            if (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']['rol'] === 'admin') {
                    echo "<label for='rol'>Rol:</label>
                        <select name='data[rol]' id='rol'>
                            <option value='cliente'>Cliente</option>
                            <option value='admin'>Admin</option>
                        </select><br>";
                }
            ?>

            <input type="submit" value="Registrar">

        </form>

    </section>