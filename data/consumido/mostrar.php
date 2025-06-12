<?php

$encabezados = ['codigo','Fecha trans.','Total'];

$columnas = ['id_consumido','fecha_consumido','total']; 

$tabla = ['Consumido']; 
$btn_texto = 'Detalles';
$enlace = ['detalles.php?id=', 'id_consumido']; 

$_SESSION['encabezados'] = $encabezados;
$_SESSION['columnas'] = $columnas;
$_SESSION['tabla'] = $tabla;
$_SESSION['btn_texto'] = $btn_texto;
$_SESSION['ruta'] = $ruta_imagen;
$_SESSION['enlace'] = $enlace;
