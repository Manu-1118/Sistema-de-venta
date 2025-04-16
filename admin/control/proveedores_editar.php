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
    header('Location: /admin/control/proveedores.php');
}

// Consulta
$query_modi_proveedor = "SELECT * FROM Proveedor WHERE id = $id;";
$resultado_proveedor = mysqli_fetch_assoc(mysqli_query($db, $query_modi_proveedor));

//debuguear($resultado_proveedor);

$codigo = $resultado_proveedor['id'];
$nombres = $resultado_proveedor['nombres'];
$apellidos = $resultado_proveedor['apellidos'];
$empresa = $resultado_proveedor['empresa'];
$telefono = $resultado_proveedor['telefono'];

// verificar que se mando informacion al post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //debuguear($_POST);
    // Obtener los valores del POST y escapar las cadenas de texto para evitar inyecciones sql
    //$codigo = mysqli_real_escape_string($db, $_POST['txtNombre']);
    $nombres = mysqli_real_escape_string($db, $_POST['txtNombre']);
    $apellidos = mysqli_real_escape_string($db, $_POST['txtApellido']);
    $empresa = mysqli_real_escape_string($db, $_POST['txtEmpresa']);
    $telefono = mysqli_real_escape_string($db, $_POST['txtTelefono']);

    // si un campo esta vacio, mandar error
    if (!$nombres || !$apellidos || !$empresa) {
        $errores[] = "Los campos nombre, apellidos y empresa son obligatorios";
    }

    // si el arreglo de errores esta vacio, hacer la insercion
    if (empty($errores)) {

        // Crear consulta con los valores
        $query_modificar = "UPDATE Proveedor SET nombres = '$nombres', apellidos = '$apellidos', empresa = '$empresa', telefono = '$telefono' WHERE id = $id;";
        $resultado_modificar = mysqli_query($db, $query_modificar);

        // si el resultado devolvio una fila modificada mostrar que si se inserto
        if ($resultado_modificar) {
            header('Location: /admin/control/proveedores.php?resultado=2');
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
            <legend>Editar Proveedor</legend>

            <label for="txtCodigo">Codigo</label>
            <input disabled type="text" name="txtCodigo" placeholder="Nombre de usuario" id="txtCodigo" value="<?php echo $codigo; ?>">

            <label for="txtNombre">Nombres</label>
            <input type="text" name="txtNombre" placeholder="Nombre de usuario" id="txtNombre" value="<?php echo $nombres; ?>">

            <label for="txtApellido">Apellidos</label>
            <input type="text" name="txtApellido" placeholder="Apellido de usuario" id="txtApellido" value="<?php echo $apellidos; ?>">

            <label for="txtEmpresa">Empresa</label>
            <input type="text" name="txtEmpresa" placeholder="Disegsa" id="txtEmpresa" value="<?php echo $empresa; ?>">

            <label for="txtTelefono">Teléfono</label>
            <input type="number" name="txtTelefono" placeholder="76789865" id="txtTelefono" value="<?php echo $telefono; ?>">

        </fieldset>
        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="proveedores.php">
                <span>Cancelar</span>
            </a>

            <input type="submit" value="Editar" class="boton-azul">

        </div>

    </form>
</main>

<?php incluirTemplate('footer'); ?>