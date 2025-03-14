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
                <img src="/build/img/icons/shop.png" alt="icono venta" class="logo icono-principal-inverso">
                <span class="name">El pilar</span>
            </div>

            <!--OTROS ICONOS DE ACCESIBILIDAD-->

        </div><!--.contenido-left-->

        <div class="contenido-derecha">
            <div class="buscador">
                <div class="icono-lupa icono-principal-inverso">
                    <img src="build/img/icons/buscar.png" alt="-">
                </div>
                <input type="search" placeholder="Buscar algún producto" class="barra">
            </div>

            <a href="#">
                <img src="build/img/icons/moon.png" alt="boton darkmode" class="btnDarkMode icono-principal-inverso">
            </a>
            <!--<a href="#">
                <img src="src/icons/comentarios.svg" alt="comentario">
            </a>
            <a href="#">
                <img src="src/icons/preguntas.svg" alt="preguntas">
            </a>

            <a href="#">
                <img src="build/img/icons/notificaciones.svg" alt="notificaciones" class="icono-principal">
            </a>-->


            <img src="build/img/usuario.png" alt="Foto user" class="usuario">

        </div><!--.contenido-right-->
    </header><!--.header-->

    <div class="sidebar" id="sidebar">
        <nav>
            <ul>
                <li>
                    <a href="#">
                        <img src="build/img/icons/productos.png" alt="icono" class="icono-principal">
                        <span>Productos</span>
                    </a>
                </li><!--.icono-->
                <li>
                    <a href="#">
                        <img src="build/img/icons/contado.png" alt="icono" class="icono-principal">
                        <span>Ventas</span>
                    </a>
                </li><!--.icono-->
                <li>
                    <a href="#">
                        <img src="build/img/icons/credito.png" alt="icono" class="icono-principal">
                        <span>Créditos</span>
                    </a>
                </li><!--.icono-->
                <li>
                    <a href="#">
                        <img src="build/img/icons/compra.png" alt="icono" class="icono-principal">
                        <span>Compras</span>
                    </a>
                </li><!--.icono-->
                <li>
                    <a href="#">
                        <img src="build/img/icons/dañado.png" alt="icono" class="icono-principal">
                        <span>Dañado</span>
                    </a>
                </li><!--.icono-->
                <li>
                    <a href="#">
                        <img src="build/img/icons/cliente.png" alt="icono" class="icono-principal">
                        <span>Clientes</span>
                    </a>
                </li><!--.icono-->
                <li>
                    <a href="#">
                        <img src="build/img/icons/proveedor.png" alt="icono" class="icono-principal">
                        <span>Proveedores</span>
                    </a>
                </li><!--.icono-->
                <li>
                    <a href="#">
                        <img src="build/img/icons/admin.png" alt="icono" class="icono-principal">
                        <span>Administradores</span>
                    </a>
                </li><!--.icono-->
            </ul>
        </nav>

        <a href="#" class="logout">
            <img src="build/img/icons/logout.png" alt="cerrar sesion" class="icono-principal">
            <span>Cerrar Sesión</span>
        </a>

    </div><!--.sidebar-->