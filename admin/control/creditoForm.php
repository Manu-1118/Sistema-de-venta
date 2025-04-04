<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';
require '../../includes/data/clientes.php';
$db = conectarDB(); // Conexión a la base de datos

incluirTemplate('header');
incluirTemplate('slidebar');

$errores = [];

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Aquí iría la lógica para procesar el formulario
}

echo '<script>console.table(' . json_encode($productos) . ');</script>';
echo '<script>console.table(' . json_encode($clientes) . ');</script>';
?>

$clientes = json_encode($clientes);
$productos = json_encode($productos);

<!-- Contenido del formulario -->
<main id="main" class="main">
    <h2>Registrar Crédito</h2>

    <div class="total-compra-container">
        <label for="totalCompra" class="form-label">Total de Compra:</label>
        <input type="text" id="totalCompra" readonly>
    </div>

    <div class="form-container">
        <div class="form-row">
            <div class="form-col">
                <label for="fechaSistema" class="form-label">Fecha del Sistema:</label>
                <input type="text" class="form-control" id="fechaSistema" readonly>
            </div>
            <div class="form-col">
                <label for="cliente" class="form-label">Cliente:</label>
                <input type="text" class="form-control" id="cliente" name="cliente">
            </div>
        </div>

        <div class="form-row">
            <div class="form-col">
                <label for="buscarProducto" class="form-label">Buscar Producto:</label>
                <select type="search" class="form-control" id="buscarProducto" name="buscarProducto" pattern=".*\S.*" required>
                    <option value="">Seleccione un producto</option>
                    <?php foreach ($productos as $producto) { ?>
                        <option>
                            <?php echo $producto['codigo'] . ' - ' . $producto['nombre'] . ' - ' . $producto['descripcion']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-col">
                <label for="cantidad" class="form-label">Cantidad:</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad">
            </div>
            <div class="form-col">
                <button class="btn btn-primary" id="agregarProducto">Agregar</button>
            </div>
        </div>

        <div class="tabla-container">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="tablaProductos">
                    <!-- Aquí se agregarán los productos dinámicamente -->
                </tbody>
            </table>
        </div>

        <div class="form-row">
            <div class="form-col">
                <button class="btn btn-primary" id="generarCredito">Generar Crédito</button>
            </div>
        </div>
    </div>
</main>

<script>
// Obtener la fecha actual del sistema
const fechaActual = new Date();

// Formatear la fecha a YYYY-MM-DD (formato de input type="date")
const anio = fechaActual.getFullYear();
const mes = String(fechaActual.getMonth() + 1).padStart(2, '0'); // +1 porque los meses van de 0 a 11
const dia = String(fechaActual.getDate()).padStart(2, '0');
const fechaFormateada = anio + '-' + mes + '-' + dia;  // Concatenación corregida

// Establecer la fecha en el input
document.getElementById('fechaSistema').value = fechaFormateada;

// Variable para almacenar los productos
let productos = [];

document.getElementById('agregarProducto').addEventListener('click', function (e) {
    e.preventDefault();  // Prevenir el comportamiento predeterminado del botón
    
    const productoInput = document.getElementById('buscarProducto');
    const cantidadInput = document.getElementById('cantidad');

    // Validar que se haya ingresado un producto y cantidad
    if (!productoInput.value || !cantidadInput.value) {
        alert('Por favor ingresa un producto y la cantidad.');
        return;
    }

    // Simulamos que tenemos el nombre del producto y el precio
    const producto = {
        codigo: productoInput.value, // Este valor debe ser el código del producto
        nombre: productoInput.value, // Este valor debe ser el nombre del producto
        cantidad: cantidadInput.value,
        total: cantidadInput.value * 100 // Precio simulado, debes obtenerlo de tu base de datos
    };

    // Agregar producto a la lista
    productos.push(producto);

    // Mostrar los productos en la tabla
    const tablaProductos = document.getElementById('tablaProductos');
    const fila = document.createElement('tr');
    fila.innerHTML = `
        <td>${producto.nombre}</td>
        <td>${producto.cantidad}</td>
        <td>${producto.total}</td>
    `;
    tablaProductos.appendChild(fila);

    // Limpiar los campos de producto y cantidad
    productoInput.value = '';
    cantidadInput.value = '';
});

// Lógica para enviar el formulario
document.getElementById('generarCredito').addEventListener('click', function (e) {
    e.preventDefault();  // Prevenir el comportamiento predeterminado del botón

    // Obtener el cliente y el total
    const cliente = document.getElementById('cliente').value;
    const total = productos.reduce((acc, producto) => acc + producto.total, 0); // Sumar total de productos

    // Crear el formulario y enviarlo
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '';  // Acción vacía para enviar a la misma página

    // Crear campos ocultos para enviar los datos
    const inputCliente = document.createElement('input');
    inputCliente.type = 'hidden';
    inputCliente.name = 'cliente';
    inputCliente.value = cliente;
    form.appendChild(inputCliente);

    const inputTotal = document.createElement('input');
    inputTotal.type = 'hidden';
    inputTotal.name = 'total';
    inputTotal.value = total;
    form.appendChild(inputTotal);

    // Agregar los productos al formulario
    productos.forEach(function (producto, index) {
        const inputProducto = document.createElement('input');
        inputProducto.type = 'hidden';
        inputProducto.name = 'productos[' + index + '][codigo]';
        inputProducto.value = producto.codigo;
        form.appendChild(inputProducto);

        const inputCantidad = document.createElement('input');
        inputCantidad.type = 'hidden';
        inputCantidad.name = 'productos[' + index + '][cantidad]';
        inputCantidad.value = producto.cantidad;
        form.appendChild(inputCantidad);
    });

    // Enviar el formulario
    document.body.appendChild(form);
    form.submit();
});
</script>

<?php incluirTemplate('footer'); ?>
