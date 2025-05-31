<?php

$db = conectarDB();
$query = "SELECT * FROM Producto LIMIT 5";
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

    if (empty($errores)) {

        $fechaContado = date('Y-m-d H:i:s');

        $queryCredito = "INSERT INTO Contado (
        fecha_contado,total) VALUES ('$fechaContado', $total)";
        $resultadoContado = mysqli_query($db, $queryCredito);
        if (!$resultadoContado) {
            $errores[] = "Error al registrar el crédito: " . mysqli_error($db);      
        }
        else {
            $idContado = mysqli_insert_id($db);

            foreach ($productosContado as $producto) {
                $codigoProducto = mysqli_real_escape_string($db, $producto['codigo'] ?? '');
                $cantidad = mysqli_real_escape_string($db, $producto['cantidad'] ?? 0);

                if (empty($codigoProducto) || !is_numeric($cantidad) || $cantidad <= 0) {
                    if (!is_numeric($cantidad) || $cantidad <= 0) {
                        $errores[] = "La cantidad del producto '$codigoProducto' no es válida.";
                    }
                    continue; 
                }

                $queryDetalle = "INSERT INTO DetalleContado (cantidad, codigo_producto, id_contado) VALUES ($cantidad, '$codigoProducto', $idContado)";
                $resultadoDetalle = mysqli_query($db, $queryDetalle);

                if (!$resultadoDetalle) {
                    $errores[] = "Error al insertar el detalle para el producto '$codigoProducto': " . mysqli_error($db);
                }
            }

            if (empty($errores)) {
                $mensaje = "Venta registrado correctamente.";
            } else {
                $errores[] = "Venta principal registrado, pero hubo errores al registrar algunos detalles.";
            }
        }
    }
}


?>