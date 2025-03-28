<?php
require './includes/app.php';

incluirTemplate('header', true);

?>

<main class="contenedor principal" id="main">
    <h1>Categorías</h1>
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

    <section class="imagen-lista">
        <h2>Realice su lista de compras antes de salir de su casa</h2>
        <p>Seleccione todos los productos que necesite para crear su lista de compras y calcular su total</p>
        <a href="list.php" class="boton-azul">¡Crea tu lista!</a>

    </section> <!--.lista-->

    <div class="seccion-inferior">

        <section>

        </section>

        <section class="testimoniales">
            <h3>Testimoniales</h3>
            <div class="testimonial">
                <blockquote>
                    Muy buena atención y las carnes ofrecidas son de buena calidad y a un precio bastante bueno.
                </blockquote>
                <p>- Alvaro Diaz</p>
            </div>
        </section>

    </div>

</main>

<?php
incluirTemplate('footer');
?>