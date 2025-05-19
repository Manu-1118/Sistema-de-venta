<?php #productos.php
require '../../../includes/app.php';

estaAutenticado(); //verificar que $_SESSION sea true
$db = conectarDB(); //Conectar la bd

include '../../../data/productos/mostrar.php';

$resultado_mensaje = $_GET['resultado'] ?? null;

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main admin main-admin menu-toggle">

    <?php if (intval($resultado_mensaje) === 1): ?>
        <p class="alerta exito">El producto se agregó correctamente</p>
    <?php elseif (intval($resultado_mensaje) === 2): ?>
        <p class="alerta exito">El producto se modificó correctamente</p>
    <?php endif; ?>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <div class="contenedor-admin">
        <div class="alinear-derecha CA1">
            <a href="crear.php" class="boton-azul">Nuevo Prod.</a>
            <a href="categoria.php" class="boton-azul">Nueva Categ.</a>
        </div>
        <?php incluirTemplate('tabla_datos'); ?>
    </div>
</main>

<?php incluirTemplate('footer'); ?>