<?php
require 'includes/app.php';

$db = conectarDB(); // obtener la conexion de la bd

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
    $password = mysqli_real_escape_string($db, $_POST['txtPass']);

    if (!$email || !$password) {
        $errores[] = "El correo o la contraseña no es válida";
    }

    if (empty($errores)) {

        // consulta para verificar si el email existe
        $query = "SELECT * FROM usuarios WHERE email = '$email';";
        $resultado = mysqli_query($db, $query); // obtener resultado
        
        if ($resultado->num_rows) {
            
            $usuario = mysqli_fetch_assoc($resultado); // convertir la consulta
            // verificar si el pass escrito y la de la bd coinciden (autenticar)
            $auth = password_verify($password, $usuario['pass']);
            
            if ($auth) {

                // indicar que se abrio una sesion y se puede acceder a la variable $_SESSION
                session_start();

                // indicar quien inicio sesion
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['login'] = true; // indicar que la sesion esta abierta

                //redireccionar al panel ADMIN
                header('Location: /admin');
            } else {
                $errores[] = "La contraseña es incorrecta";
            } // Fin autentificacion

        } else {
            $errores[] = "El correo digitado no existe";
        } // Fin encontrar correo

    } // Fin Errores

} // Fin if POST

incluirTemplate('header', true);
?>
<main class="principal main-login fondo" id="main">
    <h1>Iniciar Sesión</h1>


    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?> <!-- Mostrar Errores -->

    <form method="POST" class="formulario login">
        <fieldset>
            <legend>Correo y Contraseña</legend>

            <label for="txtEmail">Correo</label>
            <input type="email" name="txtEmail" placeholder="ejemplo@ejemplo.com" id="txtEmail" value="<?php echo $email; ?>">

            <label for="txtPass">Contraseña</label>
            <input type="password" name="txtPass" placeholder="*******" id="txtPass">

        </fieldset>

        <input type="submit" value="Iniciar Sesión" class="alinear-derecha boton boton-azul">

    </form>
</main>

<?php
incluirTemplate('footer');
?>