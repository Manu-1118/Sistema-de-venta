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
$estadoDev = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $total = mysqli_real_escape_string($db, $_POST['totalDevuelto'] ?? '');
    $productosDevueltos = json_decode($_POST['productosSeleccionados'] ?? '[]', true); 
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion'] ?? ''); 

    if (empty($descripcion)) {
        $errores[] = "No se puede registrar un producto si el campo de descripción está vacío.";
    }
    if (empty($total) || !is_numeric($total) || $total <= 0) {
        $errores[] = "El total debe ser un número mayor que cero para registrar.";
    }

    if (empty($productosDevueltos)) {
        $errores[] = "Debes agregar al menos un producto para registrar.";
    }

    // Verificar stock disponible antes de registrar
    foreach ($productosDevueltos as $producto) {
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
            $errores[] = "El producto '$codigoProducto' no existe.";
            continue;
        }

        if ($productoDB['cantidad'] < $cantidadSolicitada) {
            $errores[] = "El producto '{$productoDB['nombre']}'. no esta disponoble, Stock disponible: {$productoDB['cantidad']}, solicitado: $cantidadSolicitada.";
        }
    }

    if (empty($errores)) {
        // Insertar en tabla Credito
        $fechaDevuelto = date('Y-m-d H:i:s');
        $queryCredito = "INSERT INTO Devolucion (
            fecha_devolucion, total, descripcion
        ) VALUES (
            '$fechaDevuelto', $total, '$descripcion'
        )";
        $resultadoDevuelto = mysqli_query($db, $queryCredito);

        if (!$resultadoDevuelto) {
            $errores[] = "Error al registrar el crédito: " . mysqli_error($db);      
        } else {
            $idDevuelto = mysqli_insert_id($db);

            foreach ($productosDevueltos as $producto) {
                $codigoProducto = mysqli_real_escape_string($db, $producto['codigo'] ?? '');
                $cantidad = mysqli_real_escape_string($db, $producto['cantidad'] ?? 0);

                // Insertar detalle
                $queryDetalle = "INSERT INTO DetalleDevolucion (cantidad,estado_devolucion, codigo_producto, id_devolucion) 
                                VALUES ($cantidad, $estadoDev,'$codigoProducto', $idDevuelto)";
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
                $mensaje = "Daño registrado correctamente.";
            } else {
                $errores[] = "Daño principal registrado, pero hubo errores al registrar algunos detalles.";
            }
        }
    }
}
?>