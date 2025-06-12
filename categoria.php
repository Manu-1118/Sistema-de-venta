<?php
require 'includes/app.php';
$db = conectarDB();

$id_categoria = filter_var($_GET['id_categoria'], FILTER_VALIDATE_INT);
if (!$id_categoria) {
    header('Location: /categorias.php');
}

$consulta = "SELECT p.imagen, p.codigo_producto, p.nombre, p.descripcion, p.precio_unitario FROM Producto p JOIN Categoria c on p.id_categoria = c.id_categoria WHERE c.id_categoria = {$id_categoria};";
$resultado = mysqli_query($db, $consulta);
// debuguear(mysqli_fetch_assoc($resultado));

incluirTemplate('header', true);
?>

<main class="main contenido-usuario" id="main">
    <div class="contenedor-producto-categoria">

        <?php while ($producto = mysqli_fetch_assoc($resultado)): ?>
            <div class="contenedor-producto">
                <img loading="lazy" src="/img/productos/<?php echo $producto['imagen']; ?>" alt="imagen producto">
                <h3><?php echo $producto['nombre']; ?></h3>
                <p>Codigo: <?php echo $producto['codigo_producto']; ?></p>
                <p><?php echo $producto['descripcion']; ?></p>
                <p>Precio: <?php echo $producto['precio_unitario']; ?></p>
            </div>
        <?php endwhile; ?>

    </div>
</main>

<?php
incluirTemplate('footer');
?>