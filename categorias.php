<?php
require 'includes/app.php';
incluirTemplate('header', true);
?>

<!-- Todas las categorias -->

<main class="contenedor section main" id="main">
    <h1>Categorías</h1>
    <?php incluirTemplate('categorias') ?>
</main>

<?php
incluirTemplate('footer');
?>