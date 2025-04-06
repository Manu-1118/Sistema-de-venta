<?php
require '../includes/app.php';

estaAutenticado();
incluirTemplate('header');
incluirTemplate('slidebar');

?>

<main id="main" class="main admin main-admin menu-toggle">
    <h2>Descripción General</h2>

    <div class="descripcion-general">
        <div class="vista vista-verde">
            <div class="contenedor-icono verde">
                <img src="/build/img/icons/productos.png" alt="Productos">
            </div>
            <div class="contenido-descripcion">
                <span class="total-descripcion">597</span>
                <span>Productos totales</span>
            </div>
        </div>
        <div class="vista vista-verde">
            <div class="contenedor-icono verde">
                <img src="/build/img/icons/dinero.png" alt="Capital del día">
            </div>
            <div class="contenido-descripcion">
                <span class="total-descripcion">C$ 5745</span>
                <span>Capital total</span>
            </div>
        </div>
        <div class="vista vista-verde">
            <div class="contenedor-icono verde">
                <img src="/build/img/icons/contado.png" alt="Ventas">
            </div>
            <div class="contenido-descripcion">
                <span class="total-descripcion">52</span>
                <span>Ventas del día</span>
            </div>
        </div>
        <div class="vista vista-roja">
            <div class="contenedor-icono rojo">
                <img src="/build/img/icons/credito.png" alt="Créditos">
            </div>
            <div class="contenido-descripcion">
                <span class="total-descripcion">10</span>
                <span>Créditos totales</span>
            </div>
        </div>
    </div>
</main><!--.main (Descripcion general)-->

<section class="graficos menu-secundario menu-toggle admin">
    <div class="contenedor-grafico fondo" id="barras_ventas_semana">
        <h2>Totales de ventas de la ultima semana</h2>
        <div class="grafico1"></div>
    </div>
    <div class="contenedor-grafico fondo" id="pie_mas_vendido">
        <h2>Productos más vendidos</h2>
        <div class="grafico2"></div>
    </div>
    <div class="contenedor-grafico fondo" id="pie_menos_vendido">
        <h2>Productos menos vendidos</h2>
        <div class="grafico3"></div>
    </div>
</section><!--.Ultimos 7 dias-->

<section>

</section><!--.Producto mas y menos vendido-->

<?php incluirTemplate('footer'); ?>