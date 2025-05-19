<?php

$encabezados = ['Foto', 'Cod. Identif.', 'Nombre', 'Apellido', 'Correo'];

$columnas = ['imagen', 'id_administrador', 'nombre', 'apellido', 'correo'];
$tabla[] = 'Administrador';
$btn_texto = 'Editar';
$ruta_imagen = 'img/administradores/';

$_SESSION['encabezados'] = $encabezados;
$_SESSION['columnas'] = $columnas;
$_SESSION['tabla'] = $tabla;
$_SESSION['btn_texto'] = $btn_texto;
$_SESSION['ruta'] = $ruta_imagen;
