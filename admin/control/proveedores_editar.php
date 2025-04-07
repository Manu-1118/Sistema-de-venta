<?php
require '../../includes/app.php';

estaAutenticado();
incluirTemplate('header');
incluirTemplate('slidebar');

$db = conectarDB();
$errores = [];

$id_proveedor = $_GET['id'] ?? null;

if (!$id_proveedor) {
    header('Location: proveedores.php');
    exit;
}

$query_proveedor = "SELECT * FROM proveedor WHERE id = $id_proveedor";
$resultado_proveedor = mysqli_query($db, $query_proveedor);
$proveedor = mysqli_fetch_assoc($resultado_proveedor);

if (!$proveedor) {
    header('Location: proveedores.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = mysqli_real_escape_string($db, $_POST['nombres']);
    $apellidos = mysqli_real_escape_string($db, $_POST['apellidos']);
    $empresa = mysqli_real_escape_string($db, $_POST['empresa']);
    $telefono = mysqli_real_escape_string($db, $_POST['telefono']);

    // Validaciones
    if (empty($nombres)) {
        $errores[] = "El nombre es obligatorio.";
    }

    if (empty($apellidos)) {
        $errores[] = "El apellido es obligatorio.";
    }

    if (empty($empresa)) {
        $errores[] = "La empresa es obligatoria.";
    }

    if (empty($errores)) {
        $query_actualizar = "UPDATE proveedor SET nombres = '$nombres', apellidos = '$apellidos', empresa = '$empresa', telefono = '$telefono' WHERE id = $id_proveedor";
        $resultado_actualizar = mysqli_query($db, $query_actualizar);

        if ($resultado_actualizar) {
            header('Location: proveedores.php');
            exit;
        } else {
            $errores[] = "Error al actualizar el proveedor.";
        }
    }
}
?>

<main id="main" class="main admin main-admin menu-toggle">
    <h1>Editar Proveedor</h1>
    <div class="contenedorForm">
        <div class="position-fixed">
            <?php foreach ($errores as $error) : ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endforeach; ?>

            <form method="POST">
                <div class="input-group">
                    <span class="input-group-text">Nombres: </span> 
                    <input type="text" name="nombres" class="form-control" value="<?php echo htmlspecialchars($proveedor['nombres']); ?>" required>
                </div>

                <div class="input-group">
                    <span class="input-group-text">Apellidos: </span>
                    <input type="text" name="apellidos" class="form-control" value="<?php echo htmlspecialchars($proveedor['apellidos']); ?>" required>
                </div>

                <div class="input-group">
                    <span class="input-group-text">Empresa: </span>
                    <input type="text" name="empresa" class="form-control" value="<?php echo htmlspecialchars($proveedor['empresa']); ?>" required>
                </div>

                <div class="input-group">
                    <span class="input-group-text">Teléfono: </span>
                    <input type="text" name="telefono" class="form-control" value="<?php echo htmlspecialchars($proveedor['telefono']); ?>">
                </div>
                
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <a class="btn btn-secondary" href="proveedores.php?">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php incluirTemplate('footer'); ?>