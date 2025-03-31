<?php

require './includes/app.php';
incluirTemplate('header', true);

//Conectar la bd
$db = conectarDB();

//escribir el query
$query = "SELECT nombre, descripcion, precio_unitario FROM Producto limit 10;";

//consultar la bd y obtener resultado
$resultadoConsulta = mysqli_query($db, $query);

//debuguear(mysqli_fetch_assoc($resultadoConsulta));

?>

<section class="imagen-lista-compras">
    <img src="/build/img/banner-lista-compra.png" alt="Banner encabezado">
</section>

<main id="main" class="principal fondo">

    <div class="contenedor-busqueda">
        <form action="" method="POST" class="formulario busqueda">
            <label for="campo">Buscar producto</label>
            <input type="text" name="campo" id="campo" placeholder="Producto...">
        </form>
    </div>
    <div class="tabla-container">
        <table class="tabla-productos">
            <thead>
                <tr>
                    <!-- <th>Imagen</th> -->
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($producto = mysqli_fetch_assoc($resultadoConsulta)): ?>
                    <tr>
                        <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['descripcion']; ?></td>
                        <td><?php echo $producto['precio_unitario']; ?></td>
                        <td>
                            <a href="#" class="boton boton-azul">
                                <span>Añadir</span>
                                <!-- <img class="icono-principal-inverso" src="/build/img/icons/compra.png" alt="compra"> -->
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<section class="principal menu-secundario fondo">
    <h3>Productos Seleccionados</h3>
    <div class="tabla-container">
        <table class="tabla-productos">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="alinear-derecha">
        <a href="" class="boton-verde btn-generar-lista">
            <img src="/build/img/icons/pdf.png" alt="pdf">
            <span>Generar lista</span>
        </a>
    </div>

</section>

<?php
incluirTemplate('footer');
?>