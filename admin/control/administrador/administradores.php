<?php
require '../../../includes/app.php';
estaAutenticado(); //verificar que $_SESSION sea true
$db = conectarDB(); //Conectar la bd

include '../../../data/administrador/mostrar.php';

$resultado_mensaje = $_GET['resultado'] ?? null;
incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main admin main-admin menu-toggle">

    <?php if (intval($resultado_mensaje) === 1): ?>
        <p class="alerta exito">El administrador se creó correctamente</p>
    <?php elseif (intval($resultado_mensaje) === 2): ?>
        <p class="alerta exito">El producto se modificó correctamente</p>
    <?php endif; ?>

    <div class="contenedor-admin">
        <div class="alinear-derecha CA1">
            <a href="crear.php" class="boton-azul">Nuevo Admin</a>
        </div>
        <?php incluirTemplate('tabla_datos'); ?>
    </div>
</main>

<?php incluirTemplate('footer'); ?>