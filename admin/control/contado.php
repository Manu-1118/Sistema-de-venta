<?php
require '../../includes/app.php';
require '../../includes/data/clientes.php';

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main">
    <h1>Contado</h1>

    <div class="contenedor">
        <div class="barra-busqueda">
            <input type="text" id="busqueda" placeholder="Buscar cliente...">
            <button id="agregar" onclick="window.location.href='ventasForm.php';">
                <img src="/src/img/icons/agregar.png" width="40" height="45" alt="Agregar venta">
            </button>

        </div>
        <div class="tabla-container">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha Registro</th>
                        <th>Cantidad de productos</th>
                        <th>Total de Venta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente) : ?>
                        <tr>
                            <td><?php echo $cliente['id']; ?></td>
                            <td><?php echo $cliente['nombre']; ?></td>
                            <td><?php echo $cliente['apellido']; ?></td>
                            <td>
                                <a href="editar.php?id=<?php echo $cliente['id']; ?>" class="editar-btn">✏️ Editar</a>
                                <a href="creditos.php?id=<?php echo $cliente['id']; ?>" class="accion-btn">💰 Créditos</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php incluirTemplate('footer'); ?>
