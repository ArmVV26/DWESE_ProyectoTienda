    <section class="contenedor">
        <?php
            if (isset($_SESSION['registro'])) {
                echo "<h1>" . $_SESSION['registro']['mensaje'] . "</h1>";
                echo "<p class='". $_SESSION['registro']['tipo']." exitoso'>Redirigiendo a la página de inicio de sesión...</p>";
                unset($_SESSION['registro']);
            }   
        ?>
    </section>

    <script>
        setTimeout(() => {
            window.location.href = '<?= URL_BASE ?>usuario/formularioLogin';
        }, 5000);
    </script>