<?php

$encabezados = ['Codigo', 'Fecha trans.', 'Total'];

$columnas = ['id_contado', 'fecha_contado', 'total'];
$tabla[] = 'Contado';
$btn_texto = 'Detalles';
$enlace = ['detalles.php?id=', 'id_contado'];

$_SESSION['encabezados'] = $encabezados;
$_SESSION['columnas'] = $columnas;
$_SESSION['tabla'] = $tabla;
$_SESSION['btn_texto'] = $btn_texto;
$_SESSION['ruta'] = $ruta_imagen;
$_SESSION['enlace'] = $enlace;
