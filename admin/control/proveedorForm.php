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

    if (!$nombres || !$apellidos || !$empresa) {
        $errores[] = "Nombre, Apellido y Empresa son obligatorios.";
    }

    if (empty($errores)) {
        $query = "INSERT INTO proveedor (nombres, apellidos, empresa, telefono) 
                    VALUES ('$nombres', '$apellidos', '$empresa', '$telefono')";

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            echo "<script>
                    Swal.fire({
                        title: '¡Proveedor Registrado!',
                        text: 'El proveedor se ha registrado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'proveedores.php';
                    });
                  </script>";
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

            <form method="POST" onsubmit="return validarProveedor()">
                <div class="input-group">
                    <span class="input-group-text">Nombres: </span> 
                    <input type="text" name="nombres" id="nombres" class="form-control" placeholder="Nombres" required>
                </div>

                <div class="input-group">
                    <span class="input-group-text">Apellidos: </span> 
                    <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Apellidos" required>
                </div>

                <div class="input-group">
                    <label for="empresa" class="input-group-text">Empresa</label>
                    <input type="text" name="empresa" id="empresa" class="form-control" placeholder="Empresa" required>
                </div>

                <div class="input-group">
                    <label for="telefono" class="input-group-text">N° Telefónico</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono">
                </div>

                <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
        </div>
    </div>
</main>

<script>
function validarProveedor() {
    const nombres = document.getElementById("nombres").value;
    const apellidos = document.getElementById("apellidos").value;
    const empresa = document.getElementById("empresa").value;

    if (nombres === "" || apellidos === "" || empresa === "") {
        alert("Por favor, complete los campos Nombre, Apellido y Empresa.");
        return false; // Evita que el formulario se envíe
    }

    return true; // Permite que el formulario se envíe
}
</script>

<?php incluirTemplate('footer'); ?>