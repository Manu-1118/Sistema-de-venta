<?php
require '../../includes/app.php';

estaAutenticado(); // Verificar que $_SESSION sea true
incluirTemplate('header');
incluirTemplate('slidebar');

//conexion a la base de datos
$db = conectarDB();
$errores = [];

//toma los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $primer_nombre = mysqli_real_escape_string($db, $_POST['primer_nombre']);
    $segundo_nombre = mysqli_real_escape_string($db, $_POST['segundo_nombre']);
    $primer_apellido = mysqli_real_escape_string($db, $_POST['primer_apellido']);
    $segundo_apellido = mysqli_real_escape_string($db, $_POST['segundo_apellido']);

    // Concatenar nombres y apellidos
    $nombre_completo = trim("$primer_nombre $segundo_nombre");
    $apellido_completo = trim("$primer_apellido $segundo_apellido");

    //valida que tenga al menos un nombre y un apellido
    if (!$primer_nombre || !$primer_apellido) {
        $errores[] = "El primer nombre y el primer apellido son obligatorios.";
    }

    if (empty($errores)) {
        $query = "INSERT INTO cliente (nombres, apellidos) 
                  VALUES ('$nombre_completo', '$apellido_completo')";

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            // Redirige a la lista de clientes
            header("Location: clientes.php"); 
            exit;
        } else {
            $errores[] = "Error al registrar el cliente.";
        }
    }
}
?>

<main id="main" class="main">
    <h1>Registrar Proveedor</h1>
    <div class="contenedorForm">
        <div class="position-fixed">
            <?php foreach ($errores as $error) : ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endforeach; ?>

            <form method="POST">
                <div class="input-group">
                    <span class="input-group-text">Nombres: </span>
                    <input type="text" name="primer_nombre" class="form-control" placeholder="Primer nombre" required>
                    <input type="text" name="segundo_nombre" class="form-control" placeholder="Segundo nombre">
                </div>

                <div class="input-group">
                    <span class="input-group-text">Apellidos: </span>
                    <input type="text" name="primer_apellido" class="form-control" placeholder="Primer apellido" required>
                    <input type="text" name="segundo_apellido" class="form-control" placeholder="Segundo apellido">
                </div>

                <div>
                    <div class="mb-3">
                        <label for="EmpresaEmpleado" class="form-label">Empresa</label>
                        <input type="text" class="form-control" id="EmpresaEmpleado" placeholder="Empresa">
                    </div>
                </div>

                <div>
                    <div class="mb-3">
                        <label for="TelfEmpleado" class="form-label">N° Telefónico</label>
                        <input type="text" class="form-control" id="TelfEmpleado" placeholder="Telefono">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
        </div>
    </div>
</main>

<?php incluirTemplate('footer'); ?>
