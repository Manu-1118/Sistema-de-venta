<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';
estaAutenticado(); //verificar que $_SESSION sea true

//Conectar la bd
$db = conectarDB();

// consulta para verificar si el correo existe
$query_mostrar = "SELECT * FROM usuarios;";
$resultado_mostrar = mysqli_query($db, $query_mostrar);
$correos_bd = mysqli_fetch_assoc($resultado_mostrar);

//Arreglo para validacion
$errores = [];

$nombre = '';
$clave = '';
$correo = '';


// verificar que se mando informacion al post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener los valores del POST y escapar las cadenas de texto para evitar inyecciones sql
    $nombre = mysqli_real_escape_string($db, $_POST['txtNombre']);
    $clave = mysqli_real_escape_string($db, $_POST['txtClave']);
    $correo = mysqli_real_escape_string($db, $_POST['txtCorreo']);

    // si un campo esta vacio, mandar error
    if (!$nombre || !$clave || !$correo) {
        $errores[] = "Todos los campos son obligatorios";
    }

    //validar que el correo digitado no exista en la bd
    foreach ($correos_bd as $CBD) {
        if ($CBD == $correo) {
            $errores[] = "Ese correo ya existe";
        }
    }

    // // si el arreglo de errores esta vacio, hacer la insercion
    if (empty($errores)) {

        // hashear la contraseña
        $claveHash = password_hash($clave, PASSWORD_DEFAULT);

        // Crear consulta con los valores
        $query_insertar = "INSERT INTO usuarios(nombre, email, pass) VALUES ('$nombre', '$correo', '$claveHash');";

        $resultado_insertar = mysqli_query($db, $query_insertar);


        // si el resultado devolvio una fila modificada mostrar que si se inserto
        if ($resultado_insertar) {
            header('Location: /admin/control/administradores.php?resultado=1');
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
            <legend>Agregar Administrador</legend>

            <label for="txtNombre">Nombre</label>
            <input type="text" name="txtNombre" placeholder="Nombre de usuario" id="txtNombre" value="<?php echo $nombre; ?>">

            <label for="txtCorreo">Correo</label>
            <input type="email" name="txtCorreo" placeholder="correo@correo.com" id="txtCorreo" value="<?php echo $correo; ?>">

            <label for="txtClave">Contraseña</label>
            <input type="password" name="txtClave" placeholder="Contraseña" id="txtClave" value="<?php echo $clave; ?>">

        </fieldset>

        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="administradores.php">
                <span>Cancelar</span>
            </a>

            <input type="submit" value="Agregar" class="boton-azul">

        </div>

    </form>
</main>

<?php incluirTemplate('footer'); ?>