<?php
require '../../includes/app.php';
require '../../includes/data/clientes.php';

estaAutenticado(); //verificar que $_SESSION sea true
incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main">
    <h1>Clientes</h1>

    <div class="contenedor-clientes">
        <div class="barra-busqueda">
            <input type="text" id="busqueda" placeholder="Buscar cliente...">
            <button id="agregarCliente">
                <img src="/src/img/icons/agregar.png" width="40" height="45" alt="Agregar cliente">
            </button>
        </div>
        <div class="tabla-container">
            <table class="tabla-clientes">
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
                            <td><?php echo $cliente['nombre']; ?></td>
                            <td><?php echo $cliente['apellido']; ?></td>
                            <td>
                                <a href="editar.php?id=<?php echo $cliente['id']; ?>" class="editar-btn">✏️ Editar</a>
                                <a href="creditos.php?id=<?php echo $cliente['id']; ?>" class="creditos-btn">💰 Créditos</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php incluirTemplate('footer'); ?>
