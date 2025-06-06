<?php
$db = conectarDB();


$query = "SELECT * FROM Producto";
$resultado = mysqli_query($db, $query);
$productos = []; 
while ($producto = mysqli_fetch_assoc($resultado)) {
    $productos[] = $producto;
}

$query2 = "SELECT * FROM Proveedor";
$resultado2 = mysqli_query($db, $query2);
$proveedores = []; 
while ($proveedor = mysqli_fetch_assoc($resultado2)) {
    $proveedores[] = $proveedor;
}

$proveedoresJSON = json_encode($proveedores);
$productosJSON = json_encode($productos); 

$errores = [];
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $idProveedor = mysqli_real_escape_string($db, $_POST['txtProveedor'] ?? '');
    $total = mysqli_real_escape_string($db, $_POST['totalCompra'] ?? '');
    $productosCompra = json_decode($_POST['productosSeleccionados'] ?? '[]', true);

    if (empty($idProveedor)) {
        $errores[] = "Debes seleccionar el proveedor.";
    } elseif (!is_numeric($idProveedor)) {
        $errores[] = "El ID del Proveedor no es válido.";
    }
    if (empty($total) || !is_numeric($total) || $total <= 0) {
        $errores[] = "El total debe ser un número mayor que cero.";
    }
    if (empty($productosCompra)) {
        $errores[] = "Debes agregar al menos un producto.";
    }

    if (empty($errores)) {

        $fechaCompra = date('Y-m-d H:i:s');

        $queryCompra = "INSERT INTO Compra (fecha_compra, total, codigo_RUC) VALUES ('$fechaCompra', $total, '$idProveedor')";
        $resultadoCompra = mysqli_query($db, $queryCompra);

        if (!$resultadoCompra) {
            $errores[] = "Error al registrar la compra " . mysqli_error($db);
        } else {
            $idCompra = mysqli_insert_id($db);

            foreach ($productosCompra as $producto) {
                $codigoProducto = mysqli_real_escape_string($db, $producto['codigo_producto'] ?? ''); // <--- ¡CAMBIO AQUÍ!
                $cantidad = mysqli_real_escape_string($db, $producto['cantidad'] ?? 0);

                if (empty($codigoProducto) || !is_numeric($cantidad) || $cantidad <= 0) {
                    $errores[] = "La cantidad del producto '$codigoProducto' no es válida o no tiene código.";
                    continue;
                }

                $queryDetalle = "INSERT INTO DetalleCompra (cantidad, codigo_producto, id_compra) VALUES ($cantidad, '$codigoProducto', $idCompra)";
                $resultadoDetalle = mysqli_query($db, $queryDetalle);

                if (!$resultadoDetalle) {
                    $errores[] = "Error al insertar el detalle para el producto '$codigoProducto': " . mysqli_error($db);
                } else {
                    $queryActualizarProducto = "UPDATE Producto SET cantidad = cantidad + $cantidad WHERE codigo_producto = '$codigoProducto'"; // <--- ¡CAMBIO AQUÍ!
                    $resultadoActualizar = mysqli_query($db, $queryActualizarProducto);

                    if (!$resultadoActualizar) {
                        $errores[] = "Error al actualizar la cantidad del producto '$codigoProducto': " . mysqli_error($db);
                    }
                }
            }
            if (empty($errores)) {
                $mensaje = "Compra registrado correctamente.";
            } else {
                $errores[] = "Compra principal registrado, pero hubo errores al registrar algunos detalles.";
            }
        }
    }
}
?>