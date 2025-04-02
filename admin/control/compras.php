<?php
require '../../includes/app.php';

$pagina_actual = basename($_SERVER['PHP_SELF']); // Obtiene el nombre del archivo actual
incluirTemplate('header');
incluirTemplate('slidebar');

?>

<main id="main" class="main">
    <h1>Compras</h1>

    <div class="contenedor">
        <div class="barra-busqueda">
            <input type="text" id="busqueda" placeholder="Buscar cliente...">
            <button id="agregar" onclick="window.location.href='compraForm.php';">
                <img src="/src/img/icons/agregar.png" width="40" height="45" alt="Agregar compra">
            </button>

        </div>
        <div class="tabla-container">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Proveedor</th>
                        <th>Cantidad de productos</th>
                        <th>Total de compra</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</main>

<?php incluirTemplate('footer'); ?>