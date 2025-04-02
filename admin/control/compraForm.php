<?php
require '../../includes/app.php';
require '../../includes/data/proveedores.php'; // Obtener proveedores
require '../../includes/data/productos.php'; // Obtener productos

$pagina_actual = basename($_SERVER['PHP_SELF']);
incluirTemplate('header');
incluirTemplate('slidebar'); // 🔹 Agregado correctamente
?>

<main id="main" class="compras-container">
    <h2>Registrar Compra</h2>

    <!-- Contenedor de fecha y proveedor -->
    <div class="top-bar">
        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="text" id="fecha" class="form-control" value="<?php echo date('d/m/Y'); ?>" readonly>
        </div>

        <div class="form-group">
            <label for="proveedor">Proveedor:</label>
            <select id="proveedor" class="form-select">
                <option value="">Seleccione un proveedor</option>
                <?php foreach ($proveedores as $proveedor) { ?>
                    <option value="<?php echo $proveedor['id']; ?>">
                        <?php echo $proveedor['nombre']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- Botón Agregar Producto alineado a la derecha -->
        <button id="agregarProducto" class="btn btn-primary">Agregar Producto +</button>
    </div>

    <!-- Buscador de producto -->
    <div class="s-container">
    <label for="producto"  margin-righ= 10px>Producto: </label>
    <input type="text" id="producto" class="form-control" placeholder="Buscar producto...">
    <button id="buscarProducto" class="btn btn-secondary">Buscar</button>
    </div>

    <!-- Cantidad y botón para agregar -->
    <div class="s-container">
        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" class="form-control" min="1" value="1">
        <button id="agregar" class="btn btn-success">Agregar</button>
    </div>

    <!-- Tabla de productos agregados -->
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Proveedor</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody id="lista-compras">
            <!-- Productos agregados dinámicamente -->
        </tbody>
    </table>

    <!-- Total de la compra -->
    <h3 class="total-compra">Total de la compra: <span id="totalCompra">$0.00</span></h3>

    <!-- Botón para registrar la compra -->
    <button id="registrarCompra" class="btn btn-primary">Registrar Compra</button>
</main>

<?php incluirTemplate('footer'); ?>
