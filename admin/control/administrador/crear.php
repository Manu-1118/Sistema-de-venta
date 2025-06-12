<?php
require '../../../includes/app.php';
$db = conectarDB(); // Conectar la bd
require '../../../data/administrador/insertar.php';
estaAutenticado(); //verificar que $_SESSION sea true

$resultado_mensaje = $_GET['resultado'];

incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="main admin main-admin menu-toggle">
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario" enctype="multipart/form-data">
        <fieldset>
            <legend>Agregar Administrador</legend>

            <label for="txtNombre">Nombre</label>
            <input type="text" name="txtNombre" autocomplete="off" placeholder="Nombre de usuario" id="txtNombre" value="<?php echo $nombre; ?>">

            <label for="txtApellido">Apellido</label>
            <input type="text" name="txtApellido" autocomplete="off" placeholder="Nombre de usuario" id="txtApellido" value="<?php echo $apellido; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" autocomplete="off" name="imagen" id="imagen" accept="image/jpeg, image/png">

            <label for="txtCorreo">Correo</label>
            <input type="email" name="txtCorreo" placeholder="correo@correo.com" autocomplete="off" id="txtCorreo" value="<?php echo $correo; ?>">

            <label for="txtClave">Contraseña</label>
            <input type="password" name="txtClave" placeholder="Contraseña" id="txtClave">

            <label for="txtClaveConfirmar">Confirmar Contraseña</label>
            <input type="password" name="txtClaveConfirmar" placeholder="Contraseña" id="txtClaveConfirmar">

        </fieldset>

        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="administradores.php">
                <span>Cancelar</span>
            </a>

            <input type="submit" value="Agregar" class="boton-azul">

        </div>

    </form>
</main>

<?php incluirTemplate('footer', true); ?>