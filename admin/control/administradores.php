<?php
require '../../includes/app.php';
require '../../includes/data/usuarios.php';

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main  id="main" class="main admin main-admin menu-toggle">
    <h1>usuarios</h1>

    <div class="contenedor">
        <div class="barra-busqueda">
            <input type="text" id="busqueda" placeholder="Buscar usuario...">
            <button id="agregar">
                <img src="/src/img/icons/agregar.png" width="40" height="45" alt="Agregar usuario">
            </button>
        </div>
        <div class="tabla-container">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>pass</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($usuarios as $usuario) : ?>
    <tr>
        <td><?php echo $usuario['id']; ?></td>
        <td><?php echo $usuario['nombre']; ?></td>
        <td><?php echo $usuario['email']; ?></td>
        <td><?php echo $usuario['pass']; ?></td>
    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php incluirTemplate('footer'); ?>