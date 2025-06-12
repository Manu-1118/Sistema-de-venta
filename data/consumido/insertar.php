<?php
$db = conectarDB();

$query = "SELECT * FROM Producto";
$resultado = mysqli_query($db, $query);
$productos = [];
while ($producto = mysqli_fetch_assoc($resultado)) {
    $productos[] = $producto;
}

$productosJSON = json_encode($productos); 
$errores = [];
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $total = mysqli_real_escape_string($db, $_POST['totalCompra'] ?? '');
    $productosCompra = json_decode($_POST['productosSeleccionados'] ?? '[]', true);

    if (empty($total) || !is_numeric($total) || $total <= 0) {
        $errores[] = "El total debe ser un número mayor que cero.";
    }
    if (empty($productosCompra)) {
        $errores[] = "Debes agregar al menos un producto.";
    }
    if (empty($errores)) { 
        foreach ($productosCompra as $producto) {
            $codigoProducto = mysqli_real_escape_string($db, $producto['codigo_producto'] ?? ''); // Cambiado a 'codigo_producto'
            $cantidadSolicitada = mysqli_real_escape_string($db, $producto['cantidad'] ?? 0);

            $consultaStock = "SELECT cantidad, nombre FROM Producto WHERE codigo_producto = '$codigoProducto'";
            $resultadoStock = mysqli_query($db, $consultaStock);
            
            if (!$resultadoStock || mysqli_num_rows($resultadoStock) === 0) {
                $errores[] = "Producto con código '$codigoProducto' no encontrado en la base de datos.";
                continue;
            }
            
            $row = mysqli_fetch_assoc($resultadoStock);
            $stockDisponible = $row['cantidad']; 
            $nombreProducto = $row['nombre'];    

            if ($cantidadSolicitada > $stockDisponible) {
                $errores[] = "No hay suficiente stock para '$nombreProducto'. Stock disponible: $stockDisponible.";
            }
        }
    }
    if (empty($errores)) {

        $fechaConsumido = date('Y-m-d H:i:s'); 

        $queryConsumido = "INSERT INTO Consumido (fecha_consumido, total) VALUES ('$fechaConsumido', $total)";
        $resultadoConsumido = mysqli_query($db, $queryConsumido);

        if (!$resultadoConsumido) {
            $errores[] = "Error al registrar el consumido: " . mysqli_error($db); // Mensaje corregido
        } else {
            $idConsumido = mysqli_insert_id($db);

            foreach ($productosCompra as $producto) {
                $codigoProducto = mysqli_real_escape_string($db, $producto['codigo_producto'] ?? ''); 
                $cantidad = mysqli_real_escape_string($db, $producto['cantidad'] ?? 0);

                if (empty($codigoProducto) || !is_numeric($cantidad) || $cantidad <= 0) {
                    $errores[] = "La cantidad del producto '$codigoProducto' no es válida o el producto no tiene un código válido.";
                    continue; 
                }

                $queryDetalle = "INSERT INTO DetalleConsumido (cantidad, codigo_producto, id_consumido) VALUES ($cantidad, '$codigoProducto', $idConsumido)";
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
                $mensaje = "Consumido registrado correctamente."; // Mensaje corregido
            } else {
                $errores[] = "Consumido registrado, pero hubo errores con algunos detalles."; // Mensaje corregido
            }
        }
    }
}
?>