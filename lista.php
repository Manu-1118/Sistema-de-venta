<?php
require 'includes/app.php';
estaAutenticado(true); //verificar que $_SESSION sea true
incluirTemplate('header', true);

//Conectar la bd
$db = conectarDB();
$encabezados = ['Imagen', 'Nombre', 'Descripción', 'Cant.', 'Precio']; //encabezados de la tabla correspondiente
// variables para añadirlas al archivo "/data/obtener_datos.php"
$columnas = ['imagen', 'nombre', 'descripcion', 'cantidad', 'precio_unitario'];
$tabla = 'Producto';
$btn_texto = 'Añadir';
$ruta_imagen = 'productos';

$_SESSION['encabezados'] = $encabezados;
$_SESSION['columnas'] = $columnas;
$_SESSION['tabla'] = $tabla;
$_SESSION['btn_texto'] = $btn_texto;
$_SESSION['ruta'] = $ruta_imagen;

?>

<section class="imagen-lista-compras">
    <img src="/build/img/banner-lista-compra.png" alt="Banner encabezado">
</section>

<main id="main" class="principal fondo">

    <div class="contenedor-lista">
        <?php incluirTemplate('tabla_datos'); ?>
    </div>

</main>

<?php
incluirTemplate('footer');
?>