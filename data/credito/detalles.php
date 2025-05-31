<?php
$errores = [];
$resultado_mostrar_detalle_array = []; 
$total_credito_actual = 0;
$monto_pagado_actual = 0;
$monto_pendiente_actual = $total_credito_actual;
$fecha_cancelacion_credito = '';


if (!isset($db) || !isset($id_credito) || !filter_var($id_credito, FILTER_VALIDATE_INT)) {
    error_log("Error: \$db o \$id_credito no están definidos o son inválidos al incluir data/credito/detalles.php. No se puede cargar el crédito.");

} else {
    $query_mostrar_detalle = "SELECT p.nombre, p.precio_unitario, dc.cantidad, p.precio_unitario * dc.cantidad AS subtotal,
                                    c.total, c.monto_pagado, c.monto_pendiente, c.fecha_cancelacion
                            FROM Credito c
                            JOIN DetalleCredito dc ON c.id_credito = dc.id_credito
                            JOIN Producto p ON dc.codigo_producto = p.codigo_producto
                            WHERE c.id_credito = ?";

    $stmt = mysqli_prepare($db, $query_mostrar_detalle);

    if ($stmt === false) {
        error_log("Error al preparar la consulta de detalle de crédito en data/credito/detalles.php: " . mysqli_error($db));

    } else {
        mysqli_stmt_bind_param($stmt, 'i', $id_credito);
        mysqli_stmt_execute($stmt);
        $resultado_mysql_original = mysqli_stmt_get_result($stmt); 
        
        if ($resultado_mysql_original) { 
            if (mysqli_num_rows($resultado_mysql_original) > 0) {
                $primer_registro = mysqli_fetch_assoc($resultado_mysql_original);

                $total_credito_actual = $primer_registro['total'];
                $monto_pagado_actual = $primer_registro['monto_pagado'];
                $monto_pendiente_actual = $primer_registro['monto_pendiente'];
                $fecha_cancelacion_credito = $primer_registro['fecha_cancelacion'];

                mysqli_data_seek($resultado_mysql_original, 0);

                $resultado_mostrar_detalle_array = mysqli_fetch_all($resultado_mysql_original, MYSQLI_ASSOC);

            } else {
                
                error_log("No se encontraron detalles para el crédito ID: " . $id_credito);
            }
            mysqli_free_result($resultado_mysql_original); 
        } else {
            error_log("Error al obtener el resultado de la consulta de detalle de crédito en data/credito/detalles.php: " . mysqli_error($db));
        }
        mysqli_stmt_close($stmt); 
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $monto_abonar = $_POST['txtMontoAbono'] ?? 0;

    $monto_abonar_filtrado = filter_var($monto_abonar, FILTER_VALIDATE_FLOAT);

    if ($monto_abonar_filtrado === false || $monto_abonar_filtrado <= 0) {
        $errores[] = "El monto a abonar debe ser un número positivo válido.";
    } else {
        $monto_abonar = $monto_abonar_filtrado;

        if ($monto_abonar > $monto_pendiente_actual) { 
            $errores[] = "No se puede abonar una cantidad mayor al monto pendiente";
        } else {
            $query_actualizar_credito = "SELECT monto_pagado, total FROM Credito WHERE id_credito = ?";
            $stmt_actualizar_credito = mysqli_prepare($db, $query_actualizar_credito);

            if ($stmt_actualizar_credito) {
                mysqli_stmt_bind_param($stmt_actualizar_credito, 'i', $id_credito);
                mysqli_stmt_execute($stmt_actualizar_credito);
                $res_actualizar_credito = mysqli_stmt_get_result($stmt_actualizar_credito);
                $credito_data_for_update = mysqli_fetch_assoc($res_actualizar_credito);
                mysqli_free_result($res_actualizar_credito);
                mysqli_stmt_close($stmt_actualizar_credito);

                if ($credito_data_for_update) {
                    $monto_pagado_db_actual = $credito_data_for_update['monto_pagado'];
                    $total_credito_db_actual = $credito_data_for_update['total'];

                    $nuevo_monto_pagado = $monto_pagado_db_actual + $monto_abonar;
                    $nuevo_monto_pendiente = $total_credito_db_actual - $nuevo_monto_pagado;

                    if ($nuevo_monto_pendiente < 0) {
                        $nuevo_monto_pendiente = 0;
                        $nuevo_monto_pagado = $total_credito_db_actual;
                    }

                    $query_update = "UPDATE Credito SET monto_pagado = ?, monto_pendiente = ? WHERE id_credito = ?";
                    $stmt_update = mysqli_prepare($db, $query_update);

                    if ($stmt_update) {
                        mysqli_stmt_bind_param($stmt_update, 'ddi', $nuevo_monto_pagado, $nuevo_monto_pendiente, $id_credito);
                        if (mysqli_stmt_execute($stmt_update)) {
                            if ($nuevo_monto_pendiente == 0) { 
                                $_SESSION['mensaje_abono'] = "¡Crédito saldado completamente! Gracias por tu pago.";
                                $_SESSION['tipo_mensaje'] = 'exito';
                            } else {
                                $_SESSION['mensaje_abono'] = "Abono realizado correctamente.";
                                $_SESSION['tipo_mensaje'] = 'exito';
                            }
                            
                            header("Location: detalles.php?id=" . $id_credito); 
                            exit; 
                        } else {
                            error_log("Error al ejecutar la actualización del crédito: " . mysqli_error($db));
                            $errores[] = "Error al guardar el abono en la base de datos.";
                        }
                        mysqli_stmt_close($stmt_update);
                    } else {
                        error_log("Error al preparar la actualización del crédito: " . mysqli_error($db));
                        $errores[] = "Error interno al preparar la actualización del crédito.";
                    }
                } else {
                    error_log("No se encontró el crédito con ID: " . $id_credito . " para actualización (POST).");
                    $errores[] = "El crédito no se encontró o ya no existe (durante la operación).";
                }
            } else {
                error_log("Error al preparar consulta de actualización de crédito (POST): " . mysqli_error($db));
                $errores[] = "Error interno al preparar la consulta de actualización.";
            }
        }
    }
}
?>