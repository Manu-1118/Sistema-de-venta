<?php

$encabezados = ['N°', 'Descripción', 'F. Devolucion', 'Total'];

$columnas = ['id_devolucion','descripcion','fecha_devolucion', 'total'];
$tabla = ['Devolucion'];
$btn_texto = 'Detalles';
$enlace = ['detalles.php?id=', 'id_devolucion'];

$_SESSION['encabezados'] = $encabezados;
$_SESSION['columnas'] = $columnas;
$_SESSION['tabla'] = $tabla;
$_SESSION['btn_texto'] = $btn_texto;
$_SESSION['ruta'] = $ruta_imagen;
$_SESSION['enlace'] = $enlace;

?>