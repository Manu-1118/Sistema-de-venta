<?php

if (!isset($_SESSION)) {
    session_start();
}

$auth = $_SESSION['login'] ?? false;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <!-- locale -->
    <link rel="stylesheet" href="/build/css/app.css">

    <title>Pulperia El Pilar</title>
    <link rel="icon" href="/build/img/i1.ico" type="image/x-icon">
    <!-- para autocompletado de credito-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>

</head>

<body>
    <header class="header <?php echo $inicio ? 'inicio-usuario' : '' ?>">

        <div class="contenido-izquierda">

            <div class="nav-admin menu-contenido"></div>
            <a href="/" class="enlace-logo">
                <div class="contenedor-logo">
                    <img src="/build/img/icons/shop.png" alt="icono venta" class="logo icono-principal-inverso">
                    <span class="name">El pilar</span>
                </div>
            </a>
        </div><!--.contenido-left-->

        <div class="contenido-derecha">
            <!-- Button trigger modal -->
            <a class="btn-Ayuda" data-bs-toggle="modal" data-bs-target="#btn-Ayuda">
                <span>Ayuda</span>
                <img src="/build/img/icons/ayuda.png" class="icono-principal-inverso" alt="buscar">
            </a>
        </div><!--.contenido-right-->

    </header><!--.header-->

    <!-- Modal -->
    <div class="modal fade" id="btn-Ayuda" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <iframe src="/docs/presentacion.pdf" width="100%" height="100%"></iframe> -->
                </div>
                <div class="modal-footer">
                    <a class="boton-rojo" data-bs-dismiss="modal">Cerrar ayuda</a>
                </div>
            </div>
        </div>
    </div>