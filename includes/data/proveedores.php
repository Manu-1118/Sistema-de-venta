<?php
$db = conectarDB();
$query = "SELECT * FROM proveedor";
$resultado = mysqli_query($db, $query);

while ($proveedor = mysqli_fetch_assoc($resultado)) {
    $proveedores[] = $proveedor;
}

// echo "<script> var proveedores = " . json_encode($proveedores) . ";
//     console.table(proveedores);
// </script>";

?>
