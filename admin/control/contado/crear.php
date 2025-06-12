<?php
require '../../../includes/app.php';
estaAutenticado(); //verificar que $_SESSION sea true
$db = conectarDB();
require '../../../data/contado/insertar.php';

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

            <legend>Detalles de la Venta</legend>

            <div id="fecha-container">
                <label for="fecha-actual">Fecha:</label>
                <input type="text" id="fecha-actual" readonly>
            </div>
            <div>
                <label for="totalCompra">Total de Venta:</label>
                <input type="text" id="totalCompra" name="totalCompra" readonly>
            </div>
            <label for="txtProductos">Productos</label>
            <input type="text" name="txtProductos" id="txtProductos" autocomplete="off" placeholder="Escribe para buscar...">
            <ul id="productoSuggestions" style="display: none; position: absolute; background-color: white; border: 1px solid #ccc; width: 95%; list-style: none; padding: 0; margin: 0; z-index: 10;"></ul>
            <input type="hidden" name="productosSeleccionados" id="productosSeleccionados">

            <label for="txtCantidadPr">Cantidad</label>
            <input type="number" name="txtCantidadPr" id="txtCantidadPr" min="0">
            <button name="lista" id="agregarProducto" type="button" class="boton-azul">Agregar</button>

            <div class="row-lista contenedor-tabla-datos">
                <table class="tabla-productos tabla-plantilla">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaProductos" class="contenedor-tabla-datos">

                    </tbody>
                </table>

            </div>
        </fieldset>
        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="contado.php">
                <span>Cancelar</span>
            </a>

            <button type="submit" id="generarCredito" class="boton-azul">Generar Venta</button>

        </div>
    </form>
</main>

<script>
    function mostrarFechaActual() {
        const fechaInput = document.getElementById('fecha-actual');
        const fecha = new Date();
        const opciones = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        fechaInput.value = fecha.toLocaleDateString(undefined, opciones);
    }
    mostrarFechaActual();

    let productos = [];
    const productosData = <?php echo $productos; ?>;

    const productoInput = document.getElementById('txtProductos');
    const productoSuggestionsList = document.getElementById('productoSuggestions');

    productoInput.addEventListener('input', function () {
        const inputValue = this.value.toLowerCase();
        productoSuggestionsList.innerHTML = '';

        if (inputValue.length > 0) {
            const filtered = productosData.filter(p =>
                p.nombre.toLowerCase().includes(inputValue) || p.codigo_producto.toLowerCase().includes(inputValue)
            );
            if (filtered.length > 0) {
                filtered.forEach(p => {
                    const li = document.createElement('li');
                    li.textContent = `${p.nombre} - ${p.descripcion} - ${p.precio_unitario}`;
                    li.style.padding = '5px';
                    li.style.cursor = 'pointer';
                    li.dataset.codigo = p.codigo_producto;
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
        const cantidad = parseInt(document.getElementById('txtCantidadPr').value);

        if (!codigo || isNaN(cantidad) || cantidad <= 0) {
            Swal.fire('Error', 'Selecciona un producto válido y una cantidad mayor a 0.', 'warning');
            return;
        }

        const existingProductIndex = productos.findIndex(p => p.codigo === codigo);
        if (existingProductIndex > -1) {
            productos[existingProductIndex].cantidad += cantidad;
            productos[existingProductIndex].total = productos[existingProductIndex].cantidad * precio;
        } else {
            productos.push({
                codigo,
                nombre,
                cantidad,
                total: precio * cantidad
            });
        }

        renderProductosTable();
        productoInput.value = '';
        productoInput.dataset.codigo = '';
        productoInput.dataset.precio = '';
        document.getElementById('txtCantidadPr').value = '';
    });

    function renderProductosTable() {
        const tabla = document.getElementById('tablaProductos');
        tabla.innerHTML = '';
        let total = 0;

        productos.forEach(p => {
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td>${p.nombre}</td>
                <td>${p.cantidad}</td>
                <td>${p.total.toFixed(2)}</td>
                <td><button class="boton-rojo eliminar-producto" onclick="eliminarProducto('${p.codigo}')">Eliminar</button></td>
            `;
            tabla.appendChild(fila);
            total += p.total;
        });

        document.getElementById('totalCompra').value = total.toFixed(2);
    }

    function eliminarProducto(codigo) {
        productos = productos.filter(p => p.codigo !== codigo);
        renderProductosTable();
    }

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (e) {
            const inputProductos = document.getElementById('productosSeleccionados');
            inputProductos.value = JSON.stringify(productos);
        });
    });

    document.getElementById('generarCredito').addEventListener('click', function (e) {
        e.preventDefault();

        const total = productos.reduce((acc, p) => acc + p.total, 0);
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '';

        const inputTotal = document.createElement('input');
        inputTotal.type = 'hidden';
        inputTotal.name = 'totalCompra';
        inputTotal.value = total;
        form.appendChild(inputTotal);

        const inputProductosSeleccionados = document.createElement('input');
        inputProductosSeleccionados.type = 'hidden';
        inputProductosSeleccionados.name = 'productosSeleccionados';
        inputProductosSeleccionados.value = JSON.stringify(productos);
        form.appendChild(inputProductosSeleccionados);

        document.body.appendChild(form);
        form.submit();
    });
</script>
<?php incluirTemplate('footer', true); ?>