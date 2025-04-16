<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';
estaAutenticado(); //verificar que $_SESSION sea true

//Conectar la bd
$db = conectarDB();

//Arreglo para validacion
$errores = [];

$nombres = '';
$apellidos = '';
$empresa = '';
$telefono = '';


// verificar que se mando informacion al post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener los valores del POST y escapar las cadenas de texto para evitar inyecciones sql
    $nombres = mysqli_real_escape_string($db, $_POST['txtNombre']);
    $apellidos = mysqli_real_escape_string($db, $_POST['txtApellido']);
    $empresa = mysqli_real_escape_string($db, $_POST['txtEmpresa']);
    $telefono = mysqli_real_escape_string($db, $_POST['txtTelefono']);

    // si un campo esta vacio, mandar error
    if (!$nombres || !$apellidos || !$empresa) {
        $errores[] = "Rellenar el nombre, apellido o la empresa del proveedor";
    }

    // si el arreglo de errores esta vacio, hacer la insercion
    if (empty($errores)) {

        // Crear consulta con los valores
        $query_insertar = "INSERT INTO Proveedor(nombres, apellidos, empresa, telefono) VALUES ('$nombres', '$apellidos', '$empresa', '$telefono');";
        $resultado_insertar = mysqli_query($db, $query_insertar);

        // si el resultado devolvio una fila modificada mostrar que si se inserto
        if ($resultado_insertar) {
            header('Location: /admin/control/proveedores.php?resultado=1');
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
            <legend>Agregar Proveedor</legend>

            <label for="txtNombre">Nombres</label>
            <input type="text" name="txtNombre" placeholder="Nombre de usuario" id="txtNombre" value="<?php echo $nombre; ?>">

            <label for="txtApellido">Apellidos</label>
            <input type="text" name="txtApellido" placeholder="Apellido de usuario" id="txtApellido" value="<?php echo $nombre; ?>">

            <label for="txtEmpresa">Empresa</label>
            <input type="text" name="txtEmpresa" placeholder="Disegsa" id="txtEmpresa" value="<?php echo $correo; ?>">

            <label for="txtTelefono">Teléfono</label>
            <input type="number" name="txtTelefono" placeholder="76789865" id="txtTelefono" value="<?php echo $clave; ?>">

        </fieldset>

        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="proveedores.php">
                <span>Cancelar</span>
            </a>

            <input type="submit" value="Agregar" class="boton-azul">

        </div>

    </form>
</main>

<?php incluirTemplate('footer'); ?>