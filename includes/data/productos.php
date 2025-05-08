<?php
$db = conectarDB(); // Asegúrate de que esta función devuelve la conexión

$query = "SELECT * FROM producto";
$resultado = mysqli_query($db, $query);

$productos = []; // Inicializa el array para evitar errores

while ($producto = mysqli_fetch_assoc($resultado)) {
    $productos[] = $producto; // Guarda cada producto en el array
}
?>
