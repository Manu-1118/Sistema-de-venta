<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';
estaAutenticado();

$db = conectarDB();

$id_credito = isset($_GET['id']) ? intval($_GET['id']) : null;

// Procesar abono
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_credito'], $_POST['monto_abono'])) {
    $id_credito_post = intval($_POST['id_credito']);
    $monto_abono = floatval($_POST['monto_abono']);

    $query = "SELECT monto_pagado, monto_pendiente FROM Credito WHERE id = $id_credito_post LIMIT 1";
    $result = mysqli_query($db, $query);
    $credito = mysqli_fetch_assoc($result);

    if ($credito && $monto_abono <= $credito['monto_pendiente']) {
        $nuevo_pagado = $credito['monto_pagado'] + $monto_abono;
        $nuevo_pendiente = $credito['monto_pendiente'] - $monto_abono;

        $query_update = "UPDATE Credito SET monto_pagado = $nuevo_pagado, monto_pendiente = $nuevo_pendiente WHERE id = $id_credito_post";
        mysqli_query($db, $query_update);
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=$id_credito_post&resultado=1");
        exit;
    } else {
        $error_abono = "El monto a abonar supera el monto pendiente o no se encontró el crédito.";
    }
}

// Mostrar solo el crédito correspondiente
$query_mostrar = "SELECT cd.id, CONCAT(c.nombres, ' ', c.apellidos) AS cliente, cd.fecha_credito, cd.fecha_cancelacion, cd.total, cd.monto_pendiente, cd.monto_pagado FROM Cliente c JOIN Credito cd ON c.id = cd.id_cliente WHERE cd.id = $id_credito LIMIT 1";
$resultado_mostrar = mysqli_query($db, $query_mostrar);
$credito = mysqli_fetch_assoc($resultado_mostrar);

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main admin main-admin menu-toggle">
    <?php if (isset($_GET['resultado']) && $_GET['resultado'] == 1): ?>
        <p class="alerta exito">El abono se registró con éxito</p>
    <?php endif; ?>

    <div class="contenedor-productos">
        <div class="tabla-containe">
            <table class="tabla-productos">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Fecha Crédito</th>
                        <th>Fecha Cancelación</th>
                        <th>Total</th>
                        <th>Monto Pagado</th>
                        <th>Monto Pendiente</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($credito): ?>
                        <tr>
                            <td>1</td>
                            <td><?php echo $credito['cliente']; ?></td>
                            <td><?php echo $credito['fecha_credito']; ?></td>
                            <td><?php echo $credito['fecha_cancelacion']; ?></td>
                            <td><?php echo number_format($credito['total'], 2); ?></td>
                            <td><?php echo number_format($credito['monto_pagado'], 2); ?></td>
                            <td><?php echo number_format($credito['monto_pendiente'], 2); ?></td>
                        </tr>
                    <?php else: ?>
                        <tr><td colspan="7">No se encontró el crédito.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="contenedor-productos">
        <h2>Formulario de Abono</h2>

        <?php if (isset($error_abono)): ?>
            <p class="alerta error"><?php echo $error_abono; ?></p>
        <?php endif; ?>

        <?php if ($credito): ?>
            <form method="POST" class="formulario">
                <input type="hidden" name="id_credito" value="<?php echo $credito['id']; ?>">

                <div class="campo">
                    <label for="abono">Cantidad a Abonar (C$):</label>
                    <input type="number" name="monto_abono" id="abono" step="0.01" min="1" required>
                </div>

                <input type="submit" value="Abonar" class="boton-verde">
            </form>
        <?php endif; ?>
    </div>
</main>

<?php incluirTemplate('footer'); ?>
