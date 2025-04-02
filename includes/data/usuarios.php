<?php
$db = conectarDB(); // Asegúrate de que esta función devuelve la conexión
$query = "SELECT * FROM usuarios";
$resultado = mysqli_query($db, $query);

$usuarios = []; // Inicializa el array para evitar errores

while ($usuario = mysqli_fetch_assoc($resultado)) {
    $usuarios[] = $usuario; // Guarda cada usuario en el array
}

// echo "<script> var usuarios = " . json_encode($usuarios) . ";
//     console.table(usuarios);
// </script>";

?>
