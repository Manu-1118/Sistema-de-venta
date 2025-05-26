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
        </div><!--.contenido-right-->

    </header><!--.header-->