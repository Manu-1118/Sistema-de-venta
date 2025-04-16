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
$query_mostrar = "SELECT * FROM Contado limit 5;";

//consultar la bd y obtener resultado
$resultado_mostrar = mysqli_query($db, $query_mostrar);

$resultado_mensaje = $_GET['resultado'] ?? null;

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<!-- class="main admin menu-toggle" -->

<main id="main" class="main admin main-admin menu-toggle">

    <?php if (intval($resultado_mensaje) === 1): ?>
        <p class="alerta exito">La venta al contado se realizó con exito</p>
    <?php endif;
    $_SESSION['lista_productos'] = []; ?>

    <div class="contenedor-productos">

        <div class="contenedor-herramientas">

            <div class="contenedor-busqueda">

                <form method="POST" class="formulario busqueda">
                    <label for="campo">Buscar</label>
                    <input type="text" name="campo" id="campo" placeholder="Venta al contado...">
                </form>

            </div>

            <a href="contado_crear.php" class="btn-agregar boton-azul">
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
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    while ($contado = mysqli_fetch_assoc($resultado_mostrar)): ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $contado['id']; ?></td>
                            <td><?php echo $contado['fecha_registro']; ?></td>
                            <td><?php echo $contado['total']; ?></td>
                            <td>
                                <a href="/admin/control/contado_detalle.php?id=<?php echo $contado['id']; ?>" class="boton-azul">Ver detalles</a>
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