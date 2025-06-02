<?php
require '../includes/app.php';
estaAutenticado();
$db = conectarDB(); // Conectarse a la bd
require '../data/dashboard.php';
//  debuguear($ultimos_dias);

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main admin main-admin menu-toggle sombra">
    <h2>Descripción General</h2>

    <a href="/admin/control/producto/productos.php">
        <div class="descripcion-general">
            <div class="vista vista-verde">
                <div class="contenedor-icono verde">
                    <img src="/build/img/icons/productos.png" alt="Productos">
                </div>
                <div class="contenido-descripcion">
                    <span class="total-descripcion"><?php echo $total_productos['total']; ?></span>
                    <span>Productos totales</span>
                </div>
            </div>
    </a><!--.vista total productos-->

    <a href="/admin/control/contado/contado.php">
        <div class="vista vista-verde">
            <div class="contenedor-icono verde">
                <img src="/build/img/icons/dinero.png" alt="Capital del día">
            </div>
            <div class="contenido-descripcion">
                <span class="total-descripcion"><?php echo 'C$ ' . $total_dia['total']; ?></span>
                <span>Capital total</span>
            </div>
        </div>
    </a><!--.vista capital del dia-->

    <a href="/admin/control/contado/contado.php">
        <div class="vista vista-verde">
            <div class="contenedor-icono verde">
                <img src="/build/img/icons/contado.png" alt="Ventas">
            </div>
            <div class="contenido-descripcion">
                <span class="total-descripcion"><?php echo $total_ventas['total']; ?></span>
                <span>Ventas del día</span>
            </div>
        </div>
    </a><!--.vista total ventas contado-->

    <a href="/admin/control/credito/creditos.php">
        <div class="vista vista-roja">
            <div class="contenedor-icono rojo">
                <img src="/build/img/icons/credito.png" alt="Créditos">
            </div>
            <div class="contenido-descripcion">
                <span class="total-descripcion"><?php echo $total_creditos['total']; ?></span>
                <span>Créditos pendientes</span>
            </div>
        </div>
    </a><!--.vista total creditos pendientes-->

    </div>
</main><!--.main (Descripcion general)-->

<section class="menu-secundario menu-toggle admin graficos">
    <div class="contenedor-grafico fondo" id="barras_ventas_semana">
        <h2>Totales de ventas de la ultima semana</h2>
        <div class="grafico1"></div>
    </div>

</section><!--.Ultimos 7 dias-->

<section class="graficos menu-secundario menu-toggle admin">

    <div class="contenedor-grafico fondo" id="barra_clientes">
        <h2>Totales de ventas de la ultima semana</h2>
        <div class="grafico4"></div>
    </div>
    <div class="contenedor-grafico fondo" id="pie_mas_vendido">
        <h2>Productos más vendidos</h2>
        <div class="grafico2"></div>
    </div>
    <div class="contenedor-grafico fondo" id="pie_menos_vendido">
        <h2>Productos menos vendidos</h2>
        <div class="grafico3"></div>
    </div>
</section>

<?php incluirTemplate('footer', true); ?>