<?php

$id_contado = filter_var($_GET['id'], FILTER_VALIDATE_INT);

if (!$id_contado) {
    header('Location: contado.php');
}

$errores = [];
$resultado_mostrar_detalle_array = [];

if (!isset($db) || !isset($id_contado) || !filter_var($id_contado, FILTER_VALIDATE_INT)) {
    error_log("Error: \$db o \$id_contado no están definidos o son inválidos al incluir data/credito/detalles.php. No se puede cargar el crédito.");
} else {
    $query_mostrar_detalle = "SELECT p.nombre, p.precio_unitario, dc.cantidad, p.precio_unitario * dc.cantidad AS subtotal,
                                    c.total, c.fecha_contado
                            FROM Contado c
                            JOIN DetalleContado dc ON c.id_contado = dc.id_contado
                            JOIN Producto p ON dc.codigo_producto = p.codigo_producto
                            WHERE c.id_contado = ?";

    $stmt = mysqli_prepare($db, $query_mostrar_detalle);
    if ($stmt === false) {
        error_log("Error al preparar la consulta de detalle de contado en data/contado/detalles.php: " . mysqli_error($db));
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $id_contado);
        mysqli_stmt_execute($stmt);
        $resultado_mysql_original = mysqli_stmt_get_result($stmt);

        if ($resultado_mysql_original) {
            if (mysqli_num_rows($resultado_mysql_original) > 0) {
                $primer_registro = mysqli_fetch_assoc($resultado_mysql_original);

                $total_contado = $primer_registro['total'];

                mysqli_data_seek($resultado_mysql_original, 0);

                $resultado_mostrar_detalle_array = mysqli_fetch_all($resultado_mysql_original, MYSQLI_ASSOC);
            } else {

                error_log("No se encontraron detalles para el crédito ID: " . $id_contado);
            }
            mysqli_free_result($resultado_mysql_original);
        } else {
            error_log("Error al obtener el resultado de la consulta de detalle de crédito en data/contado/detalles.php: " . mysqli_error($db));
        }
        mysqli_stmt_close($stmt);
    }
}
