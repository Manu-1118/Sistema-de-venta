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
$query_mostrar = "SELECT * FROM Consumido limit 10;";

//consultar la bd y obtener resultado
$resultado_mostrar = mysqli_query($db, $query_mostrar);
//debuguear(mysqli_fetch_assoc($resultado_mostrar));

$resultado_mensaje = $_GET['resultado'] ?? null;

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<!-- class="main admin menu-toggle" -->

<main id="main" class="main admin main-admin menu-toggle">

    <?php if (intval($resultado_mensaje) === 1): ?>
        <p class="alerta exito">Los productos consumidos se agendaron con exito</p>
    <?php endif;
    $_SESSION['lista_productos'] = []; ?>

    <div class="contenedor-productos">

        <div class="contenedor-herramientas">

            <div class="contenedor-busqueda">

                <form method="POST" class="formulario busqueda">
                    <label for="campo">Buscar</label>
                    <input type="text" name="campo" id="campo" placeholder="Productos consumidos...">
                </form>

            </div>

            <a href="consumidos_crear.php" class="btn-agregar boton-azul">
                <img src="/build/img/icons/agregar.png" alt="+" class="icono-principal">
                <span>Nuevo</span>
            </a>

        </div>

        <div class="tabla-containe">
            <table class="tabla-productos">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha registro</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    while ($consumido = mysqli_fetch_assoc($resultado_mostrar)): ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $consumido['fecha_registro']; ?></td>
                            <td><?php echo $consumido['total']; ?></td>
                            <td>
                                <a href="consumidos_detalles.php?id=<?php echo $consumido['id']; ?>" class="boton-azul">Ver detalles</a>
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