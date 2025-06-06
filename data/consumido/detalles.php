<?php
$id_consumido = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if (!$id_consumido) {
    header('Location: consumidos.php');
}

$errores = [];
$resultado_mostrar_detalle_array = [];

if (!isset($db) || !isset($id_consumido) || !filter_var($id_consumido, FILTER_VALIDATE_INT)) {
    error_log("Error: \$db o \$id_consumido no están definidos o son inválidos al incluir data/consumido/detalles.php. No se puede cargar la compra.");
} else {
    $query_mostrar_detalle = "SELECT p.nombre, p.precio_unitario, dc.cantidad, p.precio_unitario * dc.cantidad AS subtotal,
                                    c.total, c.fecha_consumido
                            FROM Consumido c
                            JOIN DetalleConsumido dc ON c.id_consumido = dc.id_consumido
                            JOIN Producto p ON dc.codigo_producto = p.codigo_producto
                            WHERE c.id_consumido = ?";
  $stmt = mysqli_prepare($db, $query_mostrar_detalle);
    if ($stmt === false) {
        error_log("Error al preparar la consulta de detalle de consumido en data/consumido/detalles.php: " . mysqli_error($db));
    } else{
        mysqli_stmt_bind_param($stmt, 'i', $id_consumido);
        mysqli_stmt_execute($stmt);
        $resultado_mysql_original = mysqli_stmt_get_result($stmt);

        if ($resultado_mysql_original) {
            if (mysqli_num_rows($resultado_mysql_original) > 0) {
                $primer_registro = mysqli_fetch_assoc($resultado_mysql_original);

                $total_consumido = $primer_registro['total'];

                mysqli_data_seek($resultado_mysql_original, 0);

                $resultado_mostrar_detalle_array = mysqli_fetch_all($resultado_mysql_original, MYSQLI_ASSOC);
            } else {

                error_log("No se encontraron detalles para el ID: " . $id_consumido);
            }
            mysqli_free_result($resultado_mysql_original);
        } else {
            error_log("Error al obtener el resultado de la consulta de detalle de consumido en data/consumido/detalles.php: " . mysqli_error($db));
        }
        mysqli_stmt_close($stmt);
    }
}

?>