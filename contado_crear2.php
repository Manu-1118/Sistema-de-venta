<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';
estaAutenticado(); //verificar que $_SESSION sea true

//Conectar la bd
$db = conectarDB();

/** RELLENANDO PARA LA TABLA CONTADO **/
//obtener fecha actual y generar el numero de la factura
$fecha_actual = date("Y-m-d");
$query_cantidad_facturas = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(id) as 'cantidad' FROM Contado;"));
$num_factura = intval($query_cantidad_facturas['cantidad']) + 1;
/** FIN TABLA CONTADO **/

/** MOSTRANDO DATOS DE LA TABLA PRODUCTOS **/
//escribir el query
$query_obtener_productos = "SELECT * FROM Producto;";
//consultar la bd y obtener resultado
$resultado_obtener_productos = mysqli_query($db, $query_obtener_productos);
/** FIN TABLA PRODUCTOS **/



// verificar que se mando informacion al post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // si el arreglo de errores esta vacio, hacer la insercion
    if (empty($errores)) {

        /** INSERTAR DATOS EN LA TABLA DETALLE **/
        $query_insertar_detalle = "INSERT INTO DetalleContado (cantidad, codigo_producto, id_contado) VALUES ('$cantidad', '$codigo_producto', '$id_contado')";
        /** FIN TABLA DETALLE **/

        // si el resultado devolvio una fila modificada mostrar que si se inserto
        if ($resultado_insertar) {
            header('Location: /admin/control/contado.php?resultado=1');
        }
    }
}

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
            <legend>Venta al Contado</legend>

            <label for="txtId">Número de factura</label>
            <input disabled type="text" name="txtId" id="txtId" value="<?php echo $num_factura; ?>">

            <label for="dtRegistro">Fecha de registro</label>
            <input disabled type="date" name="dtRegistro" id="dtRegistro" value="<?php echo $fecha_actual; ?>">

            <label for="txtTotal">Total</label>
            <input disabled type="number" name="txtTotal" id="txtTotal" value="<?php echo $nombre; ?>">

        </fieldset>

        <fieldset>

            <legend>Detalles de la Venta</legend>

            <label for="cbProductos">Producto</label>
            <select name="cbProductos" id="cbProductos">
                <option disabled selected value="">-- Seleccionar Producto --</option>
                <?php while ($producto = mysqli_fetch_assoc($resultado_obtener_productos)): ?>
                    <option value="<?php echo $producto['codigo']; ?>"> <?php echo $producto['nombre']; ?> </option>
                <?php endwhile; ?>
            </select>

            <label for="txtCantidad">Cantidad</label>
            <input type="number" name="txtCantidad" id="txtCantidad" value="<?php echo $nombre; ?>" min="1">

            <div class="">
                <a class="boton-azul" href="contado_crear.php" id="enlace-agregar">Añadir a la lista</a>
            </div>

        </fieldset>

        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="contado.php">
                <span>Cancelar</span>
            </a>

            <input type="submit" value="Agregar Venta" class="boton-azul">

        </div>
    </form>

    <div class="tabla-containe">
        <table class="tabla-productos">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tbody>
        </table>
    </div>

</main>

<?php incluirTemplate('footer'); ?>