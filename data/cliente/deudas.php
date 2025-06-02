<?php

$id_cliente = filter_var($_GET['id'], FILTER_VALIDATE_INT); // obtener el codigo del producto a editar y verificar que sea un valor correcto
if (!$id_cliente) {
    header('Location: clientes.php');
}

//escribir el query
$consulta = "SELECT c.fecha_credito, c.fecha_cancelacion, c.monto_pagado, c.monto_pendiente, c.total FROM Credito c JOIN Cliente ct on c.id_cliente = ct.id_cliente WHERE c.id_cliente = '{$id_cliente}' AND c.monto_pendiente > 0;";

$resultado_detalle = mysqli_query($db, $consulta);
