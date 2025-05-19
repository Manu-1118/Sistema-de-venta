<?php
require '../../includes/app.php';
estaAutenticado(); //verificar que $_SESSION sea true
//Conectar la bd
$db = conectarDB();
$encabezados = ['Fecha Dev.', 'Descripción', 'Cantidad prod.', 'Total'];

// variables para añadirlas al archivo "/data/obtener_datos.php"
$columnas = ['fecha_devolucion', 'descripcion', 'SUM(cantidad)', 'total'];
$tabla = ['Devolucion', 'DetalleDevolucion'];
$btn_texto = 'Detalles';
$inner = 'Devolucion d join DetalleDevolucion dd on d.id_devolucion = dd.id_devolucion';

$_SESSION['encabezados'] = $encabezados;
$_SESSION['columnas'] = $columnas;
$_SESSION['tabla'] = $tabla;
$_SESSION['btn_texto'] = $btn_texto;
$_SESSION['ruta'] = $ruta_imagen;
$_SESSION['inner'] = $inner;

$resultado_mensaje = $_GET['resultado'] ?? null;

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<!-- class="main admin menu-toggle" -->

<main id="main" class="main admin main-admin menu-toggle">

    <?php if (intval($resultado_mensaje) === 1): ?>
        <p class="alerta exito">Los productos dañados se agendaron con exito</p>
    <?php endif;
    $_SESSION['lista_productos'] = []; ?>

    <div class="contenedor-admin">
        <div class="alinear-derecha CA1">
            <button id='btn-abrir-modal' class="boton-azul">Registrar compra</button>
        </div>
        <?php incluirTemplate('tabla_datos'); ?>
    </div>

</main>

<div class="contenedor-modal">
    <div class="modal fondo">
        <form action="" class="formulario">
            <fieldset>
                <legend>Registrar Productos Devueltos</legend>


            </fieldset>
        </form>
        <div class="alinear-derecha botones-modal">
            <button id="btn-cerrar-modal" class="boton-rojo">Cerrar</button>
            <button id="" class="boton-azul">Agregar</button>
        </div>
    </div>
</div> <!-- copiar para todos los archivos "insertar y luego ponerles sus text y darle funcionalidad" -->

<?php incluirTemplate('footer'); ?>