<?php
require '../../../includes/app.php';
estaAutenticado(); //verificar que $_SESSION sea true
//Conectar la bd
$db = conectarDB();
require '../../../data/credito/mostrar.php';

$resultado_mensaje = $_GET['resultado'] ?? null;

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<!-- class="main admin menu-toggle" -->

<main id="main" class="main admin main-admin menu-toggle">

    <?php if (intval($resultado_mensaje) === 1): ?>
        <p class="alerta exito">El Crédito se registró con éxito</p>
    <?php endif;
    $_SESSION['lista_productos'] = []; ?>

    <div class="contenedor-admin">
        <div class="alinear-derecha CA1">
            <a href="crear.php" class="boton-azul">Nuevo Credito</a>
        </div>
        <?php incluirTemplate('tabla_datos'); ?>
    </div>
</main>

<?php incluirTemplate('footer', true); ?>