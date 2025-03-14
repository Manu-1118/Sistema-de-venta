<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="build/css/app.css">
    <title>Sistema de pulperia</title>
</head>

<body>
    <header class="header">
        <div class="contenido-izquierda">

            <div class="menu-contenido">
                <div class="menu" id="menu">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>

            <div class="contenedor-logo">
                <img src="src/icons/shop-svgrepo-com.svg" alt="icono venta" class="logo">
                <span class="name">El pilar</span>
            </div>

            <!--OTROS ICONOS DE ACCESIBILIDAD-->

        </div><!--.contenido-left-->

        <div class="contenido-derecha">
            <a href="#" class="busqueda">
                <img src="src/icons/buscar.svg" alt="icono" class="icono-principal">
                <span>Buscar</span>
            </a>

            <a href="#">
                <img src="src/icons/moon.svg" alt="boton darkmode" class="btnDarkMode icono-principal">
            </a>
            <!--<a href="#">
                <img src="src/icons/comentarios.svg" alt="comentario">
            </a>
            <a href="#">
                <img src="src/icons/preguntas.svg" alt="preguntas">
            </a>-->

            <a href="#">
                <img src="src/icons/notificaciones.svg" alt="notificaciones" class="icono-principal">
            </a>


            <img src="build/img/usuario.png" alt="Foto user" class="usuario">

        </div><!--.contenido-right-->
    </header><!--.header-->

    <div class="sidebar" id="sidebar">
        <nav>
            <ul>
                <li>
                    <a href="#">
                        <img src="src/icons/productos.svg" alt="icono" class="icono-principal">
                        <span>Productos</span>
                    </a>
                </li><!--.icono-->
                <li>
                    <a href="#">
                        <img src="src/icons/ventas.svg" alt="icono" class="icono-principal">
                        <span>Ventas</span>
                    </a>
                </li><!--.icono-->
                <li>
                    <a href="#">
                        <img src="src/icons/credito.svg" alt="icono" class="icono-principal">
                        <span>Créditos</span>
                    </a>
                </li><!--.icono-->
                <li>
                    <a href="#">
                        <img src="src/icons/compra.svg" alt="icono" class="icono-principal">
                        <span>Compras</span>
                    </a>
                </li><!--.icono-->
                <li>
                    <a href="#">
                        <img src="src/icons/clientes.svg" alt="icono" class="icono-principal">
                        <span>Clientes</span>
                    </a>
                </li><!--.icono-->
                <li>
                    <a href="#">
                        <img src="src/icons/admin.svg" alt="icono" class="icono-principal">
                        <span>Administradores</span>
                    </a>
                </li><!--.icono-->
            </ul>
        </nav>

        <a href="#">
            <img src="src/icons/logout.svg" alt="cerrar sesion" class="icono-principal">
            <span>Cerrar Sesión</span>
        </a>

    </div><!--.sidebar-->