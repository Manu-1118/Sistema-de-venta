<?php

$encabezados = ['Cliente', 'Fecha cred.', 'Fecha cancel.', 'Pagado', 'Pendiente', 'Total'];

// variables para añadirlas al archivo "/data/obtener_datos.php"
$columnas = ["CONCAT(nombre, ' ', apellido)", 'fecha_credito', 'fecha_cancelacion', 'monto_pagado', 'monto_pendiente', 'total'];
$tabla = ['Contado', 'Cliente'];
$btn_texto = 'Detalles';
$inner = 'Credito cd join Cliente ct on cd.id_cliente = ct.id_cliente';


$_SESSION['encabezados'] = $encabezados;
$_SESSION['columnas'] = $columnas;
$_SESSION['tabla'] = $tabla;
$_SESSION['btn_texto'] = $btn_texto;
$_SESSION['ruta'] = $ruta_imagen;
$_SESSION['inner'] = $inner;



