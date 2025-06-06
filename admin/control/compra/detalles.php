<?php
require '../../../includes/app.php';
$db = conectarDB();
require '../../../data/compra/detalles.php';
estaAutenticado();


$query_mostrar_detalle = "SELECT p.nombre, p.precio_compra, dc.cantidad, p.precio_compra*dc.cantidad as 'subtotal' FROM Compra c join DetalleCompra dc on c.id_compra = dc.id_compra join Producto p on dc.codigo_producto = p.codigo_producto WHERE c.id_compra = {$_GET['id']}";
// sdebuguear($query_mostrar_detalle);
$resultado_mostrar_detalle = mysqli_query($db, $query_mostrar_detalle);

$total = 0;

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<!-- class="main admin menu-toggle" -->

<main id="main" class="main admin main-admin menu-toggle">

    <!-- <?php if (intval($resultado_mensaje) === 1): ?>
        <p class="alerta exito">Los productos dañados se agendaron con exito</p>
    <?php endif;
            $_SESSION['lista_productos'] = []; ?> -->

        <div class="contenedor-productos">
            
            <div class="contenedor-tabla-datos">
            <table class="tabla-plantilla">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Precio de Compra</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tbody class="cuerpo-tabla">
                    <?php $i = 1;
                    while ($detalles = mysqli_fetch_assoc($resultado_mostrar_detalle)): ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $detalles['nombre']; ?></td>
                            <td><?php echo $detalles['precio_compra']; ?></td>
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

                <a class="boton-rojo" href="compras.php">
                    <span>Retroceder</span>
                </a>

            </div>
        </div>
    </div>
</main>

<?php incluirTemplate('footer', true); ?>