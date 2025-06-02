<?php
require '../../../includes/app.php';
estaAutenticado();
$db = conectarDB();


$id_credito = $_GET['id'] ?? null;
if (!filter_var($id_credito, FILTER_VALIDATE_INT)) {
    header('Location: creditos.php');
    exit;
}

require '../../../data/credito/detalles.php';

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main admin main-admin menu-toggle">

    <?php
    if (!empty($errores)) : ?>
        <div class="alerta error">
            <?php foreach ($errores as $error) : ?>
                <?php echo htmlspecialchars($error); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php
    if (isset($_SESSION['mensaje_abono'])) :
        $clase_alerta = $_SESSION['tipo_mensaje'] ?? 'exito';
    ?>
        <div class="alerta <?php echo $clase_alerta; ?>">
            <?php echo htmlspecialchars($_SESSION['mensaje_abono']); ?>
        </div>
        <?php
        unset($_SESSION['mensaje_abono']);
        unset($_SESSION['tipo_mensaje']);
        ?>
    <?php endif; ?>

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
                    <?php
                    $i = 1;
                    if (!empty($resultado_mostrar_detalle_array)) {
                        foreach ($resultado_mostrar_detalle_array as $credito_detalle) :
                    ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo htmlspecialchars($credito_detalle['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($credito_detalle['precio_unitario']); ?></td>
                                <td><?php echo htmlspecialchars($credito_detalle['cantidad']); ?></td>
                                <td><?php echo htmlspecialchars($credito_detalle['subtotal']); ?></td>
                            </tr>
                        <?php
                            $i++;
                        endforeach;
                    } else {
                        ?>
                        <tr>
                            <td colspan="5">No se encontraron detalles para este crédito.</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <div class="alinear-derecha separar-margin">
                <div>
                    <label>Total del registro</label>
                    <input disabled type="text" value="<?php echo htmlspecialchars($total_credito_actual); ?>">
                </div>

                <a class="boton-rojo" href="creditos.php">
                    <span>Retroceder</span>
                </a>

            </div>
        </div>
    </div>
    <form method="POST" class="formulario">
        <fieldset>
            <legend>Abonar Crédito</legend>

            <div id="fecha-cancelacion-container">
                <label for="fecha-cancelacion">Fecha Límite:</label>
                <input type="date" id="fecha-cancelacion" value="<?php echo htmlspecialchars($fecha_cancelacion_credito); ?>" readonly>
            </div>
            <div>
                <label for="monto-pendiente">Monto pendiente:</label>
                <input type="number" id="monto-pendiente" value="<?php echo htmlspecialchars($monto_pendiente_actual); ?>" readonly>
            </div>
            <div>
                <label>Monto a abonar:</label>
                <input type="number" name="txtMontoAbono" id="txtMontoAbono" placeholder="C$0.00" step="0.01">
            </div>
            <div class="alinear-derecha separar-margin">

                <a class="boton-rojo" href="creditos.php">
                    <span>Cancelar</span>
                </a>

                <input type="submit" value="Abonar" class="boton-azul">

            </div>
        </fieldset>
    </form>
</main>

<?php incluirTemplate('footer', true); ?>