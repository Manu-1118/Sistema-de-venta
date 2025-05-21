<?php

//Arreglo para validacion
$errores = [];

$codigo = '';
$productos ='';
$cantidad = '';
$cliente = '';
$fechaCredito = '';
$cantidad ='';
$total = '';

if (!isset($_SESSION['lista_productos'])) {
    $_SESSION['lista_productos'] = [];
}
//Conectar la bd
// $db = conectarDB();
$errores = [];

/** RELLENANDO PARA LA TABLA CONTADO **/
//obtener fecha actual y generar el numero de la factura
$fecha_actual = date("Y-m-d");
// $query_cantidad_facturas = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(    ) as 'cantidad' FROM Credito;"));
//$num_factura = intval($query_cantidad_facturas['cantidad']) + 1;
/** FIN TABLA CONTADO **/

/** MOSTRANDO DATOS DE LA TABLA PRODUCTOS **/
//escribir el query
// $query_obtener_productos = "SELECT * FROM Producto;";
//consultar la bd y obtener resultado
//$resultado_obtener_productos = mysqli_query($db, $query_obtener_productos);
/** FIN TABLA PRODUCTOS **/

/** MOSTRAR DATOS DE LA TABLA PROVEEDORES**/
//$query_obtener_clientes = "SELECT * FROM Cliente;";
//$resultado_obtener_clientes = mysqli_query($db, $query_obtener_clientes);
/** FIN DE LA TABLA PROVEEDORES**/

//$total = 0;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['lista'] == 'true') {

    $buscar_producto = "SELECT nombre, descripcion, categoria, precio_unitario FROM Producto WHERE codigo = {$_GET['cbProductos']};";
    $resultado_busqueda = mysqli_fetch_assoc(mysqli_query($db, $buscar_producto));

    if ($resultado_busqueda) {
        $resultado_busqueda['codigo'] = $_GET['cbProductos'];
        $resultado_busqueda['cantidad'] = $_GET['txtCantidad'];
        $_SESSION['lista_productos'][] = $resultado_busqueda;
        header('location: /admin/control/creditos_crear.php');
    }
}

$lista_productos = $_SESSION['lista_productos'];

foreach ($lista_productos as $producto) {
    $total += $producto['cantidad'] * $producto['precio_unitario'];
}

// verificar que se mando informacion al post
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // si el arreglo de errores esta vacio, hacer la insercion
    if (empty($errores)) {

        /**INSERTAR DATOS EN LA TABLA Credito**/
        $query_insertar_contado = "INSERT INTO Credito (id, fecha_credito, fecha_cancelacion, monto_pagado, monto_pendiente, total, id_cliente) VALUES ('$num_factura', '$fecha_actual', '{$_POST['dtCancelacion']}', '0.00', '$total', '$total', '{$_POST['cbClientes']}');";
        //debuguear($query_insertar_contado);
        $resultado_contado = mysqli_query($db, $query_insertar_contado);
        /**FIN DE LA TABLA CONTADO**/

        /** INSERTAR DATOS EN LA TABLA DETALLE **/
        $query_insertar_detalle = "INSERT INTO DetalleCredito (cantidad, codigo_producto, id_credito) VALUES ";
        $datos_value = "";
        $contador = 0;
        $total_productos = count($lista_productos);

        foreach ($lista_productos as $producto) {

            $contador++;
            $datos_value = $datos_value . "({$producto['cantidad']}, {$producto['codigo']}, $num_factura)";
            if ($contador < $total_productos) {
                $datos_value .= ", ";
            } else {
                $datos_value .= ";";
            }
        }
        $query_insertar_detalle = $query_insertar_detalle . $datos_value;
        //debuguear($query_insertar_detalle);
        $resultado_detalle = mysqli_query($db, $query_insertar_detalle);
        /** FIN TABLA DETALLE **/

        // si el resultado devolvio una fila modificada mostrar que si se inserto
        if ($resultado_contado && $resultado_detalle) {
            header('Location: /admin/control/creditos.php?resultado=1');
        }
    }
} 
