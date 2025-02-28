    <?php
        $_SESSION['origen'] = 'carrito';
    ?>
    <section class="contenedor-carrito">

        <section class="mostrar-productos">
            <h1> TU CARRITO </h1>
            
            <?php
                if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {

                    foreach($productoCarrito as $datos) {

                        $producto = $datos['producto'];
                        $cantidad = $datos['cantidad'];

                        $agregarMas = ($producto['stock'] > $cantidad);

                        echo "
                            <article class='atriculo-producto'>
                                <figure>    
                                    <img src='". URL_BASE ."/public/media/img/". $producto['imagen'] ."' alt='". $producto['nombre'] ."'>
                                </figure>    
                                
                                <section>
                                    <h2>". $producto['nombre'] ."</h2>
                                    <p>". $producto['descripcion'] ."</p>
                                    <p><b>Cantidad:</b> ". $cantidad ." ud/s</p>
                                    <p><b>Precio:</b> ". $producto['precio'] ." €</p>
                                    <p><b>Total:</b> ". $producto['precio'] * $cantidad ." €</p>
                                </section>

                                <section>
                                    <article>
                                        <a href='". URL_BASE ."carrito/eliminarProducto/". $producto['id'] ."'>
                                            <i class='fa-solid fa-xmark'></i>
                                        </a>
                                    </article>

                                    <article>
                                        <a href='". URL_BASE ."carrito/agregarProducto/". $producto['id'] ."'
                                            class='". ($agregarMas ? '' : 'disabled') ."'>
                                            <i class='fa-solid fa-plus'></i>
                                        </a>

                                        <a href='". URL_BASE ."carrito/restarProducto/". $producto['id'] ."'>
                                            <i class='fa-solid fa-minus'></i>
                                        </a>
                                    </article>
                                </section>
                            
                            </article>
                        ";
                    }

                } else {
                    echo "<p class='no-registros'>No hay productos en el carrito</p>";
                }
            ?>

            <a class="vaciar-carrito" href="<?=URL_BASE?>carrito/vaciarCarrito"
                onclick="return check()">Vaciar Carrito</a>

        </section>

        <aside class="pedido">
            <h2>RESUMEN DEL PEDIDO</h2>
            <article class='subtotal'>

                <?php
                    $total = 0;
                    $totalProductos = 0;
                    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                        
                        foreach($productoCarrito as $datos) {
                            $producto = $datos['producto'];
                            $cantidad = $datos['cantidad'];
                            
                            $total += $producto['precio'] * $cantidad;
                            $totalProductos += $cantidad;
                        }
                    }
                ?>

                <p> Subtototal <b>(<?=$totalProductos?> Prod/s)</b></p>
                
                <p><?=$total?> €</p>
            </article>

            <article class='envio'>
                <p> Envío </p>
                <p> 0 € </p>
            </article>

            <article class='total'>
                <p> Total <b>Iva Incluido</b></p>
                <p><?=$total*1.21?> € </p>
            </article>

            <a href="<?=URL_BASE?>pedido/formularioPedido">Comenzar Pedido</a>

        </aside>

    </section>

    <!-- Funcion para confirmar si se quiere vaciar el Carrito -->
    <script>
        function check() {
            return confirm('¿Estás seguro de que quieres vaciar el carrito?');
        }
    </script>