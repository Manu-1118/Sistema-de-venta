<?php
require '../../../includes/app.php';
estaAutenticado();
$db = conectarDB();
require '../../../data/contado/detalles.php';

//escribir el query
$query_mostrar_detalle = "SELECT p.nombre, p.precio_unitario, dc.cantidad, p.precio_unitario*dc.cantidad as 'subtotal' FROM Contado c join DetalleContado dc on c.id_contado = dc.id_contado join Producto p on dc.codigo_producto = p.codigo_producto WHERE c.id_contado = {$_GET['id']}";
// debuguear($query_mostrar_detalle);
$resultado_mostrar_detalle = mysqli_query($db, $query_mostrar_detalle);
$total = 0;
incluirTemplate('header');
incluirTemplate('slidebar');
?>

<!-- class="main admin menu-toggle" -->

<main id="main" class="main admin main-admin menu-toggle">

    <!-- <?php if (intval($resultado_mensaje) === 1): ?>
    <?php endif;
            $_SESSION['lista_productos'] = []; ?> -->

    <div class="contenedor-productos">

        <div class="contenedor-tabla-datos">
            <table class="tabla-plantilla">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Precio unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody class="cuerpo-tabla">
                    <?php $i = 1;
                    while ($detalles = mysqli_fetch_assoc($resultado_mostrar_detalle)): ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $detalles['nombre']; ?></td>
                            <td><?php echo $detalles['precio_unitario']; ?></td>
                            <td><?php echo $detalles['cantidad']; ?></td>
                            <td><?php echo $detalles['subtotal']; ?></td>
                        </tr>
                    <?php $i++;
                        $total += $detalles['subtotal'];
                    endwhile; ?>
                </tbody>
            </table>

            <div class="alinear-derecha separar-margin">

                <div>
                    <label>Total del registro</label>
                    <input disabled type="text" value="<?php echo $total ?>">
                </div>

                <a class="boton-rojo" href="contado.php">
                    <span>Retroceder</span>
                </a>

            </div>
        </div>
    </div>
</main>

<?php incluirTemplate('footer', true); ?>