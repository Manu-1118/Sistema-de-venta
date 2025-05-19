<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';
estaAutenticado(); //verificar que $_SESSION sea true

if (!isset($_SESSION['lista_productos'])) {
    $_SESSION['lista_productos'] = [];
}

//Conectar la bd
$db = conectarDB();
$errores = [];

/** RELLENANDO PARA LA TABLA CONTADO **/
//obtener fecha actual y generar el numero de la factura
$fecha_actual = date("Y-m-d");
$query_cantidad_facturas = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(id) as 'cantidad' FROM Compra;"));
$num_factura = intval($query_cantidad_facturas['cantidad']) + 1;
/** FIN TABLA CONTADO **/

/** MOSTRANDO DATOS DE LA TABLA PRODUCTOS **/
//escribir el query
$query_obtener_productos = "SELECT * FROM Producto;";
//consultar la bd y obtener resultado
$resultado_obtener_productos = mysqli_query($db, $query_obtener_productos);
/** FIN TABLA PRODUCTOS **/

/** MOSTRAR DATOS DE LA TABLA PROVEEDORES**/
$query_obtener_proveedores = "SELECT * FROM Proveedor;";
$resultado_obtener_proveedores = mysqli_query($db, $query_obtener_proveedores);
/** FIN DE LA TABLA PROVEEDORES**/

$total = 0;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['lista'] == 'true') {

    $buscar_producto = "SELECT nombre, descripcion, categoria, precio_unitario FROM Producto WHERE codigo = {$_GET['cbProductos']};";
    $resultado_busqueda = mysqli_fetch_assoc(mysqli_query($db, $buscar_producto));

    if ($resultado_busqueda) {
        $resultado_busqueda['codigo'] = $_GET['cbProductos'];
        $resultado_busqueda['cantidad'] = $_GET['txtCantidad'];
        $_SESSION['lista_productos'][] = $resultado_busqueda;
        header('location: /admin/control/compras_crear.php');
    }
}

$lista_productos = $_SESSION['lista_productos'];

foreach ($lista_productos as $producto) {
    $total += $producto['cantidad'] * $producto['precio_unitario'];
}

// verificar que se mando informacion al post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // si el arreglo de errores esta vacio, hacer la insercion
    if (empty($errores)) {

        /**INSERTAR DATOS EN LA TABLA Compra**/
        $query_insertar_contado = "INSERT INTO Compra (id, fecha, total, id_proveedor) VALUES ('$num_factura', '$fecha_actual', '$total', '{$_POST['cbProveedor']}');";
        // debuguear($query_insertar_contado);
        $resultado_contado = mysqli_query($db, $query_insertar_contado);
        /**FIN DE LA TABLA CONTADO**/

        /** INSERTAR DATOS EN LA TABLA DETALLE **/
        $query_insertar_detalle = "INSERT INTO DetalleCompra (cantidad, codigo_producto, id_compra) VALUES ";
        $datos_value = "";
        $contador = 0;
        $total_productos = count($lista_productos);

        foreach ($lista_productos as $producto) {

            $contador++;
            $datos_value = $datos_value . "({$producto['cantidad']}, {$producto['codigo']}, $num_factura)";
            if ($contador < $total_productos) {
                $datos_value .= ", ";
            } else {
                $datos_value .= ";";
            }
        }
        $query_insertar_detalle = $query_insertar_detalle . $datos_value;
        // debuguear($query_insertar_detalle);
        $resultado_detalle = mysqli_query($db, $query_insertar_detalle);
        /** FIN TABLA DETALLE **/

        // si el resultado devolvio una fila modificada mostrar que si se inserto
        if ($resultado_contado && $resultado_detalle) {
            header('Location: /admin/control/compras.php?resultado=1');
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

    <form method="GET" class="formulario" action="compras_crear.php">
        <fieldset>

            <legend>Detalles de la Compra</legend>

            <label for="cbProductos">Producto</label>
            <select name="cbProductos" id="cbProductos">
                <option disabled selected value="">-- Seleccionar Producto --</option>
                <?php while ($producto = mysqli_fetch_assoc($resultado_obtener_productos)): ?>
                    <option value="<?php echo $producto['codigo']; ?>"> <?php echo $producto['nombre']; ?> </option>
                <?php endwhile; ?>
            </select>

            <label for="txtCantidad">Cantidad</label>
            <input type="number" name="txtCantidad" id="txtCantidad" value="<?php echo $nombre; ?>" min="1">

            <button name="lista" value="true" type="submit" class="boton-azul">Añadir a la lista</button>

        </fieldset>
    </form>

    <form method="POST" class="formulario" action="compras_crear.php">
        <fieldset>
            <legend>Datos de la Compra</legend>

            <label for="txtId">Número de factura</label>
            <input disabled type="text" name="txtId" id="txtId" value="<?php echo $num_factura; ?>">

            <label for="dtRegistro">Fecha de registro</label>
            <input disabled type="date" name="dtRegistro" id="dtRegistro" value="<?php echo $fecha_actual; ?>">

            <label for="txtTotal">Total</label>
            <input disabled type="number" name="txtTotal" id="txtTotal" value="<?php echo $total; ?>">

            <label for="cbProveedor">Proveedor</label>
            <select name="cbProveedor" id="cbProveedor">
                <option disabled selected value="">-- Seleccionar Proveedor --</option>
                <?php while ($proveedor = mysqli_fetch_assoc($resultado_obtener_proveedores)): ?>
                    <option value="<?php echo $proveedor['id']; ?>"> <?php echo $proveedor['nombres']; ?> </option>
                <?php endwhile; ?>
            </select>

        </fieldset>

        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="compras.php?cancelado='true'">
                <span>Cancelar</span>
            </a>

            <input type="submit" value="Agregar" class="boton-azul">

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
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($lista_productos as $producto): ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['descripcion']; ?></td>
                        <td><?php echo $producto['cantidad']; ?></td>
                        <td><?php echo $producto['categoria']; ?></td>
                        <td><?php echo $producto['precio_unitario']; ?></td>
                        <td><?php echo ($producto['cantidad'] * $producto['precio_unitario']) ?></td>
                    </tr>
                <?php $i++;
                endforeach; ?>
            </tbody>
        </table>
    </div>

</main>

<?php incluirTemplate('footer'); ?>