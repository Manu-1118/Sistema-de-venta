<?php

$db = conectarDB();

$query = "SELECT * FROM Producto LIMIT 5";
$resultado = mysqli_query($db, $query);
while ($producto = mysqli_fetch_assoc($resultado)) {
    $productos[] = $producto;
}

$query2 = "SELECT * FROM Cliente";
$resultado2 = mysqli_query($db, $query2);
while ($cliente = mysqli_fetch_assoc($resultado2)) {
    $clientes[] = $cliente; // Guarda cada usuario en el array
}
$clientesJSON = json_encode($clientes);

date_default_timezone_set('America/Managua');

$productos = json_encode($productos);
$errores = [];
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idCliente = $_POST['cliente'] ?? null;
    $total = $_POST['total'] ?? null;
    $productosCredito = $_POST['productos'] ?? [];

    if (empty($idCliente)) {
        $errores[] = "Debes seleccionar un cliente.";
    }
    if (empty($total) || !is_numeric($total) || $total <= 0) {
        $errores[] = "El total debe ser un número mayor que cero.";
    }
    if (empty($productosCredito)) {
        $errores[] = "Debes agregar al menos un producto.";
    }
    if (empty($errores)) {

        $fechaCredito = date('Y-m-d H:i:s');


        $queryCredito = "INSERT INTO Credito (fecha_credito, total, id_cliente) VALUES ('$fechaCredito', $total, $idCliente)";
        $resultadoCredito = mysqli_query($db, $queryCredito);

        if ($resultadoCredito) {
            $idCredito = mysqli_insert_id($db);
            foreach ($productosCredito as $producto) {

                $codigoProducto = $producto['codigo'];
                $cantidad = $producto['cantidad'];

                $queryDetalle = "INSERT INTO DetalleCredito (cantidad, codigo_producto, id_credito) VALUES ($cantidad, '$codigoProducto', $idCredito)";
                mysqli_query($db, $queryDetalle);
            }

            $mensaje = "Crédito registrado correctamente.";
        } else {
            $errores[] = "Error al registrar el crédito.";


        }


    }


}


?>

