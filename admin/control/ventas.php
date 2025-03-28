<?php
require '../../includes/app.php';

$pagina_actual = basename($_SERVER['PHP_SELF']); // Obtiene el nombre del archivo actual
incluirTemplate('header');
incluirTemplate('slidebar');

?>

<main id="main" class="main">
    <h1>Ventas</h1>
    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Reiciendis debitis quisquam quis ipsum facere eos,
        magni veniam saepe, minus architecto, eum minima porro! Ipsum, nulla excepturi exercitationem minus illo
        atque.</p>
</main><!--.main-->

<?php incluirTemplate('footer'); ?>