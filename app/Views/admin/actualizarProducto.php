<section class="contenedor">
        <h1>Editar Producto</h1>

        <!-- Mostrar Usuario -->
        <?php
            if (isset($_SESSION['editar'])) {
                echo "<p class='". $_SESSION['editar']['tipo'] ."'>" . $_SESSION['editar']['mensaje'] . "</p>";
                unset($_SESSION['editar']);
            }

            if (!empty($producto)) {
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
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{$producto['id']}</td>
                                <td>{$producto['nombre']}</td>
                                <td class='descripcion'>{$producto['descripcion']}</td>
                                <td>{$producto['precio']}</td>
                                <td>{$producto['stock']}</td>
                                <td>{$producto['oferta']}</td>
                                <td>{$producto['imagen']}</td>
                                <td>{$producto['categoria_id']}</td>
                            </tr>
                        </tbody>
                    </table>";

            } else {
                echo "<p>No hay producto registrado con ese ID.</p>";
            }
        ?>

        <!-- Formulario de Actualización -->
        <!-- Formulario de Creación -->
        <form action="<?=URL_BASE ?>admin/actualizarProducto/<?=$producto['id'] ?>" method="POST">
            <input type="hidden" name="data[id]" value="<?=$producto['id']?>">

            <label for="nombre">Nombre</label>
            <input type="text" name="data[nombre]" id="nombre">

            <label for="descripcion">Descripción</label>
            <textarea name="data[descripcion]" id="descripcion"></textarea>

            <label for="precio">Precio</label>
            <input type="number" name="data[precio]" id="precio">

            <label for="stock">Stock</label>
            <input type="number" name="data[stock]" id="stock">

            <label for="producto">Oferta</label>
            <select name="data[oferta]" id="oferta">
                <option value="No">No</option>
                <option value="Si">Sí</option>
            </select>

            <label for="imagen">Imagen</label>
            <input type="file" name="data[imagen]" id="imagen">
        
            <label for="categoria_id">Categoría</label>
            <?php 
                echo "<select name='data[categoria_id]' id='categoria_id'>";

                foreach($categorias as $categoria) {
                    echo "<option value='". $categoria['id'] ."'>". $categoria['nombre'] ."</option>";
                }
                
                echo "</select>";
            ?>
            <input type="submit" value="Actualizar">
        </form>

    </section>