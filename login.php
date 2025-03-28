<?php
require 'includes/app.php';

$db = conectarDB(); // obtener la conexion de la bd

$errores = []; // arreglo para mostrar los errores


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // debuguear($_POST);

    $email = mysqli_real_escape_string($db, filter_var($_POST['txtEmail'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['txtPassword']);

    if (!$email) {
        $errores[] = "El correo es obligatorio o no es válido";
    }

    if (!$password) {
        $errores[] = "La contraseña es obligatoria";
    }

    if (empty($errores)) {

        $query = "SELECT * FROM usuarios WHERE email = '${email}';";
        $resultado = mysqli_query($db, $query);

        if ($resultado->num_rows) {
            $usuario = mysqli_fetch_assoc($resultado);

            $auth = password_verify($password, $usuario['password']);

            // if($auth) {
            //     //El usuario esta autenticado
            //     session_start();

            //     //LLenar el arreglo de la sesion
            //     $_SESSION['usuario'] = $usuario['email'];
            //     $_SESSION['login'] = true;

            //     //redireccionar una vez haya iniciado sesion
            //     header('Location: /admin');

            // } else {
            //     $errores[] = "La contraseña es incorrecta";
            // }

        } else {
            $errores[] = "El usuario no existe";
        }
    } // Fin if Errores

} // Fin if POST

incluirTemplate('header', true);
?>
<main class="contenedor principal main-login main" id="main">
    <h1>Iniciar Sesión</h1>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    
    <form method="POST" class="formulario login">
        <fieldset>
            <legend>Correo y Contraseña</legend>

            <label for="txtEmail">Correo</label>
            <input type="email" name="txtEmail" placeholder="ejemplo@ejemplo.com" id="txtEmail">

            <label for="txtPass">Contraseña</label>
            <input type="password" name="txtPassword" placeholder="*******" id="txtPass">

        </fieldset>

        <input type="submit" value="Iniciar Sesión" class="alinear-derecha boton boton-azul">

    </form>
</main>

<?php
incluirTemplate('footer');
?>