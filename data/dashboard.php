<?php
//require '../includes/app.php';
/** GENERAR DATOS DE LA DESCRIPCION GENERAL **/

// PRODUCTOS TOTALES
$total_productos = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(codigo_producto) as 'total' FROM Producto;"));
