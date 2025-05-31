<?php
require '../../../includes/app.php';
estaAutenticado(); //verificar que $_SESSION sea true
$db = conectarDB();
require '../../../data/productos/categoria.php';
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
            <legend>Agregar Nueva Categoría</legend>

            <label for="txtNombre">Nombre</label>
            <input type="text" name="txtNombre" placeholder="Lacteos" id="txtNombre" value="<?php echo $nombre; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png">

            <label for="txtDescripcion">Descripción</label>
            <input type="text" name="txtDescripcion" placeholder="Leches, Cremas, ..." id="txtDescripcion" value="<?php echo $descripcion; ?>">

        </fieldset>

        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="productos.php">
                <span>Cancelar</span>
            </a>

            <input type="submit" value="Agregar" class="boton-azul">

        </div>

    </form>
</main>

<?php incluirTemplate('footer'); ?>