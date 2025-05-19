<?php #editar.php

$codigo_producto = filter_var($_GET['id'], FILTER_VALIDATE_INT); // obtener el codigo del producto a editar y verificar que sea un valor correcto
if (!$codigo_producto) {
    header('Location: productos.php');
}

// Obtener el producto seleccionado
$producto = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM Producto WHERE codigo_producto = $codigo_producto;"));

/** CARGAR LAS CATEGORIAS PARA EL DROPDOWN **/
$Categorias = mysqli_query($db, "SELECT * FROM Categoria;");

$errores = []; // arreglo para almacenar los errores
// variables para obtener de manera temporal los valores digitados
$codigo = $producto['codigo_producto'];
$nombre = $producto['nombre'];
$precio = $producto['precio_unitario'];
$descripcion = $producto['descripcion'];
$imagen_producto = $producto['imagen'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener los valores del POST y escapar las cadenas de texto para evitar inyecciones sql
    // $codigo = mysqli_real_escape_string($db, $_POST['txtCodigo']);
    $nombre = mysqli_real_escape_string($db, $_POST['txtNombre']);
    $precio = mysqli_real_escape_string($db, $_POST['txtPrecio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['txtDescripcion']);
    $categoria = $_POST['cbCategoria'];

    // asignacion de atributos de la variable $_FILES
    $imagen = $_FILES['imagen'];

    // si un campo esta vacio, mandar error
    if (!$nombre || !$precio || !$descripcion || !$categoria) {
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

            modificarImagen('productos', $producto); // eliminar la imagen previa
            $nombre_imagen = guardarImagen('productos', $imagen); // guardar la nueva imagen
        } else {

            $nombre_imagen = $producto['imagen']; // asignar la misma imagen para no borrarla 
        }

        // procesar la imagen y guardarlar en el server

        /*
        *   consulta para insertar el producto
        *   2: se inserto correctamente
        *   -1: hubo un error al insertar en la bd
        */
        $insertar_producto = "UPDATE Producto SET nombre = '$nombre', precio_unitario = '$precio', descripcion = '$descripcion', id_categoria = '$categoria', imagen = '$nombre_imagen' WHERE codigo_producto = '$codigo_producto'";

        $resultado_insertar = mysqli_query($db, $insertar_producto);


        if ($resultado_insertar) {
            header('Location: productos.php?resultado=2');
        } else {
            header('Location: productos.php?resultado=-1');
        }
    }
}
