<?php
require '../../includes/app.php';
require '../../includes/data/clientes.php';

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main">
    <h1>Clientes</h1>

    <div class="contenedor">
        <div class="barra-busqueda">
            <input type="text" id="busqueda" placeholder="Buscar cliente...">
            <button id="agregar" onclick="window.location.href='clientesForm.php';">
                <img src="/src/img/icons/agregar.png" width="40" height="45" alt="Agregar cliente">
            </button>
        </div>
        <div class="tabla-container">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente) : ?>
                        <tr>
                            <td><?php echo $cliente['id']; ?></td>
                            <td><?php echo $cliente['nombres']; ?></td>
                            <td><?php echo $cliente['apellidos']; ?></td>
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
