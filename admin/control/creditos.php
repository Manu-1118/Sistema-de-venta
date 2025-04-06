<?php
require '../../includes/app.php'; // Incluye la configuración principal
require '../../includes/data/credito.php'; // Incluye la consulta de los créditos

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main admin main-admin menu-toggle">
    <h1>Créditos</h1>

    <div class="contenedor">
        <div class="barra-busqueda">
            <input type="text" id="busqueda" placeholder="Buscar cliente...">
            <button id="agregar" onclick="window.location.href='creditoForm.php';">
                <img src="/src/img/icons/agregar.png" width="40" height="45" alt="Agregar Credito">
            </button>
        </div>
        <div class="tabla-container">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Adquisición de Crédito</th>
                        <th>Monto Pendiente</th>
                        <th>Monto Pagado</th>
                        <th>N° de Artículos</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($creditos as $credito) : ?>
                        <tr>
                            <td><?php echo $credito['id_cliente'] . " - " . $credito['nombres'] . " " . $credito['apellidos']; ?></td>
                            <td><?php echo $credito['fecha_credito']; ?></td>
                            <td><?php echo $credito['monto_pendiente']; ?></td>
                            <td><?php echo $credito['monto_pagado']; ?></td>
                            <td><?php echo $credito['cantidad'];?></td> <!-- Placeholder para cantidad -->
                            <td><?php echo $credito['total']; ?></td>
                            <td>
                            <a href="abonarForm.php?id_credito=<?php echo $credito['id_credito']; ?>&id_cliente=<?php echo $credito['id_cliente']; ?>" class="editar-btn">💰 Abonar</a>                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php incluirTemplate('footer'); ?>
