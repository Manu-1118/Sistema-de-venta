<?php
$db = conectarDB(); // Conexión activa

$query = "SELECT * FROM producto";
$resultado = mysqli_query($db, $query);

$productos = [];

while ($producto = mysqli_fetch_assoc($resultado)) {
    $productos[] = $producto;
}
?>
