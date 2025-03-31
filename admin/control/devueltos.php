<?php
require '../../includes/app.php';

estaAutenticado(); //verificar que $_SESSION sea true
incluirTemplate('header');
incluirTemplate('slidebar');

?>

<main id="main" class="main">
    <h1>Dañados/Devueltos</h1>
    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Reiciendis debitis quisquam quis ipsum facere eos,
        magni veniam saepe, minus architecto, eum minima porro! Ipsum, nulla excepturi exercitationem minus illo
        atque.</p>
</main><!--.main-->

<?php incluirTemplate('footer'); ?>