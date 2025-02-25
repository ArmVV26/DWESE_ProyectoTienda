    <section class="contenedor">
        <h1>Crear Producto</h1>

        <?php
            if (isset($_SESSION['registro'])) {
                echo "<p class='". $_SESSION['registro']['tipo'] ."'>" . $_SESSION['registro']['mensaje'] . "</p>";
                unset($_SESSION['registro']);
            }
        ?>

        <!-- Mostrar errores de validación -->
        <?php
            if (isset($_SESSION['errores'])) {
                echo "<ul class='error'>";
                foreach ($_SESSION['errores'] as $error) {
                    echo "<li>" . $error . "</li>";
                }
                echo "</ul>";
                unset($_SESSION['errores']);
            }
        ?>
    
        <!-- Formulario de Creación -->
        <form action="<?=URL_BASE ?>admin/crearProducto" method="POST">
            <label for="nombre">Nombre</label>
            <input type="text" name="data[nombre]" id="nombre" required>

            <label for="descripcion">Descripción</label>
            <textarea name="data[descripcion]" id="descripcion" required></textarea>

            <label for="precio">Precio</label>
            <input type="number" name="data[precio]" id="precio" required>

            <label for="stock">Stock</label>
            <input type="number" name="data[stock]" id="stock" required>

            <label for="producto">Oferta</label>
            <select name="data[oferta]" id="oferta">
                <option value="No">No</option>
                <option value="Si">Sí</option>
            </select>

            <label for="imagen">Imagen</label>
            <input type="file" name="data[imagen]" id="imagen" required>
        
            <label for="categoria_id">Categoría</label>
            <?php 
                echo "<select name='data[categoria_id]' id='categoria_id'>";

                foreach($categorias as $categoria) {
                    echo "<option value='". $categoria['id'] ."'>". $categoria['nombre'] ."</option>";
                }
                
                echo "</select>";
            ?>
            <input type="submit" value="Crear">
        </form>

    </section>