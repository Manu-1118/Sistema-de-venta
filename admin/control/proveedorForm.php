<?php
require '../../includes/app.php';

estaAutenticado();
incluirTemplate('header');
incluirTemplate('slidebar');

$db = conectarDB();
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = mysqli_real_escape_string($db, $_POST['nombres']);
    $apellidos = mysqli_real_escape_string($db, $_POST['apellidos']);
    $empresa = mysqli_real_escape_string($db, $_POST['empresa']);
    $telefono = mysqli_real_escape_string($db, $_POST['telefono']);

    if (!$nombres || !$apellidos || !$empresa || !$telefono) {
        $errores[] = "Todos los campos son obligatorios.";
    }

    if (empty($errores)) {
        $query = "INSERT INTO proveedor (nombres, apellidos, empresa, telefono) 
                  VALUES ('$nombres', '$apellidos', '$empresa', '$telefono')";

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            echo "<script>alert('Proveedor registrado correctamente.'); window.location.href = 'proveedores.php';</script>";
            exit;
        } else {
            $errores[] = "Error al registrar el proveedor: " . mysqli_error($db);
        }
    }
}
?>

<main id="main" class="main admin main-admin menu-toggle">
    <h1>Registrar Proveedor</h1>
    <div class="contenedorForm">
        <div class="position-fixed">
            <?php foreach ($errores as $error) : ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endforeach; ?>

            <form method="POST">
                <div class="input-group">
                    <span class="input-group-text">Nombres: </span>
                    <input type="text" name="nombres" class="form-control" placeholder="Nombres" required>
                </div>

                <div class="input-group">
                    <span class="input-group-text">Apellidos: </span>
                    <input type="text" name="apellidos" class="form-control" placeholder="Apellidos" required>
                </div>

                <div class="mb-3">
                    <label for="empresa" class="form-label">Empresa</label>
                    <input type="text" name="empresa" class="form-control" id="empresa" placeholder="Empresa" required>
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">N° Telefónico</label>
                    <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Teléfono" required>
                </div>

                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
        </div>
    </div>
</main>

<?php incluirTemplate('footer'); ?>