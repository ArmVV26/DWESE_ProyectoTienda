    <section class="contenedor">
        <?php
            if (isset($_SESSION['pedido'])) {
                echo "<h1>" . $_SESSION['pedido']['mensaje'] . "</h1>";
                echo "<h2>" . $_SESSION['pedido']['mensaje-dos'] . "</h2>";
                echo "<p class='". $_SESSION['pedido']['tipo']." exitoso'>Redirigiendo a la página de pedidos del usuario ...</p>";
                unset($_SESSION['pedido']);
            } 
        ?>
    </section>

    <script>
        setTimeout(() => {
            window.location.href = '<?= URL_BASE ?>pedido/mostrarPedidos';
        }, 5000);
    </script>