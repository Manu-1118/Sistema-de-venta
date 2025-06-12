<?php #PLANTILLA DEL DOCUMENTO PDF

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
        
    </header>

    <main class='cuerpo'>
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
