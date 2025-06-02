<?php
//require '../includes/app.php';
/** GENERAR DATOS DE LA DESCRIPCION GENERAL **/
$hoy = date("Y-m-d");

// PRODUCTOS TOTALES
$total_productos = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(codigo_producto) as 'total' FROM Producto;"));
// TOTAL CREDITOS
$total_creditos = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(id_credito) as 'total'  FROM Credito WHERE monto_pendiente > 0"));
// CAPITAL TOTAL
$total_dia = mysqli_fetch_assoc(mysqli_query($db, "SELECT SUM(total) as 'total' FROM Contado WHERE fecha_contado = CURRENT_DATE"));
// debuguear("SELECT SUM(total) as 'total' FROM Contado WHERE fecha_contado = $hoy");
// VENTAS DEL DIA
$total_ventas = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(id_contado) as 'total' FROM Contado WHERE fecha_contado = CURRENT_DATE"));

if ($total_dia['total'] === NULL) {
    $total_dia['total'] = 0;
}

if ($total_ventas['total'] === NULL) {
    $total_ventas['total'] = 0;
}

/** DATOS PARA LOS GRAFICOS **/
$ultimos7_Dias = mysqli_query($db, "SELECT fecha_contado, SUM(total) as 'total' FROM Contado GROUP BY fecha_contado HAVING fecha_contado BETWEEN CURDATE() - INTERVAL 7 DAY AND CURDATE()");
$deudasClientes = mysqli_query($db, "SELECT ct.nombre, SUM(c.monto_pendiente) AS 'deudaTotal' FROM Credito c JOIN Cliente ct on c.id_cliente = ct.id_cliente GROUP BY ct.nombre ORDER BY SUM(c.monto_pendiente) DESC LIMIT 5;");
$masVendidos = mysqli_query($db, "SELECT p.nombre, p.descripcion, SUM(dc.cantidad) as 'cantidad' FROM Producto p JOIN DetalleContado dc on p.codigo_producto = dc.codigo_producto GROUP BY p.nombre, p.descripcion ORDER BY SUM(dc.cantidad) DESC LIMIT 5;");
$menosVendidos = mysqli_query($db, "SELECT p.nombre, p.descripcion, SUM(dc.cantidad) as 'cantidad' FROM Producto p JOIN DetalleContado dc on p.codigo_producto = dc.codigo_producto GROUP BY p.nombre, p.descripcion ORDER BY SUM(dc.cantidad) ASC LIMIT 5;");

?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    function total_ventas_semanal() {
        const data = new google.visualization.DataTable();

        data.addColumn('string', 'Días');
        data.addColumn('number', 'Total');

        data.addRows([
            <?php
            while ($dias = mysqli_fetch_assoc($ultimos7_Dias)) {
                echo "['" . $dias['fecha_contado'] . "', " . $dias['total'] . "],";
            }
            ?>
        ]);

        const config = {
            width: 1005,
            height: 300,
            backgroundColor: 'transparent', // Quita el fondo del gráfico
            hAxis: {
                textStyle: {
                    color: color, // Color de la fuente del eje horizontal
                    fontSize: 12,
                },
                title: 'Total ventas',
                titleTextStyle: {
                    color: color,
                }
            },
            vAxis: {
                textStyle: {
                    color: color, // Color de la fuente del eje vertical
                    fontSize: 12,
                },
                title: 'Días de la semana',
                titleTextStyle: {
                    color: color,
                }
            },
            legend: {
                textStyle: {
                    color: color, // Cambia el color de las etiquetas de la leyenda a rojo
                    fontSize: 12, // Cambia el tamaño de la fuente de la leyenda
                }
            },
        };

        const chart = new google.visualization.BarChart(grafico1);
        chart.draw(data, config);
    }

    function total_creditos_cliente() {

        var data = new google.visualization.arrayToDataTable([
            ['Cliente', 'Deuda acumulada'],
            <?php
            while ($deudas = mysqli_fetch_assoc($deudasClientes)) {
                echo "['" . $deudas['nombre'] . "', " . $deudas['deudaTotal'] . "],";
            }
            ?>
        ]);

        var options = {

            width: 500,
            height: 400,
            legend: {
                position: 'none'
            },
            backgroundColor: 'transparent',
            axes: {
                x: {
                    0: {
                        side: 'bottom',
                        label: 'Cliente'
                    }
                },
                y: {
                    0: {
                        side: 'left',
                        label: 'Total deuda'
                    }
                }
            },

        };

        var chart = new google.charts.Bar(document.querySelector('.grafico4'));
        // Convert the Classic options to Material options.
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    function p_mas_vendidos() {
        const data = new google.visualization.DataTable();

        data.addColumn('string', 'Productos más vendidos');
        data.addColumn('number', 'Cantidad de productos');

        data.addRows([
            <?php
            while ($PMV = mysqli_fetch_assoc($masVendidos)) {
                echo "['" . $PMV['nombre'] . " " . $PMV['descripcion'] . "', " . $PMV['cantidad'] . "],";
            }
            ?>
        ]);

        const config = {
            width: 400,
            height: 180,
            backgroundColor: 'transparent', // Quita el fondo del gráfico
            legend: {
                textStyle: {
                    color: color, // Cambia el color de las etiquetas de la leyenda a rojo
                    fontSize: 12, // Cambia el tamaño de la fuente de la leyenda
                }
            },
        };

        const chart = new google.visualization.PieChart(grafico2);
        chart.draw(data, config);
    }

    function p_menos_vendidos() {
        const data = new google.visualization.DataTable();

        data.addColumn('string', 'Productos menos vendidos');
        data.addColumn('number', 'Cantidad de productos');

        data.addRows([
            <?php
            while ($PMV = mysqli_fetch_assoc($menosVendidos)) {
                echo "['" . $PMV['nombre'] . " " . $PMV['descripcion'] . "', " . $PMV['cantidad'] . "],";
            }
            ?>
        ]);

        const config = {
            width: 400,
            height: 180,
            backgroundColor: 'transparent', // Quita el fondo del gráfico
            legend: {
                textStyle: {
                    color: color, // Cambia el color de las etiquetas de la leyenda a rojo
                    fontSize: 12, // Cambia el tamaño de la fuente de la leyenda
                }
            },
        };

        const chart = new google.visualization.PieChart(grafico3);
        chart.draw(data, config);
    }

    google.charts.load("current", {
        packages: ['corechart', 'bar']
    });

    google.charts.setOnLoadCallback(() => {
        // updateColor(); // Establecer el color inicial
        total_ventas_semanal();
        p_mas_vendidos();
        p_menos_vendidos();
        total_creditos_cliente();
    });
</script>