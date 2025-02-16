<?php
    // Inicio la sesión
    session_start();
?>

    <h1>Formulario de Registro</h1>

    <!-- Mostrar mensaje de exito si existe -->
    <?php
        if (isset($_SESSION['registro'])) {
            // echo "<p class='reg-validacion'>" . $_SESSION['registro'] . "</p>";
            echo "<p style='color:green'>" . $_SESSION['registro'] . "</p>";
            unset($_SESSION['registro']);
        }   
    ?>

    <!-- Mostrar errores de validación -->
    <?php
        if (isset($_SESSION['errores'])) {
            // echo "<ul class='errores'>";
            echo "<ul style='color:red'>";
            foreach ($_SESSION['errores'] as $error) {
                echo "<li style='color:red'>" . $error . "</li>";
            }
            echo "</ul>";
            unset($_SESSION['errores']);
        }
    ?>

    <!-- Formulario de Registro -->
    <form action="index.php?controller=Usuario&action=registrar" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required><br>

        <!-- Muestro un menú de selección del rol, si hay una sesion iniciada de un usuario admin  -->
        <?php
            if (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']->rol === 'admin') {
                echo "<label for='rol'>Rol:</label>
                      <select name='rol' id='rol'>
                          <option value='cliente'>Cliente</option>
                          <option value='admin'>Admin</option>
                      </select><br>";
            }
        ?>

        <input type="submit" value="Registrar">

    </form>