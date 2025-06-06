<?php #insertar.php

/** CARGAR LAS CATEGORIAS PARA EL DROPDOWN **/
$Categorias = mysqli_query($db, "SELECT * FROM Categoria;");

$errores = []; // arreglo para almacenar los errores
// variables para obtener de manera temporal los valores digitados
$codigo = '';
$nombre = '';
$precio = '';
$precio_compra = '';
$descripcion = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // debuguear($_FILES);
    // Obtener los valores del POST y escapar las cadenas de texto para evitar inyecciones sql
    $codigo = mysqli_real_escape_string($db, $_POST['txtCodigo']);
    $nombre = mysqli_real_escape_string($db, $_POST['txtNombre']);
    $precio = mysqli_real_escape_string($db, $_POST['txtPrecio']);
    $precio_compra = mysqli_real_escape_string($db, $_POST['txtPrecioCompra']);
    $descripcion = mysqli_real_escape_string($db, $_POST['txtDescripcion']);
    $categoria = $_POST['cbCategoria'];

    // asignacion de atributos de la variable $_FILES
    $imagen = $_FILES['imagen'];
    //debuguear($imagen['name']);

    // si un campo esta vacio, mandar error
    if (!$codigo || !$nombre || !$precio || !$precio_compra || !$descripcion || !$categoria) {
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
        $nombre_imagen = guardarImagen('productos', $imagen);

        /*
        *   consulta para insertar el producto
        *   1: se inserto correctamente
        *   -1: hubo un error al insertar en la bd
        */
        $insertar_producto = "INSERT INTO Producto (codigo_producto, nombre, precio_unitario, descripcion, id_categoria, imagen, precio_compra) VALUES ('$codigo', '$nombre', '$precio', '$descripcion', '$categoria', '$nombre_imagen', '$precio_compra');";
        $resultado_insertar = mysqli_query($db, $insertar_producto);

        if ($resultado_insertar) {
            header('Location: productos.php?resultado=1');
        } else {
            header('Location: productos.php?resultado=-1');
        }
    }
}
