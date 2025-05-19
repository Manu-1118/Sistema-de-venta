<!-- Tabla que contiene los datos extraidos de la bd segun el apartado establecido -->

<div class="CA2">
    <label for="campo-buscar">Buscar: </label>
    <input type="text" name="campo-buscar" id="campo-buscar">
</div>

<div class="CA3 contenedor-tabla-datos">
    <table class="tabla-plantilla">
        <thead>
            <?php foreach ($_SESSION['encabezados'] as $encabezado): ?>
                <th><?php echo $encabezado ?></th>
            <?php endforeach; ?>
            <th>Opciones</th>
        </thead>

        <tbody id="cuerpo-tabla" class="cuerpo-tabla">

        </tbody>
    </table>
</div>