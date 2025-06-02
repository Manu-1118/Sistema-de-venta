<?php #editar.php

$codigoAdmin = filter_var($_GET['id'], FILTER_VALIDATE_INT); // obtener el codigo del producto a editar y verificar que sea un valor correcto
if (!$codigoAdmin) {
    header('Location: Administradores.php');
}

// Obtener el producto seleccionado
$admin = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM Administrador WHERE id_administrador = $codigoAdmin;"));


$errores = []; // arreglo para almacenar los errores
// variables para obtener de manera temporal los valores digitados
$correo = $admin['correo'];
$nombre = $admin['nombre'];
$apellido = $admin['apellido'];
$imagen_admin = $admin['imagen'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener los valores del POST y escapar las cadenas de texto para evitar inyecciones sql
    // $codigo = mysqli_real_escape_string($db, $_POST['txtCodigo']);
    $nombre = mysqli_real_escape_string($db, $_POST['txtNombre']);
    $apellido = mysqli_real_escape_string($db, $_POST['txtApellido']);
    // $correo = mysqli_real_escape_string($db, $_POST['txtCorreo']);

    // asignacion de atributos de la variable $_FILES
    $imagen = $_FILES['imagen'];

    // si un campo esta vacio, mandar error
    if (!$nombre || !$apellido) {
        $errores[] = "Favor rellene todos los campos y con su formato correspondiente";
    }

    //validar el tamaño de la imagen (1mb max)
    if ($imagen['size'] > (1000 * 1000)) {
        $errores[] = "La imagen es muy pesada";
    }

    // si no hay errores hacer el proceso de insercion
    if (empty($errores)) {

        $nombre_imagen = '';

        // verificar que se este subiendo una nueva imagen
        if ($imagen['name']) {

            modificarImagen('administradores', $admin); // eliminar la imagen previa
            $nombre_imagen = guardarImagen('administradores', $imagen); // guardar la nueva imagen
        } else {

            $nombre_imagen = $admin['imagen']; // asignar la misma imagen para no borrarla 
        }

        // procesar la imagen y guardarlar en el server

        /*
        *   consulta para insertar el producto
        *   2: se inserto correctamente
        *   -1: hubo un error al insertar en la bd
        */
        $insertar_admin = "UPDATE Administrador SET nombre = '$nombre', apellido = '$apellido', imagen = '$nombre_imagen' WHERE id_administrador = '$codigoAdmin'";

        $resultado_insertar = mysqli_query($db, $insertar_admin);


        if ($resultado_insertar) {

            // session_start();
            // $_SESSION['imagen'] = $nombre_imagen;
            // $_SESSION['direccion'] = basename($_SERVER['PHP_SELF']);

            // header('Location: /data/obtener_sesion.php');
            header('Location: administradores.php?resultado=2');
        } else {
            header('Location: administradores.php?resultado=-1');
        }
    }
}
