<?php
require '../../includes/app.php';
require '../../includes/data/proveedores.php';

estaAutenticado(); //verificar que $_SESSION sea true
incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main class="main" id="main" >
    <h1>Proveedores</h1>

    <div class="contenedor-proveedores">
        <div class="barra-busqueda">
            <input type="text" id="busqueda" placeholder="Buscar Proveedor...">
            <button id="agregarProveedor">
                <img src="/src/img/icons/agregar.png" width="40" height="45" alt="Agregar Proveedor">
            </button>
        </div>
        <div class="tabla-container">
            <table class="tabla-Proveedor">
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
                            <td><?php echo $proveedor['nombre']; ?></td>
                            <td><?php echo $proveedor['apellido']; ?></td>
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
