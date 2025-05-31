<?php
$encabezados = ['Fecha Dev.', 'Descripción', 'Cantidad prod.', 'Total'];

// variables para añadirlas al archivo "/data/obtener_datos.php"
$columnas = ['fecha_devolucion', 'descripcion', 'SUM(cantidad)', 'total'];
$tabla = ['Devolucion', 'DetalleDevolucion'];
$btn_texto = 'Detalles';
$inner = 'Devolucion d join DetalleDevolucion dd on d.id_devolucion = dd.id_devolucion';

$_SESSION['encabezados'] = $encabezados;
$_SESSION['columnas'] = $columnas;
$_SESSION['tabla'] = $tabla;
$_SESSION['btn_texto'] = $btn_texto;
$_SESSION['ruta'] = $ruta_imagen;
$_SESSION['inner'] = $inner;