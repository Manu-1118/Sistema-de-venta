<?php

$errores = [];

$nombre = '';
$descripcion = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = mysqli_real_escape_string($db, $_POST['txtNombre']);
    $descripcion = mysqli_real_escape_string($db, $_POST['txtDescripcion']);

    // asignacion de atributos de la variable $_FILES
    $imagen = $_FILES['imagen'];
    //debuguear($imagen['name']);

    // si un campo esta vacio, mandar error
    if (!$nombre || !$descripcion) {
        $errores[] = "Favor rellene todos los campos y con su formato correspondiente";
    }

    // validar que se suba una imagen
    if (!$imagen['name'] || $imagen['error']) {
        $errores[] = "La imagen es obligatoria";
    }

    //validar el tamaño de la imagen (1mb max)
    if ($imagen['size'] > (1000 * 1000)) {
        $errores[] = "La imagen es muy pesada";
    }

    // si no hay errores hacer el proceso de insercion
    if (empty($errores)) {

        // procesar la imagen y guardarlar en el server
        crearContenedorImagenes();
        $nombre_imagen = guardarImagen('categorias', $imagen);

        $nueva_categoria = "INSERT INTO Categoria (nombre, descripcion, imagen) VALUES ('$nombre', '$descripcion', '$nombre_imagen');";
        $resultado_insertar = mysqli_query($db, $nueva_categoria);

        if ($resultado_insertar) {
            header('Location: crear.php');
        } else {
            header('Location: productos.php?resultado=-1');
        }
    }
}
