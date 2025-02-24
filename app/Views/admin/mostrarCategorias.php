    <section class="contenedor-tabla">
        <h1> Tabla con todos las Categorias </h1>

        <?php
            if (isset($_SESSION['editar'])) {
                echo "<p class='". $_SESSION['editar']['tipo'] ."'>" . $_SESSION['editar']['mensaje'] . "</p>";
                unset($_SESSION['editar']);
            }

            if (!empty($categorias)) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                ";

                foreach ($categorias as $categoria) {
                    echo "<tr>
                            <td>{$categoria['id']}</td>
                            <td>{$categoria['nombre']}</td>
                            <td> 
                                <a href='". URL_BASE ."categoria/eliminarCategoria?id=". $categoria['id'] ."'
                                 onclick='return check()'>
                                 Eliminar</a>
                            </td>
                        </tr>
                    ";
                }

                echo "</tbody>
                    </table>";

            } else {
                echo "<p>No hay categorias registradas.</p>";
            }
        ?>
    </section>    

    <!-- Funcion para confirmar la eliminación de la Categoria -->
    <script>
        function check() {
            return confirm('¿Estás seguro de que quieres eliminar esta categoria?');
        }
    </script>