<?php

$db = conectarDB();
$query = "SELECT * FROM Producto";
$resultado = mysqli_query($db, $query);
while ($producto = mysqli_fetch_assoc($resultado)) {
    $productos[] = $producto;
}
$productos = json_encode($productos);
$errores = [];
$mensaje = '';

date_default_timezone_set('America/Managua');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $total = mysqli_real_escape_string($db, $_POST['totalCompra'] ?? '');
    $productosContado = json_decode($_POST['productosSeleccionados'] ?? '[]', true);

    if (empty($total) || !is_numeric($total) || $total <= 0) {
        $errores[] = "El total debe ser un número mayor que cero.";
    }
    if (empty($productosContado)) {
        $errores[] = "Debes agregar al menos un producto.";
    }

    foreach ($productosContado as $producto) {
    $codigoProducto = mysqli_real_escape_string($db, $producto['codigo'] ?? '');
    $cantidadSolicitada = mysqli_real_escape_string($db, $producto['cantidad'] ?? 0);

    // Consultar stock actual y nombre del producto
    $consultaStock = "SELECT cantidad, nombre FROM Producto WHERE codigo_producto = '$codigoProducto'";
    $resultadoStock = mysqli_query($db, $consultaStock);
    $row = mysqli_fetch_assoc($resultadoStock);
    $stockDisponible = $row['cantidad'] ?? 0;
    $nombreProducto = $row['nombre'] ?? 'Producto desconocido';

    if ($cantidadSolicitada > $stockDisponible) {
        $errores[] = "No hay suficiente stock para '$nombreProducto'. Stock disponible: $stockDisponible.";
    }
}

    if (empty($errores)) {

        $fechaContado = date('Y-m-d H:i:s');

        $queryContado = "INSERT INTO Contado (fecha_contado, total) VALUES ('$fechaContado', $total)";
        $resultadoContado = mysqli_query($db, $queryContado);

        if (!$resultadoContado) {
            $errores[] = "Error al registrar la venta al contado: " . mysqli_error($db);
        } else {
            $idContado = mysqli_insert_id($db);

            foreach ($productosContado as $producto) {
                $codigoProducto = mysqli_real_escape_string($db, $producto['codigo'] ?? '');
                $cantidad = mysqli_real_escape_string($db, $producto['cantidad'] ?? 0);

                if (empty($codigoProducto) || !is_numeric($cantidad) || $cantidad <= 0) {
                    $errores[] = "La cantidad del producto '$codigoProducto' no es válida.";
                    continue;
                }

                // Insertar detalle
                $queryDetalle = "INSERT INTO DetalleContado (cantidad, codigo_producto, id_contado) VALUES ($cantidad, '$codigoProducto', $idContado)";
                $resultadoDetalle = mysqli_query($db, $queryDetalle);

                if (!$resultadoDetalle) {
                    $errores[] = "Error al insertar el detalle para el producto '$codigoProducto': " . mysqli_error($db);
                } else {
                    // Actualizar stock
                    $queryActualizarStock = "UPDATE Producto SET cantidad = cantidad - $cantidad WHERE codigo_producto = '$codigoProducto'";
                    $resultadoActualizar = mysqli_query($db, $queryActualizarStock);

                    if (!$resultadoActualizar) {
                        $errores[] = "Error al actualizar el stock del producto '$codigoProducto': " . mysqli_error($db);
                    }
                }
            }

            if (empty($errores)) {
                $mensaje = "Venta registrada correctamente.";
            } else {
                $errores[] = "Venta registrada, pero hubo errores con algunos detalles.";
            }
        }
    }
}
?>