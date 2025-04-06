<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';
estaAutenticado(); //verificar que $_SESSION sea true

//Conectar la bd
$db = conectarDB();

//escribir el query
$query_mostrar = "SELECT * FROM Producto limit 5;";

//consultar la bd y obtener resultado
$resultado_mostrar = mysqli_query($db, $query_mostrar);

//Arreglo para validacion
$errores = [];

$codigo = '';
$nombre = '';
$precio = '';
$descripcion = '';
$categoria = '';


// verificar que se mando informacion al post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener los valores del POST y escapar las cadenas de texto para evitar inyecciones sql
    $codigo = mysqli_real_escape_string($db, $_POST['txtCodigo']);
    $nombre = mysqli_real_escape_string($db, $_POST['txtNombre']);
    $precio = mysqli_real_escape_string($db, $_POST['txtPrecio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['txtDescripcion']);
    $categoria = mysqli_real_escape_string($db, $_POST['cbCategoria']);

    // si un campo esta vacio, mandar error
    if (!$codigo || !$nombre || !$precio || !$descripcion || !$categoria) {
        $errores[] = "Todos los campos son obligatorios";
    }
    // Validar precio
    if (!is_numeric($precio)) {
        $errores[] = "El precio debe ser un número válido.";
    }

    // if (!$codigo==='') {

    //     $query_codigo = "SELECT * FROM Producto WHERE codigo = $codigo;";
    //     $resultado_buscar_codigo = mysqli_query($db, $query_insertar);

    //     if ($resultado_buscar_codigo) {
    //         $errores[] = "Ya existe un producto con ese código";
    //     }
    // }


    //debuguear($errores);

    // si el arreglo de errores esta vacio, hacer la insercion
    if (empty($errores)) {

        // Crear consulta con los valores
        $query_insertar = "INSERT INTO Producto (codigo, nombre, precio_unitario, descripcion, categoria) VALUES ('$codigo', '$nombre', '$precio', '$descripcion', '$categoria');";

        $resultado_insertar = mysqli_query($db, $query_insertar);

        //debuguear($resultado_insertar);

        // si el resultado devolvio una fila modificada mostrar que si se inserto
        if ($resultado_insertar) {
            header('Location: /admin/control/productos.php?resultado=1');
        } else {

            //header('Location: ' . $_SERVER['PHP_SELF'] . '?resultado=2');
            //header('Location: admin/control/productos.php?mensaje=Error al Añadir el Producto');
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
            <legend>Agregar Producto</legend>

            <label for="txtCodigo">Código</label>
            <input type="text" name="txtCodigo" placeholder="358685" id="txtCodigo" value="<?php echo $codigo; ?>">

            <label for="txtNombre">Nombre</label>
            <input type="text" name="txtNombre" placeholder="Leche Eskimo" id="txtNombre" value="<?php echo $nombre; ?>">

            <label for="txtPrecio">Precio unitario</label>
            <input type="number" name="txtPrecio" placeholder="40.00" id="txtPrecio" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png" disabled class="disabled">

            <label for="txtDescripcion">Descripción</label>
            <input type="text" name="txtDescripcion" placeholder="Leche Eskimo entera de 900ml..." id="txtDescripcion" value="<?php echo $descripcion; ?>">

            <label for="cbCategoria">Categoría</label>
            <select name="cbCategoria">
                <option disabled selected>-- Seleccionar Categoría --</option>
                <option value="1">Lacteos</option>
            </select>

        </fieldset>

        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="productos.php">
                <span>Cancelar</span>
            </a>

            <input type="submit" value="Agregar" class="boton-azul">

        </div>

    </form>
</main>

<?php incluirTemplate('footer'); ?>