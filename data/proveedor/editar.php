<?php #editar.php

$codigoRUC = filter_var($_GET['id'], FILTER_VALIDATE_INT); // obtener el codigo del producto a editar y verificar que sea un valor correcto
if (!$codigoRUC) {
    header('Location: proveedores.php');
}

// Obtener el producto seleccionado
$proveedor = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM Proveedor WHERE codigo_RUC = $codigoRUC;"));
$errores = []; // arreglo para almacenar los errores
// variables para obtener de manera temporal los valores digitados
$RUC = $proveedor['codigo_RUC'];
$nombre = $proveedor['nombre'];
$apellido = $proveedor['apellido'];
$empresa = $proveedor['empresa'];
$telefono = $proveedor['telefono'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener los valores del POST y escapar las cadenas de texto para evitar inyecciones sql
    // $codigo = mysqli_real_escape_string($db, $_POST['txtCodigo']);
    $RUC = mysqli_real_escape_string($db, $_POST['txtRUC']);
    $nombre = mysqli_real_escape_string($db, $_POST['txtNombre']);
    $apellido = mysqli_real_escape_string($db, $_POST['txtApellido']);
    $empresa = mysqli_real_escape_string($db, $_POST['txtEmpresa']);
    $telefono = mysqli_real_escape_string($db, $_POST['txtTelefono']);

    // si un campo esta vacio, mandar error
    if (!$RUC || !$nombre || !$apellido || !$empresa || !$telefono) {
        $errores[] = "Favor rellene todos los campos y con su formato correspondiente";
    }

    // si no hay errores hacer el proceso de insercion
    if (empty($errores)) {


        /*
        *   consulta para insertar el producto
        *   2: se inserto correctamente
        *   -1: hubo un error al insertar en la bd
        */
        $insertar_proveedor = "UPDATE Proveedor SET codigo_RUC = '$RUC', nombre = '$nombre', apellido = '$apellido', empresa = '$empresa', telefono = '$telefono' WHERE codigo_RUC = '$codigoRUC'";

        $resultado_insertar = mysqli_query($db, $insertar_proveedor);


        if ($resultado_insertar) {
            header('Location: proveedores.php?resultado=2');
        } else {
            header('Location: proveedores.php?resultado=-1');
        }
    }
}
