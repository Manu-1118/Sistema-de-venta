<?php
$db = conectarDB();
$query = "SELECT * FROM producto";
$resultado = mysqli_query($db, $query);

while ($producto = mysqli_fetch_assoc($resultado)) {
    $productos[] = $producto;
}

// echo "<script> var proveedores = " . json_encode($proveedores) . ";
//     console.table(proveedores);
// </script>";

?>
