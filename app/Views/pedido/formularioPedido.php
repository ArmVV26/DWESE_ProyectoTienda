    <section class="contenedor">
        <h1>Datos de la Dirección</h1>

        <?php
            if (isset($_SESSION['pedido'])) {
                echo "<p class='". $_SESSION['pedido']['tipo'] ."'>" . $_SESSION['pedido']['mensaje'] . "</p>";
                unset($_SESSION['pedido']);
            }

            if (isset($_SESSION['errores'])) {
                echo "<p class='". $_SESSION['errores']['tipo'] ."'>" . $_SESSION['errores']['mensaje'] . "</p>";
                unset($_SESSION['errores']);
            }
        ?>
        <!-- Formulario de Pedido -->
        <form action="<?=URL_BASE ?>pedido/formularioPedido" method="POST">
            <label for="direccion">Direccion</label>
            <input type="text" name="data[direccion]" id="direccion" required>
            
            <label for="localidad">Localidad</label>
            <input type="text" name="data[localidad]" id="localidad" required>
        
            <label for="provincia">Provincia</label>
            <input type="text" name="data[provincia]" id="provincia" required>

            
            <input type="submit" value="Confirmar Pedido">
        </form>

    </section>