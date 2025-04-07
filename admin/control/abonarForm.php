<?php
require '../../includes/app.php';
require '../../includes/data/proveedores.php';

estaAutenticado();
incluirTemplate('header');
incluirTemplate('slidebar');

$db = conectarDB();
date_default_timezone_set('America/Managua');

$errores = [];

$id_credito = isset($_GET['id_credito']) ? $_GET['id_credito'] : null;
$id_cliente = isset($_GET['id_cliente']) ? $_GET['id_cliente'] : null;

// echo '<script>console.log(' . json_encode($id_credito) . ');</script>>';
// echo '<script>console.log(' . json_encode($id_cliente) . ');</script>>';
$query_nombre = "SELECT * FROM cliente WHERE id = $id_cliente";
$resultado_nombre = mysqli_query($db, $query_nombre);
$cliente = mysqli_fetch_assoc($resultado_nombre);

$query_credito = "SELECT * FROM credito WHERE id = $id_credito";
$resultado_credito = mysqli_query($db, $query_credito);
$credito = mysqli_fetch_assoc($resultado_credito);


$query_detalles = "SELECT 
                        p.nombre AS producto,
                        dc.cantidad,
                        dc.cantidad * p.precio_unitario AS total
                    FROM 
                        detallecredito dc
                    JOIN 
                        producto p ON dc.codigo_producto = p.codigo
                    WHERE 
                        dc.id_credito = $id_credito";

$resultado_detalles = mysqli_query($db, $query_detalles);
$detalles = mysqli_fetch_all($resultado_detalles, MYSQLI_ASSOC);
echo '<script>console.table(' . json_encode($detalles) . ');</script>';

if ($credito) {
    if ($credito['monto_pagado'] == null) {
        // $credito['monto_pagado'] = 0;
        $query_credito = "UPDATE credito SET monto_pagado = 0 WHERE id = $id_credito";
        $resultado_credito = mysqli_query($db, $query_credito);
    }

    if ($credito['monto_pendiente'] == null) {
        // $credito['monto_pendiente'] = $credito['total'];
        $query_credito = "UPDATE credito SET monto_pendiente = {$credito['total']} WHERE id = $id_credito";
        $resultado_credito = mysqli_query($db, $query_credito);
        $credito['monto_pendiente'] = $credito['total'];
    }
}   


echo '<script>console.table(' . json_encode($cliente) . ');</script>';
echo '<script>console.table(' . json_encode($credito) . ');</script>';

?>

<main id="main" class="main admin main-admin menu-toggle">
    <h1>Registrar Abono</h1>
    <div class="contenedorForm">
        <div class="position-fixed">
            <?php foreach ($errores as $error) : ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endforeach; ?>

            <form method="POST" action="../../includes/data/abonar.php">
                <div class="total-compra-container">
                    <label for="cliente" class="form-label">Cliente:</label>
                    <input type="text" id="cliente" value="<?php echo $cliente['nombres'] ?? ''; ?>" readonly>
                </div>

                <div class="form-row">
                    <div class="form-col" style="position: relative;">
                        <label for="montoTotal" class="form-label">Monto Total:</label>
                        <input type="text" class="form-control" id="montoTotal" value="<?php echo $credito['total'];?>" readonly>
                    </div>

                    <div class="form-col" style="position: relative;">
                        <label for="montoPendiente" class="form-label">Monto pendiente:</label>
                        <input type="text" class="form-control" id="montoPendiente" name="monto_pendiente"   value="<?php echo $credito['monto_pendiente']; ?>" readonly>
                    </div>

                    <div class="form-col" style="position: relative;">
                        <label for="cantidad" class="form-label">Cantidad a abonar:</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad">
                    </div>
                </div>

                <input type="text" name="id_credito" value="<?php echo $credito['id']; ?>" hidden class="form-control">
                <input type="text" name="id_cliente" value="<?php echo $cliente['id']; ?>" hidden class="form-control">

                <button type="submit" class="btn btn-primary">Realizar</button>
            </form>
        </div>

        <h3>Detalles del crédito</h3>

        <div class="tabla-container">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($detalles)) : ?>
                        <?php foreach ($detalles as $detalle) : ?>
                            <tr>
                                <td><?php echo $detalle['producto']; ?></td>
                                <td><?php echo $detalle['cantidad']; ?></td>
                                <td><?php echo $detalle['total']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php
incluirTemplate('footer');
?>
