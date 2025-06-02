<?php
require '../../../includes/app.php';
$db = conectarDB();
require '../../../data/proveedor/editar.php';
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

    <form method="POST" class="formulario">
        <fieldset>
            <legend>Edita el proveedor</legend>

            <label for="txtRUC">codigo RUC</label>
            <input type="text" name="txtRUC" id="txtRUC" value="<?php echo $RUC; ?>">

            <label for="txtNombre">Nombre</label>
            <input type="text" name="txtNombre" id="txtNombre" value="<?php echo $nombre; ?>">

            <label for="txtApellido">Apellido</label>
            <input type="text" name="txtApellido" id="txtApellido" value="<?php echo $apellido; ?>">

            <label for="txtEmpresa">Empresa</label>
            <input type="text" name="txtEmpresa" id="txtEmpresa" value="<?php echo $empresa; ?>">

            <label for="txtTelefono">Teléfono</label>
            <input type="text" name="txtTelefono" id="txtTelefono" value="<?php echo $telefono; ?>">



        </fieldset>

        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="proveedores.php">
                <span>Cancelar</span>
            </a>

            <input type="submit" value="Editar" class="boton-azul">

        </div>

    </form>
</main>

<?php incluirTemplate('footer', true); ?>