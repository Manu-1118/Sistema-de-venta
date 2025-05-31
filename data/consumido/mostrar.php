<?php

$encabezados = ['Fecha trans.', 'Cantidad', 'Total'];

// variables para añadirlas al archivo "/data/obtener_datos.php"
$columnas = ['fecha_consumido', 'SUM(cantidad)', 'total'];
$tabla[] = ['Consumido', 'DetalleConsumido'];
$btn_texto = 'Detalles';
$inner = 'Consumido c join DetalleConsumido dc on c.id_consumido = dc.id_consumido';

$_SESSION['encabezados'] = $encabezados;
$_SESSION['columnas'] = $columnas;
$_SESSION['tabla'] = $tabla;
$_SESSION['btn_texto'] = $btn_texto;
$_SESSION['ruta'] = $ruta_imagen;
