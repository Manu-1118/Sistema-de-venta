<?php

$encabezados = ['Proveedor', 'Empresa', 'Fecha compra', 'Total'];

// variables para añadirlas al archivo "/data/obtener_datos.php"
$columnas = ["CONCAT(nombre, ' ', apellido)", 'empresa', 'fecha_compra', 'total'];
$tabla = ['Compra', 'Proveedor'];
$btn_texto = 'Detalles';
$inner = 'Compra c join Proveedor p on c.codigo_RUC = p.codigo_RUC';

$_SESSION['encabezados'] = $encabezados;
$_SESSION['columnas'] = $columnas;
$_SESSION['tabla'] = $tabla;
$_SESSION['btn_texto'] = $btn_texto;
$_SESSION['ruta'] = $ruta_imagen;
$_SESSION['inner'] = $inner;
