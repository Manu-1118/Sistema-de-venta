<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';
estaAutenticado(); //verificar que $_SESSION sea true

//Conectar la bd
$db = conectarDB();
//Arreglo para validacion
$errores = [];
// validar que no se digite cualquier id
$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: /admin/control/productos.php');
}

// Consulta
$query_producto = "SELECT * FROM Producto WHERE codigo = $id;";
$resultado_producto = mysqli_fetch_assoc(mysqli_query($db, $query_producto));

//debuguear(mysqli_fetch_assoc($resultado_producto));

$codigo = $resultado_producto['codigo'];
$nombre = $resultado_producto['nombre'];
$precio = $resultado_producto['precio_unitario'];
$descripcion = $resultado_producto['descripcion'];
$categoria = $resultado_producto['categoria'];

// verificar que se mando informacion al post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener los valores del POST y escapar las cadenas de texto para evitar inyecciones sql
    $codigo = mysqli_real_escape_string($db, $_POST['txtCodigo']);
    $nombre = mysqli_real_escape_string($db, $_POST['txtNombre']);
    $precio = mysqli_real_escape_string($db, $_POST['txtPrecio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['txtDescripcion']);
    $categoria = mysqli_real_escape_string($db, $_POST['cbCategoria']);

    // si un campo esta vacio, mandar error
    if (!$nombre || !$precio || !$descripcion || !$categoria) {
        $errores[] = "Todos los campos son obligatorios";
    }
    // Validar precio
    if (!is_numeric($precio)) {
        $errores[] = "El precio debe ser un número válido.";
    }

    // si el arreglo de errores esta vacio, hacer la insercion
    if (empty($errores)) {

        // Crear consulta con los valores
        $query_modificar = "UPDATE Producto SET nombre = '$nombre', precio_unitario = '$precio', descripcion = '$descripcion', categoria = '$categoria' WHERE codigo = $id;";
        $resultado_modificar = mysqli_query($db, $query_modificar);

        // si el resultado devolvio una fila modificada mostrar que si se inserto
        if ($resultado_modificar) {
            header('Location: /admin/control/productos.php?resultado=2');
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
            <legend>Edita el Producto</legend>

            <label for="txtCodigo">Código</label>
            <input type="text" name="txtCodigo" placeholder="358685" id="txtCodigo" value="<?php echo $codigo; ?>" disabled>

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

            <input type="submit" value="Editar" class="boton-azul">

        </div>

    </form>
</main>

<?php incluirTemplate('footer'); ?>