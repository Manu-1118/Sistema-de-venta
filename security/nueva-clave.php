<?php
require '../includes/app.php';
$db = conectarDB(); // Conectar la bd
estaAutenticado(true); //verificar que $_SESSION sea true
// session_start();
if (!isset($_SESSION['acceso_recuperacion']) && $_SESSION['acceso_recuperacion'] != true) {
    header('Location: http://localhost:3000/');
} else {

    $errores = [];  // Arreglo para validacion
    $clave = '';
    $clave_confirmar = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $clave = mysqli_real_escape_string($db, $_POST['txtClave']);
        $clave_confirmar = mysqli_real_escape_string($db, $_POST['txtClaveConfirmar']);

        // si un campo esta vacio, mandar error
        if (!$clave || !$clave_confirmar) {
            $errores[] = "Todos los campos son obligatorios";
        }

        if (strlen($clave) < 6) {
            $errores[] = "La contraseña tiene que ser mayor de 6 caracteres";
        }

        // confirmar que las contraseñas digitadas sean las mismas
        if ($clave !== $clave_confirmar) {
            $errores[] = "Las contraseñas no son iguales";
        }


        // // si el arreglo de errores esta vacio, crear el admin
        if (empty($errores)) {

            // hashear la contraseña
            $claveHash = password_hash($clave, PASSWORD_DEFAULT);
            // actualizar contraseña
            $consulta = "UPDATE Administrador SET clave = '$claveHash' WHERE id_administrador = {$_SESSION['datos_admin']['id_administrador']};";
            // debuguear($consulta);
            $resultado = mysqli_query($db, $consulta);
            if ($consulta) {

                session_unset(); // limpiar la variable antes de usarla
                header('Location: /login.php?resultado=2');
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/build/css/app.css">
    <title>Recuperación</title>
    <link rel="icon" href="/build/img/i1.ico" type="image/x-icon">
</head>

<body>
    <main class="principal main-login fondo" id="main">
        <h1>Restablecer Contraseña</h1>


        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?> <!-- Mostrar Errores -->

        <form method="POST" class="formulario login">
            <fieldset>
                <legend>Nueva Contraseña</legend>

                <label for="txtClave">Nueva Contraseña</label>
                <input type="password" autocomplete="off" name="txtClave" placeholder="nueva contraseña" id="txtClave">

                <label for="txtClaveConfirmar">Confirmación de Contraseña</label>
                <input type="password" autocomplete="off" name="txtClaveConfirmar" placeholder="confirmar contraseña" id="txtClaveConfirmar">

            </fieldset>

            <div class="alinear-derecha">
                <input type="submit" value="Restablecer" class="boton boton-azul">
            </div>
        </form>
    </main>
</body>

</html>