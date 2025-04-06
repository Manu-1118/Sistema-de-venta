<?php
// Conexión a la base de datos
$db = conectarDB();

$query = "
    SELECT 
        c.id AS id_cliente, 
        c.nombres, 
        c.apellidos, 
        cr.id AS id_credito, 
        cr.fecha_credito, 
        cr.fecha_cancelacion, 
        cr.monto_pagado, 
        cr.monto_pendiente, 
        cr.total,
        dc.codigo_detalle,
        dc.cantidad,
        dc.codigo_producto,
        dc.id_credito
    FROM cliente c
    INNER JOIN credito cr ON c.id = cr.id_cliente
    INNER JOIN detallecredito dc ON cr.id=dc.id_credito;
";

// Ejecuta la consulta y obtiene los resultados
$resultado = mysqli_query($db, $query);


$creditos = []; // Inicializa el array para almacenar los resultados

while ($row = mysqli_fetch_assoc($resultado)) {
    $creditos[] = $row; // Guarda cada resultado en el array
}

// Función para obtener un cliente por su ID
function obtenerClientePorId($id_cliente, $db) {
    $query = "SELECT nombres, apellidos FROM cliente WHERE id = $id_cliente";
    $resultado = mysqli_query($db, $query);
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        return mysqli_fetch_assoc($resultado);
    } else {
        return null; // O manejar el error de otra manera
    }
}

// Función para obtener un crédito por su ID
function obtenerCreditoPorId($id_credito, $db) {
    $query = "SELECT fecha_credito, monto_pendiente, total FROM credito WHERE id = $id_credito";
    $resultado = mysqli_query($db, $query);
    return mysqli_fetch_assoc($resultado);
}

// Cierra la conexión a la base de datos si es necesario
mysqli_close($db);
echo '<script>console.table(' . json_encode($creditos) . ');</script>';
?>