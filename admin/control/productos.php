<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main">
    <h1>Productos</h1>
    <div class="contenedor">
        <div class="barra-busqueda">
            <input type="text" id="busqueda" placeholder="Buscar producto...">
            <button id="agregar" >
                 <img src="/src/img/icons/agregar.png" width="40" height="45" alt="Agregar producto">
            </button>
        </div>
        
        <div class="tabla-container">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Cod</th>
                        <th>Nombre</th>
                        <th>Precio U.</th>
                        <th>Categoria</th>
                        <th>Descripcion</th>
                        <!-- <th>Imagen</th> -->
                        <th>stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto) : ?>
                        <tr>
                            <td><?php echo $producto['codigo']; ?></td>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td><?php echo $producto['precio_unitario']; ?></td>
                            <td><?php echo $producto['categoria']; ?></td>
                            <td><?php echo $producto['descripcion']; ?></td>
                            <td><?php echo $producto['cantidad']; ?></td>

                            <!-- <td>
                                <img src="/src/img/categories/<?php echo $producto['imagen']; ?>" width="80" height="80" class="img-producto">
                            </td> -->
                            <!-- <td>
                                AQUI VA UNA IMAGEN
                            </td> -->
                            <td>
                                <a href="editar.php?id=<?php echo $producto['codigo']; ?>" class="editar-btn">✏️ Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php incluirTemplate('footer'); ?>
