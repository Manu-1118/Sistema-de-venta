<?php
$encabezados = ['Cod. RUC', 'Nombre', 'Apellido', 'Empresa', 'Teléfono'];

$columnas = ['codigo_RUC', 'nombre', 'apellido', 'empresa', 'telefono'];
$tabla[] = 'Proveedor';
$btn_texto = 'Editar';
$enlace = ['editar.php?id=', 'codigo_RUC'];

$_SESSION['encabezados'] = $encabezados;
$_SESSION['columnas'] = $columnas;
$_SESSION['tabla'] = $tabla;
$_SESSION['btn_texto'] = $btn_texto;
$_SESSION['enlace'] = $enlace;
