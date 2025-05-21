<?php
require '../../../includes/app.php';
estaAutenticado(); //verificar que $_SESSION sea true
$db = conectarDB();
require '../../../data/credito/insertar.php';

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


    <form method="POST" class="formulario">
        <fieldset>
            <legend>Datos del Credito</legend>

            <label for="txtProductos">Productos</label>
            <input disabled type="text" name="txtId" id="txtProductos">

            <label for="txtCantidadPr">Cantidad</label>
            <input disabled type="number" name="txtCantidadPr" id="txtCantidadPr">
            <button name="lista" value="true" type="submit" class="boton-azul">Agregar</button>
        </fieldset>

    </form>

    <form method="POST" class="formulario">
        <fieldset>
            <legend>Detalles Credito</legend>

            <label for="txtCliente">Cliente:</label>
            <input type="text" name="txtCliente" placeholder="Nombre del cliente" id="txtCliente" value="<?php echo $cliente; ?>">

            <div id="fecha-container">
            <label for="fecha-actual">Fecha:</label>
            <input type="text" id="fecha-actual" readonly>
            </div>

        </fieldset>
        <div class="alinear-derecha separar-margin">

<a class="boton-rojo" href="creditos.php">
    <span>Cancelar</span>
</a>

<input type="submit" value="Agregar" class="boton-azul">

</div>
    </form>

</main>

//fecha no modificable 
<script>
    function mostrarFechaActual() {
    const fechaInput = document.getElementById('fecha-actual');
    const fecha = new Date();
    const opciones = { year: 'numeric', month: 'long', day: 'numeric' };
    fechaInput.value = fecha.toLocaleDateString(undefined, opciones);
    }

    mostrarFechaActual();

</script>

<?php incluirTemplate('footer'); ?>