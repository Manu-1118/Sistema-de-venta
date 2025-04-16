<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';
estaAutenticado(); //verificar que $_SESSION sea true

//Conectar la bd
$db = conectarDB();

//escribir el query
$query_mostrar = "SELECT * FROM Proveedor";

//consultar la bd y obtener resultado
$resultado_mostrar = mysqli_query($db, $query_mostrar);

// debuguear(mysqli_fetch_assoc($resultado_mostrar));

$resultado_mensaje = $_GET['resultado'] ?? null;

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main admin main-admin menu-toggle">

    <?php if (intval($resultado_mensaje) === 1): ?>
        <p class="alerta exito">El proveedor se agregó correctamente</p>
    <?php elseif (intval($resultado_mensaje) === 2): ?>
        <p class="alerta exito">El proveedor se modificó correctamente</p>
    <?php endif; ?>

    <div class="contenedor-productos">

        <div class="contenedor-herramientas">

            <div class="contenedor-busqueda">

                <form method="POST" class="formulario busqueda">
                    <label for="campo">Buscar</label>
                    <input type="text" name="campo" id="campo" placeholder="Proveedores...">
                </form>

            </div>

            <a href="proveedores_crear.php" class="btn-agregar boton-azul">
                <img src="/build/img/icons/agregar.png" alt="+" class="icono-principal">
                <span>Nuevo</span>
            </a>

        </div>

        <div class="tabla-containe">
            <table class="tabla-productos">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Empresa</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    while ($proveedor = mysqli_fetch_assoc($resultado_mostrar)): ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $proveedor['id']; ?></td>
                            <td><?php echo $proveedor['nombres']; ?></td>
                            <td><?php echo $proveedor['apellidos']; ?></td>
                            <td><?php echo $proveedor['empresa']; ?></td>
                            <td><?php echo $proveedor['telefono']; ?></td>
                            <td><a href="proveedores_editar.php?id=<?php echo $proveedor['id']; ?>" class="boton-azul">✏️</a></td>
                        </tr>
                    <?php $i++;
                    endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php incluirTemplate('footer'); ?>