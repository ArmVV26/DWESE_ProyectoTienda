    <?php
        $_SESSION['origen'] = 'principal';
    ?>
    <?php
        // Importo la clase UsuarioController
        use Services\UsuarioServices;
        
        // Verifico si existe la cookie de recordar
        if (!isset($_SESSION['inicioSesion']) && isset($_COOKIE['recordar'])) {
            $usuarioId = $_COOKIE['recordar'];
            $usuario = (new UsuarioServices())->obtenerPorId($usuarioId);

            if ($usuario) {
                $_SESSION['inicioSesion'] = $usuario;
            }
        }

        // Verifico si existe la cookie del carrito
        if (isset($_SESSION['inicioSesion']) && !isset($_SESSION['carrito']) && isset($_COOKIE['carrito'])) {
            $_SESSION['carrito'] = json_decode($_COOKIE['carrito'], true);
        }
    ?>

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
                if ($producto['stock'] === 0) {
                    continue;
                } else {

                    echo "
                        <article class='producto'>
                            <figure>
                                <img src='". URL_BASE ."/public/media/img/". $producto['imagen'] ."' alt='". $producto['nombre'] ."'> 
                            </figure>
                            <section>
                                <p class='precio'>". $producto['precio'] ." €</p>
                                <h2>". $producto['nombre'] ."</h2>
                                <p class='descripcion'>". $producto['descripcion'] ."</p>
                                <a class='add-carrito' href='". URL_BASE ."carrito/agregarProducto/". $producto['id'] ."'>
                                    <i class='fa-solid fa-plus'></i>
                                </a>
                            </section>
                        </article>
                    ";
                }
            }
        ?>

    </section>