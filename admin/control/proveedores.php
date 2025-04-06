<?php
require '../../includes/app.php';
require '../../includes/data/proveedores.php';

estaAutenticado();
incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main admin main-admin menu-toggle"  >
    <h1>Proveedores</h1>

    <div class="contenedor">
        <div class="barra-busqueda">
            <input type="text" id="busqueda" placeholder="Buscar Proveedor...">
            <button id="agregar" onclick=" window.location.href='proveedorForm.php';">
                <img src="/src/img/icons/agregar.png" width="40" height="45" alt="Agregar Proveedor">
            </button>
        </div>
        <div class="tabla-container">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Empresa</th>
                        <th>Telefono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proveedores as $proveedor) : ?>
                        <tr>
                            <td><?php echo $proveedor['id']; ?></td>
                            <td><?php echo $proveedor['nombres']; ?></td>
                            <td><?php echo $proveedor['apellidos']; ?></td>
                            <td><?php echo $proveedor['empresa']; ?></td>
                            <td><?php echo $proveedor['telefono']; ?></td>
                            <td>
                                <a href="editar.php?id=<?php echo $proveedor['id']; ?>" class="editar-btn">✏️ Editar</a>
                                <a href="compras.php?id=<?php echo $proveedor['id']; ?>" class="compras-btn">💲 Compras</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php incluirTemplate('footer'); ?>