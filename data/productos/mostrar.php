<?php

$encabezados = ['Imagen', 'Código', 'Nombre', 'Descripción', 'Cant.', 'Precio']; //encabezados de la tabla correspondiente
// variables para añadirlas al archivo "/data/obtener_datos.php"
$columnas = ['imagen', 'codigo_producto', 'nombre', 'descripcion', 'cantidad', 'precio_unitario'];
$tabla[] = 'Producto';
$btn_texto = 'Editar';
$ruta_imagen = 'img/productos/';
$enlace = ['editar.php?id=', 'codigo_producto'];
$_SESSION['encabezados'] = $encabezados;
$_SESSION['columnas'] = $columnas;
$_SESSION['tabla'] = $tabla;
$_SESSION['btn_texto'] = $btn_texto;
$_SESSION['ruta'] = $ruta_imagen;
$_SESSION['enlace'] = $enlace;

$consulta = "SELECT * FROM Categoria";
$categorias = mysqli_query($db, $consulta);
