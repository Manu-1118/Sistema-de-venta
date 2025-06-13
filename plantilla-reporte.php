<?php

$consultaContado = "SELECT SUM(cd.total) as 'total'  FROM Contado cd WHERE fecha_contado >= DATE_SUB(DATE(NOW()), INTERVAL 15 DAY );";
$totalContado = mysqli_fetch_assoc(mysqli_query($db, $consultaContado));

$consultaCompra = "SELECT SUM(cd.total) as 'total'  FROM Compra cd WHERE fecha_compra >= DATE_SUB(DATE(NOW()), INTERVAL 15 DAY );";
$totalCompra = mysqli_fetch_assoc(mysqli_query($db, $consultaCompra));

$consultaCredito = "SELECT SUM(cd.monto_pendiente) as 'total'  FROM Credito cd WHERE monto_pendiente > 0;";
$totalCredito = mysqli_fetch_assoc(mysqli_query($db, $consultaCredito));

// ver el margen de ganancia de todos los productos
$consultaMargen = "SELECT p.nombre, p.descripcion, p.precio_unitario, p.precio_compra, (p.precio_unitario - p.precio_compra) as 'ganan_prod' FROM Producto p ORDER BY p.nombre ASC;";
$margenResultado = mysqli_query($db, $consultaMargen);

// todos las ventas al contado
$consultaFechasContado = "SELECT cd.fecha_contado, SUM(cd.total) as 'total' FROM Contado cd GROUP BY fecha_contado HAVING fecha_contado >= DATE_SUB(DATE(NOW()), INTERVAL 15 DAY );";
$fechasContado = mysqli_query($db, $consultaFechasContado);

// totales por fecha por las compras
$consultasFechaCompra = "SELECT c.fecha_compra, SUM(c.total) as 'total'  FROM Compra c GROUP BY fecha_compra HAVING fecha_compra >= DATE_SUB(DATE(NOW()), INTERVAL 15 DAY );";
$fechasCompras = mysqli_query($db, $consultasFechaCompra);

$consultaUniVendidas = "SELECT p.nombre, p.descripcion, p.precio_unitario, SUM(dt.cantidad) AS 'uni_tot_vend', (p.precio_unitario * SUM(dt.cantidad)) AS 'capital_total' FROM Producto p JOIN DetalleContado dt ON p.codigo_producto = dt.codigo_producto GROUP BY p.nombre, p.descripcion ORDER BY p.nombre ASC;";
$unidadesVendidas = mysqli_query($db, $consultaUniVendidas);

$consultaUniCompradas = "SELECT p.nombre, p.descripcion, p.precio_compra, SUM(dt.cantidad) AS 'uni_tot_comp', (p.precio_compra * SUM(dt.cantidad)) AS 'capital_total' FROM Producto p JOIN DetalleCompra dt ON p.codigo_producto = dt.codigo_producto GROUP BY p.nombre, p.descripcion ORDER BY p.nombre ASC;";
$unidadesCompradas = mysqli_query($db, $consultaUniCompradas);

$deudasClientes = mysqli_query($db, "SELECT ct.nombre, SUM(c.monto_pendiente) AS 'deudaTotal' FROM Credito c JOIN Cliente ct on c.id_cliente = ct.id_cliente GROUP BY ct.nombre ORDER BY SUM(c.monto_pendiente) DESC;");

$consultaProdConsumidos = "SELECT p.nombre, p.descripcion, p.precio_unitario, SUM(dt.cantidad) AS 'uni_tot_cons', (p.precio_unitario * SUM(dt.cantidad)) AS 'capital_total', cs.fecha_consumido FROM Producto p JOIN DetalleConsumido dt ON p.codigo_producto = dt.codigo_producto JOIN Consumido cs ON dt.id_consumido = cs.id_consumido GROUP BY p.nombre, p.descripcion, cs.fecha_consumido HAVING cs.fecha_consumido >= DATE_SUB(DATE(NOW()), INTERVAL 15 DAY );";
$consumidos = mysqli_query($db, $consultaProdConsumidos);

ob_start();
?>
<html>

<head>
    <style>
        html,
        body {

            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #F6FAFD;
        }

        h1 {

            text-transform: uppercase;
            color: #547C90;
            text-align: center;
            margin-bottom: 2.5rem;

        }

        p,
        span {
            margin: 0;
        }

        .cuerpo {

            width: 100%;
            height: 100%;
            margin: 1rem auto .5rem auto;
            background-color: #F6FAFD;
        }

        .info-cabecera {

            /* display: flex;
            justify-content: space-between;
            align-items: center; */
            padding: 0 6rem;
        }

        /* .info-cabecera .contenedor-logo {

            display: flex;
            flex-direction: column;
            align-items: center;

        }

        .info-cabecera .contenedor-logo .logo {

            display: flex;
            align-items: center;
            column-gap: 1rem;
        } */

        .contenedor-derecha .datos-generales .total {

            /* display: flex;
            justify-content: space-between;
            align-items: center;
            column-gap: 2rem; */
            text-align: right;
            margin: -5rem 0 6rem 0;
        }

        .contenedor-derecha .datos-generales .total:last-child {

            margin-bottom: 0;
        }

        .contenedor-tabla {

            display: flex;
            width: 90%;
            margin: 0 auto;
        }

        .contenedor-tabla h2 {

            text-transform: uppercase;
            color: #547C90;
            text-align: center;
            font-size: 1rem;
            margin: 2rem 0 0 0;
        }

        .cuerpo-tabla {

            width: 100%;
            margin: 2rem auto 0 auto;
            text-align: center;
        }

        .cuerpo-tabla table,
        th,
        td {
            border: 1px solid;
            text-align: center;
        }

        .cuerpo-tabla th {

            background-color: #547C90;
            color: #BACFDA;
        }

        .cuerpo-tabla tr:nth-child(even) {

            background-color: #BACFDA;
        }

        table {
            border-collapse: collapse;
        }
    </style>
</head>

<body>

    <main class='cuerpo'>

        <h1>Reporte de los últimos 15 días</h1>
        <div class='info-cabecera'>

            <div class='contenedor-logo'>

                <div class='logo'>
                    <img src='/build/img/icons/shop.png' alt='' class='logo icono-principal-inverso'>
                    <span class='name'>El pilar</span>
                </div>

                <span>Fecha: <?php echo date('d-m-Y'); ?></span>
            </div> <!--.lado derecho-->

            <div class='contenedor-derecha'>
                <div class='datos-generales'>
                    <div class='total'>
                        <p>Total Ventas al Contado: <span>C$ <?php echo $totalContado['total']; ?></span></p>
                    </div>
                    <div class='total'>
                        <p>Total en Compras: <span>C$ <?php echo $totalCompra['total']; ?></span></p>
                    </div>
                    <div class='total'>
                        <p>Total en Créditos: <span>C$ <?php echo $totalCredito['total']; ?></span></p>
                    </div>
                    <div class='total'>
                        <p>Perdidas: <span>C$ 1000.0<?php // echo $totalCredito['total']; ?></span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class='contenedor-tabla'>
            <h2>Capital total por Fecha en ventas al contado</h2>
            <table class='cuerpo-tabla'>
                <thead>
                    <th>Fecha</th>
                    <th>Capital total del día</th>
                </thead>

                <tbody class='data-tabla'>

                    <?php while ($fechaContado = mysqli_fetch_assoc($fechasContado)): ?>
                        <tr>
                            <td><?php echo $fechaContado['fecha_contado']; ?></td>
                            <td><?php echo $fechaContado['total']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div> <!--.tabla para ver resumen de todas las ventas al contado-->

        <div class='contenedor-tabla'>
            <h2>Capital total invertido por fecha en compras</h2>
            <table class='cuerpo-tabla'>
                <thead>
                    <th>Fecha</th>
                    <th>Capital total invertido</th>
                </thead>

                <tbody class='data-tabla'>

                    <?php while ($fechaCompra = mysqli_fetch_assoc($fechasCompras)): ?>
                        <tr>
                            <td><?php echo $fechaCompra['fecha_compra']; ?></td>
                            <td><?php echo $fechaCompra['total']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div> <!--.tabla para ver resumen de todas las ventas al contado-->

        <div class='contenedor-tabla'>
            <h2>Margen de ganancia de cada producto</h2>
            <table class='cuerpo-tabla'>
                <thead>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Precio Venta</th>
                    <th>Precio Compra</th>
                    <th>Ganancia</th>
                </thead>

                <tbody class='data-tabla'>

                    <?php while ($margen = mysqli_fetch_assoc($margenResultado)): ?>
                        <tr>
                            <td><?php echo $margen['nombre']; ?></td>
                            <td><?php echo $margen['descripcion']; ?></td>
                            <td><?php echo $margen['precio_unitario']; ?></td>
                            <td><?php echo $margen['precio_compra']; ?></td>
                            <td><?php echo $margen['ganan_prod']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div> <!--.tabla para ver el margen de ganancia de cada producto-->

        <div class='contenedor-tabla'>
            <h2>Unidades vendidas por producto</h2>
            <table class='cuerpo-tabla'>
                <thead>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Precio Venta</th>
                    <th>Unidades vendidas</th>
                    <th>Subtotal</th>
                </thead>

                <tbody class='data-tabla'>

                    <?php while ($UV = mysqli_fetch_assoc($unidadesVendidas)): ?>
                        <tr>
                            <td><?php echo $UV['nombre']; ?></td>
                            <td><?php echo $UV['descripcion']; ?></td>
                            <td><?php echo $UV['precio_unitario']; ?></td>
                            <td><?php echo $UV['uni_tot_vend']; ?></td>
                            <td><?php echo $UV['capital_total']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div> <!--.tabla para ver el total de unidades vendidas por producto y el capital generado-->

        <div class='contenedor-tabla'>
            <h2>Unidades compradas por producto</h2>
            <table class='cuerpo-tabla'>
                <thead>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Precio Compra</th>
                    <th>Unidades compradas</th>
                    <th>Subtotal</th>
                </thead>

                <tbody class='data-tabla'>

                    <?php while ($UC = mysqli_fetch_assoc($unidadesCompradas)): ?>
                        <tr>
                            <td><?php echo $UC['nombre']; ?></td>
                            <td><?php echo $UC['descripcion']; ?></td>
                            <td><?php echo $UC['precio_compra']; ?></td>
                            <td><?php echo $UC['uni_tot_comp']; ?></td>
                            <td><?php echo $UC['capital_total']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div> <!--.tabla para ver el total de unidades vendidas por producto y el capital generado-->

        <div class='contenedor-tabla'>
            <h2>Deudores</h2>
            <table class='cuerpo-tabla'>
                <thead>
                    <th>Nombre del cliente</th>
                    <th>Deuda tota</th>
                </thead>

                <tbody class='data-tabla'>

                    <?php while ($deudas = mysqli_fetch_assoc($deudasClientes)): ?>
                        <tr>
                            <td><?php echo $deudas['nombre']; ?></td>
                            <td><?php echo $deudas['deudaTotal']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div> <!--.tabla para ver la deuda total de cada cliente-->

        <div class='contenedor-tabla'>
            <h2>Productos Consumidos</h2>
            <table class='cuerpo-tabla'>
                <thead>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Precio venta</th>
                    <th>Unidades</th>
                    <th>Subtotal</th>
                    <th>Fecha Consumo</th>
                </thead>

                <tbody class='data-tabla'>

                    <?php while ($consumido = mysqli_fetch_assoc($consumidos)): ?>
                        <tr>
                            <td><?php echo $consumido['nombre']; ?></td>
                            <td><?php echo $consumido['descripcion']; ?></td>
                            <td><?php echo $consumido['precio_unitario']; ?></td>
                            <td><?php echo $consumido['uni_tot_cons']; ?></td>
                            <td><?php echo $consumido['capital_total']; ?></td>
                            <td><?php echo $consumido['fecha_consumido']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div> <!--.tabla para ver los productos consumidos-->

    </main>
</body>

</html>

<?php
$HTML = ob_get_clean();
// echo $HTML;
?>