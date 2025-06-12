<?php
require '../../../includes/app.php';
estaAutenticado(); //verificar que $_SESSION sea true
$db = conectarDB();
require '../../../data/consumido/insertar.php';

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

            <legend>Detalles de los productos consumidos</legend>

            <div id="fecha-container">
                <label for="fecha-actual">Fecha:</label>
                <input type="text" id="fecha-actual" readonly>
            </div>
            <div>
                <label for="totalCompra">Total de Compra:</label>
                <input type="text" id="totalCompra" name="totalCompra" readonly value="0.00"> </div>

        </fieldset>

        <fieldset>
            <legend>Registro Consumidos</legend>

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
                            <th>Acciones</th> </tr>
                    </thead>
                    <tbody id="tablaProductos" class="contenedor-tabla-datos">

                    </tbody>
                </table>

            </div>
        </fieldset>

        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="consumidos.php"> <span>Cancelar</span>
            </a>

            <button type="submit" id="generarCompra" class="boton-azul">Agregar</button>

        </div>
    </form>
</main>
<script>
//fecha no modificable
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
    //autocompletado de productos
    let productosEnCompra = []; 
    const productosDisponibles = <?php echo $productosJSON; ?>; 

    const productoInput = document.getElementById('txtProductos');
    const productoSuggestionsList = document.getElementById('productoSuggestions');

    productoInput.addEventListener('input', function() {
        const inputValue = this.value.toLowerCase();
        productoSuggestionsList.innerHTML = '';

        if (inputValue.length > 0) {
            const filtered = productosDisponibles.filter(p =>
                p.nombre.toLowerCase().includes(inputValue) || (p.codigo_producto && p.codigo_producto.toLowerCase().includes(inputValue))
            );
            if (filtered.length > 0) {
                filtered.forEach(p => {
                    const li = document.createElement('li');
                    li.textContent = `${p.nombre} - ${p.descripcion || ''} - $${parseFloat(p.precio_unitario).toFixed(2)}`;
                    li.style.padding = '5px';
                    li.style.cursor = 'pointer';
                    li.dataset.codigo_producto = p.codigo_producto;
                    li.dataset.precio = p.precio_unitario;
                    li.dataset.nombre = p.nombre;
                    li.addEventListener('click', function() {
                        productoInput.value = this.dataset.nombre;
                        productoInput.dataset.codigo_producto = this.dataset.codigo_producto;
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

    document.addEventListener('click', function(e) {
        if (!productoSuggestionsList.contains(e.target) && e.target !== productoInput) {
            productoSuggestionsList.style.display = 'none';
        }
    });

    document.getElementById('agregarProducto').addEventListener('click', function(e) {
        e.preventDefault();

        const codigoProducto = productoInput.dataset.codigo_producto;
        const nombre = productoInput.value;
        const precio = parseFloat(productoInput.dataset.precio);
        const cantidad = parseInt(document.getElementById('txtCantidadPr').value);

        if (!codigoProducto || isNaN(cantidad) || cantidad <= 0) {
            Swal.fire('Error', 'Selecciona un producto válido del autocompletado y una cantidad mayor a 0.', 'warning');
            return;
        }
        const existingProductIndex = productosEnCompra.findIndex(p => p.codigo_producto === codigoProducto);

        if (existingProductIndex > -1) {
            productosEnCompra[existingProductIndex].cantidad += cantidad;
            productosEnCompra[existingProductIndex].total = productosEnCompra[existingProductIndex].cantidad * precio;
        } else {
            productosEnCompra.push({
                codigo_producto: codigoProducto,
                nombre,
                cantidad,
                total: precio * cantidad
            });
        }
        renderProductosTable();
        updateTotalCompra(); // Actualiza el total

        productoInput.value = '';
        productoInput.dataset.codigo_producto = '';
        productoInput.dataset.precio = '';
        document.getElementById('txtCantidadPr').value = '';
    });

    function renderProductosTable() {
        const tablaProductosBody = document.getElementById('tablaProductos');
        tablaProductosBody.innerHTML = '';

        productosEnCompra.forEach((p, index) => {
            const fila = document.createElement('tr');
            fila.innerHTML = `
            <td>${p.nombre}</td>
            <td>${p.cantidad}</td>
            <td>${p.total.toFixed(2)}</td>
            <td><button type="button" class="boton-rojo eliminar-producto" data-index="${index}">Eliminar</button></td>
        `;
            tablaProductosBody.appendChild(fila);
        });

        document.querySelectorAll('.eliminar-producto').forEach(button => {
            button.addEventListener('click', function() {
                const indexToRemove = parseInt(this.dataset.index);
                productosEnCompra.splice(indexToRemove, 1);
                renderProductosTable();
                updateTotalCompra();
            });
        });
    }

    function updateTotalCompra() {
        const totalCompra = productosEnCompra.reduce((acc, p) => acc + p.total, 0);
        document.getElementById('totalCompra').value = totalCompra.toFixed(2);
    }
    document.addEventListener("DOMContentLoaded", function() {
    mostrarFechaActual(); // Call the function when the DOM is loaded

    // You can also place other initializations here if needed
    // For example, if you had a function to load initial products or customers.
});


    // Enviar formulario
    document.querySelector('.formulario').addEventListener('submit', function(e) {
        if (productosEnCompra.length === 0) {
            Swal.fire('Atención', 'Debes agregar al menos un producto a la compra.', 'info');
            e.preventDefault(); 
            return;
        }

        const inputProductos = document.getElementById('productosSeleccionados');
        inputProductos.value = JSON.stringify(productosEnCompra);
    });
</script>

<?php incluirTemplate('footer', true); ?>
