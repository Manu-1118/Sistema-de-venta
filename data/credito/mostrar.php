<?php

$encabezados = ['N°','Cliente', 'Fecha cred.', 'Fecha cancel.', 'Pagado', 'Pendiente', 'Total'];

$columnas = ['id_credito', "CONCAT(nombre, ' ', apellido)",'fecha_credito', 'fecha_cancelacion', 'monto_pagado', 'monto_pendiente', 'total'];
$tabla = ['Credito', 'Cliente'];
$btn_texto = 'Abonar';
$inner = 'Credito cd join Cliente ct on cd.id_cliente = ct.id_cliente';
$enlace = ['detalles.php?id=', 'id_credito']; 

$_SESSION['encabezados'] = $encabezados;
$_SESSION['columnas'] = $columnas;
$_SESSION['tabla'] = $tabla;
$_SESSION['btn_texto'] = $btn_texto;
$_SESSION['ruta'] = $ruta_imagen;
$_SESSION['inner'] = $inner;
$_SESSION['enlace'] = $enlace;

?>