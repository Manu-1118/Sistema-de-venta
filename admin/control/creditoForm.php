<?php
require '../../includes/app.php';
require '../../includes/data/productos.php';
require '../../includes/data/clientes.php';

$db = conectarDB();
date_default_timezone_set('America/Managua');

$clientesJSON = json_encode($clientes); 
$productos = json_encode($productos);

incluirTemplate('header');
incluirTemplate('slidebar');

$errores = [];
$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idCliente = $_POST['cliente'] ?? null;
    $total = $_POST['total'] ?? null;
    $productosCredito = $_POST['productos'] ?? [];

    if (empty($idCliente)) {
        $errores[] = "Debes seleccionar un cliente.";
    }
    if (empty($total) || !is_numeric($total) || $total <= 0) {
        $errores[] = "El total debe ser un número mayor que cero.";
    }
    if (empty($productosCredito)) {
        $errores[] = "Debes agregar al menos un producto.";
    }

    if (empty($errores)) {
        $fechaCredito = date('Y-m-d H:i:s');
        $queryCredito = "INSERT INTO Credito (fecha_credito, total, id_cliente) VALUES ('$fechaCredito', $total, $idCliente)";
        $resultadoCredito = mysqli_query($db, $queryCredito);

        if ($resultadoCredito) {
            $idCredito = mysqli_insert_id($db);

            foreach ($productosCredito as $producto) {
                $codigoProducto = $producto['codigo'];
                $cantidad = $producto['cantidad'];
                $queryDetalle = "INSERT INTO DetalleCredito (cantidad, codigo_producto, id_credito) VALUES ($cantidad, '$codigoProducto', $idCredito)";
                mysqli_query($db, $queryDetalle);
            }

            $mensaje = "Crédito registrado correctamente.";
        } else {
            $errores[] = "Error al registrar el crédito.";
        }
    }
}
?>

<main id="main" class="main admin main-admin menu-toggle">
    <h2>Registrar Crédito</h2>

    <div class="total-compra-container">
        <label for="totalCompra" class="form-label">Total de Compra:</label>
        <input type="text" id="totalCompra" readonly>
    </div>

    <div class="form-container">
        <div class="form-row">
            <div class="form-col">
                <label for="fechaSistema" class="form-label">Fecha:</label>
                <input type="text" class="form-control" id="fechaSistema" readonly>
            </div>
            <div class="form-col">
                <label for="clienteSelect" class="form-label">Cliente:</label>
                <select class="form-control" id="clienteSelect" name="cliente">
                    <option value="">Selecciona un cliente...</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-col" style="position: relative;">
                <label for="productoInput" class="form-label">Buscar Producto:</label>
                <input type="text" class="form-control" id="productoInput" autocomplete="off" placeholder="Escribe para buscar...">
                <ul id="productoSuggestions" style="display: none; position: absolute; background-color: white; border: 1px solid #ccc; width: 95%; list-style: none; padding: 0; margin: 0; z-index: 10;"></ul>
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
                <tbody id="tablaProductos"></tbody>
            </table>
        </div>

        <!-- <div class="form-row">
            <div class="form-col">
                <button class="btn btn-primary" id="generarCredito">Generar Crédito</button>
            </div>
        </div> -->

        <div class="d-flex justify-content-center">
            <button class="btn btn-primary" id="generarCredito">Generar Crédito</button>
            <a class="btn btn-secondary" href="creditos.php?">Cancelar</a>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // alertas de sweet alert
    <?php if (!empty($errores)) : ?>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        html: `<?php echo implode('<br>', $errores); ?>`
    });
<?php elseif (!empty($mensaje)) : ?>
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '<?php echo $mensaje; ?>'
    }).then(() => {
        window.location.href = "creditos.php";
    });
<?php endif; ?>

    //fecha no modificable
    const fechaActual = new Date();
    const anio = fechaActual.getFullYear();
    const mes = String(fechaActual.getMonth() + 1).padStart(2, '0');
    const dia = String(fechaActual.getDate()).padStart(2, '0');
    document.getElementById('fechaSistema').value = `${anio}-${mes}-${dia}`;

    let productos = [];
    const productosData = <?php echo $productos; ?>;
    const clientesData = <?php echo $clientesJSON; ?>;

    const productoInput = document.getElementById('productoInput');
    const productoSuggestionsList = document.getElementById('productoSuggestions');

    productoInput.addEventListener('input', function () {
        const inputValue = this.value.toLowerCase();
        productoSuggestionsList.innerHTML = '';

        if (inputValue.length > 0) {
            const filtered = productosData.filter(p =>
                p.nombre.toLowerCase().includes(inputValue) || p.codigo.toLowerCase().includes(inputValue)
            );

            if (filtered.length > 0) {
                filtered.forEach(p => {
                    const li = document.createElement('li');
                    li.textContent = `${p.nombre} - ${p.descripcion} - ${p.precio_unitario}`;
                    li.style.padding = '5px';
                    li.style.cursor = 'pointer';
                    li.dataset.codigo = p.codigo;
                    li.dataset.precio = p.precio_unitario;
                    li.dataset.nombre = p.nombre;

                    li.addEventListener('click', function () {
                        productoInput.value = this.dataset.nombre;
                        productoInput.dataset.codigo = this.dataset.codigo;
                        productoInput.dataset.precio = this.dataset.precio;
                        productoSuggestionsList.style.display = 'none';
                    });

                    productoSuggestionsList.appendChild(li);
                });
                productoSuggestionsList.style.display = 'block';
            } else {
                productoSuggestionsList.style.display = 'none';
            }
        } else {
            productoSuggestionsList.style.display = 'none';
        }
    });

    document.addEventListener('click', function (e) {
        if (!productoSuggestionsList.contains(e.target) && e.target !== productoInput) {
            productoSuggestionsList.style.display = 'none';
        }
    });

    document.getElementById('agregarProducto').addEventListener('click', function (e) {
        e.preventDefault();

        const codigo = productoInput.dataset.codigo;
        const nombre = productoInput.value;
        const precio = parseFloat(productoInput.dataset.precio);
        const cantidad = parseInt(document.getElementById('cantidad').value);

        if (!codigo || isNaN(cantidad) || cantidad <= 0) {
            Swal.fire('Error', 'Selecciona un producto válido y una cantidad mayor a 0.', 'warning');
            return;
        }

        const total = precio * cantidad;
        productos.push({ codigo, nombre, cantidad, total });

        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td>${nombre}</td>
            <td>${cantidad}</td>
            <td>${total.toFixed(2)}</td>
        `;
        document.getElementById('tablaProductos').appendChild(fila);

        const totalCompra = productos.reduce((acc, p) => acc + p.total, 0);
        document.getElementById('totalCompra').value = totalCompra.toFixed(2);

        productoInput.value = '';
        productoInput.dataset.codigo = '';
        productoInput.dataset.precio = '';
        document.getElementById('cantidad').value = '';
    });

    // dropdown clientes
    document.addEventListener("DOMContentLoaded", function () {
        const clienteSelect = document.getElementById('clienteSelect');

        if (clientesData && Array.isArray(clientesData)) {
            clientesData.forEach(cliente => {
                const option = document.createElement('option');
                option.value = cliente.id;
                option.textContent = `${cliente.id} - ${cliente.nombres} ${cliente.apellidos}`;
                clienteSelect.appendChild(option);
            });
        } else {
            console.error("clientesData no es un array válido:", clientesData);
        }
    });

    document.getElementById('generarCredito').addEventListener('click', function (e) {
        e.preventDefault();

        const clienteID = document.getElementById('clienteSelect').value;
        if (!clienteID) {
            Swal.fire('Atención', 'Por favor selecciona un cliente de la lista.', 'info');
            return;
        }

        const total = productos.reduce((acc, p) => acc + p.total, 0);

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '';

        const inputCliente = document.createElement('input');
        inputCliente.type = 'hidden';
        inputCliente.name = 'cliente';
        inputCliente.value = clienteID;
        form.appendChild(inputCliente);

        const inputTotal = document.createElement('input');
        inputTotal.type = 'hidden';
        inputTotal.name = 'total';
        inputTotal.value = total;
        form.appendChild(inputTotal);

        productos.forEach((p, i) => {
            const inputCodigo = document.createElement('input');
            inputCodigo.type = 'hidden';
            inputCodigo.name = `productos[${i}][codigo]`;
            inputCodigo.value = p.codigo;
            form.appendChild(inputCodigo);

            const inputCantidad = document.createElement('input');
            inputCantidad.type = 'hidden';
            inputCantidad.name = `productos[${i}][cantidad]`;
            inputCantidad.value = p.cantidad;
            form.appendChild(inputCantidad);
        });

        document.body.appendChild(form);
        form.submit();
    });
</script>

<?php incluirTemplate('footer'); ?>