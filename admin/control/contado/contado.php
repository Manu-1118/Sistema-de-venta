<?php
require '../../includes/app.php';
estaAutenticado(); //verificar que $_SESSION sea true

//Codigo para verificar si hay productos en la lista para efectuar la venta
// if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['cancelado'] == true) {

//     if (isset($_SESSION['lista_productos'])) {
//         $_SESSION['lista_productos'] = [];
//     }
// }

//Conectar la bd
$db = conectarDB();
$encabezados = ['Codigo', 'Fecha trans.', 'Total'];

// variables para añadirlas al archivo "/data/obtener_datos.php"
$columnas = ['id_contado', 'fecha_contado', 'total'];
$tabla[] = 'Contado';
$btn_texto = 'Detalles';

$_SESSION['encabezados'] = $encabezados;
$_SESSION['columnas'] = $columnas;
$_SESSION['tabla'] = $tabla;
$_SESSION['btn_texto'] = $btn_texto;
$_SESSION['ruta'] = $ruta_imagen;

//debuguear($_POST);

$resultado_mensaje = $_GET['resultado'] ?? null;

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<!-- class="main admin menu-toggle" -->

<main id="main" class="main admin main-admin menu-toggle">

    <?php if (intval($resultado_mensaje) === 1): ?>
        <p class="alerta exito">La venta al contado se realizó con exito</p>
    <?php endif;
    $_SESSION['lista_productos'] = []; ?>

    <div class="contenedor-admin">
        <div class="alinear-derecha CA1">
            <button id='btn-abrir-modal' class="boton-azul">Registrar venta al contado</button>
        </div>
        <?php incluirTemplate('tabla_datos'); ?>
    </div>

</main>

<div class="contenedor-modal">
    <div class="modal fondo">
        <form action="" class="formulario" method="POST">
        <fieldset>
            <legend>Registrar Nueva Venta al Contado</legend>

            <div class="superior dos-tablas">
                <label for="idFactura">Número de factura</label>
                <input type="number" name="idFactura" id="idFactura" value="">

                <label for="fecha">Fecha de registro</label>
                <input type="date" name="fecha" id="fecha" value="">

                <label for="txtTotal">Total</label>
                <input type="number" name="txtTotal" id="txtTotal" value="">
            </div>

            <div class="seleccion-producto">

                <label for="buscar-producto">Buscar producto</label>
                <input type="text" name="buscar-producto" id="buscar-producto" value="">
                <ul id="lista-productos"></ul>

                <label for="txtCantidad">Cantidad del producto</label>
                <input type="number" name="txtCantidad" id="txtCantidad" min='1'>
            </div>

            <div class="tabla-productos-seleccionados">
                <h2>Productos seleccionados</h2>
                <?php incluirTemplate('tabla_productos'); ?>
            </div>

        </fieldset>
        </form>
        <div class="alinear-derecha botones-modal">
            <button id="btn-cerrar-modal" class="boton-rojo">Cerrar</button>
            <button id="" class="boton-azul">Agregar</button>
        </div>
    </div>
</div> <!-- copiar para todos los archivos "insertar y luego ponerles sus text y darle funcionalidad" -->

<?php incluirTemplate('footer'); ?>