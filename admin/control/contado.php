<?php
require '../../includes/app.php';

// Incluir datos estáticos
require '../../includes/data/clientes.php';
require '../../includes/data/productos.php';

estaAutenticado(); //verificar que $_SESSION sea true
incluirTemplate('header');
incluirTemplate('slidebar');
?>

<main id="main" class="ventas-container main">
    <h2>Registrar Venta</h2>

    <div class="form-group">
        <label for="cliente">Cliente:</label>
        <select id="cliente" class="form-select">
            <option value="">Seleccione un cliente</option>
            <?php foreach ($clientes as $cliente) { ?>
                <option value="<?php echo $cliente['id']; ?>">
                    <?php echo $cliente['nombre'] . ' ' . $cliente['apellido']; ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group search-box">
        <label for="producto">Producto:</label>
        <input type="text" id="producto" class="form-control" placeholder="Buscar producto...">
        <!--<button class="search-btn">🔍</button>-->
    </div>

    <div class="form-group">
        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" class="form-control" min="1" value="1">
    </div>

    <div class="form-group">
        <label for="total">Total por producto:</label>
        <input type="text" id="total" class="form-control" readonly>
    </div>

    <button id="agregar" class="btn btn-primary">Agregar Producto</button>

    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Código</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="detalle-venta">
            <!-- Productos agregados dinámicamente -->
        </tbody>
    </table>

    <button id="generar" class="btn btn-success">Generar</button>
</main>

<?php incluirTemplate('footer'); ?>

<script>
    let productos = <?php echo json_encode($productos); ?>;

    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('producto').addEventListener('input', function () {
            let query = this.value.toLowerCase();
            let resultado = productos.find(p => p.nombre.toLowerCase().includes(query));

            if (resultado) {
                document.getElementById('cantidad').value = 1;
                document.getElementById('total').value = (resultado.precio * 1).toFixed(2);
            }
        });

        document.getElementById('cantidad').addEventListener('input', function () {
            let cantidad = parseInt(this.value) || 1;
            let producto = productos.find(p => p.nombre.toLowerCase() === document.getElementById('producto').value.toLowerCase());

            if (producto) {
                document.getElementById('total').value = (producto.precio * cantidad).toFixed(2);
            }
        });

        document.getElementById('agregar').addEventListener('click', function () {
            let producto = productos.find(p => p.nombre.toLowerCase() === document.getElementById('producto').value.toLowerCase());
            let cantidad = document.getElementById('cantidad').value;

            if (producto && cantidad > 0) {
                let tabla = document.getElementById('detalle-venta');
                let fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${producto.nombre}</td>
                    <td>${producto.categoria}</td>
                    <td>$${producto.precio.toFixed(2)}</td>
                    <td>${cantidad}</td>
                    <td><button class="btn btn-danger btn-sm eliminar">Eliminar</button></td>
                `;
                tabla.appendChild(fila);
            }
        });

        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('eliminar')) {
                event.target.closest('tr').remove();
            }
        });
    });
</script>