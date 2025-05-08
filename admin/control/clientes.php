<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';
estaAutenticado(); //verificar que $_SESSION sea true

// Conectar la bd
$db = conectarDB();

// Escribir el query
$query_mostrar = "SELECT * FROM Cliente";

// Consultar la bd y obtener resultado
$resultado_mostrar = mysqli_query($db, $query_mostrar);

// Ver si se pasó un mensaje de resultado
$resultado_mensaje = $_GET['resultado'] ?? null;

incluirTemplate('header');
incluirTemplate('slidebar');

// Verificar si hay una eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id'] ?? null;

    if ($id_cliente) {
        // Realizar la eliminación
        $query_eliminar = "DELETE FROM Cliente WHERE id = $id_cliente";
        $resultado_eliminar = mysqli_query($db, $query_eliminar);

        if ($resultado_eliminar) {
            header('Location: clientes.php?resultado=3');
            exit;
        }
    }
}

?>

<main id="main" class="main admin main-admin menu-toggle">

    <?php if (intval($resultado_mensaje) === 1): ?>
        <p class="alerta exito">El Cliente se agregó correctamente</p>
    <?php elseif (intval($resultado_mensaje) === 2): ?>
        <p class="alerta exito">El producto se modificó correctamente</p>
    <?php elseif (intval($resultado_mensaje) === 3): ?>
        <p class="alerta exito">El Cliente se eliminó correctamente</p>
    <?php endif; ?>

    <div class="contenedor-productos">

        <div class="contenedor-herramientas">

            <div class="contenedor-busqueda">

                <form method="POST" class="formulario busqueda">
                    <label for="campo">Buscar</label>
                    <input type="text" name="campo" id="campo" placeholder="Cliente...">
                </form>

            </div>

            <a href="clientes_crear.php" class="btn-agregar boton-azul">
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
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    while ($cliente = mysqli_fetch_assoc($resultado_mostrar)): ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $cliente['id']; ?></td>
                            <td><?php echo $cliente['nombres']; ?></td>
                            <td><?php echo $cliente['apellidos']; ?></td>
                            <td>
                                <a href="clientes_editar.php?id=<?php echo $cliente['id']; ?>" class="boton-azul">✏️</a>
                                <form method="POST" style="display:inline;" onsubmit="return confirmarEliminacion();">
                                    <input type="hidden" name="id" value="<?php echo $cliente['id']; ?>">
                                    <button type="submit" class="boton-rojo">🗑️</button>
                                </form>
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

<script>
function confirmarEliminacion() {
    return confirm("¿Estás segura de que deseas eliminar este cliente?");
}
</script>
