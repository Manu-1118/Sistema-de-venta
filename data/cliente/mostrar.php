<?php

$encabezados = ['Cod. Identif.', 'Nombre', 'Apellido'];

$columnas = ['id_cliente', 'nombre', 'apellido'];
$tabla[] = 'Cliente';
$btn_texto = 'Ver Créditos';
$enlace = ['deudas.php?id=', 'id_cliente'];

$_SESSION['encabezados'] = $encabezados;
$_SESSION['columnas'] = $columnas;
$_SESSION['tabla'] = $tabla;
$_SESSION['btn_texto'] = $btn_texto;
$_SESSION['enlace'] = $enlace;
