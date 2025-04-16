<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';
estaAutenticado(); //verificar que $_SESSION sea true

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['cancelado'] == true) {

    if (isset($_SESSION['lista_productos'])) {
        $_SESSION['lista_productos'] = [];
    }
}

//Conectar la bd
$db = conectarDB();

//escribir el query
$query_mostrar = "SELECT c.id, c.fecha, c.total, p.empresa, p.nombres FROM Proveedor p JOIN Compra c on p.id = c.id_proveedor;";

//consultar la bd y obtener resultado
$resultado_mostrar = mysqli_query($db, $query_mostrar);

// debuguear(mysqli_fetch_assoc($resultado_mostrar));

$resultado_mensaje = $_GET['resultado'] ?? null;

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<!-- class="main admin menu-toggle" -->

<main id="main" class="main admin main-admin menu-toggle">

    <?php if (intval($resultado_mensaje) === 1): ?>
        <p class="alerta exito">La Compra se registró con exito</p>
    <?php endif;
    $_SESSION['lista_productos'] = []; ?>

    <div class="contenedor-productos">

        <div class="contenedor-herramientas">

            <div class="contenedor-busqueda">

                <form method="POST" class="formulario busqueda">
                    <label for="campo">Buscar</label>
                    <input type="text" name="campo" id="campo" placeholder="Compras...">
                </form>

            </div>

            <a href="compras_crear.php" class="btn-agregar boton-azul">
                <img src="/build/img/icons/agregar.png" alt="+" class="icono-principal">
                <span>Nuevo</span>
            </a>

        </div>

        <div class="tabla-containe">
            <table class="tabla-productos">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>N° factura</th>
                        <th>Fecha venta</th>
                        <th>Total</th>
                        <th>Empresa</th>
                        <th>Proveedor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    while ($compra = mysqli_fetch_assoc($resultado_mostrar)): ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $compra['id']; ?></td>
                            <td><?php echo $compra['fecha']; ?></td>
                            <td><?php echo $compra['total']; ?></td>
                            <td><?php echo $compra['empresa']; ?></td>
                            <td><?php echo $compra['nombres']; ?></td>
                            <td>
                                <a href="/admin/control/compras_detalles.php?id=<?php echo $compra['id']; ?>" class="boton-azul">Ver detalles</a>
                            </td>
                        </tr>
                    <?php $i++;
                    endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php incluirTemplate('footer'); ?>