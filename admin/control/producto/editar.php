<?php
require '../../../includes/app.php';
$db = conectarDB();
require '../../../data/productos/editar.php';
estaAutenticado(); //verificar que $_SESSION sea true
incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main admin main-admin menu-toggle">
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario" enctype="multipart/form-data">
        <fieldset>
            <legend>Edita el Producto</legend>

            <label for="txtCodigo">Código</label>
            <input type="text" name="txtCodigo" placeholder="358685" id="txtCodigo" value="<?php echo $codigo; ?>" disabled>

            <label for="txtNombre">Nombre</label>
            <input type="text" name="txtNombre" placeholder="Leche Eskimo" id="txtNombre" value="<?php echo $nombre; ?>">

            <label for="txtPrecio">Precio unitario</label>
            <input type="number" name="txtPrecio" placeholder="40.00" id="txtPrecio" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png">

            <img src="/img/productos/<?php echo $imagen_producto; ?>" alt="imagen producto" class="img-producto-editar">

            <label for="txtDescripcion">Descripción</label>
            <input type="text" name="txtDescripcion" placeholder="Leche Eskimo entera de 900ml..." id="txtDescripcion" value="<?php echo $descripcion; ?>">

            <label for="cbCategoria">Categoría</label>
            <select name="cbCategoria">
                <option disabled selected>-- Seleccionar Categoría --</option>
                <?php while ($categoria = mysqli_fetch_assoc($Categorias)): ?>
                    <option value="<?php echo $categoria['id_categoria'] ?>"><?php echo $categoria['nombre'] ?></option>
                <?php endwhile; ?>
            </select>

        </fieldset>

        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="productos.php">
                <span>Cancelar</span>
            </a>

            <input type="submit" value="Editar" class="boton-azul">

        </div>

    </form>
</main>

<?php incluirTemplate('footer', true); ?>