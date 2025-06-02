<?php
require '../../../includes/app.php';
estaAutenticado();
$db = conectarDB();
require '../../../data/cliente/deudas.php';


incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main admin main-admin menu-toggle">

    <div class="contenedor-productos">

        <div class="contenedor-tabla-datos">
            <table class="tabla-plantilla">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Fecha Crédito</th>
                        <th>Fecha Cancelación</th>
                        <th>Monto Pagado</th>
                        <th>Monto Pendiente</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="cuerpo-tabla">
                    <?php
                    $i = 1;
                    while ($detalles = mysqli_fetch_assoc($resultado_detalle)): ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $detalles['fecha_credito']; ?></td>
                            <td><?php echo $detalles['fecha_cancelacion']; ?></td>
                            <td><?php echo $detalles['monto_pagado']; ?></td>
                            <td><?php echo $detalles['monto_pendiente']; ?></td>
                            <td><?php echo $detalles['total']; ?></td>
                        </tr>
                    <?php
                        $i++;
                    endwhile;
                    ?>
                </tbody>
            </table>

            <div class="alinear-derecha separar-margin">

                <a class="boton-rojo" href="clientes.php">
                    <span>Retroceder</span>
                </a>

            </div>
        </div>
    </div>
</main>

<?php incluirTemplate('footer', true); ?>