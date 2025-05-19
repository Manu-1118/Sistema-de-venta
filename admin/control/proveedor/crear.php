<?php
require '../../../includes/app.php';
estaAutenticado(); //verificar que $_SESSION sea true
$db = conectarDB(); //Conectar la bd
require '../../../data/proveedor/insertar.php';

$resultado_mensaje = $_GET['resultado'];

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
            <legend>Agregar Proveedor</legend>

            <label for="txtRUC">Código RUC</label>
            <input type="text" name="txtRUC" placeholder="Codigo RUC de la empresa" id="txtRUC" value="<?php echo $RUC; ?>">

            <label for="txtNombre">Nombres</label>
            <input type="text" name="txtNombre" placeholder="Nombre de usuario" id="txtNombre" value="<?php echo $nombres; ?>">

            <label for="txtApellido">Apellidos</label>
            <input type="text" name="txtApellido" placeholder="Apellido de usuario" id="txtApellido" value="<?php echo $apellidos; ?>">

            <label for="txtEmpresa">Empresa</label>
            <input type="text" name="txtEmpresa" placeholder="Disegsa" id="txtEmpresa" value="<?php echo $empresa; ?>">

            <label for="txtTelefono">Teléfono</label>
            <input type="number" name="txtTelefono" placeholder="76789865" id="txtTelefono" value="<?php echo $telefono; ?>">

        </fieldset>

        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="proveedores.php">
                <span>Cancelar</span>
            </a>

            <input type="submit" value="Agregar" class="boton-azul">

        </div>

    </form>
</main>

<?php incluirTemplate('footer'); ?>