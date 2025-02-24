    <section class="menu-secundario">
        <?php
            foreach ($categorias as $categoria) {
                echo "<a href='". URL_BASE ."categoria/mostrarProductos?id=". $categoria['id'] ."'>". $categoria['nombre'] ."</a>";
            }
        ?>
    </section>