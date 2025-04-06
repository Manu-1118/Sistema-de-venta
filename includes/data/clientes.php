<?php
$db = conectarDB(); // Asegúrate de que esta función devuelve la conexión
$query = "SELECT * FROM cliente";
$resultado = mysqli_query($db, $query);

$clientes = []; // Inicializa el array para evitar errores

while ($cliente = mysqli_fetch_assoc($resultado)) {
    $clientes[] = $cliente; // Guarda cada usuario en el array
}
?>
