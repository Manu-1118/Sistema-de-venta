<?php
require '../includes/app.php';
$db = conectarDB();

$errores = []; // arreglo para mostrar los errores
$email = "";

// recibir los datos de los campos del login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /** 
     * SEGURIDAD:
     * Se aplica mysqli_real_escape_string para evitar inyecciones SQL.
     * filter_var para validar el tipo de dato que se esta digitando y no cree conflicto para insertar los datos.
     **/
    $email = mysqli_real_escape_string($db, filter_var($_POST['txtEmail'], FILTER_VALIDATE_EMAIL));

    if (!$email) {

        $errores[] = "El correo es obligarotio";
    }

    if (empty($errores)) {

        // consulta para verificar si el email existe
        $query = "SELECT * FROM Administrador WHERE correo = '$email';";
        $resultado = mysqli_query($db, $query); // obtener resultado

        if ($resultado->num_rows > 0) {

            session_start(); // obtener acceso a la variable $_sesion
            session_unset(); // limpiar la variable antes de usarla

            $admin = mysqli_fetch_assoc($resultado);
            $_SESSION['datos_admin'] = $admin; // guardar datos del admin
            header('Location: /security/enviar.php'); // mandar el mail

        } else {

            $errores[] = "El correo digitado no existe";
        } // Fin encontrar correo

    } // Fin if POST
}

incluirTemplate('header', true);
?>
<main class="principal main-login fondo" id="main">
    <h1>Recuperación de Contraseña</h1>


    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?> <!-- Mostrar Errores -->

    <form method="POST" class="formulario login">
        <fieldset>
            <legend></legend>

            <label for="txtEmail">Correo</label>
            <input type="email" autocomplete="off" name="txtEmail" placeholder="ejemplo@ejemplo.com" id="txtEmail">

        </fieldset>

        <div class="inferior-login">
            <a href="/login.php">Volver al inicio de sesión</a>
            <input type="submit" value="Recuperar" class="alinear-derecha boton boton-azul">
        </div>
    </form>
</main>

<?php
incluirTemplate('footer', true);
?>