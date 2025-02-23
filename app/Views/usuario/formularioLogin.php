    <section class="contenedor">
        <h1>Formulario de Inicio de Sesión</h1>

        <!-- Mostrar mensaje de exito si existe -->
        <?php
            if (isset($_SESSION['login'])) {
                echo "<p class='". $_SESSION['login']['tipo'] ."'>" . $_SESSION['login']['mensaje'] . "</p>";
                unset($_SESSION['login']);
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
        <!-- action="<?=URL_BASE ?>usuario/formularioLogin" -->
        <form action="" method="POST">
            <label for="email">Email</label>
            <input type="email" name="data[email]" id="email" required><br>

            <label for="password">Contraseña</label>
            <input type="password" name="data[password]" id="password" required><br>

            <input type="submit" value="Inicar Sesión">

        </form>

    </section>