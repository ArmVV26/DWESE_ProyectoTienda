    <section class="contenedor">
        <h1>Creación de una Categoria</h1>

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
        <form action="<?=URL_BASE ?>admin/crearCategoria" method="POST">
            <label for="nombre">Nombre</label>
            <input type="text" name="data[nombre]" id="nombre" required>

            <input type="submit" value="Crear">

        </form>

    </section>