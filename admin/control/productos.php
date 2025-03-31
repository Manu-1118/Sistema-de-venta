<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';

estaAutenticado(); //verificar que $_SESSION sea true
incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main">
    <h1>Productos</h1>
    <div class="contenedor-productos">
        <div class="barra-busqueda">
            <input type="text" id="busqueda" placeholder="Buscar producto...">
            <button id="agregarProducto" >
                <img src="/src/img/icons/agregar.png" width="40" height="45" alt="Agregar producto">
            </button>
        </div>
        
        <div class="tabla-container">
            <table class="tabla-productos">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Precio</th>
                        <th>Descripción</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto) : ?>
                        <tr>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td><?php echo $producto['id']; ?></td>
                            <td><?php echo $producto['precio']; ?></td>
                            <td><?php echo $producto['descripcion']; ?></td>
                            <td>
                                <img src="/src/img/categories/<?php echo $producto['imagen']; ?>" width="80" height="80" class="img-producto">
                            </td>
                            <td>
                                <a href="editar.php?id=<?php echo $producto['id']; ?>" class="editar-btn">✏️ Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php incluirTemplate('footer'); ?>
