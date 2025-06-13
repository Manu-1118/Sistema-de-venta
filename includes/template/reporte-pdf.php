<?php #PLANTILLA DEL DOCUMENTO PDF

$imagenPath = "/build/img/icons/shop.png";

$consultaContado = "SELECT SUM(cd.total) as 'total'  FROM Contado cd WHERE fecha_contado >= DATE_SUB(DATE(NOW()), INTERVAL 15 DAY );";
$totalContado = mysqli_fetch_assoc(mysqli_query($db, $consultaContado));
// debuguear($totalContado);

$consultaCompra = "SELECT SUM(cd.total) as 'total'  FROM Compra cd WHERE fecha_compra >= DATE_SUB(DATE(NOW()), INTERVAL 15 DAY );";
$totalCompra = mysqli_fetch_assoc(mysqli_query($db, $consultaCompra));

$consultaCredito = "SELECT SUM(cd.monto_pendiente) as 'total'  FROM Credito cd WHERE monto_pendiente > 0;";
$totalCredito = mysqli_fetch_assoc(mysqli_query($db, $consultaCredito));


$HTML = "

<html>

<head>
    <style>
        html,
        body {

            background-color: #BACFDA;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: Arial, Helvetica, sans-serif;
        }

        h1 {

            text-transform: uppercase;
            color: #547C90;
            text-align: center;
            margin-top: 2rem;
        }

        p,
        span {
            margin: 0;
        }

        .cuerpo {

            width: 98%;
            height: 98%;
            margin: 1em auto .5rem auto;
            background-color: #F6FAFD;
        }

        .info-cabecera {

            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 6rem;
        }

        .info-cabecera .contenedor-logo {

            display: flex;
            flex-direction: column;
            align-items: center;

        }

        .info-cabecera .contenedor-logo .logo {

            display: flex;
            align-items: center;
            column-gap: 1rem;
        }

        .contenedor-derecha .datos-generales .total {

            display: flex;
            justify-content: space-between;
            align-items: center;
            column-gap: 2rem;
        }

        .contenedor-tabla {

            display: flex;
            width: 90%;
            margin: 0 auto;
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
                    <img src='data:image/png;base64," . base64_encode(file_get_contents($imagenPath)) . "'  alt=''>
                    <span class='name'>El pilar</span>
                </div>

                <span>Fecha: <?php echo date('d-m-Y'); ?></span>
            </div> <!--.lado derecho-->

            <div class='contenedor-derecha'>
                <div class='datos-generales'>
                    <div class='total'>
                        <p>Total Ventas al Contado: </p>
                        <span>C$ " . $totalContado['total'] . "</span>
                    </div>
                    <div class='total'>
                        <p>Total en Compras: </p>
                        <span>C$ " . $totalCompra['total'] . "</span>
                    </div>
                    <div class='total'>
                        <p>Total en Créditos: </p>
                        <span>C$ " . $totalCredito['total'] . "</span>
                    </div>
                </div>
            </div>
        </div>

        <div class='contenedor-tabla'>
            <table class='cuerpo-tabla'>
                <thead>
                    <th>uno</th>
                    <th>dos</th>
                    <th>tres</th>
                </thead>

                <tbody class='data-tabla'>
                    <tr>
                        <td>uno</td>
                        <td>dos</td>
                        <td>tres</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
";
