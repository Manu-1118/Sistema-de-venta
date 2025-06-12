<?php
$db = conectarDB();

$consulta = "SELECT * FROM Categoria";

if ($n != null) {
    $consulta .= " LIMIT {$n}";
}


//debuguear($n);
$resultados = mysqli_query($db, $consulta);
// debuguear(mysqli_fetch_assoc($resultados));
?>

<div class="contenedor-categorias">
    <?php while ($categoria = mysqli_fetch_assoc($resultados)): ?>

        <!--codigo php para mostrar las cat de la bd-->
        <div class="categoria">
            <img loading="lazy" src="/img/categorias/<?php echo $categoria['imagen'] ?>" alt="categoria">

            <div class="contenido-categoria">
                <h3><?php echo $categoria['nombre']; ?></h3>
                <p><?php echo $categoria['descripcion']; ?></p>
                <a href="/categoria.php?id_categoria=<?php echo $categoria['id_categoria']; ?>" class="boton-azul-block">Ver categoría</a>
            </div>
        </div><!--.categoria-->

    <?php endwhile; ?>
</div><!--.contenedor-categiras-->