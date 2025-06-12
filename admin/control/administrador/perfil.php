<?php
require '../../../includes/app.php';
$db = conectarDB();
require '../../../data/administrador/editar.php';
estaAutenticado(); //verificar que $_SESSION sea true

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
            <legend>Perfil de Administrador</legend>

            <img src="/img/administradores/<?php echo $imagen_admin; ?>" alt="imagen administrador" class="img-admin-perfil">
            <label for="imagen">Cambiar foto de perfil</label>
            <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png">

            <label for="txtCorreo">Correo</label>
            <input disabled type="mail" name="txtCorreo" id="txtCorreo" value="<?php echo $correo; ?>">

            <label for="txtNombre">Nombre</label>
            <input type="text" name="txtNombre" id="txtNombre" value="<?php echo $nombre; ?>">

            <label for="txtApellido">Apellido</label>
            <input type="text" name="txtApellido" id="txtApellido" value="<?php echo $apellido; ?>">



        </fieldset>

        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="administradores.php">
                <span>Cancelar</span>
            </a>

            <input type="submit" value="Editar" class="boton-azul">

        </div>

    </form>
</main>

<?php incluirTemplate('footer', true); ?>