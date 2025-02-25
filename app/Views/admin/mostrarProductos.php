    <section class="contenedor-tabla">
        <h1> Tabla con todos los Productos </h1>

        <?php
            if (isset($_SESSION['eliminar'])) {
                echo "<p class='". $_SESSION['eliminar']['tipo'] ."'>" . $_SESSION['eliminar']['mensaje'] . "</p>";
                unset($_SESSION['eliminar']);
            }

            if (!empty($productos)) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Oferta</th>
                                <th>Imagen</th>
                                <th>Categoría</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                ";

                foreach ($productos as $producto) {
                    echo "<tr>
                            <td>{$producto['id']}</td>
                            <td>{$producto['nombre']}</td>
                            <td class='descripcion'>{$producto['descripcion']}</td>
                            <td>{$producto['precio']}</td>
                            <td>{$producto['stock']}</td>
                            <td>{$producto['oferta']}</td>
                            <td>{$producto['imagen']}</td>
                            <td>{$producto['categoria_id']}</td>
                            <td>
                                <a href='". URL_BASE ."producto/eliminar/". $producto['id'] ."'
                                    onclick='return check()'>
                                    Eliminar</a>
                                <a href='". URL_BASE ."admin/actualizarProducto/". $producto['id'] ."'>
                                    Editar</a>
                            </td>
                        </tr>
                    ";
                }

                echo "</tbody>
                    </table>";

            } else {
                echo "<p>No hay usuarios registrados.</p>";
            }
        ?>
    </section>    

    <!-- Funcion para confirmar la eliminación del Usuario -->
    <script>
        function check() {
            return confirm('¿Estás seguro de que quieres eliminar este usuario?');
        }
    </script>