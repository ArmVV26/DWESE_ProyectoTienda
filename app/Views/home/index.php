    <section class="menu-secundario">
        <?php
            foreach ($categorias as $categoria) {
                echo "<a href='". URL_BASE ."categoria/". $categoria['id'] ."'>". $categoria['nombre'] ."</a>";
            }
        ?>
    </section>

    <section class="contenedor-productos">
        
        <?php
            foreach($productos as $producto) {
                echo "
                    <article class='producto'>
                        <figure>
                            <img src='". URL_BASE ."/public/media/img/". $producto['imagen'] ."' alt='". $producto['nombre'] ."'> 
                        </figure>
                        <section>
                            <p class='precio'>". $producto['precio'] ." €</p>
                            <h2>". $producto['nombre'] ."</h2>
                            <p class='descripcion'>". $producto['descripcion'] ."</p>
                        </section>
                    </article>
                ";
            }
            
        ?>

    </section>