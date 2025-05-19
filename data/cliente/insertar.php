<?php
$errores = []; //Arreglo para validacion

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
        $resultado_insertar = mysqli_query($db, "INSERT INTO Cliente(nombre, apellido) VALUES ('$nombres', '$apellidos');");


        // si el resultado devolvio una fila modificada mostrar que si se inserto
        if ($resultado_insertar) {
            header('Location: clientes.php?resultado=1');
        }
    }
}
