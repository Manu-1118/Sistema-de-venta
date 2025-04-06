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
// crear un arreglo para almacenar los productos seleccionados
$producto_seleccionados = [];
/** FIN TABLA PRODUCTOS **/

//Arreglo para validacion
$errores = [];




// verificar que se mando informacion al post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // debuguear($_POST);
    // // Obtener los valores del POST y escapar las cadenas de texto para evitar inyecciones sql
    // $codigo = mysqli_real_escape_string($db, $_POST['txtCodigo']);
    // $nombre = mysqli_real_escape_string($db, $_POST['txtNombre']);
    // $precio = mysqli_real_escape_string($db, $_POST['txtPrecio']);
    // $descripcion = mysqli_real_escape_string($db, $_POST['txtDescripcion']);
    // $categoria = mysqli_real_escape_string($db, $_POST['cbCategoria']);

    // // si un campo esta vacio, mandar error
    // if (!$codigo || !$nombre || !$precio || !$descripcion || !$categoria) {
    //     $errores[] = "Todos los campos son obligatorios";
    // }
    // // Validar precio
    // if (!is_numeric($precio)) {
    //     $errores[] = "El precio debe ser un número válido.";
    // }

    //debuguear($errores);

    // si el arreglo de errores esta vacio, hacer la insercion
    if (empty($errores)) {

        // Crear consulta con los valores
        // $query_insertar = "INSERT INTO Producto (codigo, nombre, precio_unitario, descripcion, categoria) VALUES ('$codigo', '$nombre', '$precio', '$descripcion', '$categoria');";

        // $resultado_insertar = mysqli_query($db, $query_insertar);

        /** INSERTAR DATOS EN LA TABLA DETALLE **/
        $query_insertar_detalle = "INSERT INTO DetalleContado (cantidad, codigo_producto, id_contado) VALUES ('$cantidad', '$codigo_producto', '$id_contado')";
        /** FIN TABLA DETALLE **/

        // si el resultado devolvio una fila modificada mostrar que si se inserto
        if ($resultado_insertar) {
            header('Location: /admin/control/contado.php?resultado=1');
        }
    }
}

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

            <label for="cbCategoria">Producto</label>
            <select name="cbCategoria">
                <option disabled selected>-- Seleccionar Categoría --</option>
                <?php while ($producto = mysqli_fetch_assoc($resultado_obtener_productos)): ?>
                    <option value="<?php echo $producto['codigo']; ?>"> <?php echo $producto['nombre']; ?> </option>
                <?php endwhile; ?>
            </select>

            <label for="txtCantidad">Total</label>
            <input type="number" name="txtCantidad" id="txtCantidad" value="<?php echo $nombre; ?>" min="1">

            <div class="">
                <a class="boton-azul" href="contado_crear.php?codigo=cbCategoria">Añadir a la lista</a>
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
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

</main>

<?php incluirTemplate('footer'); ?>