<?php
require '../../includes/app.php'; 
require '../../includes/data/credito.php'; 

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
                        <?php 
                        // Calcula el monto pendiente :total - monto pagado
                        $montoPendiente = $credito['total'] - $credito['monto_pagado']; 
                        ?>
                        <tr>
                            <td><?php echo $credito['nombres'] . " " . $credito['apellidos']; ?></td>
                            <td><?php echo $credito['fecha_credito']; ?></td>
                            <!-- se muestra el monto pendiente calculado -->
                            <td><?php echo number_format($montoPendiente ?? 0, 2); ?></td>
                            <td><?php echo number_format($credito['monto_pagado'] ?? 0, 2); ?></td>
                            <td><?php echo $credito['cantidad_total']; ?></td>
                            <td><?php echo number_format($credito['total'] ?? 0, 2); ?></td>
                            <td>
                                <a href="abonarForm.php?id_credito=<?php echo $credito['id_credito']; ?>&id_cliente=<?php echo $credito['id_cliente']; ?>" class="editar-btn">💰 Abonar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php incluirTemplate('footer'); ?>
