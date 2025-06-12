<?php
$idDevuelto = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if (!$idDevuelto) {
    header('Location: devueltos.php');
    exit; 
}

$errores = []; 
$resultado_mostrar_detalle_array = []; 
$total_contado = 0; 
$fecha_devolucion = ''; 

if (!isset($db) || !$db) {
    error_log("Error: La conexión a la base de datos (\$db) no está definida o es inválida en data/devueltos/detalles.php. No se pueden cargar los detalles.");
    $errores[] = "Error de conexión a la base de datos. Por favor, inténtelo de nuevo más tarde.";
} else {

    $query_mostrar_detalle = "SELECT p.nombre, p.precio_unitario, dd.cantidad, p.precio_unitario * dd.cantidad AS subtotal,
                                    d.total, d.fecha_devolucion,
                                    dd.codigo_detalle_devolucion, dd.estado_devolucion, dd.codigo_producto
                            FROM Devolucion d
                            JOIN DetalleDevolucion dd ON d.id_devolucion = dd.id_devolucion
                            JOIN Producto p ON dd.codigo_producto = p.codigo_producto
                            WHERE d.id_devolucion = ?";

    $stmt = mysqli_prepare($db, $query_mostrar_detalle);

    if ($stmt === false) {
        error_log("Error al preparar la consulta de detalle de devolucion en data/devueltos/detalles.php: " . mysqli_error($db));
        $errores[] = "Error interno al preparar la consulta de detalles.";
    } else {
        // Enlaza el parámetro id_devolucion a la consulta preparada
        mysqli_stmt_bind_param($stmt, 'i', $idDevuelto);
        mysqli_stmt_execute($stmt);
        $resultado_mysql_original = mysqli_stmt_get_result($stmt);

        if ($resultado_mysql_original) {
            if (mysqli_num_rows($resultado_mysql_original) > 0) {
                $resultado_mostrar_detalle_array = mysqli_fetch_all($resultado_mysql_original, MYSQLI_ASSOC);

                if (!empty($resultado_mostrar_detalle_array)) {
                    $primer_registro = $resultado_mostrar_detalle_array[0];
                    $total_contado = $primer_registro['total'];
                    $fecha_devolucion = $primer_registro['fecha_devolucion'];
                }

            } else {
                error_log("No se encontraron detalles para la devolucion ID: " . $idDevuelto);
                $errores[] = "No se encontraron detalles para esta devolución.";
            }
            mysqli_free_result($resultado_mysql_original);
        } else {
            error_log("Error al obtener el resultado de la consulta de detalle de devolucion en data/devueltos/detalles.php: " . mysqli_error($db));
            $errores[] = "Error al obtener los detalles de la devolución.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>