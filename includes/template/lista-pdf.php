<?php #PLANTILLA DEL DOCUMENTO PDF

$imagenPath = "build/img/encabezado-pdf.png";
$ruta = 'img/productos/';
$t_row = '';

if (isset($_GET['productos'])) {

    //  Obtener cadena JSON
    $urlEncodedJson = $_GET['productos'];
    // decodificar lista de la url
    $jsonDecodedLista = urldecode($urlEncodedJson);
    // convertir el json obtenido de la url y almacenarlo de manera legible
    $productos = json_decode($jsonDecodedLista, true);

    // <td class='img-producto'><img src='data:image/png;base64,/img/productos/" . base64_encode(file_get_contents($producto['imagen'])) . "'></td>
    //verificar si el json no devolvio errores
    if (json_last_error() === JSON_ERROR_NONE) {

        // recorrer todos los productos y ordenar la info en una fila por producto
        foreach ($productos as $producto) {

            // fila del producto para la tabla
            $t_row .=
                "
                    <tr>
                        <td class='img-producto'> <img src='data:image/jpeg;base64," . base64_encode(file_get_contents($ruta . $producto['imagen'])) . "' alt='Imagen de Producto'> </td>
                        <td>" . $producto['nombre'] . "</td>
                        <td>" . $producto['descripcion'] . "</td>
                        <td>" . $producto['precio_unitario'] . "</td>
                    </tr>
                ";
        }
    } else {
        // error de decodificacion
    }
} else {
    // error si el get viene vacio o si no existe
}

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
        }

        .img-encabezado {

            width: 100%;
            height: 5rem;
            margin-bottom: 5px;
        }

        .img-encabezado img {

            width: 100%;
        }

        .cuerpo {

            width: 95%;
            height: 90%;
            margin: 0 auto;
            background-color: #F6FAFD;
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

        .img-producto img {
            margin: 0 auto;
            width: 80px;
            height: 60px;
        }
    </style>
</head>

<body>
    <header class='img-encabezado'>
        <img src='data:image/png;base64," . base64_encode(file_get_contents($imagenPath)) . "'  alt=' Imagen Logo'>
    </header>

    <main class='cuerpo'>
        <div class='contenedor-tabla'>
            <table class='cuerpo-tabla'>
                <thead>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Precio unitario</th>
                    
                </thead>

                <tbody class='data-tabla'>" . $t_row . "</tbody>
            </table>
        </div>
    </main>
</body>

</html>
";
