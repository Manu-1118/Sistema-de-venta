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


// verificar que se mando informacion al post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener los valores del POST y escapar las cadenas de texto para evitar inyecciones sql
    $nombres = mysqli_real_escape_string($db, $_POST['txtNombres']);
    $apellidos = mysqli_real_escape_string($db, $_POST['txtApellidos']);
    // si un campo esta vacio, mandar error
    if (!$nombres || !$apellidos) {
        $errores[] = "Todos los campos son obligatorios";
    }

    // // si el arreglo de errores esta vacio, hacer la insercion
    if (empty($errores)) {

        // Crear consulta con los valores
        $query_insertar = "INSERT INTO Cliente(nombres, apellidos) VALUES ('$nombres', '$apellidos');";


        $resultado_insertar = mysqli_query($db, $query_insertar);


        // si el resultado devolvio una fila modificada mostrar que si se inserto
        if ($resultado_insertar) {
            header('Location: /admin/control/clientes.php?resultado=1');
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
            <legend>Agregar Cliente</legend>

            <label for="txtNombres">Nombres</label>
            <input type="text" name="txtNombres" placeholder="Nombres del cliente" id="txtNombres" value="<?php echo $nombre; ?>">

            <label for="txtApellidos">Apellidos</label>
            <input type="text" name="txtApellidos" placeholder="Apellidos del cliente" id="txtApellidos" value="<?php echo $apellido; ?>">

        </fieldset>

        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="clientes.php">
                <span>Cancelar</span>
            </a>

            <input type="submit" value="Agregar" class="boton-azul">

        </div>

    </form>
</main>

<?php incluirTemplate('footer'); ?>