<?php
require '../../../includes/app.php';
estaAutenticado(); //verificar que $_SESSION sea true
$db = conectarDB();
require '../../../data/compra/insertar.php';

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main admin main-admin menu-toggle">
    
</main>

<?php incluirTemplate('footer'); ?>