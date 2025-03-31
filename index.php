<?php
require './includes/app.php';

incluirTemplate('header', true);

?>

<section class="imagen-encabezado">
    <h2>Pulpería El Pilar</h2>
    <div class="icono-direccion">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="48" height="48" stroke-width="2">
            <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
            <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"></path>
        </svg>
        <p>Managua, Nicaragua</p>
    </div>
    <a class="boton boton-azul" href="nosotros.php">Saber más</a>
</section><!--.Imagen principal del encabezado-->

<main class="principal menu-secundario fondo" id="main">
    <h1>Categorías de Productos</h1>
    <div class="contenedor-categorias">
        <!--codigo php para mostrar las cat de la bd-->
        <div class="categoria">
            <img src="/build/img/categories/lacteos.png" alt="categoria">

            <div class="contenido-categoria">
                <h3>Lacteos</h3>
                <p>Leches, cremas, yogures...</p>
                <a href="categoria.php" class="boton-azul-block">Ver categoría</a>
            </div>
        </div><!--.categoria-->
        <div class="categoria">
            <img src="/build/img/categories/embutidos.png" alt="categoria">

            <div class="contenido-categoria">
                <h3>Embutidos</h3>
                <p>Salchichas, mortadelas, Jamón...</p>
                <a href="categoria.php" class="boton-azul-block">Ver categoría</a>
            </div>
        </div><!--.categoria-->
        <div class="categoria">
            <img src="/build/img/categories/carnes.png" alt="categoria">

            <div class="contenido-categoria">
                <h3>Carnes</h3>
                <p>Bistec, desmenuzar, cerdo, alitas...</p>
                <a href="categoria.php" class="boton-azul-block">Ver categoría</a>
            </div>
        </div><!--.categoria-->
    </div><!--.contenedor-categorias-->

    <div class="alinear-derecha">
        <a href="categorias.php" class="boton-verde">Ver todas</a>
    </div>
</main><!--.Panel de las categorias-->

<section class="imagen-lista principal menu-secundario">
    <h2>Realice su lista de compras antes de salir de su casa</h2>
    <p>Seleccione todos los productos que necesite para crear su lista de compras y calcular su total</p>
    <a href="lista.php" class="boton-azul">¡Crea tu lista!</a>
</section> <!--.Acceder al carrito virtual-->

<div class="seccion-inferior menu-secundario principal fondo">

    <section class="blog-carnes">

        <h3> Nuestras carnes principales</h3>
        <article class="entrada-blog">
            <div class="imagen">
                <img src="/build/img/corona.jpg" alt="posta de corona">
            </div>

            <div class="texto-entrada">
                    <h4>Posta de corona</h4>
                    <p>Corte semiesférico, no tiene venas y es un corte suave, excelente para asar a la parrilla, asar en bistec o guisado.</p>
            </div>
        </article>

        <article class="entrada-blog">
            <div class="imagen">
                <img src="/build/img/gallina.jpg" alt="posta de gallina">
            </div>

            <div class="texto-entrada">
                    <h4>Posta de gallina</h4>
                    <p>Situado en el cuarto delantero, debajo del hueso de la paleta (parte lateral del tórax), es un corte muy limpio sin grasa superficial.</p>
            </div>
        </article>

    </section>

    <section class="testimoniales">
        <h3>Testimoniales</h3>
        <div class="testimonial">
            <blockquote>
                Muy buena atención y las carnes ofrecidas son de excelente calidad y a un precio bastante accesible.
            </blockquote>
            <p>- Alvaro Diaz</p>
        </div>
    </section>

</div> <!--.Info extra y testimoniales-->

<?php
incluirTemplate('footer');
?>