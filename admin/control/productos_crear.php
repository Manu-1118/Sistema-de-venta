<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';
estaAutenticado();

$db = conectarDB();

// Categorías disponibles
$categorias = ['Botanas', 'Lacteos', 'Carnes', 'Embutidos', 'Aceites', 'Verduras', 'Farmacia', 'Panadería', 'Enlatados', 'Higiene y Hogar'];

$errores = [];

$codigo = '';
$nombre = '';
$precio = '';
$cantidad = '';
$descripcion = '';
$categoria = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = mysqli_real_escape_string($db, $_POST['txtCodigo']);
    $nombre = mysqli_real_escape_string($db, $_POST['txtNombre']);
    $precio = mysqli_real_escape_string($db, $_POST['txtPrecio']);
    $cantidad = mysqli_real_escape_string($db, $_POST['txtCantidad']);
    $descripcion = mysqli_real_escape_string($db, $_POST['txtDescripcion']);
    $categoria = mysqli_real_escape_string($db, $_POST['cbCategoria']);

    // Validación
    if (!$codigo || !$nombre || !$precio || !$cantidad || !$descripcion || !$categoria) {
        $errores[] = "Todos los campos son obligatorios.";
    }

    if (!is_numeric($precio) || $precio < 0) {
        $errores[] = "El precio debe ser un número positivo.";
    }

    if (!ctype_digit($cantidad) || intval($cantidad) < 0) {
        $errores[] = "La cantidad debe ser un número entero no negativo.";
    }

    // Verificar si ya existe un producto con ese código
    $query_codigo = "SELECT * FROM Producto WHERE codigo = '$codigo'";
    $resultado_buscar_codigo = mysqli_query($db, $query_codigo);
    if (mysqli_num_rows($resultado_buscar_codigo) > 0) {
        $errores[] = "Ya existe un producto con ese código.";
    }

    // Insertar si no hay errores
    if (empty($errores)) {
        $query_insertar = "INSERT INTO Producto (codigo, nombre, precio_unitario, cantidad, categoria, descripcion)
                           VALUES ('$codigo', '$nombre', '$precio', '$cantidad', '$categoria', '$descripcion')";

        $resultado_insertar = mysqli_query($db, $query_insertar);

        if ($resultado_insertar) {
            header('Location: /admin/control/productos.php?resultado=1');
            exit;
        } else {
            $errores[] = "Error al insertar: " . mysqli_error($db);
        }
    }
}

$resultado_mensaje = $_GET['resultado'] ?? null;

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main admin main-admin menu-toggle">
    <?php if ($resultado_mensaje == 1): ?>
        <p class="alerta exito">Producto agregado correctamente</p>
    <?php endif; ?>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error"><?php echo $error; ?></div>
    <?php endforeach; ?>

    <form method="POST" class="formulario">
        <fieldset>
            <legend>Agregar Producto</legend>

            <label for="txtCodigo">Código</label>
            <input type="text" name="txtCodigo" id="txtCodigo" value="<?php echo $codigo; ?>" placeholder="358685">

            <label for="txtNombre">Nombre</label>
            <input type="text" name="txtNombre" id="txtNombre" value="<?php echo $nombre; ?>" placeholder="Leche Eskimo">

            <label for="txtPrecio">Precio unitario</label>
            <input type="number" step="0.01" name="txtPrecio" id="txtPrecio" value="<?php echo $precio; ?>" placeholder="40.00">

            <label for="txtCantidad">Cantidad</label>
            <input type="number" name="txtCantidad" id="txtCantidad" value="<?php echo $cantidad; ?>" placeholder="10">

            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png" disabled class="disabled">

            <label for="txtDescripcion">Descripción</label>
            <input type="text" name="txtDescripcion" id="txtDescripcion" value="<?php echo $descripcion; ?>" placeholder="Descripción del producto...">

            <label for="cbCategoria">Categoría</label>
            <select name="cbCategoria" id="cbCategoria">
                <option disabled selected>-- Seleccionar Categoría --</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?php echo $cat; ?>" <?php echo ($cat === $categoria) ? 'selected' : ''; ?>>
                        <?php echo $cat; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </fieldset>

        <div class="alinear-derecha separar-margin">
            <a class="boton-rojo" href="productos.php">Cancelar</a>
            <input type="submit" value="Agregar" class="boton-azul">
        </div>
    </form>
</main>

<?php incluirTemplate('footer'); ?>
