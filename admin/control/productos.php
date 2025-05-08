<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';
estaAutenticado();

// Conectar a la BD
$db = conectarDB();

// Variables para búsqueda y paginación
$campo = $_GET['campo'] ?? '';
$pagina_actual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$limite = 10;
$offset = ($pagina_actual - 1) * $limite;

// Preparar cláusula WHERE si hay búsqueda
$where = '';
if (!empty($campo)) {
    $campo_escapado = mysqli_real_escape_string($db, $campo);
    $where = "WHERE nombre LIKE '%$campo_escapado%' OR categoria LIKE '%$campo_escapado%'";
}

// Obtener total de productos para paginación
$query_total = "SELECT COUNT(*) as total FROM Producto $where";
$resultado_total = mysqli_query($db, $query_total);
$total_productos = mysqli_fetch_assoc($resultado_total)['total'];
$total_paginas = ceil($total_productos / $limite);

// Obtener productos según búsqueda y paginación
$query_mostrar = "SELECT * FROM Producto $where LIMIT $limite OFFSET $offset";
$resultado_mostrar = mysqli_query($db, $query_mostrar);

// Eliminar producto si se envía POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    if ($id) {
        $query_eliminar = "DELETE FROM Producto WHERE codigo = $id;";
        $resultado_eliminar = mysqli_query($db, $query_eliminar);
        if ($resultado_eliminar) {
            header('Location: /admin/control/productos.php');
            exit;
        }
    }
}

$resultado_mensaje = $_GET['resultado'] ?? null;

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main admin main-admin menu-toggle">
    <?php if (intval($resultado_mensaje) === 1): ?>
        <p class="alerta exito">El producto se agregó correctamente</p>
    <?php elseif (intval($resultado_mensaje) === 2): ?>
        <p class="alerta exito">El producto se modificó correctamente</p>
    <?php endif; ?>

    <div class="contenedor-productos">

        <div class="contenedor-herramientas">
            <div class="contenedor-busqueda">
                <form method="GET" class="formulario busqueda">
                    <label for="campo">Buscar</label>
                    <input type="text" name="campo" id="campo" placeholder="Producto..." value="<?php echo htmlspecialchars($campo); ?>">
                </form>
            </div>

            <a href="productos_crear.php" class="btn-agregar boton-azul">
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
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + $offset; while ($producto = mysqli_fetch_assoc($resultado_mostrar)): ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $producto['codigo']; ?></td>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td><?php echo $producto['descripcion']; ?></td>
                            <td><?php echo $producto['cantidad']; ?></td>
                            <td><?php echo $producto['categoria']; ?></td>
                            <td><?php echo $producto['precio_unitario']; ?></td>
                            <td class="acciones-tabla">
                                <a href="productos_editar.php?id=<?php echo $producto['codigo']; ?>" class="boton-azul">✏️</a>
                                <form method="POST" style="display:inline;" onsubmit="return confirmarEliminacion();">
                                    <input type="hidden" name="id" value="<?php echo $producto['codigo']; ?>">
                                    <button type="submit" class="boton-rojo">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    <?php $i++; endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <?php if ($total_paginas > 1): ?>
            <div class="paginacion">
                <?php for ($p = 1; $p <= $total_paginas; $p++): ?>
                    <a class="paginacion-link <?php if ($p == $pagina_actual) echo 'activo'; ?>" 
                       href="?campo=<?php echo urlencode($campo); ?>&pagina=<?php echo $p; ?>">
                        <?php echo $p; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php incluirTemplate('footer'); ?>

<script>
function confirmarEliminacion() {
    return confirm("¿Estás segura de que deseas eliminar este producto?");
}
</script>
