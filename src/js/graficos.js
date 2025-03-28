const grafico1 = document.querySelector('.grafico1');
const grafico2 = document.querySelector('.grafico2');
const grafico3 = document.querySelector('.grafico3');

const btnDarkMode = document.querySelector('.btnDarkMode');
const body = document.querySelector('body');
let color = 'black'; // Color inicial

function updateColor() {
    color = body.classList.contains('dark-mode') ? 'white' : 'black';
}

function p_mas_vendidos() {
    const data = new google.visualization.DataTable();

    data.addColumn('string', 'Productos más vendidos');
    data.addColumn('number', 'Cantidad de productos');

    data.addRows([
        ['Huevos', 30000],
        ['Pan', 249000],
        ['Filete de pollo', 120230],
        ['Arroz', 110200],
        ['CocaCola 12onz', 50000]
    ]);

    const config = {
        width: 300,
        height: 150,
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
        ['bujillas', 30000],
        ['Frambuesa', 249000],
        ['Veladoras', 120230],
        ['Zepol', 110200]
    ]);

    const config = {
        width: 400,
        height: 150,
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

function total_ventas_semanal() {
    const data = new google.visualization.DataTable();

    data.addColumn('string', 'Días');
    data.addColumn('number', 'Total');

    data.addRows([
        ['Lunes', 5820],
        ['Martes', 10525],
        ['Miercoles', 9800],
        ['Jueves', 6089],
        ['Viernes', 7866],
        ['Sabado', 5430],
        ['Domingo', 10095],
    ]);

    const config = {
        width: 500,
        height: 400,
        backgroundColor: 'transparent', // Quita el fondo del gráfico
        hAxis: {
            textStyle: {
                color: color, // Color de la fuente del eje horizontal
                fontSize: 12,
            },
            title: 'Días de la semana',
            titleTextStyle: {
                color: color,
            }
        },
        vAxis: {
            textStyle: {
                color: color, // Color de la fuente del eje vertical
                fontSize: 12,
            },
            title: 'Ventas',
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

google.charts.load("current", { packages: ["corechart"] });

google.charts.setOnLoadCallback(() => {
    updateColor(); // Establecer el color inicial
    p_mas_vendidos();
    p_menos_vendidos();
    total_ventas_semanal();
});

// Cambiar el modo al hacer clic en el botón
btnDarkMode.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    updateColor();
    p_mas_vendidos(); // Redibujar el gráfico con el nuevo color
    p_menos_vendidos();
    total_ventas_semanal();
});