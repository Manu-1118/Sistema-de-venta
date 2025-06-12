<?php #insertar.php (administrador)

// consulta para verificar si el correo existe
$correos_bd = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM Administrador;"));

$errores = [];  // Arreglo para validacion

// variables para almacenar temporalmente los datos de la entidad
$nombre = '';
$apellido = '';
$correo = '';
$clave = '';
$clave_confirmar = '';

// verificar que se mando informacion al post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //debuguear($_POST);
    // Obtener los valores del POST y escapar las cadenas de texto para evitar inyecciones sql
    $nombre = mysqli_real_escape_string($db, $_POST['txtNombre']);
    $apellido = mysqli_real_escape_string($db, $_POST['txtApellido']);
    $correo = mysqli_real_escape_string($db, $_POST['txtCorreo']);
    $clave = mysqli_real_escape_string($db, $_POST['txtClave']);
    $clave_confirmar = mysqli_real_escape_string($db, $_POST['txtClaveConfirmar']);

    // asignacion de atributos de la variable $_FILES
    $imagen = $_FILES['imagen'];

    // si un campo esta vacio, mandar error
    if (!$nombre || !$clave || !$correo || !$clave_confirmar) {
        $errores[] = "Todos los campos son obligatorios";
    }

    if (strlen($clave) < 6) {
        $errores[] = "La contraseña tiene que ser mayor de 6 caracteres";
    }

    // validar que se suba una imagen
    if (!$imagen['name'] || $imagen['error']) {
        $errores[] = "La imagen es obligatoria";
    }

    //validar el tamaño de la imagen (1mb max)
    if ($imagen['size'] > (1000 * 1000)) {
        $errores[] = "La imagen es muy pesada";
    }

    //validar que el correo digitado no exista en la bd
    foreach ($correos_bd as $CBD) {
        if ($CBD == $correo) {
            $errores[] = "Ese correo ya está registrado";
        }
    }

    // confirmar que las contraseñas digitadas sean las mismas
    if ($clave !== $clave_confirmar) {
        $errores[] = "Las contraseñas no son iguales";
    }

    // // si el arreglo de errores esta vacio, crear el admin
    if (empty($errores)) {

        // hashear la contraseña
        $claveHash = password_hash($clave, PASSWORD_DEFAULT);

        // procesar la imagen y guardarlar en el server
        crearContenedorImagenes();
        $nombre_imagen = guardarImagen('administradores', $imagen);

        // Crear consulta con los valores
        $query_insertar = "INSERT INTO Administrador(nombre, apellido, correo, clave, imagen) VALUES ('$nombre', '$apellido', '$correo', '$claveHash', '$nombre_imagen');";

        $resultado_insertar = mysqli_query($db, $query_insertar);


        // si el resultado devolvio una fila modificada mostrar que si se inserto
        if ($resultado_insertar) {
            header('Location: administradores.php?resultado=1');
        }
    }
}
