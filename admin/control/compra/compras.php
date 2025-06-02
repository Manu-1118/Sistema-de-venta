<?php
require '../../../includes/app.php';
estaAutenticado(); //verificar que $_SESSION sea true
require '../../../data/compra/mostrar.php';

$resultado_mensaje = $_GET['resultado'] ?? null;

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<!-- class="main admin menu-toggle" -->

<main id="main" class="main admin main-admin menu-toggle">

    <?php if (intval($resultado_mensaje) === 1): ?>
        <p class="alerta exito">La Compra se registró con exito</p>
    <?php endif;
    $_SESSION['lista_productos'] = []; ?>

    <div class="contenedor-admin">
        <div class="alinear-derecha CA1">
            <a href="crear.php" class="boton-azul">Registrar Compra</a>
        </div>
        <?php incluirTemplate('tabla_datos'); ?>
    </div>

</main>

<?php incluirTemplate('footer', true); ?>