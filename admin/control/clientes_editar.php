<?php
require '../../includes/app.php';

estaAutenticado();
incluirTemplate('header');
incluirTemplate('slidebar');

$db = conectarDB();
$errores = [];

$id_cliente = $_GET['id'] ?? null;

if (!$id_cliente) {
    header('Location: clientes.php');
    exit;
}

$query_cliente = "SELECT * FROM cliente WHERE id = $id_cliente";
$resultado_cliente = mysqli_query($db, $query_cliente);
$cliente = mysqli_fetch_assoc($resultado_cliente);

if (!$cliente) {
    header('Location: clientes.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $primer_nombre = mysqli_real_escape_string($db, $_POST['primer_nombre']);
    $segundo_nombre = mysqli_real_escape_string($db, $_POST['segundo_nombre']);
    $primer_apellido = mysqli_real_escape_string($db, $_POST['primer_apellido']);
    $segundo_apellido = mysqli_real_escape_string($db, $_POST['segundo_apellido']);

    if (!$primer_nombre || !$primer_apellido) {
        $errores[] = "El primer nombre y el primer apellido son obligatorios.";
    }

    if (empty($errores)) {
        $query_actualizar = "UPDATE cliente SET nombres = '$primer_nombre $segundo_nombre', apellidos = '$primer_apellido $segundo_apellido' WHERE id = $id_cliente";
        $resultado_actualizar = mysqli_query($db, $query_actualizar);

        if ($resultado_actualizar) {
            header('Location: clientes.php');
            exit;
        } else {
            $errores[] = "Error al actualizar el cliente.";
        }
    }
}
?>
<main id="main" class="main admin main-admin menu-toggle">
    <h1>Editar Cliente</h1>
    <div class="contenedorForm">
        <div class="position-fixed">
            <?php foreach ($errores as $error) : ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endforeach; ?>

            <form method="POST">
                <div class="input-group">
                    <span class="input-group-text">Nombres: </span>
                    <input type="text" name="primer_nombre" class="form-control" placeholder="Primer nombre" value="<?php echo htmlspecialchars(explode(' ', $cliente['nombres'])[0]); ?>" required>
                    <input type="text" name="segundo_nombre" class="form-control" placeholder="Segundo nombre" value="<?php echo htmlspecialchars(explode(' ', $cliente['nombres'])[1] ?? ''); ?>">
                </div>

                <div class="input-group">
                    <span class="input-group-text">Apellidos: </span>
                    <input type="text" name="primer_apellido" class="form-control" placeholder="Primer apellido" value="<?php echo htmlspecialchars(explode(' ', $cliente['apellidos'])[0]); ?>" required>
                    <input type="text" name="segundo_apellido" class="form-control" placeholder="Segundo apellido" value="<?php echo htmlspecialchars(explode(' ', $cliente['apellidos'])[1] ?? ''); ?>">
                </div>

                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        </div>
    </div>
</main>

<?php incluirTemplate('footer'); ?>