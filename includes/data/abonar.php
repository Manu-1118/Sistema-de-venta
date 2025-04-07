<?php
require '../../includes/app.php';
$db = conectarDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos
    $id_credito = $_POST['id_credito'];
    $id_cliente = $_POST['id_cliente'];
    $monto_abonado = $_POST['cantidad'];
    $monto_pendiente = $_POST['monto_pendiente'];

    if ($monto_abonado > $monto_pendiente) {
        $errores[] = "El monto abonado no puede ser mayor al monto pendiente.";
        return $errores;
    }

    if ($monto_abonado <= $monto_pendiente) {
        $query_abonar = "UPDATE credito SET monto_pagado = monto_pagado + $monto_abonado WHERE id = $id_credito";
        $resultado_abonar = mysqli_query($db, $query_abonar);
    
        $query_abonar = "UPDATE credito SET monto_pendiente = monto_pendiente - $monto_abonado WHERE id = $id_credito";
        $resultado_abonar = mysqli_query($db, $query_abonar);
    }

    $query = "SELECT monto_pendiente FROM credito WHERE id = $id_credito";
    $resultado = mysqli_query($db, $query);
    $credito = mysqli_fetch_assoc($resultado);

    if ($credito['monto_pendiente'] == 0) {
        $query_abonar = "UPDATE credito SET fecha_cancelacion = NOW() WHERE id = $id_credito";
        $resultado_abonar = mysqli_query($db, $query_abonar);
    }

    header('Location: /admin/control/abonarForm.php?id_credito=' . $id_credito . '&id_cliente=' . $id_cliente);
}
?>
