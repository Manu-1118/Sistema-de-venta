<?php
require '../../../includes/app.php';
estaAutenticado(); //verificar que $_SESSION sea true
$db = conectarDB(); //Conectar la bd
require '../../../data/cliente/insertar.php';

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
            <legend>Agregar Cliente</legend>

            <label for="txtNombres">Nombres</label>
            <input type="text" name="txtNombres" placeholder="Nombres del cliente" id="txtNombres" value="<?php echo $nombres; ?>">

            <label for="txtApellidos">Apellidos</label>
            <input type="text" name="txtApellidos" placeholder="Apellidos del cliente" id="txtApellidos" value="<?php echo $apellidos; ?>">

        </fieldset>

        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="clientes.php">
                <span>Cancelar</span>
            </a>

            <input type="submit" value="Agregar" class="boton-azul">

        </div>

    </form>
</main>

<?php incluirTemplate('footer', true); ?>