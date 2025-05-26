<?php
require '../../../includes/app.php';
estaAutenticado(); //verificar que $_SESSION sea true
$db = conectarDB();
require '../../../data/credito/insertar.php';

//$resultado_mensaje = $_GET['resultado'];

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
            <legend>Detalles Credito</legend>

            <label for="txtCliente">Cliente:</label>
            <select class="form-control" name="txtCliente" placeholder="Nombre del cliente" id="txtCliente" value="<?php echo $cliente; ?>">

            <div id="fecha-container">
            <label for="fecha-actual">Fecha:</label>
            <input type="text" id="fecha-actual" readonly>
            </div>
            <div>
            <label for="totalCompra">Total de Compra:</label>
            <input type="text" id="totalCompra" name="total" readonly>
            </div>
        </fieldset>

    </form>


    <form method="POST" class="formulario">
        <fieldset>
            <legend>Datos del Credito</legend>

            <label for="txtProductos">Productos</label>
            <input type="text" name="txtProductos" id="txtProductos" autocomplete="off" placeholder="Escribe para buscar...">
            <ul id="productoSuggestions" style="display: none; position: absolute; background-color: white; border: 1px solid #ccc; width: 95%; list-style: none; padding: 0; margin: 0; z-index: 10;"></ul>

            <label for="txtCantidadPr">Cantidad</label>
            <input type="number" name="txtCantidadPr" id="txtCantidadPr">
            <button name="lista" id="agregarProducto" type="button" class="boton-azul">Agregar</button>

            <div class="row-lista">
            <table class="tabla-productos">
                <thead>
                    <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    </tr>
                </thead>
            <tbody id="tablaProductos">
  
            </tbody>
            </table>

            </div>
        </fieldset>  
           
        <div class="alinear-derecha separar-margin">

            <a class="boton-rojo" href="creditos.php">
            <span>Cancelar</span>
            </a>

            <button type="submit" class="boton-azul">Agregar Crédito</button>

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

//autocompletado de productos
    let productos = [];
    const productosData = <?php echo $productos; ?>;
    const clientesData = <?php echo json_encode($clientes); ?>;

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
productoInput.dataset.precio = this.dataset.precio_unitario;
document.getElementById('cantidad').value = '';
});

//dropdown cliente
document.addEventListener("DOMContentLoaded", function () {

const clienteSelect = document.getElementById('txtCliente');
if (clientesData && Array.isArray(clientesData)) {


    clientesData.forEach(cliente => {
    const option = document.createElement('option');
    option.value = cliente.id_cliente;
    option.textContent = `${cliente.id_cliente} - ${cliente.nombre} ${cliente.apellido}`;
    clienteSelect.appendChild(option);

    });
} else {
    console.error("clientesData no es un array válido:", clientesData);
}
});

</script>

<?php incluirTemplate('footer'); ?>