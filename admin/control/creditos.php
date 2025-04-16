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
$query_mostrar = "SELECT cd.id, CONCAT(c.nombres, c.apellidos) AS 'cliente', cd.fecha_credito, cd.fecha_cancelacion, cd.total, cd.monto_pendiente, cd.monto_pagado FROM Cliente c JOIN Credito cd on c.id = cd.id_cliente;";

//consultar la bd y obtener resultado
$resultado_mostrar = mysqli_query($db, $query_mostrar);

$resultado_mensaje = $_GET['resultado'] ?? null;

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<!-- class="main admin menu-toggle" -->

<main id="main" class="main admin main-admin menu-toggle">

    <?php if (intval($resultado_mensaje) === 1): ?>
        <p class="alerta exito">El Crédito se registró con éxito</p>
    <?php endif;
    $_SESSION['lista_productos'] = []; ?>

    <div class="contenedor-productos">

        <div class="contenedor-herramientas">

            <div class="contenedor-busqueda">

                <form method="POST" class="formulario busqueda">
                    <label for="campo">Buscar</label>
                    <input type="text" name="campo" id="campo" placeholder="Créditos...">
                </form>

            </div>

            <a href="creditos_crear.php" class="btn-agregar boton-azul">
                <img src="/build/img/icons/agregar.png" alt="+" class="icono-principal">
                <span>Nuevo</span>
            </a>

        </div>

        <div class="tabla-containe">
            <table class="tabla-productos">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Fecha Crédito</th>
                        <th>Fecha Cancelación</th>
                        <th>Total</th>
                        <th>Monto Pagado</th>
                        <th>Monto Pendiente</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    while ($credito = mysqli_fetch_assoc($resultado_mostrar)): ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $credito['cliente']; ?></td>
                            <td><?php echo $credito['fecha_credito']; ?></td>
                            <td><?php echo $credito['fecha_cancelacion']; ?></td>
                            <td><?php echo $credito['total']; ?></td>
                            <td><?php echo $credito['monto_pagado']; ?></td>
                            <td><?php echo $credito['monto_pendiente']; ?></td>
                            <td>
                                <a href="/admin/control/creditos_detalles.php?id=<?php echo $credito['id']; ?>" class="boton-azul">Ver detalles</a>
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