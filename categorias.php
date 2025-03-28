<?php
require 'includes/app.php';

incluirTemplate('header', true);
?>

<main class="contenedor section main" id="main">
<h1>Categorías</h1>
    <div class="contenedor-categorias">
        <!--codigo php para mostrar las cat de la bd-->
        <div class="categoria">
            <img src="/build/img/categories/lacteos.png" alt="categoria">

            <div class="contenido-categoria">
                <h3>Lacteos</h3>
                <p>Leches, cremas, yogures...</p>
                <a href="#" class="boton-azul-block">Ver categoría</a>
            </div>
        </div><!--.categoria-->
        <div class="categoria">
            <img src="/build/img/categories/embutidos.png" alt="categoria">

            <div class="contenido-categoria">
                <h3>Embutidos</h3>
                <p>Salchichas, mortadelas, Jamón...</p>
                <a href="#" class="boton-azul-block">Ver categoría</a>
            </div>
        </div><!--.categoria-->
        <div class="categoria">
            <img src="/build/img/categories/carnes.png" alt="categoria">

            <div class="contenido-categoria">
                <h3>Carnes</h3>
                <p>Bistec, desmenuzar, cerdo, alitas...</p>
                <a href="#" class="boton-azul-block">Ver categoría</a>
            </div>
        </div><!--.categoria-->
        <div class="categoria">
            <img src="/build/img/categories/aceite-de-cocina.png" alt="categoria">

            <div class="contenido-categoria">
                <h3>Aceites</h3>
                <p>Leches, cremas, yogures...</p>
                <a href="#" class="boton-azul-block">Ver categoría</a>
            </div>
        </div><!--.categoria-->
        <div class="categoria">
            <img src="/build/img/categories/verduras.png" alt="categoria">

            <div class="contenido-categoria">
                <h3>Verduras</h3>
                <p>Salchichas, mortadelas, Jamón...</p>
                <a href="#" class="boton-azul-block">Ver categoría</a>
            </div>
        </div><!--.categoria-->
        <div class="categoria">
            <img src="/build/img/categories/farmacia.png" alt="categoria">

            <div class="contenido-categoria">
                <h3>Farmacia</h3>
                <p>Bistec, desmenuzar, cerdo, alitas...</p>
                <a href="#" class="boton-azul-block">Ver categoría</a>
            </div>
        </div><!--.categoria-->
        <div class="categoria">
            <img src="/build/img/categories/panaderia.png" alt="categoria">

            <div class="contenido-categoria">
                <h3>Panadería</h3>
                <p>Leches, cremas, yogures...</p>
                <a href="#" class="boton-azul-block">Ver categoría</a>
            </div>
        </div><!--.categoria-->
        <div class="categoria">
            <img src="/build/img/categories/enlatados.png" alt="categoria">

            <div class="contenido-categoria">
                <h3>Enlatados</h3>
                <p>Salchichas, mortadelas, Jamón...</p>
                <a href="#" class="boton-azul-block">Ver categoría</a>
            </div>
        </div><!--.categoria-->
        <div class="categoria">
            <img src="/build/img/categories/higiene_hogar.png" alt="categoria">

            <div class="contenido-categoria">
                <h3>Higiene y Hogar</h3>
                <p>Bistec, desmenuzar, cerdo, alitas...</p>
                <a href="#" class="boton-azul-block">Ver categoría</a>
            </div>
        </div><!--.categoria-->
    </div><!--.contenedor-categorias-->
</main>

<?php
incluirTemplate('footer');
?>