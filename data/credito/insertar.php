<?php

$db = conectarDB();
$query = "SELECT * FROM Producto";
$resultado = mysqli_query($db, $query);
while ($producto = mysqli_fetch_assoc($resultado)) {

    $productos[] = $producto;
}

$query2 = "SELECT * FROM Cliente";
$resultado2 = mysqli_query($db, $query2);
while ($cliente = mysqli_fetch_assoc($resultado2)) {
    $clientes[] = $cliente; 
}

$clientesJSON = json_encode($clientes);
$productos = json_encode($productos);
$errores = [];
$mensaje = '';

date_default_timezone_set('America/Managua');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $idCliente = mysqli_real_escape_string($db, $_POST['txtCliente'] ?? '');
    $total = mysqli_real_escape_string($db, $_POST['totalCompra'] ?? '');
    $productosCredito = json_decode($_POST['productosSeleccionados'] ?? '[]', true); 

    $fecha_cancelacion_post = $_POST['fecha_cancelacion'] ?? ''; 
    $fecha_cancelacion_sql = "NULL"; 

    if (!empty($fecha_cancelacion_post)) {
        $timestamp_cancelacion = strtotime($fecha_cancelacion_post);
        if ($timestamp_cancelacion !== false) {
            $fecha_cancelacion_sql = "'" . date('Y-m-d H:i:s', $timestamp_cancelacion) . "'";
        } else {
            $errores[] = "Formato de fecha de cancelación inválido. Por favor, selecciona una fecha válida.";
        }
    }

    if (empty($idCliente)) {
        $errores[] = "Debes seleccionar un cliente.";
    } elseif (!is_numeric($idCliente)) {
        $errores[] = "El ID del cliente no es válido.";
    }

    if (empty($total) || !is_numeric($total) || $total <= 0) {
        $errores[] = "El total debe ser un número mayor que cero.";
    }

    if (empty($productosCredito)) {
        $errores[] = "Debes agregar al menos un producto.";
    }

    // Verificar stock disponible antes de registrar
    foreach ($productosCredito as $producto) {
        $codigoProducto = mysqli_real_escape_string($db, $producto['codigo'] ?? '');
        $cantidadSolicitada = mysqli_real_escape_string($db, $producto['cantidad'] ?? 0);

        if (!is_numeric($cantidadSolicitada) || $cantidadSolicitada <= 0) {
            $errores[] = "La cantidad del producto '$codigoProducto' no es válida.";
            continue;
        }

        // Obtener stock actual
        $consultaStock = "SELECT cantidad, nombre FROM Producto WHERE codigo_producto = '$codigoProducto'";
        $resultadoStock = mysqli_query($db, $consultaStock);
        $productoDB = mysqli_fetch_assoc($resultadoStock);

        if (!$productoDB) {
            $errores[] = "El producto con código '$codigoProducto' no existe.";
            continue;
        }

        if ($productoDB['cantidad'] < $cantidadSolicitada) {
            $errores[] = "No hay suficiente stock para el producto '{$productoDB['nombre']}'. Stock disponible: {$productoDB['cantidad']}, solicitado: $cantidadSolicitada.";
        }
    }

    if (empty($errores)) {
        // Insertar en tabla Credito
        $fechaCredito = date('Y-m-d H:i:s');
        $queryCredito = "INSERT INTO Credito (
            fecha_credito, total, monto_pagado, monto_pendiente, id_cliente, fecha_cancelacion
        ) VALUES (
            '$fechaCredito', $total, 0, $total, $idCliente, $fecha_cancelacion_sql
        )";
        $resultadoCredito = mysqli_query($db, $queryCredito);

        if (!$resultadoCredito) {
            $errores[] = "Error al registrar el crédito: " . mysqli_error($db);      
        } else {
            $idCredito = mysqli_insert_id($db);

            foreach ($productosCredito as $producto) {
                $codigoProducto = mysqli_real_escape_string($db, $producto['codigo'] ?? '');
                $cantidad = mysqli_real_escape_string($db, $producto['cantidad'] ?? 0);

                // Insertar detalle
                $queryDetalle = "INSERT INTO DetalleCredito (cantidad, codigo_producto, id_credito) 
                                VALUES ($cantidad, '$codigoProducto', $idCredito)";
                $resultadoDetalle = mysqli_query($db, $queryDetalle);

                if (!$resultadoDetalle) {
                    $errores[] = "Error al insertar el detalle para el producto '$codigoProducto': " . mysqli_error($db);
                } else {
                    // Restar stock
                    $queryActualizarStock = "UPDATE Producto SET cantidad = cantidad - $cantidad WHERE codigo_producto = '$codigoProducto'";
                    mysqli_query($db, $queryActualizarStock);
                }
            }

            if (empty($errores)) {
                $mensaje = "Crédito registrado correctamente.";
            } else {
                $errores[] = "Crédito principal registrado, pero hubo errores al registrar algunos detalles.";
            }
        }
    }
}
?>