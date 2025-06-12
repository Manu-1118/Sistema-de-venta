<?php

//Arreglo para validacion
$errores = [];

$RUC = '';
$nombres = '';
$apellidos = '';
$empresa = '';
$telefono = '';


// verificar que se mando informacion al post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener los valores del POST y escapar las cadenas de texto para evitar inyecciones sql
    $RUC = mysqli_real_escape_string($db, $_POST['txtRUC']);
    $nombres = mysqli_real_escape_string($db, $_POST['txtNombre']);
    $apellidos = mysqli_real_escape_string($db, $_POST['txtApellido']);
    $empresa = mysqli_real_escape_string($db, $_POST['txtEmpresa']);
    $telefono = mysqli_real_escape_string($db, $_POST['txtTelefono']);

    // si un campo esta vacio, mandar error
    if (!$RUC || !$nombres || !$apellidos || !$empresa) {
        $errores[] = "Favor rellene todos los campos y con su formato correspondiente";
    }

    // si el arreglo de errores esta vacio, hacer la insercion
    if (empty($errores)) {

        // Crear consulta con los valores
        $query_insertar = "INSERT INTO Proveedor(codigo_RUC, nombre, apellido, empresa, telefono) VALUES ('$RUC', '$nombres', '$apellidos', '$empresa', '$telefono');";
        $resultado_insertar = mysqli_query($db, $query_insertar);

        // si el resultado devolvio una fila modificada mostrar que si se inserto
        if ($resultado_insertar) {
            header('Location: proveedores.php?resultado=1');
        }
    }
}
