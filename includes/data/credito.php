<?php
// Conexión a la base de datos
$db = conectarDB();

// Realiza la consulta con JOIN para obtener los datos de las 4 tablas
// $query = "
//     SELECT 
//         c.id AS credito_id,
//         c.fecha_Credito,
//         c.fecha_cancelacion,
//         c.monto_pagado,
//         c.monto_pendiente,
//         c.total,
//         CONCAT(cl.nombres, ' ', cl.apellidos) AS cliente_nombre,  
//         p.nombre AS producto_nombre,
//         p.precio_unitario,
//         p.categoria,
//         p.descripcion,
//         d.cantidad
//     FROM credito c
//     JOIN cliente cl ON c.id_cliente = cl.id
//     JOIN detallecredito d ON c.id = d.id_credito
//     JOIN producto p ON d.codigo_producto = p.codigo
// ";

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
        cr.total 
    FROM cliente c
    INNER JOIN credito cr ON c.id = cr.id_cliente;
";

// Ejecuta la consulta y obtiene los resultados
$resultado = mysqli_query($db, $query);

$creditos = []; // Inicializa el array para almacenar los resultados

while ($row = mysqli_fetch_assoc($resultado)) {
    $creditos[] = $row; // Guarda cada resultado en el array
}

// Cierra la conexión a la base de datos si es necesario
mysqli_close($db);
echo '<script>console.table(' . json_encode($creditos) . ');</script>';
?>
